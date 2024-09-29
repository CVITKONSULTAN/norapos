<nav class="navbar fixed-top navbar-expand-lg" id="navbar_header">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{route('web.index')}}">
        <img height="41" id="logo_img" src="/compro/koneksiedu/Logo.png" alt="{{env('APP_NAME')}}" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav me-auto mb-2 mb-lg-0"></div>
        <div class="d-flex">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="navItemContainer">
                <li class="nav-item line">
                  <a href="#" class="nav-link {{ Request::is('/') ? 'active' : ''}}">Beranda</a>
                </li>
                <li class="nav-item line">
                  <a href="#product_list" class="nav-link {{ Request::is('/web/produk-kami') ? 'active' : ''}}">Produk Kami</a>
                </li>
                <li class="nav-item line">
                  <a href="#footer" class="nav-link {{ Request::is('/web/tentang-kami') ? 'active' : ''}}" >Tentang Kami</a>
                </li>
                {{-- <li class="nav-item">
                  <a class="nav-link {{ Request::is('/web/blog') ? 'active' : ''}}" href="{{ route('web.index') }}">Blog</a>
                </li> --}}
                <li class="nav-item">
                  <a href="/" class="btn btn-primary px-lg-5 mx-lg-1 {{ Request::is('/web/blog') ? 'active' : ''}}" >
                    Login
                  </a>
                </li>
                <li class="nav-item">
                  <a href="https://wa.me/6285157815452" class="btn btn-outline-primary {{ Request::is('/web/blog') ? 'active' : ''}}" >
                    Minta Demo
                  </a>
                </li>
                <li class="nav-item dropdown me-md-5 bahasa_container">
                  <div class="label">Bahasa</div>
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    (ID)
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Indonesia (ID)</a></li>
                    <li><a class="dropdown-item" href="#">English (EN)</a></li>
                  </ul>
                </li>
              </ul>
        </div>
      </div>
    </div>
</nav>