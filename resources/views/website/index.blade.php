@extends('website.layouts.app')

@push('styles')
    <link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css" />
    <style>
          /*         
                HERU
                script for homescreen start from here
        */

        #jumbotron{
            background: url("./img/webp/bg-jumbotron.webp");
        }
        #jumbotron .bg_jumbo h1{
            color: var(--bs-primary);
        }
        #jumbotron .bg_jumbo{
                background-color: #6312ae35;
        }
        section#feature .body_content h1{
            font-size: 40pt;
            font-weight: 600;
        }
        section#feature .body_content h3{
            font-size: 20pt;
            font-weight: 600;
        }
        section#feature .body_content h2{
            font-size: 25pt;
            font-weight: 600;
        }
        section#feature{
            background: #F3E5FF;
        }
        section#feature .container{
            padding-top: 2rem;
            padding-bottom: 1rem;
        }
        section#payment_channel .head_sec{
            color: rgba(56, 54, 54, 0.70);
        }
        section#payment_channel{
            padding-top: 2rem;
            padding-bottom: 2rem;
        }
        section#cta_1{
            background: url('./img/webp/payment_bg.webp');
            position: relative;
        }
        section#cta_1 .filter_bg{
            background: rgba(165, 58, 254, 0.50);
            filter: blur(2px);
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            z-index: 0;
        }
        section#cta_1 .quotes{
            margin: 7rem auto;
        }
        section#cta_1 .container{
            padding-top: 2rem;
            padding-bottom: 2rem;
            color: #FFF;
            text-align: center;
            font-size: 30pt;
            font-style: normal;
            font-weight: 500;
            line-height: normal;
            position: relative;
            z-index: 2;
        }
        section#product_list{
            background: rgba(165, 58, 254, 0.13);
            /* padding-top: 3rem; */
            padding-bottom: 3rem;
        }
        section#product_list .card_product h1 {
            color: var(--bs-primary);
            /* font-size: 60px; */
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            text-transform: uppercase;
        }
        section#product_list .card_product .hint{
            font-size: 10pt;
        }
        section#product_list .card_product .offer_text{
            color: #267933;
            font-size: 12pt;
            font-weight: 700;
        }
        section#product_list .card_product .price{
            /* color: var(--bs-primary); */
            /* font-size: 12pt; */
            font-weight: 600;
        }
        section#product_list .card_product .disc_price{
            color: #B51126;
            font-size: 12pt;
            font-weight: 600;
            text-decoration-line: line-through;
        }
        section#product_list .card_product ul li {
            list-style-image: url('./img/check_green.svg');
        }
        /* section#product_list .card_product .img_product{
            border-top-right-radius: 
        } */
        section#product_list .card_product{
            border-radius: 20px;
            border: 1px solid rgba(99, 18, 174, 0.20);
            background: #FFF;
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            text-align: center;
            /* border: 0.5px solid rgba(41, 45, 50, 0.10); */
            /* border-radius: 10px; */
            /* background: rgba(153, 38, 255, 0.20); */
            padding: 2rem 0.5rem;
        }
        section#feature_2 .keterangan{
            text-align: right;
            font-size: 22pt;
            font-weight: 400;
            /* margin-top: 7rem; */
        }
        section#feature_2 h5{
            font-size: 12pt;
            text-align: center;
        }
        section#feature_2 h1{
            font-size: 14pt;
        }
        section#feature_2{
            padding-top: 3rem;
            /* padding-bottom: 3rem; */
        }
        section#testimony .body #testimoni_list .testimoni_item p{
            font-size: 21pt;
            margin-bottom: 9rem;
        }
        section#testimony .body #testimoni_list{
            margin-top: 15rem;
        }
        section#testimony .body  h1{
            font-weight: 700;
        }
        section#testimony .body {
            position: relative;
            z-index: 1;
        }
        section#testimony{
            background: url('./img/webp/testimony.webp');
            position: relative;
            padding: 10rem 0rem;
            text-align: center;
        }
        section#testimony .filter_bg{
            background: rgba(255, 255, 255, 0.50);
            filter: blur(2px);
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            z-index: 0;
        }
        .swiper-wrapper{
            padding-bottom: 5rem;
        }

        .swiper-pagination-bullet {
            height: 25px;
            width: 25px;
            background: rgba(239, 232, 245, 0.8);
            box-shadow: 2px 3px rgba(0,0,0,0.5);
            /* margin-right: 2rem; */
        }
        .swiper-pagination-bullet-active{
            background: rgba(132, 28, 201, 0.80);
        }

        div#jumbotron .masuk{
                background: #fff;
        }

        div#jumbotron .masuk:hover{
            color: var(--bs-primary);
        }
        div#pelengkap h5{
            font-size: 12pt;
            padding: 1rem 0;
        }
        div#pelengkap img{
            margin-bottom: 0.5rem;
        }

        /* section#feature2 div.card_product_main{ */
        div.card_product_main{
            border-radius: 20px;
            border: 2px solid rgba(99, 18, 174, 0.20);
            background: rgba(99, 18, 174, 0.10);
            box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
            padding: 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        div.card_product_main ul li {
            list-style-image: url('./img/webp/checkedPurple.svg');
            padding-top: 10px;
            padding-left: 10px;
        }


        @media (min-width: 992px){
            #jumbotron .bg_jumbo{
                padding-top: 8rem;
                padding-bottom: 22rem;
                padding-left: 10rem;
            }
        }

        @media (max-width: 992px){
            section#cta_1 .quotes {
                font-size: 12pt;
                margin: 1rem auto !important;
            }
            section#feature .body_content h1{
                font-size: 20pt !important;
            }
            section#feature .body_content h3{
                font-size: 12pt !important;
            }
            section#feature .body_content h2{
                font-size: 20pt !important;
            }
            section#feature .body_content ul {
                margin-top: 0px !important;
                /* text-align: center !important; */
            }
            .keterangan_feature{
                display: none;
            }
            section#payment_channel h1 {
                font-size: 15pt;
            }
            div#jumbotron{
                text-align: center;
            }
            section#product_list div.card_product{
                margin-bottom: 1.5rem;
            }
            section#feature_2 p.keterangan{
                font-size: 12pt;
                text-align: center;
                margin-top: 0;
            }
            section#testimony {
                padding: 1rem 0;
            }
            section#testimony .body #testimoni_list{
                margin-top: 1rem;
            }
            section#testimony .body #testimoni_list .testimoni_item h5{
                font-size: 12pt;
            }
            section#testimony .body #testimoni_list .testimoni_item p{
                font-size: 12pt;
                margin-bottom: 1rem;
            }
            .swiper-pagination-bullet{
                height: 15px;
                width: 15px;
            }
            section#product_list h1{
                font-size: 14pt;
            }
        }

    </style>
