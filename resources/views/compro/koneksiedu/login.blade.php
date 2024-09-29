@extends('compro.koneksiedu.layouts.app')

@push('styles')
    <link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <style>
        section#login_comp {
            padding: 8rem 1rem 2rem 1rem;
            background: rgb(55 55 203 / 62%);
        }
    </style>
@endpush

@section('main')
    <section id="login_comp">
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    Silahkan login dibawah ini
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" id="login-form">
                        {{ csrf_field() }}
                        <div class="form-group">
                          <input class="form-control" 
                          placeholder="username"
                          name="username"
                          required
                          />
                        </div>
                        <div class="form-group mt-3">
                          <input class="form-control" 
                          placeholder="password"
                          name="password"
                          required
                          type="password"
                          />
                        </div>
                        <div class="d-grid mt-3">
                            <button class="btn btn-primary btn-block">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer id="footer">
        <div class="container" data-aos="fade-up"  data-aos-duration="2000">
            <img src="{{asset('./img/webp/logo-white.webp')}}" class="logo_footer my-4" alt="{{env('APP_TITLE')}}" />
            <p class="text-start">
                Jl. Tanjung Raya 2, Parit Mayor. Pontianak<br />
                Kalimantan Barat. Indonesia<br/>
                Kontak CS Kami WA : 0851-5781-5452
            </p>
            <p>
                Download the KoneksiEdu App <br/>
                Manage your School system and online, get analysis and insights and keep connected with your school with the Admin app, available on Android and Apple.
            </p>
            <div class="logo_download_container">
                <a href="https://play.google.com/">
                    <img src="{{asset('./img/webp/playstore.webp')}}" class="logo_download_app" alt="{{env('APP_TITLE')}}" />
                </a>
                <a href="https://www.apple.com/id/app-store/">
                    <img src="{{asset('./img/webp/appstore.webp')}}" class="logo_download_app" alt="{{env('APP_TITLE')}}" />
                </a>
            </div>
            <p class="text-start">Tinggalkan alamat e-mail Anda untuk mendapatkan berita terbaru dari NORAPOS</p>

            <form class="input-group mb-3">
                @csrf
                <input name="email" type="email" class="form-control email_input" placeholder="Masukkan email anda">
                <button class="btn btn-primary input_submit">Subscribe</button>
            </form>

            <p class="text-center"><b>© {{ date('Y') }} KONEKSIEDU</b></p>

        </div>
    </footer>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endpush