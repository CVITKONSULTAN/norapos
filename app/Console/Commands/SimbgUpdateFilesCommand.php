<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SimbgUpdateFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simbg:update-files 
                            {--force : Update all pengajuan even if they already have files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update uploaded_files for existing pengajuan from SIMBG';

    protected $httpClient;
    protected $baseUrl;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->baseUrl = config('simbg.base_url');
        $this->httpClient = new Client(['timeout' => 60]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('🔄 Updating uploaded_files for existing pengajuan...');

        // Get pengajuan with UID but no files (or force all)
        $query = DB::table('pengajuan')->whereNotNull('uid');
        
        if (!$this->option('force')) {
            $query->where(function($q) {
                $q->whereNull('uploaded_files')
                  ->orWhere('uploaded_files', '')
                  ->orWhere('uploaded_files', 'null')
                  ->orWhere('uploaded_files', '[]');
            });
        }

        $pengajuanList = $query->get();
        $total = count($pengajuanList);

        if ($total === 0) {
            $this->info('✅ No pengajuan need updating!');
            return 0;
        }

        $this->info("📦 Found {$total} pengajuan to update");

        // Collect UIDs
        $uids = [];
        foreach ($pengajuanList as $p) {
            $uids[] = $p->uid;
        }
        
        $this->info("UIDs to fetch: " . implode(', ', array_slice($uids, 0, 3)) . (count($uids) > 3 ? '...' : ''));

        // Batch fetch details
        $this->info("🌐 Fetching details from SIMBG...");
        $details = $this->fetchBatchDetails($uids);

        if (empty($details)) {
            $this->error('❌ Failed to fetch details from SIMBG');
            return 1;
        }

        // Update each pengajuan
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $updated = 0;
        $failed = 0;

        foreach ($pengajuanList as $pengajuan) {
            $uid = $pengajuan->uid;

            if (!isset($details[$uid])) {
                $failed++;
                $bar->advance();
                continue;
            }

            $detail = $details[$uid];
            
            if (isset($detail['error'])) {
                $failed++;
                $bar->advance();
                continue;
            }

            // Extract files
            $uploadedFiles = [];

            // Certificates
            if (!empty($detail['certificates'])) {
                foreach ($detail['certificates'] as $cert) {
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

            // Documents
            if (!empty($detail['list_data'])) {
                foreach ($detail['list_data'] as $listItem) {
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

            // Update pengajuan
            if (!empty($uploadedFiles)) {
                DB::table('pengajuan')
                    ->where('id', $pengajuan->id)
                    ->update(['uploaded_files' => json_encode($uploadedFiles)]);
                $updated++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');

        $this->info("✅ Update completed!");
        $this->table(
            ['Status', 'Count'],
            [
                ['Updated', $updated],
                ['Failed', $failed],
                ['Total', $total],
            ]
        );

        return 0;
    }

    /**
     * Fetch batch details from SIMBG
     */
    protected function fetchBatchDetails(array $uids)
    {
        try {
            $url = $this->baseUrl . '/api/data/pengajuan/batch-details';
            
            // Build query string manually for uids[] format
            $params = [];
            foreach ($uids as $uid) {
                $params[] = 'uids[]=' . urlencode($uid);
            }
            $queryString = implode('&', $params);
            $fullUrl = $url . '?' . $queryString;

            $response = $this->httpClient->get($fullUrl);
            $json = json_decode($response->getBody()->getContents(), true);

            if (!isset($json['success']) || !$json['success']) {
                throw new \Exception("Batch details API error: " . ($json['message'] ?? 'Unknown error'));
            }

            return $json['data'] ?? [];

        } catch (\Exception $e) {
            Log::error('Failed to fetch batch details: ' . $e->getMessage());
            $this->error('Error: ' . $e->getMessage());
            return [];
        }
    }
}
