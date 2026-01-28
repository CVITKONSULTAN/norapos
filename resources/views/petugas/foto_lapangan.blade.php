<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Foto Lapangan - {{ $pengajuan->no_permohonan }}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #2F80ED;
            --success: #00b809;
            --warning: #FFC107;
            --danger: #FF3D00;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #F5F5F5;
            padding-bottom: 100px;
        }
        .header-bar {
            background: var(--primary);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
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
            flex-grow: 1;
        }
        .content-section {
            padding: 20px;
        }
        .info-box {
            background: linear-gradient(135deg, var(--primary), #1e5bb8);
            color: white;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .info-box h5 {
            font-size: 14px;
            margin-bottom: 5px;
            opacity: 0.9;
        }
        .info-box p {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
        }
        .location-box {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .location-box i {
            font-size: 24px;
            color: var(--primary);
        }
        .location-box .loc-info {
            flex-grow: 1;
        }
        .location-box .loc-info label {
            font-size: 12px;
            color: #666;
            margin: 0;
        }
        .location-box .loc-info span {
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        .location-box .loc-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .loc-status.success { background: #e8f5e9; color: var(--success); }
        .loc-status.warning { background: #fff3e0; color: #f57c00; }
        .loc-status.loading { background: #e3f2fd; color: var(--primary); }
        
        .segment-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .segment-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .segment-header h6 {
            margin: 0;
            font-weight: 600;
            flex-grow: 1;
            font-size: 15px;
        }
        .segment-header .badge {
            font-size: 11px;
        }
        
        /* Dropzone Styles */
        .dropzone {
            border: 2px dashed #ddd;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: #fafafa;
        }
        .dropzone:hover {
            border-color: var(--primary);
            background: #f0f7ff;
        }
        .dropzone.dragover {
            border-color: var(--primary);
            background: #e3f2fd;
            transform: scale(1.01);
        }
        .dropzone i {
            font-size: 40px;
            color: #999;
            margin-bottom: 10px;
        }
        .dropzone p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        .dropzone small {
            color: #999;
            font-size: 12px;
        }
        
        /* Photo Grid */
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }
        .photo-item {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background: #f5f5f5;
        }
        .photo-item img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
            display: block;
        }
        .photo-item .watermark {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.7);
            color: white;
            font-size: 9px;
            padding: 4px 6px;
            text-align: center;
        }
        .photo-item .remove-btn {
            position: absolute;
            top: 6px;
            right: 6px;
            background: rgba(255,0,0,0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 26px;
            height: 26px;
            font-size: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .photo-item:hover .remove-btn {
            opacity: 1;
        }
        .photo-item .uploading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .photo-item .uploading-overlay i {
            font-size: 24px;
            color: var(--primary);
            animation: spin 1s linear infinite;
        }
        
        .bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 15px 20px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            display: flex;
            gap: 10px;
        }
        .btn-save {
            flex-grow: 1;
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-save:hover {
            background: #1e5bb8;
        }
        .btn-save:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .global-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.7);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            color: white;
        }
        .global-overlay.hidden { display: none; }
        .global-overlay i {
            font-size: 40px;
            margin-bottom: 15px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        .hidden { display: none !important; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-bar">
        <button class="back-btn" onclick="confirmBack()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h4>Foto Lapangan</h4>
    </div>

    <div class="content-section">
        <!-- Info Pengajuan -->
        <div class="info-box">
            <h5>No. Permohonan</h5>
            <p>{{ $pengajuan->no_permohonan }}</p>
        </div>

        <!-- Location Status -->
        <div class="location-box">
            <i class="fas fa-map-marker-alt"></i>
            <div class="loc-info">
                <label>Lokasi GPS</label>
                <span id="locationText">Mengambil lokasi...</span>
            </div>
            <span id="locationStatus" class="loc-status loading">
                <i class="fas fa-spinner fa-spin"></i>
            </span>
        </div>

        <!-- Photo Segments - sama dengan React Native (flattenCaptions dari ListSection) -->
        @php
        $segments = [
            // Section 1-5 (top level)
            ['id' => '1-1. Identitas Pemilik', 'name' => '1. Identitas Pemilik'],
            ['id' => '2-2. Dokumen PBG', 'name' => '2. Dokumen PBG'],
            ['id' => '3-3. Dokumen Rencana Teknis atau Gambar Terbangun', 'name' => '3. Dokumen Rencana Teknis atau Gambar Terbangun'],
            ['id' => '4-4. Kondisi Bangunan Gedung (Secara Umum)', 'name' => '4. Kondisi Bangunan Gedung (Secara Umum)'],
            ['id' => '5-5. Kesesuaian Tata Bangunan', 'name' => '5. Kesesuaian Tata Bangunan'],
            
            // Section 6 - Kesesuaian Keandalan Bangunan
            ['id' => '6-6. Kesesuaian Keandalan Bangunan', 'name' => '6. Kesesuaian Keandalan Bangunan'],
            
            // 6.1 Pemeriksaan Sistem Struktur Bangunan
            ['id' => '6-1.6.1 Pemeriksaan Sistem Struktur Bangunan', 'name' => '6.1 Pemeriksaan Sistem Struktur Bangunan'],
            ['id' => '6-1.1.a. Kolom', 'name' => 'a. Kolom'],
            ['id' => '6-1.2.b. Balok', 'name' => 'b. Balok'],
            ['id' => '6-1.3.c. Pelat Lantai', 'name' => 'c. Pelat Lantai'],
            ['id' => '6-1.4.d. Rangka Atap', 'name' => 'd. Rangka Atap'],
            ['id' => '6-1.5.e. Dinding Inti', 'name' => 'e. Dinding Inti'],
            ['id' => '6-1.6.f. Basement', 'name' => 'f. Basement'],
            ['id' => '6-1.7.g. Komponen Struktur Lainnya', 'name' => 'g. Komponen Struktur Lainnya'],
            
            // 6.2 - 6.11
            ['id' => '6-2.6.2 Pemeriksaan Sistem Proteksi Kebakaran', 'name' => '6.2 Pemeriksaan Sistem Proteksi Kebakaran'],
            ['id' => '6-3.6.3 Pemeriksaan Sistem Instalasi Listrik', 'name' => '6.3 Pemeriksaan Sistem Instalasi Listrik'],
            ['id' => '6-4.6.4 Pemeriksaan Sistem Penghawaan', 'name' => '6.4 Pemeriksaan Sistem Penghawaan'],
            ['id' => '6-5.6.5 Pemeriksaan Sistem Pencahayaan', 'name' => '6.5 Pemeriksaan Sistem Pencahayaan'],
            ['id' => '6-6.6.6 Pemeriksaan Sistem Penyediaan Air Bersih', 'name' => '6.6 Pemeriksaan Sistem Penyediaan Air Bersih'],
            ['id' => '6-7.6.7 Pemeriksaan Sistem Pengelolaan Air Kotor atau Air Limbah', 'name' => '6.7 Pemeriksaan Sistem Pengelolaan Air Kotor atau Air Limbah'],
            ['id' => '6-8.6.8 Pemeriksaan Sistem Pengelolaan Kotoran dan Sampah', 'name' => '6.8 Pemeriksaan Sistem Pengelolaan Kotoran dan Sampah'],
            ['id' => '6-9.6.9 Pemeriksaan Sistem Pengelolaan Air Hujan', 'name' => '6.9 Pemeriksaan Sistem Pengelolaan Air Hujan'],
            ['id' => '6-10.6.10 Pemeriksaan Sarana Hubungan Vertikal Antarlantai', 'name' => '6.10 Pemeriksaan Sarana Hubungan Vertikal Antarlantai'],
            ['id' => '6-11.6.11 Pemeriksaan Kelengkapan Prasarana dan Sarana Bangunan Gedung', 'name' => '6.11 Pemeriksaan Kelengkapan Prasarana dan Sarana Bangunan Gedung'],
        ];
        @endphp

        @foreach($segments as $segment)
        <div class="segment-card">
            <div class="segment-header">
                <h6>{{ $segment['name'] }}</h6>
                <span class="badge badge-secondary" id="badge-{{ Str::slug($segment['id']) }}">0 foto</span>
            </div>
            
            <!-- Dropzone -->
            <div class="dropzone" 
                 id="dropzone-{{ Str::slug($segment['id']) }}"
                 data-segment="{{ $segment['id'] }}"
                 onclick="document.getElementById('input-{{ Str::slug($segment['id']) }}').click()">
                <i class="fas fa-cloud-upload-alt"></i>
                <p>Drag & drop foto di sini</p>
                <small>atau klik untuk pilih file</small>
            </div>
            <input type="file" 
                   id="input-{{ Str::slug($segment['id']) }}" 
                   data-segment="{{ $segment['id'] }}"
                   accept="image/*" 
                   multiple 
                   style="display: none;"
                   onchange="handleFileSelect(event, '{{ $segment['id'] }}')">
            
            <!-- Photo Grid -->
            <div class="photo-grid" id="grid-{{ Str::slug($segment['id']) }}">
                <!-- Photos will be added here dynamically -->
            </div>
        </div>
        @endforeach
    </div>

    <!-- Bottom Bar -->
    <div class="bottom-bar">
        <button class="btn-save" id="btnSave" onclick="savePhotos()" disabled>
            <i class="fas fa-save"></i> Simpan Foto
        </button>
    </div>

    <!-- Global Loading Overlay -->
    <div class="global-overlay hidden" id="globalOverlay">
        <i class="fas fa-spinner"></i>
        <p id="overlayText">Menyimpan...</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const pengajuanId = {{ $pengajuan->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Photo data storage: { segment: [{ id, dataUrl, url, lat, lng, timestamp, watermark, uploading }] }
        let photoData = {};
        let currentLocation = { lat: null, lng: null };
        let photoIdCounter = 0;

        // Load existing photos - handle double-encoded JSON from mobile app
        const existingPhotos = @json(
            is_string($pengajuan->photoMaps) 
                ? json_decode($pengajuan->photoMaps, true) ?? [] 
                : ($pengajuan->photoMaps ?? [])
        );
        
        // All valid segment IDs for lookup
        const validSegments = @json(array_column($segments, 'id'));
        console.log('Valid segments:', validSegments);
        
        // Initialize
        $(document).ready(function() {
            getLocation();
            initDropzones();
            loadExistingPhotos();
            updateSaveButton();
        });

        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')
                .replace(/[^\w\-]+/g, '')
                .replace(/\-\-+/g, '-')
                .replace(/^-+/, '')
                .replace(/-+$/, '');
        }

        function initDropzones() {
            document.querySelectorAll('.dropzone').forEach(dropzone => {
                const segment = dropzone.dataset.segment;
                
                dropzone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dropzone.classList.add('dragover');
                });
                
                dropzone.addEventListener('dragleave', () => {
                    dropzone.classList.remove('dragover');
                });
                
                dropzone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('dragover');
                    
                    const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
                    if (files.length > 0) {
                        processFiles(files, segment);
                    }
                });
            });
        }

        function handleFileSelect(event, segment) {
            const files = Array.from(event.target.files);
            if (files.length > 0) {
                processFiles(files, segment);
            }
            event.target.value = ''; // Reset input
        }

        function loadExistingPhotos() {
            console.log('Loading existing photos:', existingPhotos);
            console.log('Type:', typeof existingPhotos, 'IsArray:', Array.isArray(existingPhotos));
            
            // React Native format: array of objects with caption field
            // [{ caption: "1-1. Identitas Pemilik", url: "...", lat: ..., lng: ... }, ...]
            if (existingPhotos && Array.isArray(existingPhotos)) {
                existingPhotos.forEach((photo, idx) => {
                    console.log(`Photo ${idx}:`, photo);
                    if (photo && photo.url) {
                        let segment = photo.caption;
                        
                        // Skip photo tanpa caption
                        if (!segment) {
                            console.warn('Skipping photo without caption:', photo);
                            return;
                        }
                        
                        // Check if segment is valid, jika tidak coba find yang closest match
                        if (!validSegments.includes(segment)) {
                            // Try to find matching segment (case-insensitive)
                            const foundSegment = validSegments.find(s => 
                                s.toLowerCase() === segment.toLowerCase()
                            );
                            if (foundSegment) {
                                console.log(`Matched segment: "${segment}" -> "${foundSegment}"`);
                                segment = foundSegment;
                            } else {
                                console.warn(`Segment not found for caption: "${segment}". Available:`, validSegments);
                            }
                        }
                        
                        if (!photoData[segment]) {
                            photoData[segment] = [];
                        }
                        const photoObj = {
                            id: ++photoIdCounter,
                            url: photo.url,
                            lat: photo.lat,
                            lng: photo.lng,
                            timestamp: photo.timestamp,
                            watermark: photo.watermark,
                            uploading: false
                        };
                        photoData[segment].push(photoObj);
                        renderPhoto(segment, photoObj);
                        updateBadge(segment);
                    } else {
                        console.warn('Skipping photo - missing url:', photo);
                    }
                });
            }
            // Legacy format: object with segment keys (old web format)
            else if (existingPhotos && typeof existingPhotos === 'object') {
                for (let segment in existingPhotos) {
                    if (existingPhotos[segment] && Array.isArray(existingPhotos[segment])) {
                        if (!photoData[segment]) {
                            photoData[segment] = [];
                        }
                        existingPhotos[segment].forEach(photo => {
                            if (photo && photo.url) {
                                const photoObj = {
                                    id: ++photoIdCounter,
                                    url: photo.url,
                                    lat: photo.lat,
                                    lng: photo.lng,
                                    timestamp: photo.timestamp,
                                    watermark: photo.watermark,
                                    uploading: false
                                };
                                photoData[segment].push(photoObj);
                                renderPhoto(segment, photoObj);
                            }
                        });
                        updateBadge(segment);
                    }
                }
            }
            updateSaveButton();
        }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        currentLocation.lat = position.coords.latitude;
                        currentLocation.lng = position.coords.longitude;
                        $('#locationText').text(`${currentLocation.lat.toFixed(6)}, ${currentLocation.lng.toFixed(6)}`);
                        $('#locationStatus').removeClass('loading warning').addClass('success').html('<i class="fas fa-check"></i>');
                    },
                    (error) => {
                        console.error('Location error:', error);
                        $('#locationText').text('Lokasi tidak tersedia');
                        $('#locationStatus').removeClass('loading success').addClass('warning').html('<i class="fas fa-exclamation"></i>');
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                $('#locationText').text('GPS tidak didukung');
                $('#locationStatus').removeClass('loading success').addClass('warning').html('<i class="fas fa-times"></i>');
            }
        }

        async function processFiles(files, segment) {
            for (const file of files) {
                try {
                    const photoId = ++photoIdCounter;
                    const timestamp = new Date().toLocaleString('id-ID');
                    const watermark = buildWatermark(currentLocation.lat, currentLocation.lng, timestamp);
                    
                    // Compress image
                    const compressedDataUrl = await compressImage(file);
                    
                    // Create photo object
                    const photoObj = {
                        id: photoId,
                        dataUrl: compressedDataUrl,
                        url: null,
                        lat: currentLocation.lat,
                        lng: currentLocation.lng,
                        timestamp: timestamp,
                        watermark: watermark,
                        uploading: false
                    };
                    
                    // Add to data
                    if (!photoData[segment]) {
                        photoData[segment] = [];
                    }
                    photoData[segment].push(photoObj);
                    
                    // Render photo
                    renderPhoto(segment, photoObj);
                    updateBadge(segment);
                    updateSaveButton();
                    
                } catch (error) {
                    console.error('Error processing file:', error);
                }
            }
        }

        function compressImage(file, maxWidth = 1280) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = new Image();
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        let width = img.width;
                        let height = img.height;
                        
                        if (width > maxWidth) {
                            height = (height * maxWidth) / width;
                            width = maxWidth;
                        }
                        
                        canvas.width = width;
                        canvas.height = height;
                        
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);
                        
                        resolve(canvas.toDataURL('image/jpeg', 0.65));
                    };
                    img.onerror = reject;
                    img.src = e.target.result;
                };
                reader.onerror = reject;
                reader.readAsDataURL(file);
            });
        }

        function buildWatermark(lat, lng, timestamp) {
            const coord = (lat != null && lng != null) 
                ? `${lat.toFixed(5)}, ${lng.toFixed(5)}` 
                : 'no-loc';
            return `${coord} • ${timestamp}`;
        }

        function renderPhoto(segment, photo) {
            const slugId = slugify(segment);
            const grid = $(`#grid-${slugId}`);
            
            // Check if grid exists
            if (grid.length === 0) {
                console.warn('Grid not found for segment:', segment, 'slugId:', slugId);
                // Try to find the closest matching grid
                const allGrids = $('[id^="grid-"]');
                console.log('Available grids:', allGrids.map((i, el) => el.id).get());
                return;
            }
            
            const imgSrc = photo.url || photo.dataUrl;
            
            if (!imgSrc) {
                console.warn('No image source for photo:', photo);
                return;
            }
            
            const html = `
                <div class="photo-item" id="photo-${photo.id}">
                    <img src="${imgSrc}" alt="Photo" onerror="console.error('Failed to load image:', this.src.substring(0,100))">
                    <div class="watermark">${photo.watermark || ''}</div>
                    <button class="remove-btn" onclick="removePhoto('${segment.replace(/'/g, "\\'")}', ${photo.id})">
                        <i class="fas fa-times"></i>
                    </button>
                    ${photo.uploading ? '<div class="uploading-overlay"><i class="fas fa-spinner"></i></div>' : ''}
                </div>
            `;
            grid.append(html);
        }

        function removePhoto(segment, photoId) {
            if (!photoData[segment]) return;
            
            photoData[segment] = photoData[segment].filter(p => p.id !== photoId);
            $(`#photo-${photoId}`).remove();
            
            updateBadge(segment);
            updateSaveButton();
        }

        function updateBadge(segment) {
            const count = photoData[segment] ? photoData[segment].length : 0;
            const slugId = slugify(segment);
            const badge = $(`#badge-${slugId}`);
            badge.text(`${count} foto`);
            
            if (count > 0) {
                badge.removeClass('badge-secondary').addClass('badge-success');
            } else {
                badge.removeClass('badge-success').addClass('badge-secondary');
            }
        }

        function updateSaveButton() {
            // Enable save button if there's at least 1 photo in any segment
            let hasAnyPhoto = false;
            for (let segment in photoData) {
                if (photoData[segment] && photoData[segment].length > 0) {
                    hasAnyPhoto = true;
                    break;
                }
            }
            
            $('#btnSave').prop('disabled', !hasAnyPhoto);
        }

        async function savePhotos() {
            $('#globalOverlay').removeClass('hidden');
            $('#overlayText').text('Mengupload foto...');
            
            try {
                // Count total photos to upload
                let totalToUpload = 0;
                let uploadedCount = 0;
                
                for (let segment in photoData) {
                    if (photoData[segment]) {
                        photoData[segment].forEach(photo => {
                            if (photo.dataUrl && !photo.url) {
                                totalToUpload++;
                            }
                        });
                    }
                }

                // Upload each photo
                for (let segment in photoData) {
                    if (photoData[segment]) {
                        for (let i = 0; i < photoData[segment].length; i++) {
                            const photo = photoData[segment][i];
                            if (photo.dataUrl && !photo.url) {
                                uploadedCount++;
                                $('#overlayText').text(`Mengupload foto ${uploadedCount}/${totalToUpload}...`);
                                
                                // Show uploading state
                                $(`#photo-${photo.id}`).append('<div class="uploading-overlay"><i class="fas fa-spinner"></i></div>');
                                
                                const uploadResult = await uploadPhoto(photo.dataUrl);
                                if (uploadResult && uploadResult.url) {
                                    photoData[segment][i].url = uploadResult.url;
                                    delete photoData[segment][i].dataUrl;
                                }
                                
                                // Remove uploading state
                                $(`#photo-${photo.id} .uploading-overlay`).remove();
                            }
                        }
                    }
                }

                // Prepare data for saving - format same as React Native
                // React Native format: [{ caption: "1-Identitas Pemilik", url: "...", lat: ..., lng: ... }, ...]
                const saveData = [];
                for (let segment in photoData) {
                    if (photoData[segment] && photoData[segment].length > 0) {
                        photoData[segment].forEach(p => {
                            saveData.push({
                                caption: segment,
                                url: p.url,
                                lat: p.lat,
                                lng: p.lng,
                                timestamp: p.timestamp,
                                watermark: p.watermark
                            });
                        });
                    }
                }

                // Save to server
                $('#overlayText').text('Menyimpan data...');
                
                const response = await fetch(`/ciptakarya/petugas/tugas/${pengajuanId}/save-photos`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ photoMaps: saveData })
                });

                const result = await response.json();
                
                if (result.status) {
                    alert('Foto berhasil disimpan!');
                    window.location.href = `/ciptakarya/petugas/tugas/${pengajuanId}`;
                } else {
                    throw new Error(result.message || 'Gagal menyimpan');
                }

            } catch (error) {
                console.error('Save error:', error);
                alert('Gagal menyimpan foto: ' + error.message);
            } finally {
                $('#globalOverlay').addClass('hidden');
            }
        }

        async function uploadPhoto(dataUrl) {
            // Convert dataUrl to blob
            const response = await fetch(dataUrl);
            const blob = await response.blob();
            
            const formData = new FormData();
            formData.append('file_data', blob, `photo_${Date.now()}.jpg`);
            
            const uploadResponse = await fetch('/ciptakarya/petugas/upload-photo', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });
            
            return await uploadResponse.json();
        }

        function confirmBack() {
            // Check if there are unsaved photos
            let hasUnsaved = false;
            for (let segment in photoData) {
                if (photoData[segment]) {
                    photoData[segment].forEach(photo => {
                        if (photo.dataUrl && !photo.url) {
                            hasUnsaved = true;
                        }
                    });
                }
            }
            
            if (hasUnsaved) {
                if (confirm('Ada foto yang belum disimpan. Yakin ingin kembali?')) {
                    window.history.back();
                }
            } else {
                window.history.back();
            }
        }
    </script>
</body>
</html>
