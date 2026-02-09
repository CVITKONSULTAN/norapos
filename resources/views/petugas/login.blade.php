<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Petugas Lapangan - Bidang Cipta Karya PUPR Kuburaya</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2F80ED 0%, #1e5bb8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            max-width: 450px;
            width: 100%;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-container img {
            height: 80px;
            width: 80px;
            margin-bottom: 15px;
        }
        .logo-container h3 {
            color: #333;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .logo-container p {
            color: #666;
            font-size: 14px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 18px;
            border: 1px solid #ddd;
            font-size: 15px;
        }
        .form-control:focus {
            border-color: #2F80ED;
            box-shadow: 0 0 0 0.2rem rgba(47,128,237,0.15);
        }
        .btn-login {
            background: #2F80ED;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: #1e5bb8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(47,128,237,0.3);
        }
        .alert {
            border-radius: 10px;
            font-size: 14px;
            padding: 12px 18px;
        }
        .info-text {
            text-align: center;
            color: #666;
            font-size: 13px;
            margin-top: 20px;
            line-height: 1.6;
        }
        .wave-emoji {
            animation: wave 1s ease-in-out infinite;
            display: inline-block;
        }
        @keyframes wave {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(20deg); }
            75% { transform: rotate(-20deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="{{ asset('images/kuburaya-logo.webp') }}" alt="Logo Kubu Raya" onerror="this.src='https://via.placeholder.com/80'">
            <h3>Login Petugas Lapangan</h3>
            <p>Bidang Cipta Karya PUPR Kuburaya</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>✓</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>✕</strong> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <form action="{{ route('petugas.login.send') }}" method="POST" id="loginForm">
            @csrf
            <div class="form-group">
                <label for="email" style="font-weight: 600; color: #333; margin-bottom: 8px;">
                    📧 Email Petugas
                </label>
                <input 
                    type="email" 
                    class="form-control @error('email') is-invalid @enderror" 
                    id="email" 
                    name="email" 
                    placeholder="Masukkan email Anda"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-login" id="btnSubmit">
                <span id="btnText">🔐 Kirim Link Login</span>
                <span id="btnLoading" style="display: none;">
                    <span class="spinner-border spinner-border-sm" role="status"></span> Mengirim...
                </span>
            </button>
        </form>

        <div class="info-text">
            <span class="wave-emoji">👋</span> Link login akan dikirim ke email Anda<br>
            dan berlaku selama <strong>15 menit</strong>
        </div>

        <hr style="margin: 30px 0;">
        
        <div style="text-align: center;">
            <a href="/" style="color: #2F80ED; text-decoration: none; font-size: 14px;">
                ← Kembali ke Halaman Utama
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function() {
                $('#btnText').hide();
                $('#btnLoading').show();
                $('#btnSubmit').prop('disabled', true);
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