@endpush

@section('main')
    <div class="bg-body-tertiary rounded-3" id="jumbotron">
        <section id="head" class="bg_jumbo">
            <div class="container-fluid py-5" data-aos="fade-up"  data-aos-duration="2000">
                <h1 class="display-5 fw-bold">NAIK KAN OMSET <br/>& PROFIT BISNIS ANDA</h1>
                <p class="col-md-8 fs-5 py-5">
                    Mulai bisnis jadi mudah dengan <br />online kapanpun & dari mana saja
                </p>
                <div class="button_container">
                    <a href="https://wa.me/6285157815452" class="btn btn-primary btn-lg mb-2" type="button">Uji Coba Gratis Sekarang!</a>
                    <a href="/" class="btn btn-outline-primary btn-lg mb-2 masuk" type="button">Masuk</a>
                </div>
            </div>
        </section>
    </div>
    <section id="feature">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center">Kelola usaha offline Anda dengan Aplikasi Kasir NORAPOS</h1>
                </div>
                <div class="col-md-6">
                    <img src="{{asset("./img/webp/feature_1_revisi.webp")}}" class="img-fluid" alt="{{env('APP_TITLE')}}" />
                </div>
                <div class="col-md-6">
                    <p class="text-center">Anti repot! Anti ribet! Transaksi mudah dan cepat. Cukup melalui satu perangkat, Anda dapat melakukan pencatatan transaksi secara realtime, menerima pembayaran digital hingga mencetak nota dengan praktis, dan portable.</p>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col-md-6 text-center" data-aos="fade-up"  data-aos-duration="2000">
                    <img src="{{asset('img/webp/mockup-multi-device.webp')}}" class="img-fluid" alt="{{env('APP_TITLE')}}" />
                    <h3 class="text-center keterangan_feature">Aplikasi NORAPOS</h3>
                </div>
                <div class="col-md-6 body_content" data-aos="fade-up"  data-aos-duration="2000">
                    <h1 class="text-center">KELOLA BISNIS</h1>
                    <h3 class="text-center">HANYA DALAM GENGGAMAN ANDA</h3>
                    <h2 class="text-center my-3">10 KEUNGGULAN KAMI</h2>
                    <ul class="mt-5">
                        <li>Fitur lengkap dan terintegrasi</li>
                        <li>Pembukuan & Laporan mudah dipahami (realtime)</li>
                        <li>Sinkronisasi otomatis (SmartSync)</li>
                        <li>Transaksi cepat</li>
                        <li>Mudah digunakan (user friendly)</li>
                        <li>Instalasi mudah dan praktis</li>
                        <li>Modul pengguna & pelatihan gratis</li>
                        <li>Layanan CS aktif 24 jam</li>
                        <li>Dapat di kostumisasi sesuai kebutuhan anda</li>
                        <li>Pantau bisnis anda kapanpun dan dari mana saja</li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </section>
{{-- 
    <section id="payment_channel" class="container" data-aos="fade-up"  data-aos-duration="2000">
        <h1 class="text-center">Menerima Semua Jenis Pembayaran</h1>
        <div class="row justify-content-center my-4">
            @foreach ($payment_channel->where('type','main') as $item)
                <div class="col-2 mt-2">
                    <img class="img-fluid" src="{{$item['image']}}" alt="{{env('APP_TITLE')}}" />
                </div>
            @endforeach
        </div>
        <h1 class="text-center">Metode Pembayaran Lain</h1>
        <div class="row justify-content-center my-4">
            @foreach ($payment_channel->where('type','ewallet') as $item)
                <div class="col-2 mt-2 text-center">
                    <img class="img-fluid" src="{{$item['image']}}" alt="{{env('APP_TITLE')}}" />
                </div>
            @endforeach
        </div>
    </section>
    <section id="cta_1">
        <div class="container">
            <p class="quotes" data-aos="fade-up"  data-aos-duration="2000">Anti repot! Anti ribet! Transaksi mudah dan cepat. Cukup melalui satu perangkat, Anda dapat melakukan pencatatan transaksi secara realtime, menerima pembayaran digital hingga mencetak nota dengan praktis, dan portable.</p>
        </div>
        <div class="filter_bg"></div>
    </section>
--}}
    <section id="product_list">
        <div class="container">
            <h1 class="text-center" data-aos="fade-up"  data-aos-duration="2000">Pilih perangkat keras POS yang modern, dan sesuai <br/> dengan kebutuhan bisnis anda</h1>
            <div class="row mt-5">
                <div class="col-md-6" data-aos="fade-up"  data-aos-duration="2500">
                    <div class="card_product">
                        <img class="img-fluid img_product" src="{{asset('./img/webp/MPOS-1.webp')}}" alt="{{env('APP_TITLE')}}" />
                        <ul class="text-start mt-3">
                            <li>Android 10.0</li>
                            <li>Wifi, Bluetooth, Camera</li>
                            <li>Support Fitur NFC</li>
                            <li>Support 58x40mm Paper</li>
                            {{-- <li><b>UNLIMITED FITUR NORAPOS 12 BULAN</b></li> --}}
                            <li><b>NORAPOS 12 BULAN - PRIME+</b></li>
                        </ul>
                        {{-- <p class="disc_price">Rp. 456.789,-</p> --}}
                        {{-- <h2 class="price">Rp 3.999.000,-</h2> --}}
                        {{-- <p class="hint">Harga sudah termasuk Pajak dan PPN 11%</p> --}}
                        <div class="d-grid">
                            <a href="https://wa.me/6285157815452" class="product_order btn btn-primary">Dapatkan Sekarang!</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2" data-aos="fade-up"  data-aos-duration="2500">
                    <div class="card_product">
                        <img class="img-fluid img_product" src="{{asset('./img/webp/Tab-10.webp')}}" alt="{{env('APP_TITLE')}}" />
                        <ul class="text-start mt-3">
                            <li>Screen 10.4" (Touchscreen)</li>
                            <li>Stand Tablet 360°</li>
                            <li>Cash Drawer</li>
                            <li>Printer Thermal</li>
                            {{-- <li><b>UNLIMITED FITUR NORAPOS 12 BULAN</b></li> --}}
                            <li><b>NORAPOS 12 BULAN - PRIME+</b></li>
                        </ul>
                        {{-- <p class="disc_price">Rp. 456.789,-</p> --}}
                        {{-- <h2 class="offer_text">PENAWARAN TERBATAS</h2>
                        <h2 class="price">Rp 5.300.000,-</h2>
                        <p class="hint">Harga sudah termasuk Pajak dan PPN 11%</p> --}}
                        <div class="d-grid">
                            <a href="https://wa.me/6285157815452" class="product_order btn btn-primary">Dapatkan Sekarang!</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-up"  data-aos-duration="2500">
                    <div class="card_product">
                        <img class="img-fluid img_product" src="{{asset('./img/webp/Tab-8.webp')}}" alt="{{env('APP_TITLE')}}" />
                        <ul class="text-start mt-3">
                            <li>Screen 8" (Touchscreen)</li>
                            <li>Stand Tablet 360°</li>
                            <li>Cash Drawer</li>
                            <li>Printer Thermal</li>
                            {{-- <li><b>UNLIMITED FITUR NORAPOS 12 BULAN</b></li> --}}
                            <li><b>NORAPOS 12 BULAN - PRIME+</b></li>
                        </ul>
                        {{-- <p class="disc_price">Rp. 456.789,-</p> --}}
                        {{-- <h2 class="price">Rp 4.300.000,-</h2>
                        <p class="hint">Harga sudah termasuk Pajak dan PPN 11%</p> --}}
                        <div class="d-grid">
                            <a href="https://wa.me/6285157815452" class="product_order btn btn-primary">Dapatkan Sekarang!</a>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-6" data-aos="fade-up"  data-aos-duration="2500">
                    <div class="card_product">
                        <img class="img-fluid img_product" src="{{asset('./img/webp/dual-platinum.webp')}}" alt="{{env('APP_TITLE')}}" />
                        <ul class="text-start mt-3">
                            <li>Screen 8" (Touchscreen)</li>
                            <li>Stand Tablet 360°</li>
                            <li>Cash Drawer</li>
                            <li>Printer Thermal</li>
                            <li><b>UNLIMITED FITUR NORAPOS 12 BULAN</b></li>
                        </ul>
                        <h2 class="offer_text">PENAWARAN TERBATAS</h2>
                        <h2 class="price">Rp. ???</h2>
                        <p class="hint">Harga sudah termasuk Pajak dan PPN 11%</p>
                        <div class="d-grid">
                            <a href="https://wa.me/6285157815452" class="product_order btn btn-primary">Dapatkan Sekarang!</a>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div id="pelengkap" data-aos="fade-up"  data-aos-duration="2500">
                <h5 class="text-center">Pelengkap kasir untuk memudahkan transaksi penjualan anda</h5>
                <div class="container">
                    <div class="row ">
                        <div class="col-6 text-center">
                            <img class="img-fluid" src="{{asset("./img/webp/Group_3.webp")}}" alt="{{env('APP_TITLE')}}" />
                            <p>Cash Drawer<br/>(Laci Kasir Otomatis)</p>
                        </div>
                        <div class="col-6 text-center">
                            <img class="img-fluid" src="{{asset("./img/webp/Group_4.webp")}}" alt="{{env('APP_TITLE')}}" />
                            <p>Printer Thermal</p>
                        </div>
                        <div class="col-6 text-center">
                            <img class="img-fluid" src="{{asset("./img/webp/Group_5.webp")}}" alt="{{env('APP_TITLE')}}" />
                            <p>Barcode<br/>Scanner</p>
                        </div>
                        <div class="col-6 text-center">
                            <img class="img-fluid" src="{{asset("./img/webp/Group_6.webp")}}" alt="{{env('APP_TITLE')}}" />
                            <p>Mobile POS<br/>(Support NFC)</p>
                        </div>
                        <div class="col-6 text-center">
                            <img class="img-fluid" src="{{asset("./img/webp/Group_7.webp")}}" alt="{{env('APP_TITLE')}}" />
                            <p>Tablet Galaxy</p>
                        </div>
                        <div class="col-6 text-center">
                            <img class="img-fluid" src="{{asset("./img/webp/Group_8.webp")}}" alt="{{env('APP_TITLE')}}" />
                            <p>Tablet Stand 360°</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="feature_2" class="container">
        <h1 class="text-center head" data-aos="fade-up"  data-aos-duration="2000">Mencatat Seluruh Transaksi anda dengan mudah tanpa ribet dengan ratusan fitur canggih</h1>
        <div class="row">
            <div class="col-md-12" data-aos="fade-up"  data-aos-duration="2000">
                {{-- <img class="img-fluid" src="{{asset('./img/webp/feature_2_new.webp')}}" alt="{{env('APP_TITLE')}}" /> --}}
                <div class="text-center">
                    <img class="img-fluid" src="{{asset('./img/webp/feature_2_revisi.webp')}}" alt="{{env('APP_TITLE')}}" />
                </div>
                <h5>Semua menjadi lebih mudah dan dapat di akses menggunakan semua perangkat favorit anda.</h5>
                <p class="keterangan">
                    Mengefisienkan pengelolaan bisnis offline anda. Kemanapun anda pergi tetap dapat terhubung dengan NORAPOS dengan aplikasi Android dan iOS gratis.
                </p>
                <div class="d-grid gap-1 mb-2">
                    <a href="https://wa.me/6285157815452" class="btn btn-primary btn-lg mb-2" type="button">Dapatkan Penawaran Sekarang!</a>
                    <a href="/" class="btn btn-outline-primary btn-lg mb-2 masuk" type="button">Minta Demo Gratis!</a>
                </div>
            </div>
            {{-- <div class="col-md-6" data-aos="fade-up"  data-aos-duration="2000">
                <p class="keterangan">
                    Mengefisienkan pengelolaan bisnis, dapat digunakan secara bersamaan dengan bisnis online dan offline anda.
                    Kemanapun anda pergi tetap dapat terhubung dengan NORAPOS dengan aplikasi Android dan iOS gratis.
                    Semua menjadi lebih mudah dan dapat di akses menggunakan semua perangkat favorit anda.
                </p>
            </div> --}}
            <div class="col-md-12">
                <div class="card_product_main">
                    <h5>Smart POS</h5>
                    <h2>NORA PRIME+</h2>
                    <p>Unlimited! Tanpa batasan fitur diberbagai perangkat favorite anda</p>
                    <img 
                        class="img-fluid img_product" 
                        src="{{asset('./img/webp/feature_2_new.webp')}}" 
                        alt="{{env('APP_TITLE')}}"
                    />
                    <ul class="text-start mt-3">
                        <li>Aplikasi Kasir Digital</li>
                        <li>Manajemen Stok / Produk (Tersedia Fitur Upload Masal)</li>
                        <li>Laporan Penjualan harian, bulanan, tahun</li>
                        <li>Laporan transaksi (Dilengkapi chart/grafik)</li>
                        <li>Manajemen Promo</li>
                        <li>Manajemen Karyawan (Tak Terbatas)</li>
                        <li>Menu Digital</li>
                        <li>Manajemen Agen / Pemasok</li>
                        <li>Menyimpan database pelanggan</li>
                        <li>Support Lainnya (Training da panduan pengguna, whatsapp support, call center support)</li>
                    </ul>
                    {{-- <p class="disc_price">Rp. 456.789,-</p> --}}
                    {{-- <h2 class="price">Rp 3.999.000,-</h2> --}}
                    {{-- <p class="hint">Harga sudah termasuk Pajak dan PPN 11%</p> --}}
                    <div class="d-grid">
                        <a href="https://wa.me/6285157815452" class="product_order btn btn-primary">Dapatkan Sekarang!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section id="testimony">
        <div class="container body" data-aos="fade-up"  data-aos-duration="2000">
            <h1>TESTIMONIALS</h1>
            <div class="swiper" id="testimoni_list">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                  <!-- Slides -->
                  <div class="swiper-slide testimoni_item">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <h5>Nama Pemilik Usaha, Nama Brand</h5>
                  </div>
                  <div class="swiper-slide testimoni_item">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <h5>Nama Pemilik Usaha, Nama Brand</h5>
                  </div>
                </div>
                <!-- If we need pagination -->
                <div class="swiper-pagination"></div>
              </div>
        </div>
        <div class="filter_bg"></div>
    </section> --}}
    <footer id="footer">
        <div class="container" data-aos="fade-up"  data-aos-duration="2000">
            <img src="{{asset('./img/webp/logo-white.webp')}}" class="logo_footer my-4" alt="{{env('APP_TITLE')}}" />
            {{-- <p>
                Download the Admin App <br/>
                Manage your POS system and online store, get analysis and insights and keep connected with your customers and staff with the Admin app, available on Android and Apple.
            </p>
            <div class="logo_download_container">
                <a href="https://play.google.com/">
                    <img src="{{asset('./img/webp/playstore.webp')}}" class="logo_download_app" alt="{{env('APP_TITLE')}}" />
                </a>
                <a href="https://www.apple.com/id/app-store/">
                    <img src="{{asset('./img/webp/appstore.webp')}}" class="logo_download_app" alt="{{env('APP_TITLE')}}" />
                </a>
            </div> --}}
            <p class="text-center">Tinggalkan alamat e-mail Anda untuk mendapatkan berita terbaru dari NORAPOS</p>

            <form class="input-group mb-3">
                @csrf
                <input name="email" type="email" class="form-control email_input" placeholder="Masukkan email anda">
                <button class="btn btn-primary input_submit">Subscribe</button>
            </form>

            <p class="text-center"><b>© {{ date('Y') }} NORAPOS</b></p>

        </div>
    </footer>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
    <script>
         AOS.init();
    </script>
    <script type="module">
        import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.mjs'
        $(document).ready(function(){
            // const elm = document.getElementById("#testimoni_list");
            // const swiper = new Swiper(elm)
            const swiper = new Swiper('.swiper', {

                direction: 'horizontal',
                loop: true,

                // If we need pagination
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                }
            });
        });
      
    </script>
@endpush