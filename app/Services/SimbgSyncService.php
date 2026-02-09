<?php

namespace App\Services;

use App\Models\CiptaKarya\PengajuanPBG;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Mail\PengajuanBaruSimbgMail;
use Illuminate\Support\Facades\Mail;

class SimbgSyncService
{
    protected $baseUrl;
    protected $timeout;
    protected $perPage;
    protected $httpClient;

    public function __construct()
    {
        $this->baseUrl = config('simbg.base_url');
        $this->timeout = config('simbg.timeout');
        $this->perPage = config('simbg.sync.per_page', 100);
        $this->httpClient = new Client([
            'timeout' => $this->timeout,
            'verify' => false, // Disable SSL verification if needed
        ]);
    }

    /**
     * Main sync function
     */
    public function sync($userId = null)
    {
        $startTime = now();
        $stats = [
            'total_fetched' => 0,
            'total_new' => 0,
            'total_updated' => 0,
            'total_skipped' => 0,
            'status' => 'success',
            'error_message' => null,
            'new_pengajuan_ids' => [],
        ];

        DB::beginTransaction();

        try {
            // 1. Fetch data from Robot API
            Log::info('🤖 Starting SIMBG sync...');
            $pengajuanData = $this->fetchFromRobot();
            // dd(count($pengajuanData));
            
            if (empty($pengajuanData)) {
                Log::info('✅ No new data from SIMBG (already up to date)');
                $stats['status'] = 'success';
                $stats['error_message'] = null;
                $this->logSync($stats, $userId);
                DB::commit();
                return $stats;
            }

            $stats['total_fetched'] = count($pengajuanData);
            Log::info("📊 Fetched {$stats['total_fetched']} records from SIMBG");

            // 2. Process each pengajuan
            $newUids = [];
            foreach ($pengajuanData as $data) {
                $result = $this->processPengajuan($data);
                
                if ($result['action'] === 'created') {
                    $stats['total_new']++;
                    $stats['new_pengajuan_ids'][] = $result['id'];
                    $newUids[] = $data['uid']; // Collect UIDs for batch fetch
                } elseif ($result['action'] === 'updated') {
                    $stats['total_updated']++;
                } else {
                    $stats['total_skipped']++;
                }
            }

            // 2.5. Fetch details for new pengajuan (batch)
            if (!empty($newUids)) {
                Log::info("📦 Batch fetching details for {$stats['total_new']} new pengajuan");
                $this->fetchAndSaveDetails($newUids);
            }

            // 3. Send email notification if there are new pengajuan
            if ($stats['total_new'] > 0) {
                $this->sendNotification($stats['new_pengajuan_ids']);
            }

            // 4. Log sync activity
            $this->logSync($stats, $userId);

            DB::commit();

            $duration = now()->diffInSeconds($startTime);
            Log::info("✅ Sync completed in {$duration}s - New: {$stats['total_new']}, Updated: {$stats['total_updated']}, Skipped: {$stats['total_skipped']}");

            return $stats;

        } catch (\Exception $e) {
            DB::rollBack();
            
            $stats['status'] = 'failed';
            $stats['error_message'] = $e->getMessage();
            
            Log::error('❌ SIMBG sync failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            // Still log the failed attempt
            $this->logSync($stats, $userId);

            throw $e;
        }
    }

    /**
     * Fetch data from Robot API
     */
    protected function fetchFromRobot()
    {
        try {
            // Check if we should use incremental sync
            // $lastSync = $this->getLastSync();
            
            // if ($lastSync && $lastSync->status === 'success') {
            //     // Use incremental sync
            //     return $this->fetchIncremental($lastSync->synced_at);
            // }

            // dd($lastSync);

            // Fall back to full fetch
            return $this->fetchFull();

        } catch (\Exception $e) {
            Log::error('Failed to fetch from Robot API: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Fetch incremental changes since last sync
     */
    protected function fetchIncremental($since)
    {
        $url = $this->baseUrl . '/api/data/pengajuan/since';
        
        Log::info("🔄 Incremental sync since: {$since}");

        $response = $this->httpClient->get($url, [
            'query' => [
                'timestamp' => $since,
                'limit' => $this->perPage,
            ]
        ]);

        $json = json_decode($response->getBody()->getContents(), true);

        if (!isset($json['success']) || !$json['success']) {
            throw new \Exception("Incremental sync API error: " . ($json['message'] ?? 'Unknown error'));
        }

        Log::info("✅ Incremental sync: {$json['count']} records found");

        return $json['data'] ?? [];
    }

    /**
     * Fetch all data (full sync)
     */
    protected function fetchFull()
    {
        $url = $this->baseUrl . '/api/data/pengajuan';
        
        Log::info("🌐 Full fetch from: {$url}");

        $response = $this->httpClient->get($url, [
            'query' => [
                'limit' => $this->perPage,
                'page' => 1,
            ]
        ]);

        $json = json_decode($response->getBody()->getContents(), true);

        if (!isset($json['success']) || !$json['success']) {
            throw new \Exception("Robot API returned error: " . ($json['message'] ?? 'Unknown error'));
        }

        return $json['data'] ?? [];
    }

    /**
     * Process single pengajuan data
     */
    protected function processPengajuan($data)
    {
        $uid = $data['uid'] ?? null;

        if (!$uid) {
            Log::warning('Skipping record without UID', ['data' => $data]);
            return ['action' => 'skipped', 'id' => null];
        }

        // Map Robot data to Laravel model
        $mapped = $this->mapRobotToLaravel($data);

        // Check if already exists by UID
        $existing = PengajuanPBG::where('uid', $uid)->first();

        if ($existing) {
            // Update existing data
            $existing->update($mapped);
            Log::info("🔄 Updated existing pengajuan: {$existing->id} (UID: {$uid})");
            return ['action' => 'updated', 'id' => $existing->id];
        }

        // Check if no_permohonan already exists (to avoid duplicate key error)
        if (!empty($mapped['no_permohonan'])) {
            $existingByNoPermohonan = PengajuanPBG::where('no_permohonan', $mapped['no_permohonan'])->first();
            
            if ($existingByNoPermohonan) {
                // Update the existing record with new UID and data
                $existingByNoPermohonan->update($mapped);
                Log::info("🔄 Updated pengajuan by no_permohonan: {$existingByNoPermohonan->id} (No: {$mapped['no_permohonan']}, New UID: {$uid})");
                return ['action' => 'updated', 'id' => $existingByNoPermohonan->id];
            }
        }

        try {
            // Create new pengajuan
            $pengajuan = PengajuanPBG::create($mapped);

            Log::info("✅ Created new pengajuan: {$pengajuan->id} (UID: {$uid})");

            return ['action' => 'created', 'id' => $pengajuan->id];
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle duplicate entry error
            if ($e->getCode() == 23000 || strpos($e->getMessage(), 'Duplicate entry') !== false) {
                Log::warning("⚠️ Duplicate entry detected, attempting to update instead for UID: {$uid}");
                
                // Try to find by no_permohonan again (race condition handling)
                if (!empty($mapped['no_permohonan'])) {
                    $existingByNoPermohonan = PengajuanPBG::where('no_permohonan', $mapped['no_permohonan'])->first();
                    
                    if ($existingByNoPermohonan) {
                        $existingByNoPermohonan->update($mapped);
                        Log::info("🔄 Updated pengajuan after duplicate error: {$existingByNoPermohonan->id} (UID: {$uid})");
                        return ['action' => 'updated', 'id' => $existingByNoPermohonan->id];
                    }
                }
                
                // If still can't find, try by UID one more time
                $existingByUid = PengajuanPBG::where('uid', $uid)->first();
                if ($existingByUid) {
                    $existingByUid->update($mapped);
                    Log::info("🔄 Updated pengajuan after duplicate error (by UID): {$existingByUid->id} (UID: {$uid})");
                    return ['action' => 'updated', 'id' => $existingByUid->id];
                }
                
                // If still can't find, skip this record
                Log::error("❌ Could not resolve duplicate entry for UID: {$uid}, No: {$mapped['no_permohonan']}");
                return ['action' => 'skipped', 'id' => null];
            }
            
            // Re-throw if it's not a duplicate entry error
            throw $e;
        }
    }

    /**
     * Map Robot SIMBG data to Laravel model structure
     */
    protected function mapRobotToLaravel($data)
    {
        return [
            'uid' => $data['uid'],
            'tipe' => $this->mapApplicationType($data['application_type_name'] ?? $data['application_type'] ?? null),
            'no_permohonan' => $data['registration_number'] ?? null,
            'nama_pemohon' => $data['owner_name'] ?? $data['name'] ?? null,
            'alamat' => $data['address'] ?? null,
            'fungsi_bangunan' => $this->mapFunctionType($data['function_type'] ?? null),
            'luas_bangunan' => $data['total_area'] ?? null,
            'nilai_retribusi' => $data['retribution'] ?? null,
            'status' => $this->mapStatus($data['status_name'] ?? null),
            'simbg_synced_at' => now(),
            'created_at' => $data['start_date'] ?? $data['created_at'] ?? now(),
        ];
    }

    /**
     * Map application type from SIMBG to Laravel
     */
    protected function mapApplicationType($type)
    {
        $typeLower = strtolower($type ?? '');
        
        // Check for SLF keywords
        if (strpos($typeLower, 'sertifikat laik fungsi') !== false || 
            strpos($typeLower, 'slf') !== false) {
            return 'SLF';
        }
        
        // Check for PBG keywords
        if (strpos($typeLower, 'persetujuan bangunan gedung') !== false || 
            strpos($typeLower, 'pbg') !== false) {
            return 'PBG';
        }
        
        // Check for combined
        if (strpos($typeLower, 'pbg') !== false && strpos($typeLower, 'slf') !== false) {
            return 'PBG/SLF';
        }
        
        return 'PBG'; // Default
    }

    /**
     * Map function type
     */
    protected function mapFunctionType($type)
    {
        // Map ke fungsi bangunan yang ada
        $validTypes = ['Khusus', 'Sosial Budaya', 'Hunian', 'Usaha', 'Keagamaan'];
        
        // Simple mapping - bisa diperluas
        foreach ($validTypes as $valid) {
            if (stripos($type ?? '', $valid) !== false) {
                return $valid;
            }
        }

        return 'Hunian'; // Default
    }

    /**
     * Map status from SIMBG to Laravel
     */
    protected function mapStatus($statusName)
    {
        $status = strtolower($statusName ?? '');

        if (stripos($status, 'selesai') !== false || stripos($status, 'terbit') !== false) {
            return 'terbit';
        }

        if (stripos($status, 'tolak') !== false || stripos($status, 'ditolak') !== false) {
            return 'tolak';
        }

        return 'proses'; // Default
    }

    /**
     * Fetch and save details for multiple UIDs (batch)
     */
    protected function fetchAndSaveDetails($uids)
    {
        try {
            $url = $this->baseUrl . '/api/data/pengajuan/batch-details';
            
            // Build query string with UIDs
            $queryString = http_build_query(['uids' => $uids]);
            $fullUrl = $url . '?' . $queryString;
            
            $uidsCount = count($uids);
            Log::info("🌐 Batch fetching from: {$url} ({$uidsCount} UIDs)");

            $response = $this->httpClient->get($fullUrl, [
                'timeout' => $this->timeout * 2 // Double timeout for batch
            ]);

            $json = json_decode($response->getBody()->getContents(), true);

            if (!isset($json['success']) || !$json['success']) {
                throw new \Exception("Batch details API error: " . ($json['message'] ?? 'Unknown error'));
            }

            $data = $json['data'] ?? [];
            $summary = $json['summary'] ?? [];

            Log::info("📦 Batch fetch summary: " . json_encode($summary));

            // Save details to database
            foreach ($data as $uid => $details) {
                if (isset($details['error'])) {
                    Log::warning("⚠️ Error fetching details for UID {$uid}: {$details['error']}");
                    continue;
                }

                // Find pengajuan by UID
                $pengajuan = PengajuanPBG::where('uid', $uid)->first();
                if (!$pengajuan) {
                    Log::warning("⚠️ Pengajuan not found for UID: {$uid}");
                    continue;
                }

                // Collect all file paths from certificates and list_data
                $uploadedFiles = [];

                // Extract files from certificates
                if (!empty($details['certificates'])) {
                    foreach ($details['certificates'] as $cert) {
                        if (isset($cert['certificate_data']['file'])) {
                            $filename = basename($cert['certificate_data']['file']);
                            $downloadUrl = $this->baseUrl . '/downloads/certificates/' . $uid . '/' . $filename;
                            
                            $uploadedFiles[] = [
                                'type' => 'certificate',
                                'file' => $downloadUrl,
                                'name' => $cert['certificate_data']['name'] ?? 'Certificate',
                                'number' => $cert['certificate_data']['number'] ?? null,
                                'ownership' => $cert['certificate_data']['ownership'] ?? null,
                            ];
                        }
                    }
                }

                // Extract files from list_data
                if (!empty($details['list_data'])) {
                    foreach ($details['list_data'] as $listItem) {
                        if (isset($listItem['list_data']['file'])) {
                            $filename = basename($listItem['list_data']['file']);
                            $downloadUrl = $this->baseUrl . '/downloads/list_data/' . $uid . '/' . $filename;
                            
                            $uploadedFiles[] = [
                                'type' => 'document',
                                'file' => $downloadUrl,
                                'name' => $listItem['list_data']['name'] ?? 'Document',
                                'data_type' => $listItem['list_data']['data_type_name'] ?? null,
                            ];
                        }
                    }
                }

                // Extract detail data for additional fields
                $detailData = $details['detail']['detail_data'] ?? [];
                
                // Extract certificate data (for No. Persil and additional Luas Tanah)
                $certificateData = [];
                if (!empty($details['certificates'])) {
                    // Use first certificate
                    $certificateData = $details['certificates'][0]['certificate_data'] ?? [];
                }
                
                // Update pengajuan with detail data
                if (!empty($detailData)) {
                    $pengajuan->nama_bangunan = $detailData['name_building'] ?? $pengajuan->nama_bangunan;
                    $pengajuan->jumlah_bangunan = $detailData['unit'] ?? $pengajuan->jumlah_bangunan;
                    $pengajuan->jumlah_lantai = $detailData['floor'] ?? $pengajuan->jumlah_lantai;
                    $pengajuan->ketinggian_bangunan = $detailData['height'] ?? $pengajuan->ketinggian_bangunan;
                    $pengajuan->lokasi_bangunan = $detailData['building_address'] ?? $pengajuan->lokasi_bangunan;
                    $pengajuan->nik = $detailData['nik'] ?? $pengajuan->nik;
                    $pengajuan->no_krk = $detailData['kkr_number'] ?? $pengajuan->no_krk;
                    $pengajuan->pemilik_tanah = $detailData['owner_name'] ?? $pengajuan->pemilik_tanah;
                    
                    // Luas tanah from detail (building area), fallback to certificate area (land area)
                    $pengajuan->luas_tanah = $detailData['area'] ?? $certificateData['area'] ?? $pengajuan->luas_tanah;
                    
                    // KDB, KDH, KLB
                    $pengajuan->kdb_max = $detailData['koefisien_dasar_bangunan'] ?? $pengajuan->kdb_max;
                    $pengajuan->kdh_min = $detailData['koefisien_lantai_hijau'] ?? $pengajuan->kdh_min;
                    $pengajuan->koefisiensi_lantai = $detailData['koefisien_lantai_bangunan'] ?? $pengajuan->koefisiensi_lantai;
                    $pengajuan->gbs_min = $detailData['gsb'] ?? $pengajuan->gbs_min;
                    
                    // Koordinat (format: latitude, longitude)
                    if (!empty($detailData['latitude']) && !empty($detailData['longitude'])) {
                        $pengajuan->koordinat_bangunan = $detailData['latitude'] . ', ' . $detailData['longitude'];
                    }
                    
                    Log::debug("✅ Detail data available for UID: {$uid}");
                }
                
                // Extract data from certificate
                if (!empty($certificateData)) {
                    // No. Persil from certificate number
                    $pengajuan->no_persil = $certificateData['number'] ?? $pengajuan->no_persil;
                    
                    Log::debug("✅ Certificate data available for UID: {$uid}");
                }

                // Update pengajuan with uploaded_files
                if (!empty($uploadedFiles)) {
                    $pengajuan->uploaded_files = $uploadedFiles; // Laravel will auto-encode JSON
                    
                    $fileCount = count($uploadedFiles);
                    Log::info("📎 Saved {$fileCount} files for UID: {$uid}");
                } else {
                    Log::debug("⚠️ No files found for UID: {$uid}");
                }
                
                // Save all changes
                $pengajuan->save();
            }

        } catch (\Exception $e) {
            Log::error('Failed to fetch batch details: ' . $e->getMessage());
            // Don't throw - detail fetch failure shouldn't break main sync
        }
    }

    /**
     * Send email notification to kabid & admin
     */
    protected function sendNotification($pengajuanIds)
    {
        try {
            $business_id = 18; // server - fixed business ID
            
            // Get recipients based on roles with business_id format
            // Format: "Kepala Bidang#18", "Admin#18"
            $roles = config('simbg.notification_roles', ['Kepala Bidang', 'Admin']);
            
            $recipients = collect();
            
            foreach ($roles as $role) {
                $roleWithBusiness = $role . '#' . $business_id;
                $users = User::role($roleWithBusiness)->get();
                
                if ($users->count() > 0) {
                    $recipients = $recipients->merge($users);
                    Log::info("Found {$users->count()} users with role: {$roleWithBusiness}");
                }
            }

            if ($recipients->isEmpty()) {
                Log::warning('No recipients found for notification. Roles checked: ' . implode(', ', array_map(function($r) use ($business_id) {
                    return $r . '#' . $business_id;
                }, $roles)));
                return;
            }

            // Get pengajuan data
            $pengajuanList = PengajuanPBG::whereIn('id', $pengajuanIds)->get();

            // Get unique email list
            $emailList = $recipients->pluck('email')->filter()->unique()->toArray();

            if (empty($emailList)) {
                Log::warning('No email addresses found for recipients');
                return;
            }

            // Send email to all recipients
            Mail::to($emailList)->send(new PengajuanBaruSimbgMail($pengajuanList, $recipients->first()));
            
            Log::info("📧 Email sent to: " . implode(', ', $emailList));

        } catch (\Exception $e) {
            Log::error('Failed to send notification: ' . $e->getMessage());
            // Don't throw - notification failure shouldn't break sync
        }
    }

    /**
     * Log sync activity to database
     */
    protected function logSync($stats, $userId = null)
    {
        try {
            DB::table('simbg_sync_logs')->insert([
                'synced_at' => now(),
                'total_fetched' => $stats['total_fetched'],
                'total_new' => $stats['total_new'],
                'total_updated' => $stats['total_updated'],
                'total_skipped' => $stats['total_skipped'],
                'status' => $stats['status'],
                'error_message' => $stats['error_message'],
                'synced_by' => $userId,
                'new_pengajuan_ids' => json_encode($stats['new_pengajuan_ids']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to log sync: ' . $e->getMessage());
        }
    }

    /**
     * Get last sync info
     */
    public function getLastSync()
    {
        return DB::table('simbg_sync_logs')
            ->orderBy('synced_at', 'desc')
            ->first();
    }
}
