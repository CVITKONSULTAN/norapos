<!DOCTYPE html>
<html lang="id" translate="no">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Platform pendidikan yang mempermudah administrasi, pengelolaan, dan komunikasi di lingkungan pendidikan."
    />
    <meta
      name="keywords"
      content="platform pendidikan, administrasi sekolah, KoneksiEdu, manajemen sekolah, pendidikan Indonesia"
    />
    <title>PPDB SD MUHAMMADIYAH 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Default background image for desktop */
      section.hero {
        background-image: url("/compro/koneksiedu/assets/images/herodesktop.png");
        background-size: cover;
        background-position: center;
      }
      .help-block{
        color: red;
      }
      /* Background image for mobile devices */
      @media (max-width: 768px) {
        section.hero {
          background-image: url("/compro/koneksiedu/assets/images/heromobile.png");
        }
      }
    </style>
  </head>
  <body>
    <!-- Header / Navigation -->
    <header>
      <nav class="sticky top-0 w-full z-20 bg-[#FAF8F4] shadow-md z-30">
        <div
          class="mx-auto px-4 md:px-10 py-4 md:py-5 flex justify-between items-center"
        >
          <a href="/">
            <img
              src="/compro/koneksiedu/assets/images/logo.png"
              class="w-40 md:w-48"
              alt="KoneksiEdu Logo"
            />
          </a>

          <!-- Desktop Menu -->
          <div
            class="hidden md:flex justify-between items-center gap-6 lg:gap-12"
          >
            <a
              href="/"
              class="text-gray-800 hover:text-[#286D6B] transition-colors"
              >Home</a
            >
            <a
              href="#"
              class="text-gray-800 hover:text-[#286D6B] transition-colors"
              >About Us</a
            >
            <a
              href="#"
              class="text-gray-800 hover:text-[#286D6B] transition-colors"
              >Contact</a
            >
            <a
              href="/login"
              class="text-white bg-[#286D6B] hover:opacity-80 transition-colors py-2 px-4 lg:px-8 rounded-md"
              >Login</a
            >
          </div>

          <!-- Mobile Menu Button -->
          <button id="burgerMenu" class="md:hidden text-[#286D6B] text-2xl">
            ☰
          </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <div
          id="mobileMenu"
          class="mobile-menu bg-[#FAF8F4] max-h-0 overflow-hidden"
        >
          <ul class="flex flex-col items-center space-y-4 py-6">
            <li>
              <a
                href="/"
                class="text-gray-800 hover:text-[#286D6B] transition-colors"
                >Home</a
              >
            </li>
            <li>
              <a
                href="#"
                class="text-gray-800 hover:text-[#286D6B] transition-colors"
                >About Us</a
              >
            </li>
            <li>
              <a
                href="#"
                class="text-gray-800 hover:text-[#286D6B] transition-colors"
                >Contact</a
              >
            </li>
            <li class="w-full px-4">
              <a
                href="/login"
                class="flex items-center justify-center text-white bg-[#286D6B] hover:opacity-80 transition-colors py-2 px-8 rounded-md"
                >Login</a
              >
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <main class="container mx-auto px-4 py-8">
      <h1 class="text-xl md:text-2xl font-bold text-center text-[#286D6B] mb-8">
        Formulir Registrasi Calon Peserta Didik Baru
      </h1>

      <div>
        <h2 class="text-xl font-bold text-[#286D6B] mb-4">
          Anak anda sudah terdaftar dan ingin print bukti pendaftaran? <a style="color: blue;" href="javascript:void(0)" onclick="popupCetakBukti()">Klik Disini</a>
        </h2>
      </div>

      <form
        onsubmit="submitPPDB(event)"
        class="bg-white p-6 rounded-lg shadow-md space-y-6"
      >
        <!-- Bagian A -->
        <div>
          <h2 class="text-xl font-bold text-[#286D6B] mb-4">
            A. Jenis Pendaftaran
          </h2>

          <div class="space-y-4">
            <div>
              <label for="jenis-pendaftaran" class="block font-medium"
                >Jenis Pendaftaran</label
              >
              <select
                id="jenis-pendaftaran"
                class="w-full border rounded-lg px-4 py-2"
                required
              >
                <option value="siswa-baru">Siswa Baru</option>
                <option value="mutasi">Mutasi</option>
              </select>
            </div>
            <div id="input-nama-asal-sekolah" class="invisible">
              <label for="nama-asal-sekolah" class="block font-medium"
                >Nama Asal Sekolah</label
              >
              <input
                type="text"
                id="nama-asal-sekolah"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Nama Asal Sekolah"
              />
            </div>
            <div id="input-npsn-asal-sekolah" class="invisible">
              <label for="npsn-asal-sekolah" class="block font-medium"
                >NPSN Asal Sekolah</label
              >
              <input
                type="text"
                id="npsn-asal-sekolah"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="NPSN Asal Sekolah"
              />
            </div>
          </div>
        </div>

        <!-- Bagian B -->
        <div>
          <h2 class="text-xl font-bold text-[#286D6B] mb-4">
            B. Identitas Calon Peserta Didik Baru
          </h2>

          <div class="space-y-4">
            <div>
              <label for="nama-lengkap" class="block font-medium"
                >Nama Lengkap</label
              >
              <input
                type="text"
                id="nama-lengkap"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Nama Lengkap"
                required
              />
            </div>

            <div>
              <label class="block font-medium">Jenis Kelamin</label>
              <div class="flex items-center space-x-4">
                <label class="flex items-center">
                  <input
                    type="radio"
                    name="jenis-kelamin"
                    value="Laki-Laki"
                    class="mr-2"
                    required
                  />
                  Laki-Laki
                </label>
                <label class="flex items-center">
                  <input
                    type="radio"
                    name="jenis-kelamin"
                    value="Perempuan"
                    class="mr-2"
                  />
                  Perempuan
                </label>
              </div>
            </div>

            <div id="input-nisn" class="invisible">
              <label for="nisn" name="nisn" class="block font-medium"
                >NISN</label
              >
              <input
                type="text"
                name="nisn"
                id="nisn"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="NISN"
              />
            </div>

            <div>
              <label for="nik" class="block font-medium">NIK</label>
              <input
                type="text"
                id="nik"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="NIK"
                required
              />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="tempat-lahir" class="block font-medium"
                  >Tempat Lahir</label
                >
                <input
                  type="text"
                  id="tempat-lahir"
                  class="w-full border rounded-lg px-4 py-2"
                  placeholder="Tempat Lahir"
                  required
                />
              </div>
              <div>
                <label for="tanggal-lahir" class="block font-medium"
                  >Tanggal Lahir</label
                >
                <input
                  type="date"
                  id="tanggal-lahir"
                  class="w-full border rounded-lg px-4 py-2"
                  required
                />
              </div>
            </div>

            <div>
              <label for="agama" class="block font-medium">Agama</label>
              <select
                id="agama"
                class="w-full border rounded-lg px-4 py-2"
                required
              >
                <option value="islam">Islam</option>
                <option value="kristen">Kristen</option>
                <option value="buddha">Buddha</option>
                <option value="hindu">Hindu</option>
                <option value="konghucu">Konghucu</option>
              </select>
            </div>

            <div>
              <label for="kebutuhan-khusus" class="block font-medium"
                >Berkebutuhan Khusus</label
              >
              <input
                type="text"
                id="kebutuhan-khusus"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Berkebutuhan Khusus"
                required
              />
            </div>

            <div>
              <label for="alamat" class="block font-medium">Alamat Rumah</label>
              <textarea
                id="alamat"
                class="w-full border rounded-lg px-4 py-2"
                rows="3"
                placeholder="Alamat Rumah"
                required
              ></textarea>
            </div>

            <div>
              <label for="dusun" class="block font-medium">Dusun</label>
              <input
                type="text"
                id="dusun"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Nama Dusun"
                required
              />
            </div>

            <div>
              <label for="kelurahan" class="block font-medium"
                >Kelurahan/Desa</label
              >
              <input
                type="text"
                id="kelurahan"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Nama Kelurahan/Desa"
                required
              />
            </div>

            <div>
              <label for="kecamatan" class="block font-medium">Kecamatan</label>
              <input
                type="text"
                id="kecamatan"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Nama Kecamatan"
                required
              />
            </div>

            <div>
              <label for="kabupaten" class="block font-medium"
                >Kabupaten/Kota</label
              >
              <input
                type="text"
                id="kabupaten"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Nama Kabupaten/Kota"
                required
              />
            </div>

            <div>
              <label for="provinsi" class="block font-medium">Provinsi</label>
              <input
                type="text"
                id="provinsi"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Nama Provinsi"
                required
              />
            </div>

            <div>
              <label for="transportasi" class="block font-medium"
                >Alat Transportasi ke Sekolah</label
              >
              <input
                type="text"
                id="transportasi"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Alat Transportasi ke Sekolah"
                required
              />
            </div>

            <div>
              <label for="jenis-tinggal" class="block font-medium"
                >Jenis Tinggal</label
              >
              <input
                type="text"
                id="jenis-tinggal"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Jenis Tinggal"
                required
              />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label for="telpon-rumah" class="block font-medium"
                  >No. Telp Rumah</label
                >
                <input
                  type="text"
                  id="telpon-rumah"
                  class="w-full border rounded-lg px-4 py-2"
                  placeholder="No. Telp Rumah"
                  required
                />
              </div>
              <div>
                <label for="telpon-hape" class="block font-medium"
                  >No. HP</label
                >
                <input
                  type="text"
                  id="telpon-hape"
                  class="w-full border rounded-lg px-4 py-2"
                  placeholder="No. HP"
                  required
                />
              </div>
            </div>

            <div>
              <label for="email-pribadi" class="block font-medium"
                >Email Pribadi</label
              >
              <input
                type="email"
                id="email-pribadi"
                class="w-full border rounded-lg px-4 py-2"
                placeholder="Email Pribadi"
                required
              />
            </div>

            <div>
              <label for="pas-foto" class="block font-medium">
                Pas Foto Siswa (Format: .jpeg, .jpg, .png)
              </label>
              <input
                type="file"
                id="pas-foto"
                class="w-full border rounded-lg px-4 py-2"
                accept=".jpeg, .jpg, .png"
                required
                onchange="validateAndCompressFile(this, 'pas-foto')"
              />
              <div id="pas-foto-loading" class="hidden">Loading...</div>
              <img
                id="pas-foto-preview"
                class="hidden w-32 mt-2"
                alt="Preview"
              />
            </div>
          </div>
        </div>

        <!-- Bagian C -->
        <div class="space-y-4">
          <h2 class="text-xl font-bold text-[#286D6B] mb-4">
            C. Data Orangtua/Wali
          </h2>
          <!-- Ayah -->
          <div>
            <label for="ayah-nama" class="block font-medium">Nama Ayah</label>
            <input
              placeholder="Nama Ayah"
              type="text"
              id="ayah-nama"
              class="w-full border rounded-lg px-4 py-2"
            />
          </div>
          <div>
            <label for="ayah-tahun-lahir" class="block font-medium"
              >Tahun Lahir Ayah:</label
            >
            <input
              placeholder="Tahun Lahir Ayah"
              type="text"
              name="ayah-tahun-lahir"
              id="ayah-tahun-lahir"
              class="w-full border rounded-lg px-4 py-2"
            />
          </div>
          <div>
            <label class="block font-medium">Pekerjaan Ayah:</label>
            <input
              placeholder="Pekerjaan Ayah"
              type="text"
              name="pekerjaan-ayah"
              id="pekerjaan-ayah"
              class="w-full border rounded-lg px-4 py-2"
            />
          </div>
          <div>
            <label for="pendidikan-ayah" class="block font-medium"
              >Pendidikan Ayah</label
            >
            <select
              placeholder="Pendidikan Ayah"
              id="pendidikan-ayah"
              class="w-full border rounded-lg px-4 py-2"
            >
              <option value="">Pilih Pendidikan</option>
              <option>S3</option>
              <option>S2</option>
              <option>D4/S1</option>
              <option>D3</option>
              <option>D2</option>
              <option>D1</option>
              <option>SMA Sederajat</option>
              <option>SMP Sederajat</option>
              <option>SD Sederajat</option>
              <option>Putus SD</option>
              <option>Tidak Sekolah</option>
            </select>
          </div>
          <div>
            <label for="kebutuhan-khusus-ayah" class="block font-medium"
              >Berkebutuhan Khusus</label
            >
            <input
              type="text"
              id="kebutuhan-khusus-ayah"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Berkebutuhan Khusus"
            />
          </div>
          <div>
            <label class="block font-medium">Penghasilan Bulanan Ayah</label>
            <input
              type="text"
              id="penghasilan-ayah"
              name="penghasilan-ayah"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Penghasilan Bulanan Ayah"
            />
          </div>
          <!-- Ibu -->
          <div>
            <label for="ibu-nama" class="block font-medium">Nama Ibu</label>
            <input
              type="text"
              id="ibu-nama"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Nama Ibu"
            />
          </div>
          <div>
            <label for="ibu-tahun-lahir" class="block font-medium"
              >Tahun Lahir Ibu:</label
            >
            <input
              type="text"
              name="ibu-tahun-lahir"
              id="ibu-tahun-lahir"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Tahun Lahir Ibu"
            />
          </div>
          <div>
            <label class="block font-medium">Pekerjaan Ibu:</label>
            <input
              type="text"
              name="pekerjaan-ibu"
              id="pekerjaan-ibu"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Pekerjaan Ibu"
            />
          </div>
          <div>
            <label for="pendidikan-ibu" class="block font-medium"
              >Pendidikan Ibu</label
            >
            <select
              id="pendidikan-ibu"
              class="w-full border rounded-lg px-4 py-2"
            >
              <option value="">Pilih Pendidikan</option>
              <option>S3</option>
              <option>S2</option>
              <option>D4/S1</option>
              <option>D3</option>
              <option>D2</option>
              <option>D1</option>
              <option>SMA Sederajat</option>
              <option>SMP Sederajat</option>
              <option>SD Sederajat</option>
              <option>Putus SD</option>
              <option>Tidak Sekolah</option>
            </select>
          </div>
          <div>
            <label for="kebutuhan-khusus-ibu" class="block font-medium"
              >Berkebutuhan Khusus</label
            >
            <input
              type="text"
              id="kebutuhan-khusus-ibu"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Berkebutuhan Khusus"
            />
          </div>
          <div>
            <label class="block font-medium">Penghasilan Bulanan Ibu</label>
            <input
              type="text"
              id="penghasilan-ibu"
              name="penghasilan-ibu"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Penghasilan Bulanan Ibu"
            />
          </div>
          <!-- Wali -->
          <div>
            <label for="wali-nama" class="block font-medium">Nama Wali</label>
            <input
              type="text"
              id="wali-nama"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Nama Wali"
            />
          </div>
          <div>
            <label for="wali-tahun-lahir" class="block font-medium"
              >Tahun Lahir Wali:</label
            >
            <input
              type="text"
              id="wali-tahun-lahir"
              name="wali-tahun-lahir"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Tahun Lahir Wali"
            />
          </div>
          <div>
            <label class="block font-medium">Pekerjaan Wali:</label>
            <input
              type="text"
              id="pekerjaan-wali"
              name="pekerjaan-wali"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Pekerjaan Wali"
            />
          </div>
          <div>
            <label for="pendidikan-wali" class="block font-medium"
              >Pendidikan Wali</label
            >
            <select
              id="pendidikan-wali"
              class="w-full border rounded-lg px-4 py-2"
            >
              <option value="">Pilih Pendidikan</option>
              <option>S3</option>
              <option>S2</option>
              <option>D4/S1</option>
              <option>D3</option>
              <option>D2</option>
              <option>D1</option>
              <option>SMA Sederajat</option>
              <option>SMP Sederajat</option>
              <option>SD Sederajat</option>
              <option>Putus SD</option>
              <option>Tidak Sekolah</option>
            </select>
          </div>
          <div>
            <label for="kebutuhan-khusus-wali" class="block font-medium"
              >Berkebutuhan Khusus</label
            >
            <input
              type="text"
              id="kebutuhan-khusus-wali"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Berkebutuhan Khusus"
            />
          </div>
          <div>
            <label class="block font-medium">Penghasilan Bulanan Wali</label>
            <input
              type="text"
              id="penghasilan-wali"
              name="penghasilan-wali"
              class="w-full border rounded-lg px-4 py-2"
              placeholder="Penghasilan Bulanan Wali"
            />
          </div>

          <!-- Bagian D -->
          <div>
            <h2 class="text-xl font-bold text-[#286D6B] mb-4">
              D. Data Periodik Calon Peserta Didik
            </h2>
            <div class="space-y-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label for="tinggi-badan" class="block font-medium"
                    >Tinggi Badan</label
                  >
                  <input
                    type="number"
                    id="tinggi-badan"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Tinggi Badan (cm)"
                    required
                  />
                </div>
                <div>
                  <label for="berat-bedan" class="block font-medium"
                    >Berat Badan</label
                  >
                  <input
                    type="number"
                    id="berat-badan"
                    class="w-full border rounded-lg px-4 py-2"
                    placeholder="Berat Badan (kg)"
                    required
                  />
                </div>
              </div>

              <div>
                <label for="jarak-ke-sekolah" class="block font-medium"
                  >Jarak Tempat Tinggal Ke Sekolah</label
                >
                <input
                  placeholder="Jarak Tempat Tinggal Ke Sekolah"
                  type="text"
                  id="jarak-ke-sekolah"
                  class="w-full border rounded-lg px-4 py-2"
                  required
                />
              </div>
              <div>
                <label for="waktu-ke-sekolah" class="block font-medium"
                  >Waktu Tempuh Berangkat Ke Sekolah</label
                >
                <input
                  placeholder="Waktu Tempuh Berangkat Ke Sekolah"
                  type="text"
                  id="waktu-ke-sekolah"
                  class="w-full border rounded-lg px-4 py-2"
                  required
                />
              </div>
              <div>
                <label for="prestasi-peserta" class="block font-medium"
                  >Prestasi Calon Peserta Didik</label
                >
                <textarea
                  id="prestasi"
                  class="w-full border rounded-lg px-4 py-2"
                  rows="3"
                  placeholder="Prestasi Calon Peserta Didik"
                ></textarea>
              </div>
            </div>
          </div>
          <!-- Bagian E -->
          <div>
            <h2 class="text-xl font-bold text-[#286D6B] mb-4">
              E. Berkas Persyaratan
            </h2>

            <div class="space-y-4">
              <div>
                <label for="bukti-pembayaran" class="block font-medium">
                  Bukti Pembayaran PPDB (Format: .jpeg, .jpg, .png)
                </label>
                <input
                  type="file"
                  id="bukti-pembayaran"
                  class="w-full border rounded-lg px-4 py-2"
                  accept=".jpeg, .jpg, .png"
                  required
                  onchange="validateAndCompressFile(this, 'bukti-pembayaran')"
                />
                <div id="bukti-pembayaran-loading" class="hidden">
                  Loading...
                </div>
                <img
                  id="bukti-pembayaran-preview"
                  class="hidden w-32 mt-2"
                  alt="Preview"
                />
              </div>
              <div>
                <label for="kartu-keluarga" class="block font-medium">
                  Kartu Keluarga (Format: .jpeg, .jpg, .png)
                </label>
                <input
                  type="file"
                  id="kartu-keluarga"
                  class="w-full border rounded-lg px-4 py-2"
                  accept=".jpeg, .jpg, .png"
                  required
                  onchange="validateAndCompressFile(this, 'kartu-keluarga')"
                />
                <div id="kartu-keluarga-loading" class="hidden">Loading...</div>
                <img
                  id="kartu-keluarga-preview"
                  class="hidden w-32 mt-2"
                  alt="Preview"
                />
              </div>
              <div>
                <label for="akta-lahir" class="block font-medium">
                  Akta Kelahiran Siswa (Format: .jpeg, .jpg, .png)
                </label>
                <input
                  type="file"
                  id="akta-lahir"
                  class="w-full border rounded-lg px-4 py-2"
                  accept=".jpeg, .jpg, .png"
                  required
                  onchange="validateAndCompressFile(this, 'akta-lahir')"
                />
                <div id="akta-lahir-loading" class="hidden">Loading...</div>
                <img
                  id="akta-lahir-preview"
                  class="hidden w-32 mt-2"
                  alt="Preview"
                />
              </div>
            </div>
          </div>

          <div class="w-full flex justify-center mt-6">
            <button
              id="button-submit"
              type="submit"
              class="bg-[#286D6B] w-full text-white text-lg font-semibold py-3 px-8 rounded-lg shadow-lg hover:bg-[#1d524f] transition duration-300 ease-in-out transform hover:-translate-y-1"
            >
              Kirim
            </button>
          </div>
          <!-- end form -->
        </div>
      </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/compro/koneksiedu/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script>
      const changeNIK = (input,print) => {
        let val = $("#nik").val();
        if(input) val = input;
        if(!val) return;
        $.ajax({
          url:"{{route('sekolah_sd.ppdb.cek_nik')}}",
          data:{nik:val},
          success:(response)=>{
            if(!response.status) {
              $("#button-submit").removeAttr('disabled')
              if(print){
                Swal.fire({
                  title: 'Info',
                  text: 'Nik belum pernah terdaftar',
                  icon: 'info',
                  background: '#fef2c0',
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK',
                });
              }
              return;
            }
            if(response.status){
              if(print){
                Swal.fire({
                  title: 'Info',
                  text: 'NIK terdaftar, tunggu sebentar...',
                  icon: 'info',
                  background: '#fef2c0',
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK',
                });
                const id = response.data.id;
                const url = `/ppdb-simuda/print/${id}`;
                window.location.href = url;
                return;
              }
              Swal.fire({
                title: 'Info',
                text: 'NIK ini telah terdaftar',
                icon: 'info',
                background: '#fef2c0',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
              });
            }
              
              $("#button-submit").attr('disabled',true)
          }
        })
      }
      $("#nik").change(changeNIK)
      // $("#nik").keyup(changeNIK)

      const HitungTglLahir = (tgl_lahir) => {
        if(!tgl_lahir || tgl_lahir == null) return '-';
        // Tanggal lahir
        const birthDate = moment(tgl_lahir, 'YYYY-MM-DD');
        // Tanggal saat ini
        const currentDate = moment();

        // Hitung selisih tahun dan bulan
        const years = currentDate.diff(birthDate, 'years');
        const months = currentDate.diff(birthDate.add(years, 'years'), 'months');

        // Output
        // console.log(`Umur: ${years} tahun dan ${months} bulan.`);
        // return `${years} tahun ${months} bulan`;
        // return {tahun:years,bulan:months}
        return months
      }

      $("#tanggal-lahir").change(function(){
        const val = $(this).val()
        const res = HitungTglLahir(val)
        if(res < 66){
          Swal.fire({
            title: 'Info',
            text: 'Umur kurang dari 5 Tahun 6 Bulan',
            icon: 'info',
            background: '#fef2c0',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK',
          });
          
          $("#button-submit").attr('disabled',true)
          return;
        }
        $("#button-submit").removeAttr('disabled')
        return;
      })

      const popupCetakBukti = () => {
        Swal.fire({
          title: 'Masukkan NIK',
          input: 'text',
          inputPlaceholder: '...',
          showCancelButton: true,
          confirmButtonText: 'Submit',
          preConfirm: (value) => {
            if (!value) {
              Swal.showValidationMessage('NIK tidak boleh kosong!');
            }
            return value; // Jika validasi berhasil, kembalikan nilai
          },
        }).then((result) => {
          if (result.isConfirmed) {
            changeNIK(result.value,true);
          }
        });
      }
    </script>
  </body>
</html>
