<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SIMTEK MELAJU - Sistem Informasi Manajemen Teknis untuk Survey SLF (Sertifikat Laik Fungsi) dan PBG (Persetujuan Bangunan Gedung) Kabupaten Kubu Raya. Platform digital terintegrasi untuk pengelolaan data bangunan.">
    <meta name="keywords" content="SIMTEK MELAJU, SLF, PBG, Sertifikat Laik Fungsi, Persetujuan Bangunan Gedung, Kubu Raya, Survey Bangunan, Manajemen Teknis, Sistem Informasi Bangunan">
    <meta name="author" content="Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Kubu Raya">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="SIMTEK MELAJU - Sistem Survey SLF & PBG Kubu Raya">
    <meta property="og:description" content="Platform digital terintegrasi untuk pengelolaan Survey SLF dan PBG di Kabupaten Kubu Raya">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://simtekmelaju.com">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SIMTEK MELAJU - Sistem Survey SLF & PBG Kubu Raya">
    <meta name="twitter:description" content="Platform digital terintegrasi untuk pengelolaan Survey SLF dan PBG di Kabupaten Kubu Raya">
    
    <title>SIMTEK MELAJU - Sistem Survey SLF & PBG Kubu Raya | Kabupaten Kubu Raya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-blue: #0066CC;
            --secondary-green: #4CAF50;
            --light-blue: #E3F2FD;
            --dark-blue: #003d7a;
            --orange: #FF9800;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Header/Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            padding: 80px 0 60px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -200px;
            right: -200px;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-blue) !important;
            font-size: 24px;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-blue) !important;
            transform: translateY(-2px);
        }

        .btn-login-nav {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: white !important;
            padding: 8px 25px;
            border-radius: 25px;
            font-weight: 600;
        }

        .btn-login-nav:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 102, 204, 0.3);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .logo-shield {
            width: 200px;
            height: auto;
            margin-bottom: 30px;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .logo-text-container {
            margin-bottom: 20px;
        }

        .hero-content {
            color: white;
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 20px;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
        }

        .hero-content .subtitle {
            font-size: 24px;
            margin-bottom: 30px;
            opacity: 0.95;
        }

        .hero-content p {
            font-size: 18px;
            line-height: 1.8;
            max-width: 800px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }

        .hero-buttons {
            margin-top: 30px;
        }

        .btn-hero {
            padding: 15px 40px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 50px;
            margin: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary-hero {
            background: white;
            color: var(--primary-blue);
            border: 2px solid white;
        }

        .btn-primary-hero:hover {
            background: transparent;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }

        .btn-outline-hero {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline-hero:hover {
            background: white;
            color: var(--primary-blue);
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.3);
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 42px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 18px;
            color: #666;
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            height: 100%;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 102, 204, 0.15);
            border-color: var(--primary-blue);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 35px;
            color: white;
        }

        .feature-card h3 {
            font-size: 22px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #666;
            line-height: 1.7;
            font-size: 15px;
        }

        /* About Section */
        .about-section {
            padding: 80px 0;
            background: white;
        }

        .about-content {
            display: flex;
            align-items: center;
            gap: 60px;
        }

        .about-text h2 {
            font-size: 38px;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 25px;
        }

        .about-text p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 20px;
        }

        .about-list {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }

        .about-list li {
            padding: 12px 0;
            font-size: 16px;
            color: #333;
            display: flex;
            align-items: center;
        }

        .about-list li i {
            color: var(--secondary-green);
            margin-right: 15px;
            font-size: 20px;
        }

        .stats-box {
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            border-radius: 20px;
            padding: 40px;
            color: white;
            text-align: center;
        }

        .stats-box h3 {
            font-size: 48px;
            font-weight: 900;
            margin-bottom: 10px;
        }

        .stats-box p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* Services Section */
        .services-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--light-blue) 0%, #ffffff 100%);
        }

        .service-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border-left: 5px solid var(--primary-blue);
        }

        .service-card:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 40px rgba(0, 102, 204, 0.15);
        }

        .service-card h4 {
            color: var(--primary-blue);
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 20px;
        }

        .service-card p {
            color: #666;
            line-height: 1.7;
            margin: 0;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            padding: 80px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            top: -150px;
            left: -100px;
        }

        .cta-section h2 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .cta-section p {
            font-size: 20px;
            margin-bottom: 40px;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }

        /* Footer */
        .footer {
            background: #1a1a1a;
            color: white;
            padding: 60px 0 30px;
        }

        .footer h5 {
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--orange);
        }

        .footer p, .footer a {
            color: #ccc;
            line-height: 2;
            text-decoration: none;
        }

        .footer a:hover {
            color: var(--orange);
        }

        .footer-bottom {
            border-top: 1px solid #333;
            margin-top: 40px;
            padding-top: 30px;
            text-align: center;
            color: #999;
        }

        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: #333;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--primary-blue);
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 32px;
            }

            .hero-content .subtitle {
                font-size: 18px;
            }

            .logo-shield {
                width: 120px;
            }

            .about-content {
                flex-direction: column;
            }

            .btn-hero {
                display: block;
                margin: 10px auto;
                max-width: 300px;
            }
        }

        /* Statistics Section */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .stat-box:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.25);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .stat-number {
            font-size: 56px;
            font-weight: 900;
            margin: 15px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .stat-label {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            opacity: 0.95;
        }

        .stat-icon {
            font-size: 40px;
            opacity: 0.8;
        }

        /* Tracking Section */
        .tracking-section {
            padding: 80px 0;
            background: white;
        }

        .tracking-card {
            background: linear-gradient(135deg, var(--light-blue) 0%, #ffffff 100%);
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0, 102, 204, 0.1);
            max-width: 700px;
            margin: 0 auto;
        }

        .tracking-input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .tracking-input {
            width: 100%;
            padding: 20px 25px;
            font-size: 18px;
            border: 3px solid #e0e0e0;
            border-radius: 50px;
            outline: none;
            transition: all 0.3s ease;
        }

        .tracking-input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
        }

        .btn-track {
            width: 100%;
            padding: 20px;
            font-size: 20px;
            font-weight: 700;
            border: none;
            border-radius: 50px;
            background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-track:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 102, 204, 0.3);
        }

        .tracking-result {
            margin-top: 40px;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .info-table th {
            padding: 12px;
            text-align: left;
            color: #666;
            font-weight: 600;
            width: 180px;
        }

        .info-table td {
            padding: 12px;
            color: #333;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .badge-success {
            background: #4CAF50;
            color: white;
        }

        .badge-warning {
            background: #FF9800;
            color: white;
        }

        .badge-info {
            background: var(--primary-blue);
            color: white;
        }

        .progress-timeline {
            margin-top: 30px;
        }

        .timeline-step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 25px;
            position: relative;
        }

        .timeline-step::before {
            content: '';
            position: absolute;
            left: 25px;
            top: 50px;
            width: 3px;
            height: calc(100% + 25px);
            background: #e0e0e0;
        }

        .timeline-step:last-child::before {
            display: none;
        }

        .timeline-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-right: 20px;
            flex-shrink: 0;
            z-index: 1;
        }

        .timeline-icon.completed {
            background: linear-gradient(135deg, #4CAF50, #43e97b);
            color: white;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }

        .timeline-icon.pending {
            background: #e0e0e0;
            color: #999;
        }

        .timeline-content h4 {
            margin: 0 0 5px 0;
            color: #333;
            font-size: 16px;
        }

        .timeline-status {
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shield-alt"></i> SIMTEK MELAJU
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#beranda">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#layanan">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-login-nav" href="/login">
                            <i class="fas fa-sign-in-alt"></i> Login Admin
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ciptakarya/petugas/login" style="background: linear-gradient(135deg, #4CAF50, #43a047); color: white !important; padding: 8px 25px; border-radius: 25px; font-weight: 600; margin-left: 5px;">
                            <i class="fas fa-user-hard-hat"></i> Login Petugas
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" id="beranda">
        <div class="container">
            <div class="logo-container">
                <!-- Shield Logo SVG -->
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

                <!-- SIMTEK MELAJU Text -->
                <div class="logo-text-container">
                    <div style="margin-bottom: 10px;">
                        <span style="font-size: 56px; font-weight: 900; color: white; letter-spacing: 3px; text-shadow: 4px 4px 8px rgba(0,0,0,0.3);">SIMTEK</span>
                    </div>
                    <div style="border-top: 4px solid #FF9800; border-bottom: 4px solid #FF9800; padding: 8px 0; margin: 15px 0;">
                        <span style="font-size: 60px; font-weight: 900; color: #4CAF50; letter-spacing: 3px; text-shadow: 4px 4px 8px rgba(0,0,0,0.3);">MELAJU</span>
                    </div>
                    <div style="margin-top: 20px;">
                        <span style="font-size: 20px; font-weight: 600; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">SISTEM SURVEY SLF & PBG KUBU RAYA</span>
                    </div>
                    <!-- PUPR Badge -->
                    <div style="margin-top: 30px; padding: 15px 30px; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 50px; display: inline-block; border: 2px solid rgba(255,255,255,0.3);">
                        <a href="https://pupr.kuburayakab.go.id/" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: white; display: flex; align-items: center; gap: 15px;">
                            <i class="fas fa-building" style="font-size: 24px;"></i>
                            <div style="text-align: left;">
                                <div style="font-size: 11px; opacity: 0.9; letter-spacing: 1px;">BAGIAN DARI</div>
                                <div style="font-size: 14px; font-weight: 700; letter-spacing: 0.5px;">DINAS PUPR PRKP - BIDANG CIPTA KARYA</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="hero-content">
                <h1>Sistem Informasi Manajemen Teknis</h1>
                <p class="subtitle">Pengelolaan Survey SLF & PBG Terpadu</p>
                <p>
                    Platform digital terintegrasi untuk memudahkan proses survey, pengelolaan data, dan monitoring 
                    Sertifikat Laik Fungsi (SLF) dan Persetujuan Bangunan Gedung (PBG) di Kabupaten Kubu Raya
                </p>
                <div class="hero-buttons">
                    <a href="/login" class="btn-hero btn-primary-hero">
                        <i class="fas fa-sign-in-alt"></i> Login Admin
                    </a>
                    <a href="/ciptakarya/petugas/login" class="btn-hero" style="background: linear-gradient(135deg, #4CAF50, #43a047); color: white; border: 2px solid #4CAF50;">
                        <i class="fas fa-user-hard-hat"></i> Login Petugas Lapangan
                    </a>
                    <a href="#tentang" class="btn-hero btn-outline-hero">
                        <i class="fas fa-info-circle"></i> Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;">Statistik Real-Time</h2>
                <p style="color: rgba(255,255,255,0.9);">Data terkini pengajuan dan kunjungan website di Kabupaten Kubu Raya</p>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-spinner"></i></div>
                        <div class="stat-number" id="stat-pbg-proses">-</div>
                        <div class="stat-label">PBG Diproses</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-number" id="stat-pbg-terbit">-</div>
                        <div class="stat-label">PBG Terbit</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-spinner"></i></div>
                        <div class="stat-number" id="stat-slf-proses">-</div>
                        <div class="stat-label">SLF Diproses</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-number" id="stat-slf-terbit">-</div>
                        <div class="stat-label">SLF Terbit</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-eye"></i></div>
                        <div class="stat-number" id="stat-visitor-today">-</div>
                        <div class="stat-label">Kunjungan Hari Ini</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="stat-box">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <div class="stat-number" id="stat-visitor-total">-</div>
                        <div class="stat-label">Total Kunjungan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tracking Section -->
    <section class="tracking-section">
        <div class="container">
            <div class="section-title">
                <h2>Lacak Status Pengajuan Anda</h2>
                <p>Cek progress pengajuan PBG/SLF Anda secara real-time</p>
            </div>
            <div class="tracking-card">
                <h3 style="text-align: center; color: var(--primary-blue); margin-bottom: 30px;">
                    <i class="fas fa-search"></i> Tracking Pengajuan
                </h3>
                <div class="tracking-input-group">
                    <input 
                        type="text" 
                        id="no_permohonan_tracking" 
                        class="tracking-input" 
                        placeholder="Masukkan Nomor Permohonan (contoh: PBG/2025/001)"
                        onkeypress="if(event.key === 'Enter') trackStatus()"
                    />
                </div>
                <button class="btn-track" onclick="trackStatus()">
                    <i class="fas fa-search"></i> Cek Status Sekarang
                </button>
                <div id="tracking-result" style="display: none;"></div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section" id="fitur">
        <div class="container">
            <div class="section-title">
                <h2>Fitur Unggulan</h2>
                <p>Solusi lengkap untuk pengelolaan survey bangunan yang efisien dan terstandar</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h3>Survey Digital</h3>
                        <p>Sistem survey berbasis digital yang memudahkan pengisian data langsung di lapangan dengan validasi real-time dan dokumentasi foto.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <h3>Database Terpusat</h3>
                        <p>Penyimpanan data terpusat dan terstruktur untuk semua informasi bangunan, hasil survey, dan dokumen pendukung.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Monitoring Real-time</h3>
                        <p>Dashboard interaktif untuk monitoring progres survey, status pengajuan, dan statistik bangunan secara real-time.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-certificate"></i>
                        </div>
                        <h3>Manajemen Sertifikat</h3>
                        <p>Pengelolaan dan tracking sertifikat SLF & PBG dengan reminder otomatis untuk perpanjangan dan masa berlaku.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h3>Pemetaan Lokasi</h3>
                        <p>Integrasi dengan peta digital untuk visualisasi lokasi bangunan dan distribusi geografis data survey.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-file-pdf"></i>
                        </div>
                        <h3>Laporan Otomatis</h3>
                        <p>Generate laporan lengkap dalam format PDF dengan template standar untuk berbagai kebutuhan administratif.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section" id="tentang">
        <div class="container">
            <div class="about-content row">
                <div class="col-md-7">
                    <div class="about-text">
                        <h2>Tentang SIMTEK MELAJU</h2>
                        <p>
                            <strong>SIMTEK MELAJU</strong> adalah sistem informasi manajemen teknis yang dirancang khusus untuk 
                            mendukung proses survey dan pengelolaan data Sertifikat Laik Fungsi (SLF) dan Persetujuan Bangunan 
                            Gedung (PBG) di Kabupaten Kubu Raya.
                        </p>
                        <p>
                            Sistem ini dikembangkan untuk meningkatkan efisiensi, akurasi, dan transparansi dalam pengelolaan 
                            data bangunan, memastikan kepatuhan terhadap regulasi, serta memudahkan koordinasi antar pemangku 
                            kepentingan.
                        </p>
                        <ul class="about-list">
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Digitalisasi proses survey lapangan
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Pengelolaan dokumen dan sertifikat terintegrasi
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Monitoring dan pelaporan berbasis data
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Aksesibilitas tinggi dengan teknologi cloud
                            </li>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                Keamanan data terjamin dengan enkripsi
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="stats-box mb-4">
                        <div style="font-size: 50px; margin-bottom: 15px;"><i class="fas fa-building"></i></div>
                        <h3 style="font-size: 32px; margin-bottom: 15px;">Kabupaten Kubu Raya</h3>
                        <p style="font-size: 16px;">Dinas Pekerjaan Umum dan Penataan Ruang</p>
                    </div>
                    <div class="stats-box">
                        <div style="font-size: 50px; margin-bottom: 15px;"><i class="fas fa-shield-alt"></i></div>
                        <h3 style="font-size: 32px; margin-bottom: 15px;">Keamanan Data</h3>
                        <p style="font-size: 16px;">Sistem Terenkripsi & Backup Terjadwal</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section" id="layanan">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Sistem</h2>
                <p>Berbagai layanan yang tersedia dalam SIMTEK MELAJU</p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="service-card">
                        <h4><i class="fas fa-certificate"></i> Survey SLF (Sertifikat Laik Fungsi)</h4>
                        <p>
                            Pengelolaan lengkap proses survey kelayakan fungsi bangunan, mulai dari pengajuan, 
                            pemeriksaan lapangan, hingga penerbitan sertifikat.
                        </p>
                    </div>
                    <div class="service-card">
                        <h4><i class="fas fa-building"></i> Survey PBG (Persetujuan Bangunan Gedung)</h4>
                        <p>
                            Manajemen proses persetujuan bangunan gedung dengan dokumentasi lengkap dan tracking 
                            status aplikasi secara real-time.
                        </p>
                    </div>
                    <div class="service-card">
                        <h4><i class="fas fa-camera"></i> Dokumentasi Digital</h4>
                        <p>
                            Penyimpanan dan pengelolaan foto-foto hasil survey dengan metadata lokasi dan timestamp 
                            untuk dokumentasi yang komprehensif.
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="service-card">
                        <h4><i class="fas fa-chart-pie"></i> Dashboard & Analytics</h4>
                        <p>
                            Visualisasi data dalam bentuk grafik dan chart interaktif untuk memudahkan analisis 
                            dan pengambilan keputusan.
                        </p>
                    </div>
                    <div class="service-card">
                        <h4><i class="fas fa-bell"></i> Notifikasi & Reminder</h4>
                        <p>
                            Sistem notifikasi otomatis untuk mengingatkan deadline, perpanjangan sertifikat, 
                            dan update status aplikasi.
                        </p>
                    </div>
                    <div class="service-card">
                        <h4><i class="fas fa-users"></i> Multi-User Management</h4>
                        <p>
                            Manajemen pengguna dengan level akses berbeda untuk surveyor, admin, dan pejabat 
                            dengan audit trail lengkap.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-title">
                <h2>Download Aplikasi Mobile</h2>
                <p>Akses SIMTEK MELAJU langsung dari smartphone Anda</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="feature-card" style="text-align: center;">
                        <h3 style="margin-bottom: 30px;">Download Aplikasi SIMTEK MELAJU</h3>
                        <p style="margin-bottom: 30px;">Nikmati kemudahan mengakses sistem survey SLF & PBG langsung dari perangkat mobile Anda. Download aplikasi sekarang!</p>
                        <div class="row justify-content-center">
                            <div class="col-md-6 mb-3">
                                <a href="/CKverify.apk" class="btn-hero btn-primary-hero" style="width: 100%; display: block; padding: 15px;">
                                    <i class="fab fa-android" style="font-size: 24px;"></i><br>
                                    <strong>Download untuk Android</strong><br>
                                    <small>File APK - Versi 1.0</small>
                                </a>
                            </div>
                            <div class="col-md-6 mb-3">
                                <a href="mailto:admin@itkonsultan.co.id?subject=Request Download Aplikasi iOS SIMTEK MELAJU&body=Halo Admin,%0D%0A%0D%0ASaya ingin request untuk download aplikasi SIMTEK MELAJU versi iOS dari App Store.%0D%0A%0D%0ANama: [Isi nama Anda]%0D%0AInstansi: [Isi instansi Anda]%0D%0AEmail: [Isi email Anda]%0D%0ANo. HP: [Isi nomor HP Anda]%0D%0A%0D%0ATerima kasih." class="btn-hero btn-outline-hero" style="width: 100%; display: block; padding: 15px; background: white; color: var(--primary-blue); border: 2px solid var(--primary-blue);">
                                    <i class="fab fa-app-store-ios" style="font-size: 24px;"></i><br>
                                    <strong>Request untuk iOS</strong><br>
                                    <small>Kirim Email Request</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Siap Menggunakan SIMTEK MELAJU?</h2>
            <p>Bergabunglah dengan sistem pengelolaan survey yang modern dan efisien</p>
            <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                <a href="/login" class="btn-hero btn-primary-hero">
                    <i class="fas fa-rocket"></i> Login Admin
                </a>
                <a href="/ciptakarya/petugas/login" class="btn-hero" style="background: #4CAF50; color: white; border: 2px solid #4CAF50;">
                    <i class="fas fa-user-hard-hat"></i> Login Petugas Lapangan
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <h5>SIMTEK MELAJU</h5>
                    <p>
                        Sistem Informasi Manajemen Teknis untuk Survey SLF & PBG Kabupaten Kubu Raya.
                    </p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Link Cepat</h5>
                    <p><a href="#beranda">Beranda</a></p>
                    <p><a href="#tentang">Tentang</a></p>
                    <p><a href="#fitur">Fitur</a></p>
                    <p><a href="#layanan">Layanan</a></p>
                    <p><a href="/login">Login</a></p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Kontak</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Kabupaten Kubu Raya, Kalimantan Barat</p>
                    <p><i class="fas fa-phone"></i> +6282255985321 </p>
                    <p><i class="fas fa-envelope"></i> admin@simtekmelaju.com</p>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Dinas Terkait</h5>
                    <div style="padding: 20px; background: rgba(255,255,255,0.05); border-radius: 10px; border: 2px solid rgba(255,255,255,0.1);">
                        <a href="https://pupr.kuburayakab.go.id/" target="_blank" rel="noopener noreferrer" style="text-decoration: none;">
                            <div style="text-align: center; margin-bottom: 10px;">
                                <i class="fas fa-building" style="font-size: 40px; color: var(--orange);"></i>
                            </div>
                            <p style="margin: 0; font-size: 12px; line-height: 1.5; text-align: center; color: #ccc;">
                                <strong style="color: var(--orange);">DINAS PUPR PRKP</strong><br>
                                Kabupaten Kubu Raya<br>
                                <span style="font-size: 11px;">Bidang Cipta Karya</span>
                            </p>
                        </a>
                    </div>
                    <p style="margin-top: 15px; font-size: 12px; text-align: center;">
                        <a href="https://pupr.kuburayakab.go.id/" target="_blank" rel="noopener noreferrer" style="color: var(--orange);">
                            <i class="fas fa-external-link-alt"></i> Kunjungi Website Resmi
                        </a>
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} SIMTEK MELAJU - Kabupaten Kubu Raya. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Load Statistics on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadStatistics();
            loadVisitorStatistics();
        });

        function loadStatistics() {
            fetch('/ciptakarya/statistics')
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        document.getElementById('stat-pbg-proses').textContent = data.data.pbg.proses;
                        document.getElementById('stat-pbg-terbit').textContent = data.data.pbg.terbit;
                        document.getElementById('stat-slf-proses').textContent = data.data.slf.proses;
                        document.getElementById('stat-slf-terbit').textContent = data.data.slf.terbit;
                    }
                })
                .catch(error => {
                    console.error('Error loading statistics:', error);
                    document.querySelectorAll('.stat-number').forEach(el => {
                        if (el.id.includes('pbg') || el.id.includes('slf')) {
                            el.textContent = '0';
                        }
                    });
                });
        }

        function loadVisitorStatistics() {
            fetch('/visitor-statistics')
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        document.getElementById('stat-visitor-today').textContent = formatNumber(data.data.today);
                        document.getElementById('stat-visitor-total').textContent = formatNumber(data.data.total);
                    }
                })
                .catch(error => {
                    console.error('Error loading visitor statistics:', error);
                    document.getElementById('stat-visitor-today').textContent = '0';
                    document.getElementById('stat-visitor-total').textContent = '0';
                });
        }

        function formatNumber(num) {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + 'M';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(1) + 'K';
            }
            return num.toString();
        }

        function trackStatus() {
            const noPermohonan = document.getElementById('no_permohonan_tracking').value.trim();
            const resultDiv = document.getElementById('tracking-result');

            if (!noPermohonan) {
                alert('Silakan masukkan nomor permohonan');
                return;
            }

            // Show loading
            resultDiv.style.display = 'block';
            resultDiv.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin fa-3x" style="color: var(--primary-blue);"></i><p style="margin-top: 20px; color: #666;">Mencari data pengajuan...</p></div>';

            // Fetch tracking data
            fetch('/ciptakarya/public-tracking', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ no_permohonan: noPermohonan })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    displayTrackingResult(data.data);
                } else {
                    resultDiv.innerHTML = `
                        <div style="text-align: center; padding: 30px; background: #fff3cd; border-radius: 10px; border-left: 5px solid #ffc107;">
                            <i class="fas fa-exclamation-triangle" style="font-size: 50px; color: #ffc107; margin-bottom: 15px;"></i>
                            <h4 style="color: #856404; margin-bottom: 10px;">Data Tidak Ditemukan</h4>
                            <p style="color: #856404; margin: 0;">${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = `
                    <div style="text-align: center; padding: 30px; background: #f8d7da; border-radius: 10px; border-left: 5px solid #dc3545;">
                        <i class="fas fa-times-circle" style="font-size: 50px; color: #dc3545; margin-bottom: 15px;"></i>
                        <h4 style="color: #721c24; margin-bottom: 10px;">Terjadi Kesalahan</h4>
                        <p style="color: #721c24; margin: 0;">Gagal mengambil data. Silakan coba lagi.</p>
                    </div>
                `;
            });
        }

        function displayTrackingResult(data) {
            const resultDiv = document.getElementById('tracking-result');
            
            let statusClass = 'badge-info';
            if (data.status.toLowerCase().includes('terbit')) {
                statusClass = 'badge-success';
            } else if (data.status.toLowerCase().includes('proses') || data.status.toLowerCase().includes('pending')) {
                statusClass = 'badge-warning';
            }

            let html = `
                <div class="tracking-result">
                    <h4 style="color: var(--primary-blue); margin-bottom: 25px; text-align: center;">
                        <i class="fas fa-check-circle"></i> Informasi Pengajuan Ditemukan
                    </h4>
                    <table class="info-table">
                        <tr>
                            <th><i class="fas fa-file-alt"></i> No. Permohonan</th>
                            <td><strong>${data.no_permohonan}</strong></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-user"></i> Nama Pemohon</th>
                            <td>${data.nama_pemohon}</td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-building"></i> Tipe Pengajuan</th>
                            <td><span class="status-badge badge-info">${data.tipe}</span></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-info-circle"></i> Status</th>
                            <td><span class="status-badge ${statusClass}">${data.status}</span></td>
                        </tr>
                    </table>

                    <hr style="border-color: #e0e0e0; margin: 30px 0;">

                    <h4 style="color: #333; margin-bottom: 25px; text-align: center;">
                        <i class="fas fa-tasks"></i> Progress Tahapan
                    </h4>
                    <div class="progress-timeline">
            `;

            data.flow.forEach((step, index) => {
                const iconClass = step.status === 'completed' ? 'completed' : 'pending';
                const statusText = step.status === 'completed' ? '✓ Selesai' : 'Menunggu';
                const statusColor = step.status === 'completed' ? '#4CAF50' : '#999';

                html += `
                    <div class="timeline-step">
                        <div class="timeline-icon ${iconClass}">
                            <i class="fas ${step.icon}"></i>
                        </div>
                        <div class="timeline-content">
                            <h4>${step.name}</h4>
                            <div class="timeline-status" style="color: ${statusColor}; font-weight: 600;">
                                ${statusText}
                            </div>
                        </div>
                    </div>
                `;
            });

            html += `
                    </div>
                    <div style="margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 10px; text-align: center;">
                        <p style="margin: 0; color: #666; font-size: 14px;">
                            <i class="fas fa-info-circle"></i> 
                            <em>Data diperbarui secara otomatis. Refresh halaman untuk melihat update terbaru.</em>
                        </p>
                    </div>
                </div>
            `;

            resultDiv.innerHTML = html;
            resultDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 5px 30px rgba(0, 0, 0, 0.15)';
            } else {
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });
    </script>
</body>
</html>
