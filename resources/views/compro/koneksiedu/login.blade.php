@extends('compro.koneksiedu.layouts.app')

@push('styles')
    
@endpush

@section('main')
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
            <img
              src="/compro/koneksiedu/assets/images/gplay.png"
              class="w-40 md:w-48 h-auto cursor-pointer"
              alt="Google Play"
            />
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
        <form
            method="POST" action="{{ route('login') }}"
        class="bg-[#538A89] px-4 py-6 md:p-8 rounded-md text-white mt-[-12px] md:mt-[-16px] shadow-lg max-w-md w-full relative z-10"
        >
            {{ csrf_field() }}
          <!-- Login title -->
          <h3 class="font-bold text-2xl md:text-3xl text-center mb-4">
            Log in to KoneksiEdu
          </h3>

          <!-- Input fields -->
          <div class="flex flex-col items-start gap-4 mt-4 w-full">
            <input
              required
              type="text"
              placeholder="Masukkan username sekolah anda"
              name="username"
              class="w-full p-3 rounded-md bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#286D6B]"
            />
            <input
              required
              type="password"
              name="password"
              placeholder="Masukkan password anda"
              class="w-full p-3 rounded-md bg-white text-black focus:outline-none focus:ring-2 focus:ring-[#286D6B]"
            />
          </div>

          <!-- Remember me checkbox and forgot password link -->
          <div class="flex justify-between items-center w-full mt-4 text-sm">
            <label class="flex items-center">
              <input type="checkbox" class="mr-2 accent-[#286D6B]" />
              Ingat saya
            </label>
            {{-- <a href="#" class="text-white hover:underline">Lupa password?</a> --}}
          </div>

          <!-- Login button -->
          <button
            type="submit"
            class="mt-6 bg-[#CBA523] text-white font-bold py-3 px-6 w-full rounded-md hover:opacity-80 transition duration-200"
          >
            Masuk
          </button>
          <a
          href="tel:"
            class="mt-2 bg-white text-[#CBA523] font-bold py-3 px-6 w-full rounded-md hover:opacity-80 transition duration-200"
          >
            Request Demo Sistem
            </a>
        </form>
      </section>
    </div>
@endsection

@push('scripts')
    
@endpush