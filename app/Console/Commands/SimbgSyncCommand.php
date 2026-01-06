<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SimbgSyncService;
use Illuminate\Support\Facades\Log;

class SimbgSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simbg:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data pengajuan dari SIMBG Robot ke Laravel';

    protected $syncService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SimbgSyncService $syncService)
    {
        parent::__construct();
        $this->syncService = $syncService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('🤖 Starting SIMBG sync...');
        Log::info('Cron: SIMBG sync started via command');

        try {
            $startTime = now();
            
            // Run sync (no user ID for cron jobs)
            $result = $this->syncService->sync();

            $duration = now()->diffInSeconds($startTime);

            // Display results
            $this->line('');
            $this->info("✅ Sync completed in {$duration} seconds!");
            $this->line('');
            $this->table(
                ['Metric', 'Count'],
                [
                    ['Total Fetched', $result['total_fetched']],
                    ['New Records', $result['total_new']],
                    ['Updated Records', $result['total_updated']],
                    ['Skipped Records', $result['total_skipped']],
                    ['Status', strtoupper($result['status'])],
                ]
            );

            if ($result['total_new'] > 0) {
                $this->info("📧 Email notifications sent to Kabid & Admin");
            }

            Log::info('Cron: SIMBG sync completed', $result);

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Sync failed: ' . $e->getMessage());
            Log::error('Cron: SIMBG sync failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return 1;
        }
    }
}
