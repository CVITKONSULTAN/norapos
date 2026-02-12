<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Login Petugas Lapangan</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #2F80ED 0%, #1e5bb8 100%);
            color: white;
            padding: 30px 40px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-header p {
            margin: 8px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .email-body {
            padding: 40px;
        }
        .email-body h2 {
            color: #333;
            font-size: 20px;
            margin: 0 0 10px;
        }
        .email-body p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 20px;
        }
        .login-button {
            display: inline-block;
            background: #2F80ED;
            color: white;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            text-align: center;
            margin: 20px 0;
            transition: background 0.3s;
        }
        .login-button:hover {
            background: #1e5bb8;
        }
        .info-box {
            background: #FFF9E6;
            border-left: 4px solid #FFC107;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 0;
            font-size: 14px;
            color: #856404;
        }
        .email-footer {
            background: #f9f9f9;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .email-footer p {
            color: #999;
            font-size: 13px;
            margin: 5px 0;
        }
        .alternative-link {
            word-break: break-all;
            background: #f5f5f5;
            padding: 12px;
            border-radius: 6px;
            font-size: 13px;
            color: #666;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>🔐 Link Login Petugas Lapangan</h1>
            <p>Cipta Karya Kabupaten Kubu Raya</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h2>Halo, {{ $petugas->nama }} 👋</h2>
            
            <p>
                Kami menerima permintaan untuk login ke sistem petugas lapangan. 
                Klik tombol di bawah ini untuk melanjutkan:
            </p>

            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="login-button">
                    Login Sekarang
                </a>
            </div>

            <div class="info-box">
                <p>
                    <strong>⚠️ Penting:</strong> Link ini berlaku selama <strong>15 menit</strong> 
                    dan hanya dapat digunakan satu kali. Jika link kadaluarsa, silakan request link baru.
                </p>
            </div>

            <p style="font-size: 14px; color: #999;">
                Atau copy dan paste link berikut ke browser Anda:
            </p>
            
            <div class="alternative-link">
                {{ $loginUrl }}
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #999;">
                Jika Anda tidak meminta link ini, abaikan email ini. 
                Akun Anda tetap aman.
            </p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p><strong>Cipta Karya Kabupaten Kubu Raya</strong></p>
            <p>Sistem Petugas Lapangan Verifikasi PBG</p>
            <p style="margin-top: 15px;">
                Email ini dikirim secara otomatis, mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
