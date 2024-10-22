<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-4" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="Platform pendidikan yang mempermudah administrasi, pengelolaan, dan komunikasi di lingkungan pendidikan."
    />
    <meta
      name="keywords"
      content="platform pendidikan, administrasi sekolah, KoneksiEdu, manajemen sekolah, pendidikan Indonesia"
    />
    <title>KoneksiEdu - Platform Pendidikan Terintegrasi</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Default background image for desktop */
      section.hero {
        background-image: url("/compro/koneksiedu/assets/images/herodesktop.png");
        background-size: cover;
        background-position: center;
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
      <nav class="sticky top-0 w-full z-20 bg-[#FAF8F4] shadow-md">
        <div
          class="mx-auto px-4 md:px-10 py-4 md:py-5 flex justify-between items-center"
        >
          <img
            src="/compro/koneksiedu/assets/images/logo.png"
            class="w-40 md:w-48"
            alt="KoneksiEdu Logo"
          />

          <!-- Desktop Menu -->
          <div
            class="hidden md:flex justify-between items-center gap-6 lg:gap-12"
          >
            <a
              href="/peta"
              class="text-gray-800 hover:text-[#286D6B] transition-colors"
              >Home</a
            >
            <a
              href="/peta"
              class="text-gray-800 hover:text-[#286D6B] transition-colors"
              >About Us</a
            >
            <a
              href="/peta"
              class="text-gray-800 hover:text-[#286D6B] transition-colors"
              >Contact</a
            >
            <a
              href="/peta"
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
                href="#"
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
                href="#"
                class="flex items-center justify-center text-white bg-[#286D6B] hover:opacity-80 transition-colors py-2 px-8 rounded-md"
                >Login</a
              >
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Hero -->
    <section
      class="hero bg-[#FAF8F4] relative min-h-[50vh] md:min-h-screen flex flex-col md:flex-row justify-center items-center text-center px-6 md:px-12 py-6"
    >
      <div class="flex flex-col items-center md:items-start">
        <img
          src="/compro/koneksiedu/assets/images/herotitle.png"
          class="h-28 md:h-40"
          alt="Hero Guru"
        />
        <p class="text-black w-[70%] mt-8 md:mb-12 text-center md:text-left">
          Dengan desain antarmuka yang sederhana dan mudah digunakan,
          KoneksiEdu, Sistem Informasi Manajemen Sekolah cerdas terintegrasi
          untuk analisis performa akademik secara tepat dan menyeluruh.
        </p>
        <a
          href="#"
          class="bg-[#CBA523] gap-4 font-bold text-white px-8 py-4 rounded-md hover:bg-opacity-90 transition-colors hidden md:flex"
        >
          <i class="fas fa-phone fa-2x"></i>
          <span class="text-xl">Hubungi Kami</span>
        </a>
      </div>

      <img
        src="/compro/koneksiedu/assets/images/heroperson.png"
        class="h-auto max-h-[800px] md:max-h-[600px] md:mt-8"
        alt="hero person"
      />
    </section>

    <!-- Features  -->
    <main class="relative z-20 -mt-6 md:-mt-8 bg-[#FAF8F4] py-10">
      <div
        class="mx-auto grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 px-6 md:px-12"
      >
        <!--  Items -->
        <div
          class="flex flex-col items-center bg-white py-6 rounded-lg shadow-md transition-transform transform hover:scale-105"
        >
          <img
            src="/compro/koneksiedu/assets/icons/guru.png"
            class="w-16 h-16"
            alt="Ikon Guru"
          />
          <p
            class="text-[#286D6B] text-lg md:text-xl font-bold text-center mt-4"
          >
            Guru
          </p>
          <p class="text-[#286D6B] text-sm md:text-base text-center mt-2">
            Membantu guru menjalankan tugas secara efektif & efisien
          </p>
        </div>

        <div
          class="flex flex-col items-center bg-white py-6 rounded-lg shadow-md transition-transform transform hover:scale-105"
        >
          <img
            src="/compro/koneksiedu/assets/icons/guru.png"
            class="w-16 h-16"
            alt="Ikon Kepala Sekolah"
          />
          <p
            class="text-[#286D6B] text-lg md:text-xl font-bold text-center mt-4"
          >
            Kepala Sekolah
          </p>
          <p class="text-[#286D6B] text-sm md:text-base text-center mt-2">
            Mengoptimalkan Pelaksanaan administratif dan manajemen sekolah
          </p>
        </div>

        <div
          class="flex flex-col items-center bg-white py-6 rounded-lg shadow-md transition-transform transform hover:scale-105"
        >
          <img
            src="/compro/koneksiedu/assets/icons/orangtua.png"
            class="w-16 h-16"
            alt="Ikon Orang Tua"
          />
          <p
            class="text-[#286D6B] text-lg md:text-xl font-bold text-center mt-4"
          >
            Orang Tua
          </p>
          <p class="text-[#286D6B] text-sm md:text-base text-center mt-2">
            Memudahkan memantau perkembangan akademik anak dan informasi sekolah
          </p>
        </div>

        <div
          class="flex flex-col items-center bg-white py-6 rounded-lg shadow-md transition-transform transform hover:scale-105"
        >
          <img
            src="/compro/koneksiedu/assets/icons/yayasan.png"
            class="w-16 h-16"
            alt="Ikon Dinas Pendidikan / Yayasan"
          />
          <p
            class="text-[#286D6B] text-lg md:text-xl font-bold text-center mt-4"
          >
            Dinas Pendidikan / Yayasan
          </p>
          <p class="text-[#286D6B] text-sm md:text-base text-center mt-2">
            Memudahkan dalam memantau perkembangan sekolah
          </p>
        </div>

        <div
          class="flex flex-col items-center bg-white py-6 rounded-lg shadow-md transition-transform transform hover:scale-105"
        >
          <img
            src="/compro/koneksiedu/assets/icons/siswa.png"
            class="w-16 h-16"
            alt="Ikon Siswa"
          />
          <p
            class="text-[#286D6B] text-lg md:text-xl font-bold text-center mt-4"
          >
            Siswa
          </p>
          <p class="text-[#286D6B] text-sm md:text-base text-center mt-2">
            Materi pembelajaran lengkap dan terstruktur
          </p>
        </div>

        <div
          class="flex flex-col items-center bg-white py-6 rounded-lg shadow-md transition-transform transform hover:scale-105"
        >
          <img
            src="/compro/koneksiedu/assets/icons/siswa.png"
            class="w-16 h-16"
            alt="Ikon Staff Tata Usaha"
          />
          <p
            class="text-[#286D6B] text-lg md:text-xl font-bold text-center mt-4"
          >
            Staff Tata Usaha
          </p>
          <p class="text-[#286D6B] text-sm md:text-base text-center mt-2">
            Membantu menjalankan tugas di sekolah secara efektif dan efisien
          </p>
        </div>
      </div>
    </main>

    <!-- Platform  -->
    <section
      class="bg-[#286D6B] flex flex-col md:flex-row justify-between items-center px-6 md:px-10 py-10 gap-8"
    >
      <img
        src="/compro/koneksiedu/assets/images/feature.png"
        class="w-full md:w-1/2 h-80 object-contain"
        alt="Fitur KoneksiEdu"
      />
      <div class="flex flex-col justify-center items-start gap-6 md:w-1/2">
        <h2
          class="text-xl md:text-2xl md:text-3xl font-medium text-white text-center md:text-left"
        >
          1 PLATFORM COCOK UNTUK SEMUA ELEMENT
        </h2>
        <p class="text-white leading-relaxed text-center md:text-left">
          Dirancang untuk mempermudah administrasi, pengelolaan, dan komunikasi
          dilingkungan pendidikan. Dengan antarmuka yang user-friendly dan fitur
          yang lengkap, KoneksiEdu membantu sekolah dalam mengelola berbagai
          aspek operasional, mulai dari administrasi akademik, Penerimaan
          Peserta Didik Baru (PPDB) hingga manajemen keuangan sekolah.
        </p>
        <a
          href="#"
          class="bg-[#CBA523] text-white px-10 py-4 rounded-md hover:bg-opacity-90 transition-colors self-center md:self-start"
          >Info selengkapnya</a
        >
      </div>
    </section>

    <section
      class="flex justify-between items-center px-6 md:px-12 py-8 bg-[#FAF8F4]"
    >
      <div class="flex flex-col gap-8">
        <h2
          class="text-4xl font-medium text-[#60605F] text-center md:text-left"
        >
          Tentang KoneksiEdu
        </h2>

        <div
          class="flex flex-col gap-4 text-[#60605F] text-center md:text-left"
        >
          <p>
            Sistem sekolah cerdas terintegrasi merupakan pendekatan yang
            menggabungkan teknologi informasi dan komunikasi dengan proses
            pembelajaran untuk meningkatkan efisiensi dan efektivitas
            dilingkungan pendidikan.
          </p>

          <p>
            Menghadirkan Platform Kolaboratif yang memfasilitasi kerja sama
            antara siswa, guru, dan orang tua untuk mendukung proses
            pembelajaran yang lebih baik dan transparan dengan memberikan akses
            kepada orang tua untuk memantau perkembangan anak, termasuk laporan
            nilai dan kehadiran.
          </p>

          <ul class="text-[#60605F] space-y-2 mt-4">
            <li class="flex items-center gap-3 font-bold text-left">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Sistem Raport Digital (E-Raport) Kurikulum Merdeka
            </li>
            <li class="flex items-center gap-3 font-bold text-left">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Dilengkapi dengan sistem Penerimaan Peserta Didik Baru (PPDB)
            </li>
            <li class="flex items-center gap-3 font-bold text-left">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Berbasis cloud, data aman, dengan fitur lengkap yang mudah
              digunakan
            </li>
            <li class="flex items-center gap-3 font-bold text-left">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Tanpa down-time error meski diakses ratusan hingga ribuan user
            </li>
            <li class="flex items-center gap-3 font-bold text-left">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Mendukung fitur kostumisasi, sesuai dengan kebutuhan sekolah
            </li>
            <li class="flex items-center gap-3 font-bold text-left">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />Dukungan training dan support kepada sekolah
            </li>
          </ul>
        </div>
      </div>
      <img
        src="/compro/koneksiedu/assets/images/tentang.png"
        class="w-[500px] h-[500px] hidden md:block"
        alt="Ikon Siswa"
      />
    </section>

    <section
      class="flex flex-col-reverse md:flex-row items-center md:items-start justify-between px-4 md:px-12 py-8 space-y-8 md:space-y-0"
    >
      <img
        src="/compro/koneksiedu/assets/images/download.png"
        class="w-full max-w-md md:max-w-lg h-auto"
        alt="Download"
      />
      <div class="flex flex-col gap-4 md:ml-8 lg:ml-12">
        <h2 class="text-xl md:text-2xl text-[#60605F]">Download Aplikasi</h2>
        <h3 class="text-2xl md:text-3xl font-medium text-[#60605F]">
          Dapatkan Aplikasi Kami Sekarang!
        </h3>

        <div class="flex flex-col gap-4 text-[#60605F]">
          <p>
            Tetap terhubung sebagai sekolah atau orang tua siswa untuk terus
            memantau perkembangan akademik dan aktivitas siswa secara update dan
            realtime.
          </p>

          <div class="flex justify-start gap-4 md:gap-8 items-center mt-6">
            <img
              src="/compro/koneksiedu/assets/images/gplay.png"
              class="w-36 md:w-48 h-auto cursor-pointer"
              alt="Ikon Siswa"
            />
            <img
              src="/compro/koneksiedu/assets/images/kurikulum.png"
              class="w-36 md:w-48 h-auto"
              alt="Kurikulum Siswa"
            />
          </div>
        </div>
      </div>
    </section>

    <footer
      class="bg-[#286D6B] px-6 md:px-12 py-8 flex flex-col md:flex-row gap-4 justify-between items-start"
    >
      <div>
        <p class="font-bold text-white text-3xl mb-4">Kontak kami</p>
        <p class="font-medium text-white">
          Jadwalkan demo dan dapatkan Penawaran khusus untuk Sekolah Anda.
        </p>
        <p class="font-medium text-white mb-2">EXTRA CASHBACK 15%</p>
        <p class="text-white">
          Jalan Tanjung Raya 2, Pontianak Timur 78231, Indonesia
        </p>
        <p class="text-white">Email : admin@koneksiedu.com</p>
        <p class="text-white">Telp : (+62) 812 54 1973 59</p>

        <!-- Social Media  -->
        <div class="mt-4">
          <a href="https://youtube.com" target="_blank" class="text-white mx-2">
            <i class="fab fa-youtube fa-2x"></i>
          </a>
          <a
            href="https://instagram.com"
            target="_blank"
            class="text-white mx-2"
          >
            <i class="fab fa-instagram fa-2x"></i>
          </a>
          <a
            href="https://facebook.com"
            target="_blank"
            class="text-white mx-2"
          >
            <i class="fab fa-facebook fa-2x"></i>
          </a>
        </div>
      </div>

      <div class="flex flex-col">
        <p class="font-bold text-white text-3xl mb-4">Newsletter</p>
        <p class="text-white">
          Jadilah yang pertama mendapatkan promo dan pemberitahuan terupdate
          dari kami.
        </p>
        <div class="mt-4">
          <div class="flex">
            <input
              type="email"
              placeholder="Masukkan email anda..."
              class="p-2 rounded-l-md w-full"
            />
            <button class="bg-[#CBA523] text-white py-2 px-6 rounded-r-md">
              Subscribe
            </button>
          </div>
        </div>
        <img
          src="/compro/koneksiedu/assets/images/logowhite.png"
          class="w-64 h-18 mt-8"
          alt="Kurikulum Siswa"
        />
      </div>
    </footer>
    <script>
      const burgerMenu = document.getElementById("burgerMenu");
      const mobileMenu = document.getElementById("mobileMenu");

      burgerMenu.addEventListener("click", () => {
        if (
          mobileMenu.style.maxHeight === "0px" ||
          mobileMenu.style.maxHeight === ""
        ) {
          mobileMenu.style.maxHeight = "400px";
        } else {
          mobileMenu.style.maxHeight = "0px";
        }
      });

      window.addEventListener("resize", () => {
        if (window.innerWidth >= 768) {
          mobileMenu.style.maxHeight = "0px"; // Hide mobile menu
        }
      });
    </script>
  </body>
</html>
