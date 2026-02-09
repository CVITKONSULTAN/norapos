<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMTEK MELAJU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0066CC;
            --secondary-green: #4CAF50;
            --light-blue: #E3F2FD;
            --dark-blue: #003d7a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--light-blue) 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 102, 204, 0.15);
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
        }

        .login-left {
            flex: 1;
            min-width: 300px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .login-left::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .logo-container {
            position: relative;
            z-index: 1;
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-shield {
            width: 150px;
            height: auto;
            margin-bottom: 20px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));
        }

        .logo-text {
            width: 100%;
            max-width: 350px;
            height: auto;
            margin-bottom: 20px;
        }

        .welcome-text {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .welcome-text h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .welcome-text p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.95;
        }

        .login-right {
            flex: 1;
            min-width: 300px;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 40px;
        }

        .form-header h2 {
            color: var(--primary-blue);
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .form-header p {
            color: #666;
            font-size: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-blue);
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-blue);
            background: white;
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .checkbox-container input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-right: 8px;
            cursor: pointer;
            accent-color: var(--primary-blue);
        }

        .checkbox-container label {
            color: #666;
            font-size: 14px;
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: var(--primary-blue);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--dark-blue);
            text-decoration: underline;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-danger {
            background-color: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }

        @media (max-width: 768px) {
            .login-left {
                padding: 40px 30px;
            }

            .login-right {
                padding: 40px 30px;
            }

            .logo-shield {
                width: 100px;
            }

            .logo-text {
                max-width: 250px;
            }

            .welcome-text h1 {
                font-size: 22px;
            }

            .form-header h2 {
                font-size: 26px;
            }
        }

        .building-icon {
            position: absolute;
            opacity: 0.05;
            font-size: 200px;
            color: white;
            z-index: 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Side - Branding -->
        <div class="login-left">
            <i class="fas fa-city building-icon"></i>
            
            <div class="logo-container">
                <!-- Shield Logo -->
                <svg class="logo-shield" viewBox="0 0 566 670" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="shieldGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#1e88e5;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#0d47a1;stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="buildingGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#29b6f6;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#0288d1;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    
                    <!-- Shield outline -->
                    <path d="M283 10 C140 30, 50 80, 50 140 L50 350 C50 520, 180 630, 283 660 C386 630, 516 520, 516 350 L516 140 C516 80, 426 30, 283 10 Z" 
                          fill="url(#shieldGradient)" stroke="#003d7a" stroke-width="8"/>
                    
                    <!-- Inner shield -->
                    <path d="M283 35 C160 52, 85 95, 85 145 L85 340 C85 490, 200 585, 283 610 C366 585, 481 490, 481 340 L481 145 C481 95, 406 52, 283 35 Z" 
                          fill="url(#buildingGradient)" stroke="white" stroke-width="6"/>
                    
                    <!-- Buildings -->
                    <g transform="translate(150, 200)">
                        <!-- Building 1 -->
                        <rect x="0" y="60" width="40" height="120" fill="white" opacity="0.9"/>
                        <rect x="5" y="70" width="8" height="8" fill="#0288d1"/>
                        <rect x="15" y="70" width="8" height="8" fill="#0288d1"/>
                        <rect x="27" y="70" width="8" height="8" fill="#0288d1"/>
                        <rect x="5" y="85" width="8" height="8" fill="#0288d1"/>
                        <rect x="15" y="85" width="8" height="8" fill="#0288d1"/>
                        <rect x="27" y="85" width="8" height="8" fill="#0288d1"/>
                        <rect x="5" y="100" width="8" height="8" fill="#0288d1"/>
                        <rect x="15" y="100" width="8" height="8" fill="#0288d1"/>
                        <rect x="27" y="100" width="8" height="8" fill="#0288d1"/>
                        
                        <!-- Building 2 (Taller) -->
                        <rect x="50" y="30" width="50" height="150" fill="white" opacity="0.9"/>
                        <rect x="56" y="40" width="10" height="10" fill="#0288d1"/>
                        <rect x="70" y="40" width="10" height="10" fill="#0288d1"/>
                        <rect x="84" y="40" width="10" height="10" fill="#0288d1"/>
                        <rect x="56" y="58" width="10" height="10" fill="#0288d1"/>
                        <rect x="70" y="58" width="10" height="10" fill="#0288d1"/>
                        <rect x="84" y="58" width="10" height="10" fill="#0288d1"/>
                        <rect x="56" y="76" width="10" height="10" fill="#0288d1"/>
                        <rect x="70" y="76" width="10" height="10" fill="#0288d1"/>
                        <rect x="84" y="76" width="10" height="10" fill="#0288d1"/>
                        
                        <!-- Building 3 -->
                        <rect x="110" y="80" width="45" height="100" fill="white" opacity="0.9"/>
                        <rect x="116" y="90" width="9" height="9" fill="#0288d1"/>
                        <rect x="129" y="90" width="9" height="9" fill="#0288d1"/>
                        <rect x="142" y="90" width="9" height="9" fill="#0288d1"/>
                        <rect x="116" y="106" width="9" height="9" fill="#0288d1"/>
                        <rect x="129" y="106" width="9" height="9" fill="#0288d1"/>
                        <rect x="142" y="106" width="9" height="9" fill="#0288d1"/>
                    </g>
                    
                    <!-- Stars -->
                    <g transform="translate(320, 180)">
                        <polygon points="25,10 28,20 38,20 30,26 33,36 25,30 17,36 20,26 12,20 22,20" fill="#FFD700"/>
                        <polygon points="55,25 57,31 63,31 58,35 60,41 55,37 50,41 52,35 47,31 53,31" fill="#FFD700"/>
                        <polygon points="45,45 47,50 52,50 48,53 50,58 45,55 40,58 42,53 38,50 43,50" fill="#FFD700"/>
                        <polygon points="70,50 71.5,54 75.5,54 72.5,56.5 73.5,60.5 70,58 66.5,60.5 67.5,56.5 64.5,54 68.5,54" fill="#FFD700"/>
                    </g>
                    
                    <!-- Orange swoosh -->
                    <path d="M100 450 Q283 380, 466 450 L466 480 Q283 410, 100 480 Z" 
                          fill="#FF9800" opacity="0.9"/>
                    <path d="M120 470 Q283 405, 446 470 L446 490 Q283 425, 120 490 Z" 
                          fill="#FFB300" opacity="0.8"/>
                </svg>

                <!-- SIMTEK MELAJU Text Logo -->
                <div class="logo-text">
                    <div style="margin-bottom: 10px;">
                        <span style="font-size: 48px; font-weight: 900; color: white; letter-spacing: 2px; text-shadow: 3px 3px 6px rgba(0,0,0,0.3);">SIMTEK</span>
                    </div>
                    <div style="border-top: 3px solid #FF9800; border-bottom: 3px solid #FF9800; padding: 5px 0; margin: 10px 0;">
                        <span style="font-size: 52px; font-weight: 900; color: #4CAF50; letter-spacing: 2px; text-shadow: 3px 3px 6px rgba(0,0,0,0.3);">MELAJU</span>
                    </div>
                    <div style="margin-top: 15px;">
                        <span style="font-size: 16px; font-weight: 600; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">SISTEM SURVEY SLF & PBG KUBU RAYA</span>
                    </div>
                </div>
            </div>

            <div class="welcome-text">
                <h1>Selamat Datang!</h1>
                <p>Sistem Informasi Manajemen Teknik untuk Survey SLF (Sertifikat Laik Fungsi) dan PBG (Persetujuan Bangunan Gedung) Kabupaten Kubu Raya</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-right">
            <div class="form-header">
                <h2>Masuk</h2>
                <p>Silakan masuk dengan kredensial Anda</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> Ada masalah dengan input Anda.<br>
                    <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <div class="input-group-custom">
                        <i class="fas fa-user"></i>
                        <input 
                            id="username" 
                            type="text" 
                            class="form-control @error('username') is-invalid @enderror" 
                            name="username" 
                            value="{{ old('username') }}" 
                            required 
                            autofocus 
                            placeholder="Masukkan username Anda"
                        >
                    </div>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group-custom">
                        <i class="fas fa-lock"></i>
                        <input 
                            id="password" 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            name="password" 
                            required 
                            placeholder="Masukkan password Anda"
                        >
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">Ingat saya</label>
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </button>

                <div style="margin-top: 20px; text-align: center;">
                    <p style="color: #666; margin-bottom: 15px; font-size: 14px;">Download Aplikasi Mobile:</p>
                    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
                        <a href="/CKverify.apk" style="flex: 1; min-width: 200px; padding: 12px 20px; background: linear-gradient(135deg, #4CAF50, #388E3C); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; display: inline-block; text-align: center;">
                            <i class="fab fa-android" style="font-size: 18px;"></i> Android APK
                        </a>
                        <a href="mailto:admin@itkonsultan.co.id?subject=Request Download Aplikasi iOS SIMTEK MELAJU&body=Halo Admin,%0D%0A%0D%0ASaya ingin request untuk download aplikasi SIMTEK MELAJU versi iOS dari App Store.%0D%0A%0D%0ANama: [Isi nama Anda]%0D%0AInstansi: [Isi instansi Anda]%0D%0AEmail: [Isi email Anda]%0D%0ANo. HP: [Isi nomor HP Anda]%0D%0A%0D%0ATerima kasih." style="flex: 1; min-width: 200px; padding: 12px 20px; background: #000; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; display: inline-block; text-align: center;">
                            <i class="fab fa-app-store-ios" style="font-size: 18px;"></i> iOS App Store
                        </a>
                    </div>
                </div>

                @if(config('app.env') != 'demo')
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">
                            <i class="fas fa-key"></i> Lupa password Anda?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
