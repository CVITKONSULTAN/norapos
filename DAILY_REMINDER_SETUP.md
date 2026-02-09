# Setup Cron Job untuk Notifikasi Harian Pengajuan

## Fitur yang Ditambahkan

### 1. Kolom "Hari Ke-" di Tabel DataTables
- Menampilkan berapa hari kerja (tidak termasuk Sabtu & Minggu) sejak pengajuan dibuat
- Highlight warna:
  - **Hijau**: 1-10 hari kerja
  - **Orange**: 11-15 hari kerja
  - **Merah & Bold**: Lebih dari 15 hari kerja (sudah melebihi batas SLA)

### 2. Notifikasi Email Harian
- Sistem otomatis mengirim email reminder ke setiap user yang memiliki pengajuan menunggu
- Email dikirim berdasarkan role/tahapan proses
- Hanya mengirim ke user yang memiliki pengajuan tertunda di tahapannya

## Setup Cron Job

### 1. Test Command Secara Manual

Sebelum setup cron, test dulu command-nya:

```bash
# Test kirim notifikasi reminder
php artisan pengajuan:reminder

# Test sync SIMBG (kalau perlu)
php artisan simbg:sync
```

### 2. Setup Cron Job di Server

Edit crontab:

```bash
crontab -e
```

Tambahkan line berikut:

```bash
# Laravel Scheduler - Running every minute
* * * * * cd /var/www/kartika && php artisan schedule:run >> /dev/null 2>&1
```

**Catatan:** 
- Laravel scheduler akan menjalankan semua task yang didefinisikan di `app/Console/Kernel.php`
- Notifikasi reminder akan berjalan otomatis setiap hari jam **08:00 pagi**
- SIMBG sync akan berjalan otomatis setiap hari jam **01:00 pagi**

### 3. Verifikasi Cron Berjalan

Cek log Laravel untuk memastikan cron berjalan:

```bash
tail -f storage/logs/laravel.log
```

Atau cek schedule list:

```bash
php artisan schedule:list
```

## Struktur File yang Ditambahkan

```
app/
├── Console/
│   ├── Commands/
│   │   └── SendDailyPengajuanReminder.php    # Command untuk kirim email
│   └── Kernel.php                             # Schedule definition (Updated)
├── Mail/
│   └── DailyPengajuanReminderMail.php        # Mailable class
└── Http/
    └── Controllers/
        └── CiptaKarya/
            └── DataController.php             # Updated dengan hitungHariKerja()

resources/
└── views/
    └── emails/
        └── daily_pengajuan_reminder.blade.php # Email template
```

## Konfigurasi Email

Pastikan konfigurasi email di `.env` sudah benar:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Logika Notifikasi

Notifikasi akan dikirim ke user berdasarkan **role** dan **tahapan proses**:

**Format Role:** `namarole#business_id` (contoh: `Admin#18`)

| Role (Format: role#18) | Tahapan Tracking | Kondisi Notifikasi |
|------|------------------|-------------------|
| Admin#18 | admin | Pengajuan baru yang belum ditugaskan |
| Petugas Lapangan#18 | petugas_lapangan | Pengajuan sudah ditugaskan, belum survey |
| Pemeriksa#18 | pemeriksa | Menunggu pemeriksaan dokumen |
| Retribusi#18 | admin_retribusi | Menunggu perhitungan retribusi |
| Koordinator#18 | koordinator | Menunggu verifikasi koordinator |
| Kepala Bidang#18 | kabid | Menunggu validasi Kabid |
| Kepala Dinas#18 | kadis | Menunggu approval Kadis |

**Daftar Role di Sistem:**
- Admin
- Kasir
- Kepala Bidang
- Kepala Dinas
- Koordinator
- Pemeriksa
- Petugas Lapangan
- Retribusi

## Testing

### Manual Test Command

```bash
# Jalankan command manual untuk test
php artisan pengajuan:reminder

# Cek output di console untuk lihat berapa email terkirim
```

### Test dengan Tinker

```bash
php artisan tinker
```

```php
// Test ambil pengajuan yang pending
$pengajuan = \App\Models\CiptaKarya\PengajuanPBG::whereIn('status', ['proses', 'pending'])->get();
$pengajuan->count(); // lihat jumlahnya

// Test kirim email manual
Mail::to('test@example.com')->send(
    new \App\Mail\DailyPengajuanReminderMail(
        [['no_permohonan' => 'TEST001', 'nama_pemohon' => 'Test User', 'tipe' => 'PBG', 'hari_kerja' => 12, 'current_step' => 'admin', 'created_at' => '01/01/2026']],
        'Test User',
        'Admin'
    )
);
```

## Troubleshooting

### Email tidak terkirim
1. Cek konfigurasi MAIL di `.env`
2. Cek log error: `tail -f storage/logs/laravel.log`
3. Test SMTP connection dengan tinker
4. Pastikan firewall tidak block port SMTP

### Cron tidak berjalan
1. Cek apakah crontab sudah terdaftar: `crontab -l`
2. Cek permission folder: `chmod -R 775 storage bootstrap/cache`
3. Cek cron service running: `systemctl status cron`
4. Cek syslog: `grep CRON /var/log/syslog`

### Kolom Hari Ke- tidak muncul
1. Clear cache: `php artisan cache:clear`
2. Refresh DataTable di browser (Ctrl+F5)
3. Cek console browser untuk error JavaScript

## Maintenance

### Disable Notifikasi Sementara
Edit `app/Console/Kernel.php`, comment line schedule:

```php
// $schedule->command('pengajuan:reminder')
//     ->dailyAt('08:00')
//     ...
```

### Ubah Waktu Kirim Notifikasi
Edit di `app/Console/Kernel.php`:

```php
// Ubah dari 08:00 ke waktu lain, misalnya 07:30
$schedule->command('pengajuan:reminder')
    ->dailyAt('07:30')
    ...
```

### Kirim ke Email BCC Admin
Edit command `SendDailyPengajuanReminder.php`:

```php
Mail::to($user->email)
    ->bcc('admin@example.com') // tambahkan ini
    ->send(new DailyPengajuanReminderMail(...));
```

## Performance Note

- Command akan skip pengajuan yang sudah status 'terbit' atau 'tolak'
- Hanya memproses pengajuan dengan status 'proses' atau 'pending'
- Email hanya dikirim ke user yang ada pengajuan tertunda di tahapannya
- Tidak ada email spam ke user yang tidak punya tugas pending

## Author & Support

Dikembangkan untuk sistem SIMBG Kartika.
Untuk support: hubungi tim IT internal.
