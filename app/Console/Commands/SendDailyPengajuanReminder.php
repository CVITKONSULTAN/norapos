<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CiptaKarya\PengajuanPBG;
use App\Models\CiptaKarya\PbgTracking;
use App\User;
use App\Mail\DailyPengajuanReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendDailyPengajuanReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pengajuan:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email reminder harian untuk pengajuan yang masih diproses';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('📧 Starting daily pengajuan reminder...');
        Log::info('Cron: Daily pengajuan reminder started');

        try {
            $startTime = now();
            
            // Mapping role ke step tracking
            // Format role: namarole#business_id (contoh: Admin#18)
            $businessId = 18; // Default business_id
            
            $roleStepMapping = [
                "Admin#{$businessId}" => 'admin',
                "Petugas Lapangan#{$businessId}" => 'petugas_lapangan',
                "Pemeriksa#{$businessId}" => 'pemeriksa',
                "Retribusi#{$businessId}" => 'admin_retribusi',
                "Koordinator#{$businessId}" => 'koordinator',
                "Kepala Bidang#{$businessId}" => 'kabid',
                "Kepala Dinas#{$businessId}" => 'kadis',
            ];

            $totalEmailSent = 0;

            foreach ($roleStepMapping as $roleName => $stepName) {
                $this->info("Processing role: {$roleName}");
                
                // Get users by role (format: namarole#business_id)
                $users = User::whereHas('roles', function($q) use ($roleName) {
                    $q->where('name', $roleName); // Role sudah dalam format Admin#18
                })->get();

                foreach ($users as $user) {
                    // Get pengajuan yang statusnya masih 'proses' atau 'pending'
                    // dan masih di tahapan user ini (berdasarkan tracking)
                    $pengajuanList = $this->getPengajuanForUser($user, $stepName);

                    if (count($pengajuanList) > 0) {
                        // Kirim email
                        // Extract role name tanpa business_id untuk display
                        $displayRoleName = explode('#', $roleName)[0];
                        
                        Mail::to($user->email)->send(
                            new DailyPengajuanReminderMail(
                                $pengajuanList,
                                $user->first_name . ' ' . $user->last_name,
                                $displayRoleName
                            )
                        );

                        $totalEmailSent++;
                        $this->info("Email sent to: {$user->email} ({$user->first_name}) - " . count($pengajuanList) . " pengajuan");
                        Log::info("Daily reminder sent to {$user->email}", ['pengajuan_count' => count($pengajuanList)]);
                    }
                }
            }

            $duration = now()->diffInSeconds($startTime);
            $this->info("✅ Daily reminder completed in {$duration}s. Total emails sent: {$totalEmailSent}");
            Log::info('Cron: Daily pengajuan reminder completed', [
                'duration_seconds' => $duration,
                'emails_sent' => $totalEmailSent
            ]);

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            Log::error('Cron: Daily reminder failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return 1;
        }
    }

    /**
     * Get pengajuan yang masih menunggu aksi dari user dengan role tertentu
     */
    private function getPengajuanForUser($user, $stepName)
    {
        // Ambil pengajuan yang masih status proses/pending
        $pengajuanQuery = PengajuanPBG::whereIn('status', ['proses', 'pending'])
            ->orderBy('created_at', 'asc')
            ->get();

        $result = [];

        foreach ($pengajuanQuery as $pengajuan) {
            // Cek di tracking apakah pengajuan ini masih di tahap stepName
            // dan belum di-approve
            $tracking = PbgTracking::where('pengajuan_id', $pengajuan->id)
                ->where('role', $stepName)
                ->first();

            // Jika tracking belum ada atau status masih pending
            if (!$tracking || $tracking->status == 'pending') {
                $hariKerja = $this->hitungHariKerja($pengajuan->created_at, now());
                
                $result[] = [
                    'id' => $pengajuan->id,
                    'no_permohonan' => $pengajuan->no_permohonan,
                    'nama_pemohon' => $pengajuan->nama_pemohon,
                    'tipe' => $pengajuan->tipe,
                    'hari_kerja' => $hariKerja,
                    'current_step' => $stepName,
                    'created_at' => $pengajuan->created_at->format('d/m/Y'),
                ];
            }
        }

        return $result;
    }

    /**
     * Hitung hari kerja (tidak termasuk Sabtu & Minggu)
     */
    private function hitungHariKerja($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        $hariKerja = 0;
        
        while ($start->lte($end)) {
            // 6 = Sabtu, 0 = Minggu
            if ($start->dayOfWeek !== 6 && $start->dayOfWeek !== 0) {
                $hariKerja++;
            }
            $start->addDay();
        }
        
        return $hariKerja;
    }
}
