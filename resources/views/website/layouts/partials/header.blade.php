<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{route('web.index')}}">
        <img src="/img/logo.svg" alt="{{env('APP_NAME')}}" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <div class="navbar-nav me-auto mb-2 mb-lg-0"></div>
        <div class="d-flex">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                  <a class="nav-link {{ Request::is('/') ? 'active' : ''}}" href="{{ route('web.index') }}">Beranda</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Request::is('/web/produk-kami') ? 'active' : ''}}" href="{{ route('web.index') }}">Produk Kami</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Request::is('/web/tentang-kami') ? 'active' : ''}}" href="{{ route('web.index') }}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link {{ Request::is('/web/blog') ? 'active' : ''}}" href="{{ route('web.index') }}">Blog</a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-primary px-lg-5 mx-lg-1 {{ Request::is('/web/blog') ? 'active' : ''}}" href="{{ route('web.index') }}">
                    Login
                  </a>
                </li>
                <li class="nav-item">
                  <a class="btn btn-outline-primary {{ Request::is('/web/blog') ? 'active' : ''}}" href="{{ route('web.index') }}">
                    Minta Demo
                  </a>
                </li>
                <li class="nav-item dropdown me-md-5">
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