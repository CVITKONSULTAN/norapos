<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Tugas - {{ $pengajuan->no_permohonan }}</title>
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
        .content-section {
            padding: 20px;
        }
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
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
            width: 150px;
            flex-shrink: 0;
        }
        .info-row span {
            color: #333;
            flex-grow: 1;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            color: white;
        }
        .status-proses { background: #FFC107; }
        .status-terbit { background: #00b809; }
        .status-gagal { background: #FF3D00; }
        .btn-primary-custom {
            background: #2F80ED;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-primary-custom:hover {
            background: #1e5bb8;
            transform: translateY(-2px);
        }
        .uploaded-files {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }
        .file-item {
            text-align: center;
            padding: 10px;
            background: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .file-item i {
            font-size: 30px;
            color: #2F80ED;
            margin-bottom: 5px;
        }
        .file-item a {
            font-size: 12px;
            color: #333;
            text-decoration: none;
            display: block;
            margin-top: 5px;
        }
        .file-item a:hover {
            color: #2F80ED;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-bar">
        <button class="back-btn" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h4>Detail Tugas Verifikasi</h4>
    </div>

    <div class="content-section">
        <!-- Status Badge -->
        <div class="text-center mb-3">
            <span class="status-badge status-{{ $pengajuan->status }}">
                {{ strtoupper($pengajuan->status) }}
            </span>
        </div>

        <!-- Info Permohonan -->
        <div class="info-card">
            <h5><i class="fas fa-file-alt"></i> Informasi Permohonan</h5>
            <div class="info-row">
                <label>Tipe:</label>
                <span>{{ $pengajuan->tipe ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>No Permohonan:</label>
                <span>{{ $pengajuan->no_permohonan ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>No KRK:</label>
                <span>{{ $pengajuan->no_krk ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>Tanggal:</label>
                <span>{{ $pengajuan->created_at ? $pengajuan->created_at->format('d/m/Y H:i') : '-' }}</span>
            </div>
        </div>

        <!-- Info Pemohon -->
        <div class="info-card">
            <h5><i class="fas fa-user"></i> Data Pemohon</h5>
            <div class="info-row">
                <label>Nama:</label>
                <span>{{ $pengajuan->nama_pemohon ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>NIK:</label>
                <span>{{ $pengajuan->nik ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>Alamat:</label>
                <span>{{ $pengajuan->alamat ?? '-' }}</span>
            </div>
        </div>

        <!-- Info Bangunan -->
        <div class="info-card">
            <h5><i class="fas fa-building"></i> Data Bangunan</h5>
            <div class="info-row">
                <label>Nama Bangunan:</label>
                <span>{{ $pengajuan->nama_bangunan ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>Fungsi:</label>
                <span>{{ $pengajuan->fungsi_bangunan ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>Jumlah Bangunan:</label>
                <span>{{ $pengajuan->jumlah_bangunan ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>Jumlah Lantai:</label>
                <span>{{ $pengajuan->jumlah_lantai ?? '-' }}</span>
            </div>
            <div class="info-row">
                <label>Luas Bangunan:</label>
                <span>{{ $pengajuan->luas_bangunan ?? '-' }} m²</span>
            </div>
            <div class="info-row">
                <label>Lokasi:</label>
                <span>{{ $pengajuan->lokasi_bangunan ?? '-' }}</span>
            </div>
        </div>

        <!-- Lampiran Files -->
        @if($pengajuan->uploaded_files && count($pengajuan->uploaded_files) > 0)
        <div class="info-card">
            <h5><i class="fas fa-paperclip"></i> Lampiran Dokumen</h5>
            <div class="uploaded-files">
                @foreach($pengajuan->uploaded_files as $file)
                    <div class="file-item">
                        <i class="fas fa-file-pdf"></i>
                        <a href="{{ $file['file'] ?? '#' }}" target="_blank">
                            {{ $file['name'] ?? 'File' }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Menu Verifikasi -->
        @if($pengajuan->status === 'proses')
        <div class="info-card">
            <h5><i class="fas fa-tasks"></i> Menu Verifikasi</h5>
            
            @php
                // Handle double-encoded JSON from mobile app
                $photoMapsData = is_string($pengajuan->photoMaps) 
                    ? json_decode($pengajuan->photoMaps, true) ?? [] 
                    : ($pengajuan->photoMaps ?? []);
                $answersData = is_string($pengajuan->answers)
                    ? json_decode($pengajuan->answers, true) ?? []
                    : ($pengajuan->answers ?? []);
                
                // React Native format: array of objects [{ caption: "...", url: "..." }, ...]
                $hasPhotos = !empty($photoMapsData) && is_array($photoMapsData);
                $photoCount = 0;
                if ($hasPhotos) {
                    // Check if it's React Native format (array with caption)
                    if (isset($photoMapsData[0]) && isset($photoMapsData[0]['caption'])) {
                        $photoCount = count($photoMapsData);
                    } else {
                        // Legacy format: object with segment keys
                        foreach ($photoMapsData as $photos) {
                            if (is_array($photos)) {
                                $photoCount += count($photos);
                            }
                        }
                    }
                }
                $photosComplete = $photoCount > 0;
                
                $hasAnswers = !empty($answersData) && is_array($answersData);
                $answerCount = $hasAnswers ? count($answersData) : 0;
                $answersComplete = $answerCount > 0; // Kuesioner opsional
            @endphp

            <div class="menu-list">
                <!-- Foto Lapangan -->
                <a href="{{ route('petugas.tugas.foto', $pengajuan->id) }}" class="menu-item">
                    <div class="menu-icon {{ $photosComplete ? 'complete' : '' }}">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="menu-text">
                        <h6>Foto Lapangan</h6>
                        <small>{{ $photoCount > 0 ? $photoCount . ' foto diupload' : 'Belum ada foto' }}</small>
                    </div>
                    <i class="fas fa-chevron-right menu-arrow"></i>
                </a>

                <!-- Kuesioner -->
                <a href="{{ route('petugas.tugas.kuesioner', $pengajuan->id) }}" class="menu-item">
                    <div class="menu-icon {{ $answerCount > 0 ? 'complete' : '' }}">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="menu-text">
                        <h6>Kuesioner Verifikasi <span style="font-size: 10px; color: #888;">(Opsional)</span></h6>
                        <small>{{ $answerCount > 0 ? $answerCount . ' pertanyaan terjawab' : 'Belum diisi' }}</small>
                    </div>
                    <i class="fas fa-chevron-right menu-arrow"></i>
                </a>

                <!-- Submit Verifikasi -->
                <a href="{{ route('petugas.tugas.submit', $pengajuan->id) }}" class="menu-item {{ !$photosComplete ? 'disabled' : 'submit-ready' }}">
                    <div class="menu-icon submit">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <div class="menu-text">
                        <h6>Submit Verifikasi</h6>
                        <small>{{ $photosComplete ? 'Siap dikirim' : 'Upload minimal 1 foto' }}</small>
                    </div>
                    <i class="fas fa-chevron-right menu-arrow"></i>
                </a>
            </div>
        </div>
        @else
        <div class="info-card">
            <h5><i class="fas fa-check-circle"></i> Status Verifikasi</h5>
            <div class="status-complete-box">
                <i class="fas {{ $pengajuan->status === 'terbit' ? 'fa-check-circle text-success' : 'fa-times-circle text-danger' }}"></i>
                <p>Verifikasi telah selesai dengan status: <strong>{{ strtoupper($pengajuan->status) }}</strong></p>
            </div>
            
            @if(!empty($pengajuan->notes))
            <div class="notes-box">
                <strong>Catatan:</strong>
                <p>{{ $pengajuan->notes }}</p>
            </div>
            @endif
        </div>
        @endif

        <!-- Tombol Kembali -->
        <div style="margin-top: 15px;">
            <a href="{{ route('petugas.dashboard') }}" class="btn btn-primary-custom">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <style>
        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 10px;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s;
        }
        .menu-item:hover {
            background: #f0f7ff;
            transform: translateX(5px);
        }
        .menu-item.disabled {
            opacity: 0.6;
            pointer-events: none;
        }
        .menu-item.submit-ready {
            background: #e8f5e9;
        }
        .menu-item.submit-ready:hover {
            background: #c8e6c9;
        }
        .menu-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            background: #2F80ED;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-right: 15px;
        }
        .menu-icon.complete {
            background: #00b809;
        }
        .menu-icon.submit {
            background: #FFC107;
        }
        .menu-text {
            flex-grow: 1;
        }
        .menu-text h6 {
            margin: 0 0 3px 0;
            font-size: 15px;
            font-weight: 600;
            color: #333;
        }
        .menu-text small {
            color: #666;
            font-size: 12px;
        }
        .menu-arrow {
            color: #999;
            font-size: 14px;
        }
        .status-complete-box {
            text-align: center;
            padding: 20px;
        }
        .status-complete-box i {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .status-complete-box p {
            margin: 0;
            color: #666;
        }
        .notes-box {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
        }
        .notes-box strong {
            font-size: 13px;
            color: #333;
        }
        .notes-box p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #666;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</body>
</html>
