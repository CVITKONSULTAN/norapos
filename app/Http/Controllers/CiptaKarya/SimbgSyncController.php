<?php

namespace App\Http\Controllers\CiptaKarya;

use App\Http\Controllers\Controller;
use App\Services\SimbgSyncService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SimbgSyncController extends Controller
{
    protected $syncService;

    public function __construct(SimbgSyncService $syncService)
    {
        $this->syncService = $syncService;
    }

    /**
     * Trigger manual sync
     */
    public function sync(Request $request)
    {
        try {
            Log::info('🔄 Manual sync triggered by user: ' . auth()->id());

            // Run sync
            $result = $this->syncService->sync(auth()->id());

            // Prepare response message
            $message = $this->buildResponseMessage($result);

            return response()->json([
                'status' => true,
                'message' => $message,
                'data' => [
                    'total_fetched' => $result['total_fetched'],
                    'total_new' => $result['total_new'],
                    'total_updated' => $result['total_updated'],
                    'total_skipped' => $result['total_skipped'],
                    'sync_status' => $result['status'],
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Sync failed: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan sinkronisasi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get last sync info
     */
    public function getLastSync()
    {
        try {
            $lastSync = $this->syncService->getLastSync();

            if (!$lastSync) {
                return response()->json([
                    'status' => true,
                    'message' => 'Belum pernah melakukan sync',
                    'data' => null,
                ]);
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'synced_at' => $lastSync->synced_at,
                    'total_fetched' => $lastSync->total_fetched,
                    'total_new' => $lastSync->total_new,
                    'total_updated' => $lastSync->total_updated,
                    'status' => $lastSync->status,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get sync logs with pagination
     */
    public function getLogs(Request $request)
    {
        try {
            $limit = $request->input('limit', 20);
            
            $logs = \DB::table('simbg_sync_logs')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($log) {
                    return [
                        'id' => $log->id,
                        'status' => $log->status,
                        'total_synced' => $log->total_fetched ?? 0,
                        'message' => $this->formatLogMessage($log),
                        'created_at' => $log->created_at,
                    ];
                });

            return response()->json([
                'status' => true,
                'data' => $logs,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat log: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Format log message for display
     */
    protected function formatLogMessage($log)
    {
        if ($log->status === 'failed') {
            return $log->error_message ?? 'Sync gagal';
        }

        $parts = [];
        
        if ($log->total_new > 0) {
            $parts[] = "{$log->total_new} baru";
        }
        
        if ($log->total_updated > 0) {
            $parts[] = "{$log->total_updated} diupdate";
        }
        
        if ($log->total_skipped > 0) {
            $parts[] = "{$log->total_skipped} di-skip";
        }

        if (empty($parts)) {
            return 'Tidak ada data baru';
        }

        return 'Data: ' . implode(', ', $parts);
    }

    /**
     * Build user-friendly response message
     */
    protected function buildResponseMessage($result)
    {
        if ($result['status'] === 'failed') {
            return 'Sync gagal: ' . ($result['error_message'] ?? 'Unknown error');
        }

        $parts = [];
        
        if ($result['total_new'] > 0) {
            $parts[] = "{$result['total_new']} pengajuan baru ditambahkan";
        }
        
        if ($result['total_updated'] > 0) {
            $parts[] = "{$result['total_updated']} pengajuan diupdate";
        }
        
        if ($result['total_skipped'] > 0) {
            $parts[] = "{$result['total_skipped']} pengajuan sudah ada (di-skip)";
        }

        if (empty($parts)) {
            return 'Sync berhasil. Tidak ada data baru.';
        }

        $message = 'Sync berhasil! ' . implode(', ', $parts) . '.';

        if ($result['total_new'] > 0) {
            $message .= ' Email notifikasi telah dikirim ke Kabid & Admin.';
        }

        return $message;
    }
}
