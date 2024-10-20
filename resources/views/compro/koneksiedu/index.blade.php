@extends('compro.koneksiedu.layouts.app')

@section('main')
    
  <!-- Hero -->
  <section
  class="hero relative min-h-[50vh] md:min-h-screen flex flex-col md:flex-row justify-center items-center text-center px-6 md:px-12 py-6"
>
<div class="flex flex-col items-center md:items-start">
  <img src="/compro/koneksiedu/assets/images/herotitle.png" class="h-40" alt="Hero Guru" />
  <p class="text-black w-[70%] mt-8 md:mb-12 text-center md:text-left">
    Dengan desain antarmuka yang sederhana dan mudah digunakan, KoneksiEdu,
    Sistem Informasi Manajemen Sekolah cerdas terintegrasi untuk analisis
    performa akademik secara tepat dan menyeluruh.
  </p>
  <a
    href="#"
    class="bg-[#CBA523] gap-4 font-bold text-white px-8 py-4 rounded-md hover:bg-opacity-90 transition-colors hidden md:flex"
  >
    <i class="fab fa-youtube fa-2x"></i>
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
    <main class="relative z-20 -mt-6 md:-mt-8 bg-white py-10">
      <div
        class="container mx-auto grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-6 px-6 md:px-12"
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
        <h2 class="text-2xl md:text-3xl font-medium text-white">
          1 PLATFORM COCOK UNTUK SEMUA ELEMENT
        </h2>
        <p class="text-white leading-relaxed">
          Dirancang untuk mempermudah administrasi, pengelolaan, dan komunikasi
          dilingkungan pendidikan. Dengan antarmuka yang user-friendly dan fitur
          yang lengkap, KoneksiEdu membantu sekolah dalam mengelola berbagai
          aspek operasional, mulai dari administrasi akademik, Penerimaan
          Peserta Didik Baru (PPDB) hingga manajemen keuangan sekolah.
        </p>
        <a
          href="#"
          class="bg-[#CBA523] text-white px-8 py-4 rounded-md hover:bg-opacity-90 transition-colors"
          >Info selengkapnya</a
        >
      </div>
    </section>

    <section class="flex justify-between items-center px-6 md:px-12 py-8">
      <div class="flex flex-col gap-8">
        <h2 class="text-4xl font-medium text-[#60605F] text-center md:text-left">Tentang KoneksiEdu</h2>

        <div class="flex flex-col gap-4 text-[#60605F] text-center md:text-left">
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
            <li class="flex items-center gap-3 font-bold">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Sistem Raport Digital (E-Raport) Kurikulum Merdeka
            </li>
            <li class="flex items-center gap-3 font-bold">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Dilengkapi dengan sistem Penerimaan Peserta Didik Baru (PPDB)
            </li>
            <li class="flex items-center gap-3 font-bold">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Berbasis cloud, data aman, dengan fitur lengkap yang mudah
              digunakan
            </li>
            <li class="flex items-center gap-3 font-bold">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Tanpa down-time error meski diakses ratusan hingga ribuan user
            </li>
            <li class="flex items-center gap-3 font-bold">
              <img
                src="/compro/koneksiedu/assets/images/bullet.png"
                class="w-5"
                alt="KoneksiEdu Logo"
              />
              Mendukung fitur kostumisasi, sesuai dengan kebutuhan sekolah
            </li>
            <li class="flex items-center gap-3 font-bold">
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

    <section class="flex flex-col flex-col-reverse md:flex-row items-end justify-between px-6 md:px-12 py-8">
      <img
        src="/compro/koneksiedu/assets/images/download.png"
        class="w-[600px] h-[400px]"
        alt="Download"
      />
      <div class="flex flex-col gap-4">
        <h2 class="text-2xl font-medium text-[#60605F]">Download Aplikasi</h2>
        <h3 class="text-4xl font-medium text-[#60605F]">Dapatkan Aplikasi Kami Sekarang!</h2>

        <div class="flex flex-col gap-4 text-[#60605F]">
          <p>
            Tetap terhubung sebagai sekolah atau orang tua siswa untuk terus memantau perkembangan akademik dan aktivitas siswa secara update dan realtime.
          </p>

          <div class="flex justify-start gap-8 items-center mt-8">
            <img
            src="/compro/koneksiedu/assets/images/gplay.png"
            class="w-48 h-18 cursor-pointer"
            alt="Ikon Siswa"
          />
            <img
            src="/compro/koneksiedu/assets/images/kurikulum.png"
            class="w-48 h-18"
            alt="Kurikulum Siswa"
          />
          </div>
        </div>
      </div>
    </section>
@endsection