<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Petugas - {{ $petugas->nama }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #F5F5F5;
            padding-bottom: 30px;
        }
        .header-section {
            background: #2F80ED;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            padding-bottom: 50px;
            color: white;
        }
        .profile-header {
            display: flex;
            align-items: center;
            padding: 20px 24px;
        }
        .avatar {
            height: 60px;
            width: 60px;
            border-radius: 50%;
            margin-right: 15px;
            border: 3px solid rgba(255,255,255,0.3);
            object-fit: cover;
        }
        .profile-header h2 {
            font-size: 22px;
            margin-bottom: 6px;
        }
        .profile-header p {
            opacity: 0.7;
            font-size: 14px;
            margin: 0;
        }
        .stats-cards {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: -40px;
            padding: 0 15px;
            flex-wrap: wrap;
        }
        .card-stat {
            background: white;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            flex: 1;
            min-width: 110px;
            max-width: 150px;
        }
        .card-stat img {
            height: 28px;
            width: 28px;
            margin-right: 10px;
        }
        .card-stat small {
            font-size: 10px;
            color: #999;
            display: block;
        }
        .card-stat h3 {
            font-weight: bold;
            font-size: 20px;
            margin: 0;
            color: #333;
        }
        .filter-tabs {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            margin-top: 15px;
        }
        .tab {
            padding: 8px 16px;
            border-radius: 20px;
            border: none;
            font-size: 13px;
            font-weight: 600;
            background: rgba(47,128,237,0.1);
            color: #2F80ED;
            cursor: pointer;
            transition: all 0.3s;
        }
        .tab.active {
            background: #2F80ED;
            color: white;
        }
        .search-box {
            margin: 0 15px 15px;
            position: relative;
        }
        .search-box input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #ddd;
            border-radius: 10px;
            font-size: 15px;
        }
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }
        .pengajuan-card {
            background: white;
            margin: 8px 15px;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            position: relative;
            cursor: pointer;
            transition: all 0.2s;
        }
        .pengajuan-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .status-badge {
            position: absolute;
            right: 10px;
            top: 10px;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 10px;
            font-weight: bold;
            color: white;
        }
        .status-proses { background: #FFC107; }
        .status-terbit { background: #00b809; }
        .status-gagal { background: #FF3D00; }
        .pengajuan-card h5 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }
        .pengajuan-card p {
            font-size: 13px;
            color: #666;
            margin-bottom: 5px;
        }
        .btn-lampiran {
            margin-top: 12px;
            background: #2F80ED;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            border: none;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-lampiran:hover {
            background: #1e5bb8;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }
        .empty-state i {
            font-size: 60px;
            margin-bottom: 15px;
            color: #ddd;
        }
        .logout-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #FF3D00;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            box-shadow: 0 4px 12px rgba(255,61,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            z-index: 999;
        }
        .logout-btn:hover {
            background: #d63200;
            transform: scale(1.1);
        }
        .loading-spinner {
            text-align: center;
            padding: 30px;
        }
        .nav-links {
            display: flex;
            justify-content: space-around;
            padding: 10px 15px;
            background: white;
            margin: 15px;
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
    <div class="header-section">
        <div class="profile-header">
            <img src="{{ $petugas->google_data['picture'] ?? asset('images/default-avatar.png') }}" 
                 alt="Avatar" 
                 class="avatar"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($petugas->nama) }}&background=2F80ED&color=fff&size=120'">
            <div>
                <h2>Hi, {{ $petugas->nama }} 👋</h2>
                <p>Selamat datang kembali</p>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards">
        <div class="card-stat">
            <img src="{{ asset('images/brifecase-timer-yellow.png') }}" alt="Proses" onerror="this.style.display='none'">
            <div>
                <small>Proses</small>
                <h3 id="stat-proses">{{ $stat['proses'] }}</h3>
            </div>
        </div>
        <div class="card-stat">
            <img src="{{ asset('images/flag.png') }}" alt="Terbit" onerror="this.style.display='none'">
            <div>
                <small>Izin Terbit</small>
                <h3 id="stat-terbit">{{ $stat['izin_terbit'] }}</h3>
            </div>
        </div>
        <div class="card-stat">
            <img src="{{ asset('images/brifecase-timer.png') }}" alt="Gagal" onerror="this.style.display='none'">
            <div>
                <small>Gagal</small>
                <h3 id="stat-gagal">{{ $stat['gagal'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="{{ route('petugas.dashboard') }}" class="nav-link-item active">
            <i class="fas fa-home"></i><br>Dashboard
        </a>
        <a href="{{ route('petugas.profil') }}" class="nav-link-item">
            <i class="fas fa-user"></i><br>Profil
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="tab active" data-status="all" onclick="filterStatus('all')">Semua</button>
        <button class="tab" data-status="proses" onclick="filterStatus('proses')">Proses</button>
        <button class="tab" data-status="terbit" onclick="filterStatus('terbit')">Terbit</button>
        <button class="tab" data-status="gagal" onclick="filterStatus('gagal')">Gagal</button>
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Cari nama pemohon...">
    </div>

    <!-- List Pengajuan -->
    <div id="pengajuanList">
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin" style="font-size: 30px; color: #2F80ED;"></i>
            <p style="margin-top: 10px; color: #999;">Memuat data...</p>
        </div>
    </div>

    <!-- Logout Button -->
    <form action="{{ route('petugas.logout') }}" method="POST" id="logoutForm">
        @csrf
        <button type="submit" class="logout-btn" title="Logout">
            <i class="fas fa-sign-out-alt"></i>
        </button>
    </form>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        let currentStatus = 'all';
        let searchTimeout;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load data saat halaman dibuka
        $(document).ready(function() {
            loadPengajuan();
        });

        // Filter by status
        function filterStatus(status) {
            currentStatus = status;
            
            // Update active tab
            $('.tab').removeClass('active');
            $(`.tab[data-status="${status}"]`).addClass('active');
            
            loadPengajuan();
        }

        // Search dengan debounce
        $('#searchInput').on('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                loadPengajuan();
            }, 400);
        });

        // Load pengajuan dari API
        function loadPengajuan() {
            const search = $('#searchInput').val();
            
            $('#pengajuanList').html(`
                <div class="loading-spinner">
                    <i class="fas fa-spinner fa-spin" style="font-size: 30px; color: #2F80ED;"></i>
                    <p style="margin-top: 10px; color: #999;">Memuat data...</p>
                </div>
            `);

            $.ajax({
                url: '{{ route("petugas.api.tugas") }}',
                method: 'GET',
                data: {
                    status: currentStatus,
                    search: search
                },
                success: function(response) {
                    if (response.status && response.data.length > 0) {
                        renderPengajuan(response.data);
                    } else {
                        showEmptyState();
                    }
                },
                error: function() {
                    $('#pengajuanList').html(`
                        <div class="empty-state">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Gagal memuat data</p>
                        </div>
                    `);
                }
            });
        }

        // Render list pengajuan
        function renderPengajuan(data) {
            let html = '';
            
            data.forEach(item => {
                const statusClass = `status-${item.status}`;
                const detailUrl = `{{ url('ciptakarya/petugas/tugas') }}/${item.id}`;
                
                html += `
                    <div class="pengajuan-card" onclick="window.location='${detailUrl}'">
                        <span class="status-badge ${statusClass}">${item.status.toUpperCase()}</span>
                        <h5>Tipe: ${item.tipe || '-'}</h5>
                        <p><strong>No Permohonan:</strong> ${item.no_permohonan || '-'}</p>
                        <p><strong>Pemohon:</strong> ${item.nama_pemohon || '-'}</p>
                        <p><strong>Fungsi Bangunan:</strong> ${item.fungsi_bangunan || '-'}</p>
                        <p><strong>Luas Bangunan:</strong> ${item.luas_bangunan || '-'} m²</p>
                        <p><strong>Tanggal:</strong> ${item.created_at || '-'}</p>
                    </div>
                `;
            });
            
            $('#pengajuanList').html(html);
        }

        // Empty state
        function showEmptyState() {
            $('#pengajuanList').html(`
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>Tidak ada data pengajuan</p>
                </div>
            `);
        }

        // Confirm logout
        $('#logoutForm').on('submit', function(e) {
            if (!confirm('Yakin ingin logout?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
