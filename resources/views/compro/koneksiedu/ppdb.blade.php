{{-- resources/views/ppdb_revamp.blade.php --}}
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB SD Muhammadiyah 2 Pontianak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <style>
      body {
        background-color: #f5f7f8;
        font-family: "Poppins", sans-serif;
      }
      .card {
        border-radius: 1rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      }
      .form-section-title {
        background-color: #286D6B;
        color: white;
        padding: .75rem 1rem;
        border-radius: .5rem .5rem 0 0;
        font-weight: 600;
        font-size: 1rem;
      }
      .btn-submit {
        background-color: #286D6B;
        color: white;
        font-weight: 600;
      }
      .btn-submit:hover {
        background-color: #1f5755;
      }
      .required::after {
        content: "*";
        color: red;
        margin-left: 4px;
      }
      .ppdb-header {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        gap: 20px;
      }
      .ppdb-header img {
        width: 80px;
        height: auto;
      }
      .ppdb-header h5 {
        font-weight: 700;
        color: #000;
        text-transform: uppercase;
        margin: 0;
        line-height: 1.4;
      }
      #popupPembayaranPPDB .modal-content {
        background: #fafafa;
        border-radius: 1.25rem;
      }

      #popupPembayaranPPDB h4 {
        letter-spacing: 0.5px;
      }

      #popupPembayaranPPDB .text-uppercase {
        font-size: 0.9rem;
        letter-spacing: 1px;
      }

      #popupPembayaranPPDB .letter-spacing-1 {
        letter-spacing: 0.05em;
      }

      #popupPembayaranPPDB .border-start {
        border-color: #dc3545 !important; /* merah Bootstrap */
      }

      #popupPembayaranPPDB .btn-success {
        background: linear-gradient(135deg, #28a745, #218838);
        border: none;
        transition: all 0.2s ease-in-out;
      }

      #popupPembayaranPPDB .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      }

      #popupPembayaranPPDB .bg-light {
        background-color: #f9f9f9 !important;
      }

      #popupPembayaranPPDB .shadow-sm {
        box-shadow: 0 2px 6px rgba(0,0,0,0.08) !important;
      }

      #popupUploadBukti .modal-content,
      #popupMenungguValidasi .modal-content {
        background-color: #fafafa;
        border-radius: 1.25rem;
      }

      #popupMenungguValidasi img {
        filter: drop-shadow(0 4px 10px rgba(0,0,0,0.1));
      }

      #popupMenungguValidasi h5 {
        line-height: 1.5;
      }

      #popupMenungguValidasi .btn-secondary {
        background-color: #e5e5e5;
        border: none;
        color: #555;
        font-weight: 600;
      }

      #popupUploadBukti input[type="file"] {
        background-color: #fff;
      }

    </style>
  </head>
  <body>

    <div class="container py-5">

      <div class="ppdb-header mb-4">
        <img src="/img/svg/sdm2_logo.svg" alt="Logo SD Muhammadiyah 2 Pontianak">
        <h5>
          PENERIMAAN PESERTA DIDIK BARU<br>
          SD MUHAMMADIYAH 2 PONTIANAK<br>
          TAHUN AJARAN 2026/2026
        </h5>
      </div>

      <!-- Modal Pembayaran PPDB -->
      <div class="modal fade" id="popupPembayaranPPDB" tabindex="-1" aria-labelledby="popupPembayaranLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-5">

              <h4 class="fw-bold text-dark mb-3">PEMBAYARAN FORMULIR PENDAFTARAN</h4>

              <p class="text-muted mb-4">
                Penerimaan Peserta Didik Baru (PPDB) <b>SD Muhammadiyah 2 Pontianak</b>,<br>
                Tahun Ajaran <span id="tahun-ajaran">{{$tahun_ajaran}}</span> sebesar 
                <b id="nominal-pembayaran" class="text-dark">Rp {{ number_format($jumlah_tagihan,0,',','.') }},-</b>
              </p>

              <!-- Tombol Lihat Kwitansi -->
              <a
                href="#"
                target="_blank"
                class="btn btn-outline-primary px-4 rounded-pill mb-3 btnLihatKwitansi"
              >
                <i class="bi bi-receipt-cutoff me-2"></i> Lihat Kwitansi Pembayaran
              </a>

              <div class="bg-light rounded-4 py-3 px-4 mb-4 shadow-sm border-start border-4 border-danger">
                <p class="text-danger fw-semibold mb-1 fs-6 text-uppercase letter-spacing-1">
                  Batas Pembayaran Terakhir
                </p>

                <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">
                  <div class="bg-white shadow-sm rounded-pill px-4 py-2">
                    <span class="text-dark fw-semibold">
                      Sisa waktu: <span id="countdown-value" class="text-danger fw-bold">00:00:00</span>
                    </span>
                  </div>
                </div>

                <p class="fw-bold text-danger fs-5 mt-3 mb-0">
                  <span id="hari-batas">-</span>,
                  <span id="tanggal-batas">00/00/0000</span> &nbsp;
                  Waktu: <span id="waktu-batas">00:00</span> WIB
                </p>
              </div>

              <div class="bg-white border rounded-4 p-4 shadow-sm mb-4">
                <p class="mb-2 fw-semibold text-secondary">Nomor Kode Bayar / Rekening ({{$nama_bank}})</p>
                <h2 class="fw-bold text-dark mb-3" id="kode-bayar">{{ $no_rek }}</h2>
                <p class="small text-muted mb-0">
                  Pembayaran dilakukan ke bank ABC dengan kode akhir nominal <b class="text-dark" id="kode_unik">0</b>.<br>
                  Contoh transfer: <b id="contoh-transfer" class="text-dark">Rp 0,-</b>
                </p>
              </div>

              <p class="text-muted mb-4">
                Silakan upload bukti pembayaran formulir pendaftaran anda di bawah ini.
              </p>

              <div class="border rounded-4 p-4 bg-light mb-3 text-center">
                <input type="file" id="buktiPembayaranFile" class="form-control mb-3" accept="image/*,application/pdf">
                
                <!-- Indikator upload -->
                <div id="loader-bukti" style="display: none;">
                  <div class="spinner-border text-success" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                  <span class="ms-2 fw-semibold text-success">Sedang mengupload bukti pembayaran...</span>
                </div>

                <!-- Preview -->
                <div class="mt-3" id="preview-bukti-container" style="display: none;">
                  <p class="fw-semibold text-dark mb-2">Preview Bukti Pembayaran:</p>
                  <img id="preview-bukti" class="img-thumbnail" style="max-width: 250px; border-radius: 8px;">
                  <div id="upload-success" class="text-success mt-2 fw-semibold d-none">✅ Bukti pembayaran berhasil diupload</div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- Modal 2: Menunggu Validasi -->
      <div class="modal fade" id="popupMenungguValidasi" tabindex="-1" aria-labelledby="popupMenungguValidasiLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center p-5">
              <h5 class="fw-bold mb-3">
                Penerimaan Peserta Didik Baru (PPDB)<br>
                SD Muhammadiyah 2 Pontianak, Tahun Ajaran <span id="tahunAjaranValidasi">{{ $tahun_ajaran }}</span>
              </h5>

              <p class="text-danger fw-semibold mb-4">
                Mohon menunggu proses admin memvalidasi pembayaran anda.
              </p>

              <a
                href="#"
                target="_blank"
                class="btn btn-outline-primary px-4 rounded-pill mb-3 btnLihatKwitansi"
              >
                <i class="bi bi-receipt-cutoff me-2"></i> Lihat Kwitansi Pembayaran
              </a>

              <div class="row">
                <div class="col-md-12">
                  <img src="/img/svg/sdm2_logo.svg" alt="Logo SD Muhammadiyah 2" width="180" class="mb-4">
                </div>
                <div class="col-md-12">
                  <button type="button" class="btn btn-secondary btn-lg w-50 rounded-pill py-2">
                    Cetak Kartu Nomor Test Siswa
                  </button>
                </div>
              </div>



              <p class="mt-3 text-muted fst-italic small">
                Anda dapat menekan tombol cetak kartu test siswa saat proses validasi pembayaran berhasil.
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="card mx-auto" style="max-width: 720px;">
        <div class="card-body p-4">

          <h5 class="text-center fw-bold mb-4 text-success">Data Calon Siswa</h5>

          <form onsubmit="submitPPDB(event)">
            {{-- Nama --}}
            <div class="mb-3">
              <label for="nama-lengkap" class="form-label required">Nama Lengkap</label>
              <input name="nama" type="text" id="nama-lengkap" class="form-control" placeholder="Nama Lengkap" required>
            </div>

            {{-- Jenis Kelamin --}}
            <div class="mb-3">
              <label class="form-label required">Jenis Kelamin</label>
              <select name="jenis-kelamin" id="jenis-kelamin" class="form-select" required>
                <option value="">Pilih jenis kelamin</option>
                <option value="Laki-Laki">Laki-Laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>

            {{-- Tempat dan Tanggal Lahir --}}
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="tempat-lahir" class="form-label required">Tempat Lahir</label>
                <input name="tempat-lahir" type="text" id="tempat-lahir" class="form-control" placeholder="Tempat Lahir" required>
              </div>
              <div class="col-md-6">
                <label class="form-label required">Tanggal Lahir</label>
                <div class="d-flex gap-2">
                  <select id="tanggal-lahir-day" class="form-select" style="width:100px;">
                    <option value="">Tgl</option>
                  </select>

                  <select id="tanggal-lahir-month" class="form-select" style="width:140px;">
                    <option value="">Bulan</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">Nopember</option>
                    <option value="12">Desember</option>
                  </select>

                  <select id="tanggal-lahir-year" class="form-select" style="width:140px;">
                    <option value="">Tahun</option>
                  </select>
                </div>

                <!-- Hidden input untuk menjaga kompatibilitas dengan script lama -->
                <input type="hidden" id="tanggal-lahir" name="tanggal-lahir" />
              </div>
            </div>

            {{-- Agama --}}
            <div class="mb-3">
              <label for="agama" class="form-label required">Agama</label>
              <select id="agama" class="form-select" required>
                <option value="Islam">Islam</option>
                <option value="Kristen">Kristen</option>
                <option value="Hindu">Hindu</option>
                <option value="Buddha">Buddha</option>
                <option value="Konghucu">Konghucu</option>
              </select>
            </div>

            {{-- Alamat --}}
            <div class="mb-3">
              <label for="alamat" class="form-label required">Alamat Lengkap</label>
              <textarea id="alamat" rows="2" class="form-control" 
              {{-- placeholder="Jl. Ahmad Yani No. 01, Kota Pontianak"  --}}
              required></textarea>
            </div>

            {{-- No HP --}}
            <div class="mb-3">
              <label for="telpon-hape" class="form-label required">No. HP / WhatsApp</label>
              <input type="text" id="telpon-hape" class="form-control" 
              {{-- placeholder="081122334455"  --}}
              required>
            </div>

            {{-- Upload Berkas --}}
            <h6 class="form-section-title mt-4">Upload Berkas Pendukung</h6>
            <div class="p-3 border rounded-bottom bg-light mb-4">

              {{-- KK --}}
              <div class="mb-4">
                <label class="form-label fw-semibold">Scan / Foto Kartu Keluarga (KK)</label>
                <input type="file" id="kartu-keluarga" class="form-control" accept=".jpeg, .jpg, .png">
                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG — Maksimal 500KB</small>

                <div class="mt-3 text-center" id="loader-kartu-keluarga" style="display: none;">
                  <div class="spinner-border text-success" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                  <span class="ms-2">Sedang memproses dan mengupload...</span>
                </div>

                <div class="mt-3 text-center">
                  <img id="preview-kartu-keluarga" class="img-thumbnail d-none" style="max-width: 200px; border-radius: 8px;">
                  <div id="success-kartu-keluarga" class="text-success fw-semibold mt-2 d-none">✅ Berhasil diupload</div>
                </div>
              </div>

              {{-- Akta Lahir --}}
              <div class="mb-4">
                <label class="form-label fw-semibold">Scan / Foto Akta Lahir Calon Siswa</label>
                <input type="file" id="akta-lahir" class="form-control" accept=".jpeg, .jpg, .png">
                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG — Maksimal 500KB</small>

                <div class="mt-3 text-center" id="loader-akta-lahir" style="display: none;">
                  <div class="spinner-border text-success" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                  <span class="ms-2">Sedang memproses dan mengupload...</span>
                </div>

                <div class="mt-3 text-center">
                  <img id="preview-akta-lahir" class="img-thumbnail d-none" style="max-width: 200px; border-radius: 8px;">
                  <div id="success-akta-lahir" class="text-success fw-semibold mt-2 d-none">✅ Berhasil diupload</div>
                </div>
              </div>

              {{-- KIA --}}
              <div class="mb-4">
                <label class="form-label fw-semibold">
                  Scan / Foto Kartu Identitas Anak (KIA)
                  <span class="text-muted">(opsional)</span>
                </label>
                <input type="file" id="kartu-anak" class="form-control" accept=".jpeg, .jpg, .png">
                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG — Maksimal 500KB</small>

                <div class="mt-3 text-center" id="loader-kartu-anak" style="display: none;">
                  <div class="spinner-border text-success" role="status" style="width: 1.5rem; height: 1.5rem;"></div>
                  <span class="ms-2">Sedang memproses dan mengupload...</span>
                </div>

                <div class="mt-3 text-center">
                  <img id="preview-kartu-anak" class="img-thumbnail d-none" style="max-width: 200px; border-radius: 8px;">
                  <div id="success-kartu-anak" class="text-success fw-semibold mt-2 d-none">✅ Berhasil diupload</div>
                </div>
              </div>

            </div>


            {{-- Persetujuan --}}
            <h6 class="form-section-title">Pernyataan dan Persetujuan</h6>
            <div class="p-3 border rounded-bottom bg-light mb-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="check-identitas">
                <label class="form-check-label" for="check-identitas">
                  Identitas anak di atas adalah benar.
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="check-usia">
                <label class="form-check-label" for="check-usia">
                  Usia anak tidak kurang dari usia yang dipersyaratkan (minimal 5 tahun 6 bulan).
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="check-tanggungjawab">
                <label class="form-check-label" for="check-tanggungjawab">
                  Saya menyetujui bahwa segala kesalahan penginputan data menjadi tanggung jawab saya pribadi, dan pihak sekolah berhak mengambil tindakan sesuai kebijakan.
                </label>
              </div>
            </div>

            <div class="d-grid">
              <button id="button-submit" type="submit" class="btn btn-submit py-2">
                <i class="bi bi-upload"></i> Upload dan Kirim Pendaftaran
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>

      const HitungTglLahir = (tgl_lahir) => {
        if (!tgl_lahir) return '-';

        const birthDate = moment(tgl_lahir, 'YYYY-MM-DD');
        const currentDate = moment("{{$tgl_penerimaan}}", 'YYYY-MM-DD');

        // Hitung selisih tahun dan bulan
        const years = currentDate.diff(birthDate, 'years');
        const months = currentDate.diff(birthDate.add(years, 'years'), 'months');

        // Total bulan usia
        const totalMonths = (years * 12) + months;

        return totalMonths;
      };

      (function(){

        const minYears = {{$min_tahun}};
        const minMonths = {{$min_bulan}};

        const $day = $("#tanggal-lahir-day");
        const $month = $("#tanggal-lahir-month");
        const $year = $("#tanggal-lahir-year");
        const $hidden = $("#tanggal-lahir");

        // Isi hari (1..31)
        function populateDays(maxDay = 31) {
          $day.empty();
          $day.append('<option value="">Tgl</option>');
          for (let d = 1; d <= maxDay; d++) {
            const dv = d < 10 ? '0' + d : '' + d;
            $day.append(`<option value="${dv}">${d}</option>`);
          }
        }

        // Isi tahun: dari currentYear ke (currentYear - 20)
        function populateYears() {
          const now = moment();
          const currentYear = now.year();

          // Batas maksimum tahun lahir (harus <= tanggal yang memenuhi syarat)
          const maxAllowed = moment().subtract(minYears, 'years').subtract(minMonths, 'months');
          const maxAllowedYear = maxAllowed.year();

          const minYear = currentYear - 20;
          $year.empty();
          $year.append('<option value="">Tahun</option>');
          for (let y = currentYear; y >= minYear; y--) {
            if (y > maxAllowedYear) {
              $year.append(`<option value="${y}" disabled>${y} (terlalu muda)</option>`);
            } else {
              $year.append(`<option value="${y}">${y}</option>`);
            }
          }
        }

        // Sesuaikan jumlah hari
        function adjustDays() {
          const m = $month.val();
          const y = $year.val();
          if (!m) {
            populateDays(31);
            return;
          }
          const yy = y ? parseInt(y,10) : 2000;
          const daysInMonth = moment(`${yy}-${m}`, 'YYYY-MM').daysInMonth();
          const prevVal = $day.val();
          populateDays(daysInMonth);
          if (prevVal && parseInt(prevVal,10) <= daysInMonth) {
            $day.val(prevVal);
          }
        }

        // Gabungkan dan isi hidden field
        function syncHiddenAndValidate() {
          const d = $day.val();
          const m = $month.val();
          const y = $year.val();
          if (!d || !m || !y) {
            $hidden.val('');
            $hidden.trigger('change');
            return;
          }
          const iso = `${y}-${m}-${d}`;
          $hidden.val(iso);
          $hidden.trigger('change');
        }

        // Deteksi perubahan dan beri peringatan umur
        $hidden.on('change', function(){
          const val = $(this).val();
          if(!val) return;

          const totalMonths = HitungTglLahir(val);

          // Hitung batas minimum (misal 5 tahun 6 bulan = 66 bulan)
          const minMonthsTotal = (minYears * 12) + minMonths;

          if (typeof totalMonths === 'number' && totalMonths < minMonthsTotal) {
            Swal.fire({
              title: 'Info',
              text: 'Umur kurang dari 5 Tahun 6 Bulan',
              icon: 'info',
              background: '#fef2c0',
              confirmButtonColor: '#3085d6',
            });
          }
        });


        // Event listeners
        $day.on('change', syncHiddenAndValidate);
        $month.on('change', function(){ adjustDays(); syncHiddenAndValidate(); });
        $year.on('change', function(){ adjustDays(); syncHiddenAndValidate(); });

        // Init saat load
        $(document).ready(function(){
          populateDays();
          populateYears();
          const existing = $hidden.val();
          if (existing) {
            const m = moment(existing, 'YYYY-MM-DD');
            if (m.isValid()) {
              $year.val(m.format('YYYY'));
              $month.val(m.format('MM'));
              adjustDays();
              $day.val(m.format('DD'));
            }
          }
        });
      })();

      const baseURL = window.location.origin;
      const linkBerkasPPDB = {
        link_kartu_keluarga: "",
        link_akta_lahir: "",
        link_kartu_anak: ""
      };

      // 🚀 Fungsi utama untuk handle kompresi dan upload
      async function handleFileInput(event, previewId) {
        const file = event.target.files[0];
        if (!file) return;

        const previewElement = document.getElementById(`preview-${previewId}`);
        const loader = document.getElementById(`loader-${previewId}`);
        const success = document.getElementById(`success-${previewId}`);

        // Reset state
        loader.style.display = "block";
        success.classList.add("d-none");
        previewElement.classList.add("d-none");

        try {
          // Validasi ekstensi
          if (!file.type.startsWith("image/")) {
            loader.style.display = "none";
            Swal.fire("Format Tidak Valid", "Hanya file gambar (jpg, jpeg, png) yang diperbolehkan.", "error");
            return;
          }

          // 🔧 Opsi kompresi
          const options = {
            maxSizeMB: 0.45,         // target 450KB
            maxWidthOrHeight: 1280,  // resize kalau besar
            useWebWorker: true,
          };

          // Kompres file
          const compressedBlob = await imageCompression(file, options);
          const compressedFile = new File([compressedBlob], file.name, { type: file.type });

          console.log(
            `Asli: ${(file.size / 1024).toFixed(1)}KB → Kompres: ${(compressedFile.size / 1024).toFixed(1)}KB`
          );

          // Validasi ukuran setelah kompres
          if (compressedFile.size > 524288) {
            loader.style.display = "none";
            Swal.fire("File Terlalu Besar", "Setelah kompres masih > 500KB. Gunakan gambar lain.", "error");
            return;
          }

          // Upload file yang sudah dikonversi ulang ke File (bukan Blob)
          await uploadFileToServer(compressedFile, previewId, previewElement, loader, success);

        } catch (err) {
          loader.style.display = "none";
          console.error("Error Kompresi:", err);
          Swal.fire("Error", "Terjadi kesalahan saat mengompres file.", "error");
        }
      }

      // 🚀 Fungsi Upload ke Server + Preview + Status
      async function uploadFileToServer(file, previewId, previewElement, loader, success) {
        const formData = new FormData();
        formData.append("file_data", file);

        try {
          const response = await axios.post(`${baseURL}/api/sekolah_sd/upload`, formData, {
            headers: { "Content-Type": "multipart/form-data" },
            onUploadProgress: function(progressEvent) {
              const percent = Math.round((progressEvent.loaded / progressEvent.total) * 100);
              loader.querySelector("span").innerText = `Mengupload... ${percent}%`;
            }
          });

          if (response.data.status) {
            loader.style.display = "none";

            // Tampilkan preview
            const url = URL.createObjectURL(file);
            previewElement.src = url;
            previewElement.classList.remove("d-none");

            // Tampilkan sukses
            success.classList.remove("d-none");
            setTimeout(() => success.classList.add("d-none"), 3000);

            // Simpan ke object global
            const data = response.data.data;
            switch (previewId) {
              case "kartu-keluarga":
                linkBerkasPPDB.link_kartu_keluarga = data;
                break;
              case "akta-lahir":
                linkBerkasPPDB.link_akta_lahir = data;
                break;
              case "kartu-anak":
                linkBerkasPPDB.link_kartu_anak = data;
                break;
            }
          } else {
            loader.style.display = "none";
            Swal.fire("Gagal", response.data.message || "Upload gagal.", "error");
          }
        } catch (error) {
          loader.style.display = "none";
          console.error(error);
          Swal.fire({
            title: "Error Upload",
            text: error.response?.data?.message || error.message,
            icon: "error"
          });
        }
      }

      // 🎧 Event listener untuk tiap input
      document.getElementById("kartu-keluarga").addEventListener("change", (e) => handleFileInput(e, "kartu-keluarga"));
      document.getElementById("akta-lahir").addEventListener("change", (e) => handleFileInput(e, "akta-lahir"));
      document.getElementById("kartu-anak").addEventListener("change", (e) => handleFileInput(e, "kartu-anak"));

      async function submitPPDB(event) {
        event.preventDefault();

        try {
          // Ambil semua input dari form
          const formData = new FormData(event.target);
          const payload = Object.fromEntries(formData.entries());

          // Tambahkan link file hasil upload
          payload.link_kartu_keluarga = linkBerkasPPDB.link_kartu_keluarga;
          payload.link_akta_lahir = linkBerkasPPDB.link_akta_lahir;
          payload.link_kartu_anak = linkBerkasPPDB.link_kartu_anak;
          payload.link_kartu_anak = linkBerkasPPDB.link_kartu_anak;
          payload.bank_pembayaran = {
            nama_bank:"{{$nama_bank}}",
            no_rek:"{{$no_rek}}",
            atas_nama:"{{$atas_nama}}"
          }

          // Jika ada field kosong yang wajib
          if (!payload.nama) {
            Swal.fire("Peringatan", "Nama Lengkap wajib diisi!", "warning");
            return;
          }

          // ✅ Validasi file wajib (Kartu Keluarga & Akta Lahir)
          if (!payload.link_kartu_keluarga) {
            Swal.fire({
              title: "Peringatan",
              text: "Berkas Kartu Keluarga wajib diunggah!",
              icon: "warning",
              background: "#fff3cd",
              confirmButtonColor: "#3085d6",
            });
            return;
          }

          if (!payload.link_akta_lahir) {
            Swal.fire({
              title: "Peringatan",
              text: "Berkas Akta Lahir wajib diunggah!",
              icon: "warning",
              background: "#fff3cd",
              confirmButtonColor: "#3085d6",
            });
            return;
          }

          // ✅ Validasi checkbox pernyataan (tanpa hitung umur)
          const checkIdentitas = document.getElementById("check-identitas").checked;
          const checkUsia = document.getElementById("check-usia").checked;
          const checkTanggungjawab = document.getElementById("check-tanggungjawab").checked;

          if (!checkIdentitas || !checkUsia || !checkTanggungjawab) {
            Swal.fire({
              title: "Validasi Gagal",
              text: "Harap centang semua pernyataan dan persetujuan terlebih dahulu sebelum melanjutkan.",
              icon: "warning",
              background: "#fff3cd",
              confirmButtonColor: "#3085d6",
            });
            return;
          }

          // Kirim ke server
          const res = await axios.post(`${baseURL}/api/sekolah_sd/ppdb/store`, payload);

          if (res.data.status) {


            showPopupPembayaran({
              kode_bayar: res.data.data.kode_bayar,
              biaya_dasar: res.data.data.biaya_dasar,
              nominal: res.data.data.total_bayar,
              kodeAkhir: res.data.data.kode_unik,
            });

          } else {
            Swal.fire("Gagal", res.data.message || "Terjadi kesalahan saat menyimpan.", "error");
          }

        } catch (err) {
          console.error(err);
          Swal.fire("Error", err.response?.data?.message || err.message, "error");
        }
      }

      // Mapping hari agar "Sunday" jadi "Ahad"
      const hariMap = {
        Sunday: "Ahad",
        Monday: "Senin",
        Tuesday: "Selasa",
        Wednesday: "Rabu",
        Thursday: "Kamis",
        Friday: "Jumat",
        Saturday: "Sabtu"
      };

      let modal;

      function showPopupPembayaran({ 
        kode_bayar = "",
        biaya_dasar = 350000,
        nominal = 350000,
        kodeAkhir = 0,
      }) {
        // Hitung batas waktu pembayaran (1 jam dari sekarang)
        const deadline = moment().add(1, 'hours');

        const hariEnglish = deadline.format('dddd');
        const hari = hariMap[hariEnglish] || hariEnglish;

        const tanggal = deadline.format('DD/MM/YYYY');
        const waktu = deadline.format('HH:mm');

        // Format nominal + contoh transfer
        const nominalStr = `Rp${biaya_dasar.toLocaleString('id-ID')},-`;
        const contohTransfer = `Rp${(nominal).toLocaleString('id-ID')}`;

        const url = `/kwitansi-ppdb-simuda?kode_bayar=${kode_bayar}`
        $(".btnLihatKwitansi").attr('href',url);

        // Isi data ke elemen
        document.getElementById("nominal-pembayaran").textContent = nominalStr;
        document.getElementById("hari-batas").textContent = hari;
        document.getElementById("tanggal-batas").textContent = tanggal;
        document.getElementById("waktu-batas").textContent = waktu;
        document.getElementById("contoh-transfer").textContent = contohTransfer;
        document.getElementById("kode_unik").textContent = kodeAkhir;

        // ✅ Countdown timer setup
        const countdownValue = document.getElementById("countdown-value");

        // Bersihkan timer lama kalau ada
        if (window.ppdbCountdownInterval) clearInterval(window.ppdbCountdownInterval);

        window.ppdbCountdownInterval = setInterval(() => {
          const now = moment();
          const diff = moment.duration(deadline.diff(now));

          if (diff.asMinutes() <= 10) {
            countdownValue.classList.add("text-danger");
          } else {
            countdownValue.classList.remove("text-danger");
          }


          if (diff.asSeconds() <= 0) {
            clearInterval(window.ppdbCountdownInterval);
            countdownValue.textContent = "00:00:00";
            countdownValue.classList.add("text-danger");
            Swal.fire({
              title: "Waktu Habis!",
              text: "Batas waktu pembayaran sudah berakhir. Silakan lakukan pendaftaran ulang.",
              icon: "warning",
              confirmButtonText: "Tutup",
            });
            return;
          }

          const hours = String(Math.floor(diff.asHours())).padStart(2, "0");
          const minutes = String(diff.minutes()).padStart(2, "0");
          const seconds = String(diff.seconds()).padStart(2, "0");
          countdownValue.textContent = `${hours}:${minutes}:${seconds}`;
        }, 1000);

        // ✅ Tampilkan modal dengan Bootstrap API
        const modalEl = document.getElementById("popupPembayaranPPDB");
        modal = new bootstrap.Modal(modalEl);
        modal.show();

      }

      if (typeof linkBerkasPPDB === "undefined") {
        window.linkBerkasPPDB = {};
      }

      const buktiFileInput = document.getElementById("buktiPembayaranFile");
      const loader = document.getElementById("loader-bukti");
      const previewContainer = document.getElementById("preview-bukti-container");
      const previewImage = document.getElementById("preview-bukti");
      const uploadSuccess = document.getElementById("upload-success");

      // ✅ Event utama: otomatis upload saat file diganti
      buktiFileInput.addEventListener("change", async (event) => {
        const file = event.target.files[0];
        if (!file) return;

        loader.style.display = "block";
        uploadSuccess.classList.add("d-none");
        previewContainer.style.display = "none";

        try {
          let uploadFile = file;

          // Kompres gambar jika formatnya image/*
          if (file.type.startsWith("image/")) {
            const options = {
              maxSizeMB: 0.45,         // target 450KB
              maxWidthOrHeight: 1280,  // resize jika besar
              useWebWorker: true,
            };
            // uploadFile = await imageCompression(file, options);
            const compressedBlob = await imageCompression(file, options);
            uploadFile = new File([compressedBlob], file.name, { type: file.type });
            console.log(
              `Kompresi Bukti: ${(file.size / 1024).toFixed(1)}KB → ${(uploadFile.size / 1024).toFixed(1)}KB`
            );
          }

          // Validasi ukuran setelah kompres
          if (uploadFile.size > 524288) {
            loader.style.display = "none";
            Swal.fire("File Terlalu Besar", "Ukuran file melebihi 500KB setelah kompresi.", "error");
            return;
          }

          // Upload ke server
          const formData = new FormData();
          formData.append("file_data", uploadFile);

          const response = await axios.post(`${baseURL}/api/sekolah_sd/upload`, formData, {
            headers: { "Content-Type": "multipart/form-data" },
            onUploadProgress: (progressEvent) => {
              const percent = Math.round((progressEvent.loaded / progressEvent.total) * 100);
              loader.querySelector("span").innerText = `Mengupload... ${percent}%`;
            },
          });

          loader.style.display = "none";

          if (response.data.status) {
            const data = response.data.data;
            linkBerkasPPDB.link_pembayaran_ppdb = data;

            // Preview file
            if (file.type.startsWith("image/")) {
              previewImage.src = URL.createObjectURL(uploadFile);
              previewContainer.style.display = "block";
              previewImage.classList.remove("d-none");
            } else {
              previewContainer.innerHTML = `
                <div class="alert alert-success fw-semibold">
                  ✅ File bukti pembayaran (PDF) berhasil diupload
                </div>`;
              previewContainer.style.display = "block";
            }

            uploadSuccess.classList.remove("d-none");

            Swal.fire({
              title: "Upload Berhasil",
              text: "Bukti pembayaran berhasil diupload.",
              icon: "success",
              timer: 1500,
              showConfirmButton: false,
            });


          } else {
            Swal.fire("Gagal", response.data.message || "Upload gagal.", "error");
          }
        } catch (error) {
          loader.style.display = "none";
          btnUpload.disabled = false;
          btnUpload.innerHTML = `<i class="bi bi-upload me-2"></i> Upload Gagal`;
          console.error("Upload Error:", error);
          Swal.fire("Error", error.response?.data?.message || error.message, "error");
        }
      });
      

    </script>


  </body>
</html>
