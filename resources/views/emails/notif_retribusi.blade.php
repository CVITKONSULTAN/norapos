<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Notifikasi Verifikasi Pemeriksa</title>
</head>

<body style="background:#f8f6ef; margin:0; padding:30px; font-family:Arial, sans-serif;">

    <div style="
        max-width:600px; 
        margin:0 auto; 
        background:white;
        border-radius:10px;
        border:1px solid #f0dba8;
        box-shadow:0 6px 18px rgba(0,0,0,0.06);
        overflow:hidden;
    ">

        <!-- HEADER -->
        <div style="
            background:#f4c542; 
            padding:18px 25px; 
            color:#fff; 
            font-size:22px; 
            font-weight:bold;
            text-align:center;
            letter-spacing:0.5px;">
            Pemberitahuan Verifikasi Pemeriksa
        </div>

        <!-- CONTENT -->
        <div style="padding:25px; color:#333;">

            <p style="font-size:16px; margin-top:0;">
                Yth. <b>Admin Retribusi</b>,
            </p>

            <p style="font-size:15px; line-height:1.5;">
                Pemeriksa telah menyelesaikan verifikasi pada salah satu pengajuan bangunan.  
                Berikut detail informasi pengajuan:
            </p>

            <!-- CARD INFO -->
            <div style="
                background:#fffdf3;
                border:1px solid #f3e4b8;
                border-radius:8px;
                padding:15px 18px;
                margin:20px 0;
            ">
                <p style="margin:6px 0; font-size:14px;">
                    <b>No. Permohonan:</b> {{ $pengajuan->no_permohonan }}
                </p>
                <p style="margin:6px 0; font-size:14px;">
                    <b>Nama Pemohon:</b> {{ $pengajuan->nama_pemohon }}
                </p>
                <p style="margin:6px 0; font-size:14px;">
                    <b>Nama Bangunan:</b> {{ $pengajuan->nama_bangunan }}
                </p>
            </div>

            <!-- VERIFIKASI RESULT -->
            <h3 style="
                margin:10px 0 5px; 
                font-size:17px;
                border-bottom:2px solid #eee;
                padding-bottom:4px;
            ">
                Hasil Pemeriksa
            </h3>

            <p style="font-size:14px; margin:6px 0;">
                <b>Status:</b> 
                <span style="
                    color: {{ $tracking->status == 'sesuai' ? '#16a34a' : '#dc2626' }};
                    font-weight:bold;
                    text-transform:uppercase;
                ">
                    {{ $tracking->status }}
                </span>
            </p>

            @if($tracking->catatan)
            <p style="font-size:14px; margin:6px 0;">
                <b>Catatan:</b> {{ $tracking->catatan }}
            </p>
            @endif

            <p style="font-size:14px; margin:6px 0;">
                <b>Waktu Verifikasi:</b> {{ $tracking->verified_at }}
            </p>

            <br>

            <p style="font-size:15px; line-height:1.5;">
                Silakan melanjutkan proses <b>perhitungan retribusi</b> melalui aplikasi Cipta Karya.
            </p>

            <!-- BUTTON -->
            <div style="text-align:center; margin:30px 0 10px;">
                <a href="{{ url('/ciptakarya/list-data-pbg?pengajuan=' . $pengajuan->id) }}" 
                    style="
                        background:#f4c542;
                        color:#333;
                        padding:12px 25px;
                        border-radius:6px;
                        text-decoration:none;
                        font-weight:bold;
                        font-size:15px;
                        display:inline-block;
                    ">
                    Buka Aplikasi
                </a>
            </div>

        </div>

        <!-- FOOTER -->
        <div style="
            background:#faf8ef;
            padding:12px 20px;
            font-size:12px;
            color:#888;
            text-align:center;
            border-top:1px solid #f0e6c4;
        ">
            Email ini dikirim otomatis oleh sistem. Harap tidak membalas email ini.
        </div>

    </div>

</body>
</html>
