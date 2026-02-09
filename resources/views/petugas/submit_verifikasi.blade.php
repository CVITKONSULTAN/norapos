<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Submit Verifikasi - {{ $pengajuan->no_permohonan }}</title>
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
        .checklist-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .checklist-card h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        .checklist-item {
            display: flex;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }
        .checklist-item:last-child {
            border-bottom: none;
        }
        .checklist-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 14px;
        }
        .checklist-icon.complete {
            background: #e8f5e9;
            color: var(--success);
        }
        .checklist-icon.incomplete {
            background: #fff3e0;
            color: #f57c00;
        }
        .checklist-icon.neutral {
            background: #f5f5f5;
            color: #888;
        }
        .checklist-text {
            flex-grow: 1;
        }
        .checklist-text h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }
        .checklist-text small {
            color: #666;
        }
        .checklist-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
        }
        .checklist-action.complete {
            background: #e8f5e9;
            color: var(--success);
        }
        .checklist-action.incomplete {
            background: var(--primary);
            color: white;
        }
        .checklist-action.neutral {
            background: #f5f5f5;
            color: #666;
        }
        
        .photo-upload-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .photo-upload-section h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        .final-photo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }
        .final-photo-slot {
            aspect-ratio: 4/3;
            background: #f5f5f5;
            border: 2px dashed #ddd;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.2s;
        }
        .final-photo-slot:hover {
            border-color: var(--primary);
            background: #f0f7ff;
        }
        .final-photo-slot.has-photo {
            border-style: solid;
            border-color: var(--success);
        }
        .final-photo-slot i {
            font-size: 30px;
            color: #999;
            margin-bottom: 8px;
        }
        .final-photo-slot span {
            font-size: 12px;
            color: #666;
            text-align: center;
        }
        .final-photo-slot img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .final-photo-slot .watermark {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.6);
            color: white;
            font-size: 10px;
            padding: 5px;
            text-align: center;
        }
        .final-photo-slot .remove-btn {
            position: absolute;
            top: 8px;
            right: 8px;
            background: rgba(255,0,0,0.8);
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            font-size: 14px;
            cursor: pointer;
            display: none;
        }
        .final-photo-slot:hover .remove-btn {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .notes-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .notes-section h5 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }
        .notes-textarea {
            width: 100%;
            min-height: 120px;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            resize: vertical;
        }
        .notes-textarea:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .bottom-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            padding: 15px 20px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        }
        .btn-submit {
            width: 100%;
            background: var(--success);
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background: #009907;
        }
        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .loading-overlay {
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
        .loading-overlay.hidden { display: none; }
        .loading-overlay i {
            font-size: 40px;
            margin-bottom: 15px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        
        .alert-warning-custom {
            background: #fff3e0;
            border: 1px solid #ffcc80;
            border-radius: 8px;
            padding: 12px 15px;
            color: #e65100;
            font-size: 13px;
            margin-bottom: 15px;
        }
        .alert-warning-custom i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-bar">
        <button class="back-btn" onclick="window.history.back()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h4>Submit Verifikasi</h4>
    </div>

    <div class="content-section">
        <!-- Info Pengajuan -->
        <div class="info-box">
            <h5>No. Permohonan</h5>
            <p>{{ $pengajuan->no_permohonan }}</p>
        </div>

        <!-- Checklist -->
        <div class="checklist-card">
            <h5><i class="fas fa-tasks"></i> Kelengkapan Verifikasi</h5>
            
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
                $answersComplete = $answerCount > 0; // Kuesioner opsional, cukup 1 jawaban
            @endphp

            <div class="checklist-item">
                <div class="checklist-icon {{ $photosComplete ? 'complete' : 'incomplete' }}">
                    <i class="fas {{ $photosComplete ? 'fa-check' : 'fa-camera' }}"></i>
                </div>
                <div class="checklist-text">
                    <h6>Foto Lapangan</h6>
                    <small>{{ $photosComplete ? $photoCount . ' foto diupload' : 'Belum ada foto' }}</small>
                </div>
                <a href="{{ route('petugas.tugas.foto', $pengajuan->id) }}" 
                   class="checklist-action {{ $photosComplete ? 'complete' : 'incomplete' }}">
                    {{ $photosComplete ? 'Lihat' : 'Upload' }}
                </a>
            </div>

            <div class="checklist-item">
                <div class="checklist-icon {{ $answerCount > 0 ? 'complete' : 'neutral' }}">
                    <i class="fas {{ $answerCount > 0 ? 'fa-check' : 'fa-clipboard-list' }}"></i>
                </div>
                <div class="checklist-text">
                    <h6>Kuesioner Verifikasi <span style="font-size: 11px; color: #888;">(Opsional)</span></h6>
                    <small>{{ $answerCount > 0 ? $answerCount . ' pertanyaan terjawab' : 'Belum ada jawaban' }}</small>
                </div>
                <a href="{{ route('petugas.tugas.kuesioner', $pengajuan->id) }}" 
                   class="checklist-action {{ $answerCount > 0 ? 'complete' : 'neutral' }}">
                    {{ $answerCount > 0 ? 'Edit' : 'Isi' }}
                </a>
            </div>
        </div>

        <!-- Hidden file input -->
        <input type="file" id="finalPhotoInput" accept="image/*" capture="environment" style="display: none;">

        <!-- Notes Section -->
        <div class="notes-section">
            <h5><i class="fas fa-sticky-note"></i> Catatan Verifikasi (Opsional)</h5>
            <textarea class="notes-textarea" id="notesInput" placeholder="Tambahkan catatan atau keterangan tambahan...">{{ $pengajuan->notes ?? '' }}</textarea>
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bottom-bar">
        <button class="btn-submit" id="btnSubmit" onclick="submitVerifikasi()" {{ !$photosComplete ? 'disabled' : '' }}>
            <i class="fas fa-paper-plane"></i> Submit Verifikasi
        </button>
        @if(!$photosComplete)
        <p style="text-align: center; font-size: 12px; color: #999; margin-top: 10px;">Upload minimal 1 foto untuk submit</p>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay hidden" id="loadingOverlay">
        <i class="fas fa-spinner"></i>
        <p id="loadingText">Memproses...</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const pengajuanId = {{ $pengajuan->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Final photos data
        let finalPhotos = @json($pengajuan->list_foto ?? []);
        let currentLocation = { lat: null, lng: null };
        let currentPhotoIndex = null;

        // Initialize
        $(document).ready(function() {
            getLocation();
        });

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        currentLocation.lat = position.coords.latitude;
                        currentLocation.lng = position.coords.longitude;
                    },
                    (error) => console.log('Location error:', error),
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            }
        }

        function selectFinalPhoto(index) {
            currentPhotoIndex = index;
            $('#finalPhotoInput').click();
        }

        $('#finalPhotoInput').on('change', async function(e) {
            const file = e.target.files[0];
            if (file && currentPhotoIndex !== null) {
                await processFinalPhoto(file, currentPhotoIndex);
            }
            $(this).val('');
        });

        async function processFinalPhoto(file, index) {
            try {
                const compressedDataUrl = await compressImage(file);
                const timestamp = new Date().toLocaleString('id-ID');
                const watermark = buildWatermark(currentLocation.lat, currentLocation.lng, timestamp);

                // Ensure array has enough elements
                while (finalPhotos.length <= index) {
                    finalPhotos.push(null);
                }

                finalPhotos[index] = {
                    dataUrl: compressedDataUrl,
                    url: null,
                    lat: currentLocation.lat,
                    lng: currentLocation.lng,
                    timestamp: timestamp,
                    watermark: watermark
                };

                updateFinalPhotoSlot(index, finalPhotos[index]);
            } catch (error) {
                console.error('Error processing photo:', error);
                alert('Gagal memproses foto');
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

        function updateFinalPhotoSlot(index, photo) {
            const slot = $(`.final-photo-slot[data-index="${index}"]`);
            const imgSrc = photo.url || photo.dataUrl;
            
            slot.addClass('has-photo');
            slot.html(`
                <img src="${imgSrc}" alt="Final Photo">
                <div class="watermark">${photo.watermark || ''}</div>
                <button class="remove-btn" onclick="event.stopPropagation(); removeFinalPhoto(${index})">
                    <i class="fas fa-times"></i>
                </button>
            `);
        }

        function removeFinalPhoto(index) {
            finalPhotos[index] = null;
            
            const slot = $(`.final-photo-slot[data-index="${index}"]`);
            slot.removeClass('has-photo');
            slot.html(`
                <i class="fas fa-plus"></i>
                <span>Tambah Foto</span>
            `);
        }

        async function submitVerifikasi() {
            if (!confirm('Yakin ingin mengirim verifikasi? Data yang sudah dikirim tidak dapat diubah.')) {
                return;
            }

            $('#loadingOverlay').removeClass('hidden');
            $('#loadingText').text('Mengupload foto...');

            try {
                // Upload final photos that need uploading
                for (let i = 0; i < finalPhotos.length; i++) {
                    const photo = finalPhotos[i];
                    if (photo && photo.dataUrl && !photo.url) {
                        const uploadResult = await uploadPhoto(photo.dataUrl);
                        if (uploadResult && uploadResult.url) {
                            finalPhotos[i].url = uploadResult.url;
                            delete finalPhotos[i].dataUrl;
                        }
                    }
                }

                // Prepare final photos data
                const listFoto = finalPhotos.filter(p => p && p.url).map(p => ({
                    url: p.url,
                    lat: p.lat,
                    lng: p.lng,
                    timestamp: p.timestamp,
                    watermark: p.watermark
                }));

                // Get notes
                const notes = $('#notesInput').val().trim();

                // Submit to server
                $('#loadingText').text('Mengirim verifikasi...');

                const response = await fetch(`/ciptakarya/petugas/tugas/${pengajuanId}/submit`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        list_foto: listFoto,
                        notes: notes
                    })
                });

                const result = await response.json();

                if (result.status) {
                    alert('Verifikasi berhasil dikirim!');
                    window.location.href = '/ciptakarya/petugas/dashboard';
                } else {
                    throw new Error(result.message || 'Gagal mengirim verifikasi');
                }

            } catch (error) {
                console.error('Submit error:', error);
                alert('Gagal mengirim verifikasi: ' + error.message);
            } finally {
                $('#loadingOverlay').addClass('hidden');
            }
        }

        async function uploadPhoto(dataUrl) {
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
    </script>
</body>
</html>
