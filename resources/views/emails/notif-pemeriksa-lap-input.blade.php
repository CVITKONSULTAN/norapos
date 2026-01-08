<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background:#f7f7f7; padding:20px;">
    
    <div style="max-width:600px; margin:auto; background:white; border-radius:8px; padding:25px; box-shadow:0 0 8px rgba(0,0,0,0.1);">

        <h2 style="margin-top:0; color:#333; font-weight:600;">
            Pemeriksaan Lapangan Telah Selesai
        </h2>

        <p style="font-size:14px; color:#444;">
            Yth. Bapak/Ibu Pemeriksa,
        </p>

        <p style="font-size:14px; color:#444; line-height:1.5;">
            Petugas lapangan telah menyelesaikan input hasil pemeriksaan untuk pengajuan berikut:
        </p>

        <table style="width:100%; margin-top:10px; border-collapse:collapse; font-size:14px;">
            <tr>
                <td style="padding:6px 0; color:#555; width:150px;">No Pemohon</td>
                <td style="padding:6px 0; color:#333;">: {{ $pengajuan->no_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555; width:150px;">Nama Pemohon</td>
                <td style="padding:6px 0; color:#333;">: {{ $pengajuan->nama_pemohon }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;">Fungsi Bangunan</td>
                <td style="padding:6px 0; color:#333;">: {{ $pengajuan->fungsi_bangunan }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;">Alamat Bangunan</td>
                <td style="padding:6px 0; color:#333;">: {{ $pengajuan->alamat }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#555;">Tanggal Pemeriksaan</td>
                <td style="padding:6px 0; color:#333;">: {{ date('d/m/Y H:i:s') }}</td>
            </tr>
        </table>

        <p style="margin-top:18px; font-size:14px; color:#444;">
            Silakan melakukan verifikasi melalui tombol berikut:
        </p>

        <p style="text-align:left; margin-top:15px;">
            <a href="{{ url('/ciptakarya/list-data-pbg?pengajuan=' . $pengajuan->id) }}"
               style="background:#0d6efd; color:white; padding:10px 18px; border-radius:6px; text-decoration:none; font-size:14px;">
                Buka Detail Pemeriksaan
            </a>
        </p>

        <p style="margin-top:25px; font-size:13px; color:#777; line-height:1.5;">
            Terima kasih.<br>
            <strong>Sistem PBG Online</strong>
        </p>

    </div>

</body>
</html>
