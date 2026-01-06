<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sekolah\PPDBSetting;
use App\Models\Sekolah\PPDBSekolah;
use Illuminate\Support\Facades\DB;

class PPDBTestData extends Command
{
    protected $signature = 'ppdb:test-data';
    protected $description = 'Generate test data untuk fitur assign jadwal PPDB';

    public function handle()
    {
        $this->info('🚀 Membuat data test PPDB...');

        // Cek apakah data test sudah ada
        $existing = PPDBSekolah::whereIn('kode_bayar', [
            'PPDB-AR123', 'PPDB-SN456', 'PPDB-BS789', 'PPDB-DL234', 'PPDB-EP567',
            'PPDB-FR111', 'PPDB-GS222'
        ])->count();

        if ($existing > 0) {
            if (!$this->confirm("⚠️  Data test sudah ada ({$existing} peserta). Hapus dan buat ulang?")) {
                $this->info('❌ Dibatalkan.');
                return;
            }

            // Hapus data lama - hapus jadwal dulu
            $deletedSchedules = DB::table('ppdb_test_schedules')->whereIn('kode_bayar', [
                'PPDB-AR123', 'PPDB-SN456', 'PPDB-BS789', 'PPDB-DL234', 'PPDB-EP567',
                'PPDB-FR111', 'PPDB-GS222'
            ])->delete();

            // Hapus peserta
            $deletedPeserta = PPDBSekolah::whereIn('kode_bayar', [
                'PPDB-AR123', 'PPDB-SN456', 'PPDB-BS789', 'PPDB-DL234', 'PPDB-EP567',
                'PPDB-FR111', 'PPDB-GS222'
            ])->delete();

            $this->info("🗑️  Data lama berhasil dihapus ({$deletedPeserta} peserta, {$deletedSchedules} jadwal).");
        }

        // 1. Insert PPDB Setting Aktif
        $setting = PPDBSetting::where('close_ppdb', false)->first();
        
        if (!$setting) {
            $setting = PPDBSetting::create([
                'tahun_ajaran' => '2025/2026',
                'tgl_penerimaan' => '2026-01-01',
                'jumlah_tagihan' => 350000,
                'nama_bank' => 'Bank Kalbar',
                'no_rek' => '12345678',
                'atas_nama' => 'SD Muhammadiyah 2',
                'close_ppdb' => false,
                'session_capacities' => [
                    [
                        'type' => 'iq',
                        'date' => '2026-01-15',
                        'start' => '08:00',
                        'end' => '09:00',
                        'capacity' => 15
                    ],
                    [
                        'type' => 'iq',
                        'date' => '2026-01-15',
                        'start' => '09:30',
                        'end' => '10:30',
                        'capacity' => 15
                    ],
                    [
                        'type' => 'iq',
                        'date' => '2026-01-16',
                        'start' => '08:00',
                        'end' => '09:00',
                        'capacity' => 15
                    ],
                    [
                        'type' => 'map',
                        'date' => '2026-01-15',
                        'start' => '10:45',
                        'end' => '11:45',
                        'capacity' => 15
                    ],
                    [
                        'type' => 'map',
                        'date' => '2026-01-15',
                        'start' => '13:00',
                        'end' => '14:00',
                        'capacity' => 15
                    ],
                    [
                        'type' => 'map',
                        'date' => '2026-01-16',
                        'start' => '10:45',
                        'end' => '11:45',
                        'capacity' => 15
                    ]
                ]
            ]);
            $this->info("✅ PPDB Setting created (ID: {$setting->id})");
        } else {
            $this->info("✅ Menggunakan PPDB Setting existing (ID: {$setting->id})");
        }

        // 2. Insert Peserta BELUM ADA JADWAL
        $pesertaBelumJadwal = [
            [
                'nama' => 'Ahmad Ridho',
                'kode_bayar' => 'PPDB-AR123',
                'detail' => [
                    'nama_lengkap' => 'Ahmad Ridho',
                    'no_hp' => '081234567890',
                    'email' => 'ahmad.ridho@example.com',
                    'nik' => '6371012345678901'
                ]
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'kode_bayar' => 'PPDB-SN456',
                'detail' => [
                    'nama_lengkap' => 'Siti Nurhaliza',
                    'no_hp' => '081234567891',
                    'email' => 'siti.nurhaliza@example.com',
                    'nik' => '6371012345678902'
                ]
            ],
            [
                'nama' => 'Budi Santoso',
                'kode_bayar' => 'PPDB-BS789',
                'detail' => [
                    'nama_lengkap' => 'Budi Santoso',
                    'no_hp' => '081234567892',
                    'email' => 'budi.santoso@example.com',
                    'nik' => '6371012345678903'
                ]
            ],
            [
                'nama' => 'Dewi Lestari',
                'kode_bayar' => 'PPDB-DL234',
                'detail' => [
                    'nama_lengkap' => 'Dewi Lestari',
                    'no_hp' => '081234567893',
                    'email' => 'dewi.lestari@example.com',
                    'nik' => '6371012345678904'
                ]
            ],
            [
                'nama' => 'Eko Prasetyo',
                'kode_bayar' => 'PPDB-EP567',
                'detail' => [
                    'nama_lengkap' => 'Eko Prasetyo',
                    'no_hp' => '081234567894',
                    'email' => 'eko.prasetyo@example.com',
                    'nik' => '6371012345678905'
                ]
            ]
        ];

        foreach ($pesertaBelumJadwal as $data) {
            PPDBSekolah::create([
                'nama' => $data['nama'],
                'kode_bayar' => $data['kode_bayar'],
                'status_bayar' => 'sudah',
                'detail' => $data['detail'],
                'validated_at' => now(),
                'ppdb_setting_id' => $setting->id
            ]);
        }

        $this->info("✅ 5 Peserta BELUM DAPAT JADWAL berhasil dibuat");

        // 3. Insert Peserta SUDAH ADA JADWAL
        $pesertaSudahJadwal = [
            [
                'nama' => 'Fajar Ramadhan',
                'kode_bayar' => 'PPDB-FR111',
                'detail' => [
                    'nama_lengkap' => 'Fajar Ramadhan',
                    'no_hp' => '081234567895',
                    'email' => 'fajar.ramadhan@example.com',
                    'nik' => '6371012345678906'
                ]
            ],
            [
                'nama' => 'Gita Savitri',
                'kode_bayar' => 'PPDB-GS222',
                'detail' => [
                    'nama_lengkap' => 'Gita Savitri',
                    'no_hp' => '081234567896',
                    'email' => 'gita.savitri@example.com',
                    'nik' => '6371012345678907'
                ]
            ]
        ];

        foreach ($pesertaSudahJadwal as $data) {
            PPDBSekolah::create([
                'nama' => $data['nama'],
                'kode_bayar' => $data['kode_bayar'],
                'status_bayar' => 'sudah',
                'detail' => $data['detail'],
                'validated_at' => now(),
                'ppdb_setting_id' => $setting->id
            ]);

            // Insert jadwal
            DB::table('ppdb_test_schedules')->insert([
                'kode_bayar' => $data['kode_bayar'],
                'iq_date' => '2026-01-15',
                'iq_start_time' => '08:00:00',
                'iq_end_time' => '09:00:00',
                'map_date' => '2026-01-15',
                'map_start_time' => '10:45:00',
                'map_end_time' => '11:45:00',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        $this->info("✅ 2 Peserta SUDAH DAPAT JADWAL berhasil dibuat");

        $this->line('');
        $this->line('========================================');
        $this->info('📊 HASIL YANG DIHARAPKAN:');
        $this->line('========================================');
        $this->line('1. Ada 5 peserta BELUM DAPAT JADWAL:');
        $this->line('   - Ahmad Ridho (PPDB-AR123)');
        $this->line('   - Siti Nurhaliza (PPDB-SN456)');
        $this->line('   - Budi Santoso (PPDB-BS789)');
        $this->line('   - Dewi Lestari (PPDB-DL234)');
        $this->line('   - Eko Prasetyo (PPDB-EP567)');
        $this->line('');
        $this->line('2. Ada 2 peserta SUDAH DAPAT JADWAL:');
        $this->line('   - Fajar Ramadhan (PPDB-FR111)');
        $this->line('   - Gita Savitri (PPDB-GS222)');
        $this->line('');
        $this->line('3. Statistik Kapasitas:');
        $this->line('   - IQ 15 Jan 08:00-09:00 → 2/15 (13 slot kosong)');
        $this->line('   - IQ 15 Jan 09:30-10:30 → 0/15 (15 slot kosong)');
        $this->line('   - IQ 16 Jan 08:00-09:00 → 0/15 (15 slot kosong)');
        $this->line('   - MAP 15 Jan 10:45-11:45 → 2/15 (13 slot kosong)');
        $this->line('   - MAP 15 Jan 13:00-14:00 → 0/15 (15 slot kosong)');
        $this->line('   - MAP 16 Jan 10:45-11:45 → 0/15 (15 slot kosong)');
        $this->line('========================================');
        $this->line('');
        $this->info('🎉 Selesai! Silakan test fitur assign jadwal.');
    }
}
