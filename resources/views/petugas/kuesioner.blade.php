<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kuesioner Verifikasi - {{ $pengajuan->no_permohonan }}</title>
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
            padding: 15px;
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
        .progress-bar-container {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .progress-bar-container label {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            display: block;
        }
        .progress {
            height: 8px;
            border-radius: 4px;
        }
        .progress-text {
            font-size: 12px;
            color: var(--primary);
            text-align: right;
            margin-top: 5px;
        }
        
        .section-card {
            background: white;
            border-radius: 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .section-header {
            padding: 15px;
            display: flex;
            align-items: center;
            cursor: pointer;
            border-bottom: 1px solid #eee;
            transition: background 0.2s;
        }
        .section-header:hover {
            background: #f9f9f9;
        }
        .section-header .icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 14px;
        }
        .section-header .icon.complete {
            background: var(--success);
        }
        .section-header h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            flex-grow: 1;
        }
        .section-header .chevron {
            color: #999;
            transition: transform 0.3s;
        }
        .section-header.expanded .chevron {
            transform: rotate(180deg);
        }
        .section-body {
            display: none;
            padding: 15px;
            background: #fafafa;
        }
        .section-body.show {
            display: block;
        }
        
        .question-item {
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #eee;
        }
        .question-text {
            font-size: 13px;
            color: #333;
            margin-bottom: 10px;
            font-weight: 500;
        }
        .choices-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .choice-btn {
            padding: 8px 16px;
            border: 2px solid #ddd;
            border-radius: 20px;
            background: white;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .choice-btn:hover {
            border-color: var(--primary);
        }
        .choice-btn.selected {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        .choice-btn.selected-negative {
            background: var(--danger);
            border-color: var(--danger);
            color: white;
        }
        .field-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 13px;
        }
        .field-input:focus {
            outline: none;
            border-color: var(--primary);
        }
        
        .subsection-card {
            background: #fff;
            border-radius: 8px;
            margin-bottom: 8px;
            border: 1px solid #e0e0e0;
        }
        .subsection-header {
            padding: 12px;
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #555;
        }
        .subsection-header:hover {
            background: #f5f5f5;
        }
        .subsection-body {
            display: none;
            padding: 12px;
            background: #f9f9f9;
        }
        .subsection-body.show {
            display: block;
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
        .btn-save {
            width: 100%;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header-bar">
        <button class="back-btn" onclick="confirmBack()">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h4>Kuesioner Verifikasi</h4>
    </div>

    <div class="content-section">
        <!-- Info Pengajuan -->
        <div class="info-box">
            <h5>No. Permohonan</h5>
            <p>{{ $pengajuan->no_permohonan }}</p>
        </div>

        <!-- Progress Bar -->
        <div class="progress-bar-container">
            <label>Progress Pengisian</label>
            <div class="progress">
                <div class="progress-bar bg-primary" id="progressBar" style="width: 0%"></div>
            </div>
            <div class="progress-text" id="progressText">0 / 0 terjawab</div>
        </div>

        <!-- Sections Container -->
        <div id="sectionsContainer">
            <!-- Will be rendered by JavaScript -->
        </div>
    </div>

    <!-- Bottom Bar -->
    <div class="bottom-bar">
        <button class="btn-save" id="btnSave" onclick="saveAnswers()">
            <i class="fas fa-save"></i> Simpan Jawaban
        </button>
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay hidden" id="loadingOverlay">
        <i class="fas fa-spinner"></i>
        <p>Menyimpan jawaban...</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const pengajuanId = {{ $pengajuan->id }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        
        // Answers storage - must be object, not array
        window.answers = {};
        
        // Load existing answers - handle double-encoded JSON from mobile app
        const existingAnswers = @json(
            is_string($pengajuan->answers) 
                ? json_decode($pengajuan->answers, true) ?? (object)[] 
                : ($pengajuan->answers ?? (object)[])
        );
        console.log('Existing answers from server:', existingAnswers);
        
        // ==========================================
        // STRUKTUR KUESIONER (dari ListSection.ts)
        // ==========================================
        const initialListSection = [
            {
                caption: '1. Identitas Pemilik',
                questioner: [
                    {
                        type: 'choice',
                        question: '1) Pemilik sesuai dokumen?',
                        choices: [
                            { label: 'Ya', value: 1 },
                            { label: 'Tidak Ada', value: -2 },
                        ],
                    },
                ],
            },
            {
                caption: '2. Dokumen PBG',
                questioner: [
                    { type: 'choice', question: '1) Dokumen PBG Tersedia', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '2) Fungsi Bangunan Gedung sesuai dengan informasi di dalam PBG', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '3) Luas Bangunan Gedung Sesuai dengan informasi di dalam PBG', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '4) Ketinggian Bangunan Gedung sesuai dengan informasi di dalam PBG', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '5) Jumlah Lantai Bangunan Gedung sesuai dengan informasi di dalam PBG', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                ],
            },
            {
                caption: '3. Dokumen Rencana Teknis atau Gambar Terbangun',
                questioner: [
                    { type: 'choice', question: '1) Dokumen rencana teknis atau gambar terbangun tersedia', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '2) Fungsi Bangunan Gedung sesuai dengan informasi dalam dokumen rencana teknis atau gambar terbangun', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '3) Luas Bangunan Gedung sesuai dengan informasi dalam dokumen rencana teknis atau gambar terbangun', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '4) Ketinggian Bangunan Gedung sesuai dengan informasi dalam dokumen rencana teknis atau gambar terbangun', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '5) Jumlah Lantai Bangunan Gedung sesuai dengan informasi dalam dokumen rencana teknis atau gambar terbangun', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '6) Kondisi struktur sesuai dengan informasi di dalam Dokumen rencana teknis atau gambar terbangun', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '7) Kondisi arsitektur sesuai dengan informasi di dalam Dokumen rencana teknis atau gambar terbangun', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '8) Kondisi Mekanikal, Elektrikal, dan Plambing sesuai dengan informasi di dalam Dokumen rencana teknis atau gambar terbangun', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                ],
            },
            {
                caption: '4. Kondisi Bangunan Gedung (Secara Umum)',
                questioner: [
                    { type: 'choice', question: '1) Miring / Deformasi', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '2) Terdapat Kerusakan', choices: [{ label: 'Ringan', value: 1 }, { label: 'Sedang', value: 2 }, { label: 'Berat', value: 3 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '3) Bangunan dimanfaatkan', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                    { type: 'choice', question: '4) Bangunan terawat dengan baik', choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                ],
            },
            {
                caption: '5. Kesesuaian Tata Bangunan',
                questioner: [
                    { type: 'choice', question: '1) Fungsi Bangunan', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual :' },
                    { type: 'choice', question: '2) Pemanfaatan Ruang Dalam', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual :' },
                    { type: 'choice', question: '3) Pemanfaatan Ruang Luar', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual :' },
                    { type: 'choice', question: '4) Luas Lantai Dasar Bangunan', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual :' },
                    { type: 'choice', question: '5) Luas Total Lantai Bangunan', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual :' },
                    { type: 'choice', question: '6) Jumlah Lantai Bangunan', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual :' },
                    { type: 'choice', question: '7) Ketinggian Bangunan', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual :' },
                    { type: 'choice', question: '8) Luas Daerah Hijau Dalam Persil', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m2) :' },
                    { type: 'choice', question: '9) Jarak Sempadan Jalan', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                    { type: 'choice', question: '10) Jarak Sempadan Sungai', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                    { type: 'choice', question: '11) Jarak Sempadan Jalur Tegangan Tinggi', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                    { type: 'choice', question: '12) Jarak Bangunan Dengan Batas Kiri', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                    { type: 'choice', question: '13) Jarak Bangunan Dengan Batas Kanan', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                    { type: 'choice', question: '14) Jarak Bangunan Dengan Batas Belakang', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                    { type: 'choice', question: '15) Jarak Dengan Bangunan Kiri', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                    { type: 'choice', question: '16) Jarak Dengan Bangunan Kanan', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                    { type: 'choice', question: '17) Jarak Dengan Bangunan Belakang', choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] },
                    { type: 'field', question: 'Hasil Pengamatan Visual (m) :' },
                ],
            },
            {
                caption: '6. Kesesuaian Keandalan Bangunan',
                child: [
                    {
                        caption: '6.1 Pemeriksaan Sistem Struktur Bangunan',
                        child: [
                            { caption: 'a. Kolom', questioner: createStructureQuestions() },
                            { caption: 'b. Balok', questioner: createStructureQuestions() },
                            { caption: 'c. Pelat Lantai', questioner: createStructureQuestions() },
                            { caption: 'd. Rangka Atap', questioner: [
                                { type: 'choice', question: '1) Korosi baja profil pada struktur baja', choices: [{ label: 'Ada', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                                { type: 'field', question: 'Keterangan :' },
                                { type: 'choice', question: '2) Kerapuhan kayu akibat serangga perusak (rayap) pada struktur kayu', choices: [{ label: 'Ada', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                                { type: 'field', question: 'Keterangan :' },
                            ]},
                            { caption: 'e. Dinding Inti', questioner: createStructureQuestions() },
                            { caption: 'f. Basement', questioner: createStructureQuestions() },
                            { caption: 'g. Komponen Struktur Lainnya', questioner: createExtendedStructureQuestions() },
                        ],
                    },
                    { caption: '6.2 Pemeriksaan Sistem Proteksi Kebakaran', questioner: createFireProtectionQuestions() },
                    { caption: '6.3 Pemeriksaan Sistem Instalasi Listrik', questioner: createDualQuestions(['Sumber Listrik', 'Panel listrik', 'Instalasi Listrik']) },
                    { caption: '6.4 Pemeriksaan Sistem Penghawaan', questioner: createDualQuestions(['Ventilasi Alami', 'Ventilasi Mekanik', 'Sistem Pengkondisian Udara']) },
                    { caption: '6.5 Pemeriksaan Sistem Pencahayaan', questioner: createDualQuestions(['Sistem Pencahayaan Alami', 'Sistem Pencahayaan Buatan']) },
                    { caption: '6.6 Pemeriksaan Sistem Penyediaan Air Bersih', questioner: createDualQuestions(['Sumber Air Bersih', 'Sistem Distribusi Air Bersih']) },
                    { caption: '6.7 Pemeriksaan Sistem Pengelolaan Air Kotor atau Air Limbah', questioner: createDualQuestions(['Peralatan Saniter', 'Instalasi Inlet/Outlet', 'Sistem Jaringan Pembuangan']) },
                    { caption: '6.8 Pemeriksaan Sistem Pengelolaan Kotoran dan Sampah', questioner: createDualQuestions(['Inlet Pembuangan', 'Penampungan Sementara Dalam Persil']) },
                    { caption: '6.9 Pemeriksaan Sistem Pengelolaan Air Hujan', questioner: createDualQuestions(['Sistem Penangkap Air Hujan, Termasuk Talang', 'Sistem Penyaluran Air Hujan, Termasuk Pipa Tegak dan Drainase Dalam Persil', 'Sistem Penampungan, Pengolahan, Peresapan Dan/Atau Pembuangan Air']) },
                    { caption: '6.10 Pemeriksaan Sarana Hubungan Vertikal Antarlantai', questioner: createDualQuestions(['Tangga', 'Ram', 'Sistem Lift']) },
                    { caption: '6.11 Pemeriksaan Kelengkapan Prasarana dan Sarana Bangunan Gedung', questioner: createDualQuestions(['Fasilitas Parkir', 'Ruang Ibadah', 'Ruang Ganti', 'Tempat Sampah', 'Toilet', 'Sistem Komunikasi', 'Sistem Informasi', 'Kelengkapan Lainnya']) },
                ],
            },
        ];

        // Helper functions to create question arrays
        function createStructureQuestions() {
            return [
                { type: 'choice', question: '1) Lubang lubang yang relatif dalam dan lebar pada beton (voids atau honeycombs)', choices: [{ label: 'Ada', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                { type: 'field', question: 'Keterangan :' },
                { type: 'choice', question: '2) Pecahan pada beton dalam garis-garis yang relatif panjang dan sempit (retak)', choices: [{ label: 'Ada', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                { type: 'field', question: 'Keterangan :' },
                { type: 'choice', question: '3) Pengelupasan dangkal pada permukaan beton (scalling/spalling)', choices: [{ label: 'Ada', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                { type: 'field', question: 'Keterangan :' },
                { type: 'choice', question: '4) Korosi pada baja tulangan beton', choices: [{ label: 'Ada', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                { type: 'field', question: 'Keterangan :' },
                { type: 'choice', question: '5) Korosi pada baja profil untuk struktur baja', choices: [{ label: 'Ada', value: 1 }, { label: 'Tidak Ada', value: -2 }] },
                { type: 'field', question: 'Keterangan :' },
            ];
        }

        function createExtendedStructureQuestions() {
            const base = createStructureQuestions();
            base.push({ type: 'choice', question: '6) Kerapuhan kayu akibat serangga perusak (rayap) pada struktur kayu', choices: [{ label: 'Ada', value: 1 }, { label: 'Tidak Ada', value: -2 }] });
            base.push({ type: 'field', question: 'Keterangan :' });
            return base;
        }

        function createFireProtectionQuestions() {
            const items = [
                'Pompa Pemadam Kebakaran', 'Ketersediaan Air', 'Alat Pemadam Api Ringan',
                'Sistem Deteksi Kebakaran', 'Sistem Alarm Kebakaran', 'Sistem Komunikasi Darurat',
                'Sistem Pengendali Asap', 'Tangga Kebakaran', 'Pintu Kebakaran',
                'Penerangan Darurat', 'Tanda Penunjuk Arah'
            ];
            const questions = [];
            items.forEach((item, idx) => {
                questions.push({ type: 'choice', question: `${idx+1}) ${item} (Pengamatan Visual)`, choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak', value: -2 }] });
                questions.push({ type: 'choice', question: `${item} (Kesesuaian Faktual dengan Rencana dan Gambar Teknis)`, choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] });
            });
            return questions;
        }

        function createDualQuestions(items) {
            const questions = [];
            items.forEach((item, idx) => {
                questions.push({ type: 'choice', question: `${idx+1}) ${item} (Pengamatan Visual)`, choices: [{ label: 'Ya', value: 1 }, { label: 'Tidak', value: -2 }] });
                questions.push({ type: 'choice', question: `${item} (Kesesuaian Faktual dengan Rencana dan Gambar Teknis)`, choices: [{ label: 'Sesuai', value: 1 }, { label: 'Tidak Sesuai', value: -2 }] });
            });
            return questions;
        }

        // Initialize
        $(document).ready(function() {
            if (existingAnswers && typeof existingAnswers === 'object' && !Array.isArray(existingAnswers)) {
                window.answers = existingAnswers;
            }
            console.log('Initialized answers:', window.answers);
            renderSections();
            updateProgress();
        });

        function renderSections() {
            const container = $('#sectionsContainer');
            container.empty();

            initialListSection.forEach((section, sIdx) => {
                // Use caption as the key (same as React Native)
                const sectionHtml = createSectionHTML(section, section.caption, sIdx);
                container.append(sectionHtml);
            });
        }

        function createSectionHTML(section, sectionCaption, sIdx) {
            const sectionId = `section_${sIdx}`;
            let html = `
                <div class="section-card">
                    <div class="section-header" onclick="toggleSection('${sectionId}')">
                        <div class="icon" id="icon_${sectionId}">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <h6>${section.caption}</h6>
                        <i class="fas fa-chevron-down chevron" id="chevron_${sectionId}"></i>
                    </div>
                    <div class="section-body" id="body_${sectionId}">
            `;

            if (section.questioner) {
                // Pass caption for key generation
                html += renderQuestions(section.questioner, sectionCaption);
            }

            if (section.child) {
                section.child.forEach((child, cIdx) => {
                    html += renderChildSection(child, child.caption, `${sectionId}_${cIdx}`);
                });
            }

            html += `</div></div>`;
            return html;
        }

        function renderChildSection(child, childCaption, childHtmlId) {
            let html = `
                <div class="subsection-card">
                    <div class="subsection-header" onclick="toggleSubsection('${childHtmlId}')">
                        <i class="fas fa-chevron-right mr-2" id="chevron_${childHtmlId}" style="font-size: 10px;"></i>
                        ${child.caption}
                    </div>
                    <div class="subsection-body" id="body_${childHtmlId}">
            `;

            if (child.questioner) {
                html += renderQuestions(child.questioner, childCaption);
            }

            if (child.child) {
                child.child.forEach((subChild, scIdx) => {
                    // Pass subChild caption for nested children
                    html += renderChildSection(subChild, subChild.caption, `${childHtmlId}_${scIdx}`);
                });
            }

            html += `</div></div>`;
            return html;
        }

        // Format key: "caption__index" with value object {"value": x}
        function renderQuestions(questioner, caption) {
            let html = '';
            questioner.forEach((q, qIdx) => {
                // Key format same as React Native: "caption__index"
                const qId = `${caption}__${qIdx}`;
                const existingAnswer = window.answers[qId];
                const existingValue = existingAnswer ? existingAnswer.value : undefined;

                if (q.type === 'choice') {
                    html += `
                        <div class="question-item">
                            <div class="question-text">${q.question}</div>
                            <div class="choices-group">
                    `;
                    q.choices.forEach((choice) => {
                        const isSelected = existingValue === choice.value;
                        const selectedClass = isSelected ? (choice.value < 0 ? 'selected-negative' : 'selected') : '';
                        html += `
                            <button type="button" class="choice-btn ${selectedClass}" 
                                    onclick="selectChoice('${qId}', ${choice.value}, this)">
                                ${choice.label}
                            </button>
                        `;
                    });
                    html += `</div></div>`;
                } else if (q.type === 'field') {
                    html += `
                        <div class="question-item">
                            <div class="question-text">${q.question}</div>
                            <input type="text" class="field-input" 
                                   placeholder="Masukkan keterangan..."
                                   value="${existingValue || ''}"
                                   onchange="setFieldValue('${qId}', this.value)">
                        </div>
                    `;
                }
            });
            return html;
        }

        function toggleSection(sectionId) {
            const body = $(`#body_${sectionId}`);
            const header = body.prev('.section-header');
            
            body.toggleClass('show');
            header.toggleClass('expanded');
        }

        function toggleSubsection(sectionId) {
            const body = $(`#body_${sectionId}`);
            const chevron = $(`#chevron_${sectionId}`);
            
            body.toggleClass('show');
            chevron.toggleClass('fa-chevron-right fa-chevron-down');
        }

        // Store answer with value object format: {"value": x}
        function selectChoice(qId, value, btn) {
            console.log('selectChoice called:', qId, value);
            window.answers[qId] = { value: value };
            console.log('Current answers:', window.answers);
            
            // Update UI
            $(btn).siblings().removeClass('selected selected-negative');
            $(btn).addClass(value < 0 ? 'selected-negative' : 'selected');
            
            updateProgress();
        }

        function setFieldValue(qId, value) {
            console.log('setFieldValue called:', qId, value);
            if (value.trim()) {
                window.answers[qId] = { value: value.trim() };
            } else {
                delete window.answers[qId];
            }
            console.log('Current answers:', window.answers);
            updateProgress();
        }

        function updateProgress() {
            // Count total choice questions and answered
            let totalChoices = 0;
            let answeredChoices = 0;

            function countQuestions(questioner, caption) {
                questioner.forEach((q, qIdx) => {
                    if (q.type === 'choice') {
                        totalChoices++;
                        const qId = `${caption}__${qIdx}`;
                        if (window.answers[qId] !== undefined) {
                            answeredChoices++;
                        }
                    }
                });
            }

            function processSection(section) {
                if (section.questioner) {
                    countQuestions(section.questioner, section.caption);
                }
                if (section.child) {
                    section.child.forEach((child) => {
                        processSection(child);
                    });
                }
            }

            initialListSection.forEach((section) => {
                processSection(section);
            });

            const progress = totalChoices > 0 ? Math.round((answeredChoices / totalChoices) * 100) : 0;
            $('#progressBar').css('width', `${progress}%`);
            $('#progressText').text(`${answeredChoices} / ${totalChoices} terjawab`);
        }

        async function saveAnswers() {
            console.log('Saving answers:', window.answers);
            console.log('Answers count:', Object.keys(window.answers).length);
            
            if (Object.keys(window.answers).length === 0) {
                alert('Belum ada jawaban yang diisi!');
                return;
            }
            
            $('#loadingOverlay').removeClass('hidden');

            try {
                // Send both answers and questions (same as React Native)
                const payload = { 
                    answers: window.answers,
                    questions: initialListSection
                };
                console.log('Payload:', JSON.stringify(payload));
                
                const response = await fetch(`/ciptakarya/petugas/tugas/${pengajuanId}/save-answers`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();
                console.log('Response:', result);

                if (result.status) {
                    alert('Jawaban berhasil disimpan!');
                    window.location.href = `/ciptakarya/petugas/tugas/${pengajuanId}`;
                } else {
                    throw new Error(result.message || 'Gagal menyimpan');
                }
            } catch (error) {
                console.error('Save error:', error);
                alert('Gagal menyimpan jawaban: ' + error.message);
            } finally {
                $('#loadingOverlay').addClass('hidden');
            }
        }

        function confirmBack() {
            if (Object.keys(window.answers).length > 0) {
                if (confirm('Yakin ingin kembali? Perubahan yang belum disimpan akan hilang.')) {
                    window.history.back();
                }
            } else {
                window.history.back();
            }
        }
    </script>
</body>
</html>
