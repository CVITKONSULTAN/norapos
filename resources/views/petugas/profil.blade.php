<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Petugas - {{ $petugas->nama }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #F5F5F5;
            padding-bottom: 80px;
        }
        .header-bar {
            background: #2F80ED;
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .header-bar .back-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            margin-right: 15px;
            cursor: pointer;
        }
        .header-bar h4 {
            margin: 0;
            font-size: 18px;
        }
        .profile-section {
            text-align: center;
            padding: 30px 20px;
            background: white;
            margin: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .avatar-large {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #2F80ED;
            margin-bottom: 15px;
            object-fit: cover;
        }
        .profile-section h3 {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .profile-section p {
            color: #666;
            font-size: 14px;
            margin: 0;
        }
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin: 0 20px 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .info-card h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid #2F80ED;
            padding-bottom: 8px;
        }
        .info-row {
            display: flex;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .info-row label {
            font-weight: 600;
            color: #666;
            width: 120px;
            flex-shrink: 0;
        }
        .info-row span {
            color: #333;
            flex-grow: 1;
        }
        .btn-logout {
            background: #FF3D00;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            width: calc(100% - 40px);
            margin: 0 20px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-logout:hover {
            background: #d63200;
            transform: translateY(-2px);
        }
        .nav-links {
            display: flex;
            justify-content: space-around;
            padding: 10px 15px;
            background: white;
            margin: 15px 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .nav-link-item {
            text-align: center;
            color: #666;
            text-decoration: none;
            font-size: 13px;
            padding: 8px 15px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link-item:hover {
            background: #f0f0f0;
            color: #2F80ED;
        }
        .nav-link-item.active {
            color: #2F80ED;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-bar">
        <button class="back-btn" onclick="window.location='{{ route('petugas.dashboard') }}'">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h4>Profil Petugas</h4>
    </div>

    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="{{ route('petugas.dashboard') }}" class="nav-link-item">
            <i class="fas fa-home"></i><br>Dashboard
        </a>
        <a href="{{ route('petugas.profil') }}" class="nav-link-item active">
            <i class="fas fa-user"></i><br>Profil
        </a>
    </div>

    <!-- Profile Header -->
    <div class="profile-section">
        <img src="{{ $petugas->google_data['picture'] ?? asset('images/default-avatar.png') }}" 
             alt="Avatar" 
             class="avatar-large"
             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($petugas->nama) }}&background=2F80ED&color=fff&size=200'">
        <h3>{{ $petugas->nama }}</h3>
        <p>{{ $petugas->jabatan ?? 'Petugas Lapangan' }}</p>
    </div>

    <!-- Data Pribadi -->
    <div class="info-card">
        <h5><i class="fas fa-user-circle"></i> Data Pribadi</h5>
        <div class="info-row">
            <label>Nama Lengkap:</label>
            <span>{{ $petugas->nama ?? '-' }}</span>
        </div>
        <div class="info-row">
            <label>Email:</label>
            <span>{{ $petugas->email ?? '-' }}</span>
        </div>
        <div class="info-row">
            <label>NIK:</label>
            <span>{{ $petugas->nik ?? '-' }}</span>
        </div>
        <div class="info-row">
            <label>NIP:</label>
            <span>{{ $petugas->nip ?? '-' }}</span>
        </div>
    </div>

    <!-- Data Kepegawaian -->
    <div class="info-card">
        <h5><i class="fas fa-briefcase"></i> Data Kepegawaian</h5>
        <div class="info-row">
            <label>Bidang:</label>
            <span>{{ $petugas->bidang ?? '-' }}</span>
        </div>
        <div class="info-row">
            <label>Jabatan:</label>
            <span>{{ $petugas->jabatan ?? '-' }}</span>
        </div>
        <div class="info-row">
            <label>Terdaftar:</label>
            <span>{{ $petugas->created_at ? $petugas->created_at->format('d F Y') : '-' }}</span>
        </div>
    </div>

    <!-- Logout Button -->
    <form action="{{ route('petugas.logout') }}" method="POST" id="logoutForm" style="margin-top: 30px;">
        @csrf
        <button type="submit" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $('#logoutForm').on('submit', function(e) {
            if (!confirm('Yakin ingin logout?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
