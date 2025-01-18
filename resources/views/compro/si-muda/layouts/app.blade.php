@php
    $title = $domain ?? env('APP_TITLE');
@endphp
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
    <title>KoneksiEdu - Platform Pendidikan Terintegrasi | {{$title}}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
     /* Default background image for desktop */
     section.hero {
        background-image: url("../assets/images/herodesktop.png");
        background-size: cover;
        background-position: center;
      }

      /* Background image for mobile devices */
      @media (max-width: 768px) {
        section.hero {
          background-image: url("../assets/images/heromobile.png");
        }
      }
    </style>
    @yield('styles')
    
  </head>
  <body>
    <!-- Header / Navigation -->
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
                href="/"
                class="text-gray-800 hover:text-[#286D6B] transition-colors"
                >Home</a
              >
              <a
                href="/about"
                class="text-gray-800 hover:text-[#286D6B] transition-colors"
                >About Us</a
              >
              <a
                href="/contact"
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


    @yield('main')

    <footer class="bg-[#286D6B] px-6 md:px-12 py-8 flex flex-col md:flex-row gap-4 justify-between items-start">
      <div>
        <p class="font-bold text-white text-3xl mb-4">
          Kontak kami
        </p>
        <p class="font-medium text-white">
          Jadwalkan demo dan dapatkan Penawaran khusus untuk Sekolah Anda.
        </p>
        <p class="font-medium text-white mb-2">
          EXTRA CASHBACK 15%
        </p>
        <p class="text-white">
          Jalan Tanjung Raya 2, Pontianak Timur 78231, Indonesia
        </p>
        <p class="text-white">
          Email : admin@koneksiedu.com
        </p>
        <p class="text-white">
          Telp   : (+62) 812 54 1973 59
        </p>
        
        <!-- Social Media  -->
        <div class="mt-4">
          <a href="https://youtube.com" target="_blank" class="text-white mx-2">
            <i class="fab fa-youtube fa-2x"></i>
          </a>
          <a href="https://instagram.com" target="_blank" class="text-white mx-2">
            <i class="fab fa-instagram fa-2x"></i>
          </a>
          <a href="https://facebook.com" target="_blank" class="text-white mx-2">
            <i class="fab fa-facebook fa-2x"></i>
          </a>
        </div>
      </div>
     
      <div class="flex flex-col">
        <p class="font-bold text-white text-3xl mb-4">
          Newsletter
        </p>
        <p class="text-white">
          Jadilah yang pertama mendapatkan promo dan pemberitahuan terupdate dari kami.
        </p>
        <div class="mt-4">
          <div class="flex">
            <input type="email" placeholder="Masukkan email anda..." class="p-2 rounded-l-md w-full" />
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
    
    @yield('scripts')
    
  </body>
</html>
