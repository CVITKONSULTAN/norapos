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
    <title>Register Simuda - Platform Pendidikan Terintegrasi</title>
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
                href="/index.html"
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
                href="/login.html"
                class="flex items-center justify-center text-white bg-[#286D6B] hover:opacity-80 transition-colors py-2 px-8 rounded-md"
                >Login</a
              >
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Content -->
    <div
      class="min-h-[50vh] md:max-h-[90vh] flex flex-col flex-col-reverse md:flex-row justify-between items-center w-full"
    >
      <!-- Download Section -->
      <section
        class="hero bg-[#FAF8F4] relative min-h-[50vh] md:min-h-screen flex flex-col md:flex-row justify-center items-end text-center px-4 md:px-12 py-4 md:py-6 w-full"
      >
        <div class="flex flex-col items-start gap-2">
          <h2 class="font-medium text-xl md:text-2xl text-gray-800">
            Download Aplikasi
          </h2>
          <p class="text-gray-800 text-left text-base">
            Tetap terhubung sebagai sekolah atau orang tua siswa untuk terus
            memantau perkembangan akademik dan aktivitas siswa secara update dan
            realtime.
          </p>
          <div
            class="flex justify-start gap-2 md:gap-8 items-center mt-4 md:mt-6"
          >
            <a href="https://play.google.com/store/apps/details?id=com.itkonsultan.simuda">
              <img
                src="/compro/koneksiedu/assets/images/gplay.png"
                class="w-40 md:w-48 h-auto cursor-pointer"
                alt="Google Play"
              />
            </a>
            <img
              src="/compro/koneksiedu/assets/images/kurikulum.png"
              class="w-40 md:w-48 h-auto"
              alt="Kurikulum Siswa"
            />
          </div>
        </div>
      </section>

      <!-- Login Form -->
      <section
        class="bg-[#286D6B] relative min-h-[50vh] md:min-h-screen flex flex-col justify-center items-center text-center px-4 md:px-12 py-6 w-full"
      >
        <!-- Login image -->
        <img
          src="/compro/koneksiedu/assets/images/loginimg.png"
          class="h-auto max-h-[320px] md:max-h-[290px] md:mt-8 relative z-20"
          alt="login image"
        />

        <!-- Login form container -->
        <form method="POST" action="{{ route('sekolah_sd.register') }}" id="login-form"
          class="bg-[#538A89] px-4 py-6 md:p-8 rounded-md text-white mt-[-12px] md:mt-[-16px] shadow-lg max-w-md w-full relative z-10"
        >
          {{ csrf_field() }}
          <!-- Login title -->
          <h3 class="font-bold text-2xl md:text-3xl text-center mb-4">
            Buat Akun Simuda
          </h3>

          <!-- Input fields -->
          <div class="flex flex-col items-start gap-4 mt-4 w-full">
            <input
              type="text"
              name="nisn"
              placeholder="Masukkan NISN"
              class="w-full p-3 rounded-md bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#286D6B]"
            />
            @if ($errors->has('nisn'))
                <span class="help-block">
                    <strong>{{ $errors->first('nisn') }}</strong>
                </span>
            @endif
            <input
              name="email"
              type="email"
              placeholder="Masukkan email anda"
              class="w-full p-3 rounded-md bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#286D6B]"
            />
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>

          <!-- Login button -->
          <button
            type="submit"
            class="mt-6 bg-[#CBA523] text-white font-bold py-3 px-6 w-full rounded-md hover:opacity-80 transition duration-200"
          >
            Kirim Link
          </button>
        </form>
      </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/localization/messages_id.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

      const gotoLink = () => {
        window.location.href = "https://wa.me/6281254197359";
      }

      $("#login-form").validate({
        submitHandler: (form) => {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: (response) => {
                    if(!response.status){
                        return Swal.fire({
                            title: 'Gagal!',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        })
                    }
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    })
                },
                error: (xhr) => {
                    Swal.fire({
                        title: 'Gagal!',
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    })
                }
            })
            return false;
        }
      })
    </script>
  </body>
</html>
