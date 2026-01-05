<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4CAF50; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .schedule-box { background: white; padding: 15px; margin: 10px 0; border-left: 4px solid #2196F3; }
        .schedule-title { font-weight: bold; color: #2196F3; margin-bottom: 10px; }
        .info-row { margin: 8px 0; }
        .label { font-weight: bold; display: inline-block; width: 150px; }
        .footer { text-align: center; padding: 20px; color: #777; font-size: 12px; }
        .button { display: inline-block; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>🎓 Jadwal Tes PPDB</h2>
            <p>SD Muhammadiyah 2 Pontianak</p>
        </div>

        <div class="content">
            <p>Yth. Orang Tua/Wali dari <strong>{{ $data['nama'] }}</strong>,</p>
            
            <p>Selamat! Pembayaran Anda telah diverifikasi. Berikut adalah jadwal tes untuk calon peserta didik:</p>

            <!-- Info Peserta -->
            <div class="schedule-box">
                <div class="info-row">
                    <span class="label">Nama Peserta:</span>
                    <span>{{ $data['nama'] }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Kode Bayar:</span>
                    <span><strong>{{ $data['kode_bayar'] }}</strong></span>
                </div>
            </div>

            <!-- Jadwal Tes IQ -->
            @if(!empty($data['iq_date']))
            <div class="schedule-box">
                <div class="schedule-title">📝 Tes IQ (Intelegensi)</div>
                <div class="info-row">
                    <span class="label">Tanggal:</span>
                    <span>{{ \Carbon\Carbon::parse($data['iq_date'])->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Waktu:</span>
                    <span>{{ \Carbon\Carbon::parse($data['iq_start_time'])->format('H:i') }} - {{ \Carbon\Carbon::parse($data['iq_end_time'])->format('H:i') }} WIB</span>
                </div>
                @if(!empty($data['tempat_tes']))
                <div class="info-row">
                    <span class="label">Tempat:</span>
                    <span>{{ $data['tempat_tes'] }}</span>
                </div>
                @endif
            </div>
            @endif

            <!-- Jadwal Tes Pemetaan -->
            @if(!empty($data['map_date']))
            <div class="schedule-box">
                <div class="schedule-title">🗺️ Tes Pemetaan (MAP)</div>
                <div class="info-row">
                    <span class="label">Tanggal:</span>
                    <span>{{ \Carbon\Carbon::parse($data['map_date'])->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Waktu:</span>
                    <span>{{ \Carbon\Carbon::parse($data['map_start_time'])->format('H:i') }} - {{ \Carbon\Carbon::parse($data['map_end_time'])->format('H:i') }} WIB</span>
                </div>
                @if(!empty($data['tempat_tes']))
                <div class="info-row">
                    <span class="label">Tempat:</span>
                    <span>{{ $data['tempat_tes'] }}</span>
                </div>
                @endif
            </div>
            @endif

            <!-- Catatan Penting -->
            <div style="background: #fff3cd; padding: 15px; margin: 20px 0; border-left: 4px solid #ffc107; border-radius: 5px;">
                <strong>⚠️ Catatan Penting:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Harap datang <strong>15 menit sebelum</strong> jadwal tes dimulai</li>
                    <li>Bawa alat tulis (pensil 2B, penghapus, pulpen)</li>
                    <li>Kenakan pakaian yang rapi dan sopan</li>
                    <li>Bawa kartu tes PPDB (dapat dicetak dari website)</li>
                </ul>
            </div>

            <div style="text-align: center; margin: 20px 0;">
                <a href="{{ url('/cetak-karu-simuda?kode_bayar=' . $data['kode_bayar']) }}" class="button">
                    🖨️ Cetak Kartu Tes
                </a>
            </div>

            <!-- <p>Jika ada pertanyaan, silakan hubungi kami melalui:</p>
            <div class="info-row">
                <span class="label">Telepon:</span>
                <span>0561-734567</span>
            </div>
            <div class="info-row">
                <span class="label">WhatsApp:</span>
                <span>0812-3456-7890</span>
            </div> -->
        </div>

        <div class="footer">
            <p><strong>SD Muhammadiyah 2 Pontianak</strong></p>
            <p>Jl. KH. Ahmad Dahlan No. 2, Pontianak, Kalimantan Barat</p>
            <p style="font-size: 11px; color: #999;">
                Email ini dikirim secara otomatis. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
