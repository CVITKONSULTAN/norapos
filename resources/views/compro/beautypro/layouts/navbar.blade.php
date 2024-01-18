<!-- Navbar  -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <a class="navbar-brand" href="#">
            <img src="/compro/beutypro/Logo.png" class="d-inline-block align-top" alt="Logo">
            <div class="d-inline-block pl-2">
                <h1 class="mb-0 head_title">Beauty Pro Clinic</h1>
                <span class="tagline">THE BEST FACIAL IN TOWN</span>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
              <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item {{ Request::is('product') || Request::is('services') ? 'active' : '' }} dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Services & Products
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item {{ Request::is('services') ? 'active' : '' }}" href="/services">Our Services</a>
                <a class="dropdown-item {{ Request::is('product') ? 'active' : '' }}" href="/product">Products</a>
              </div>
            </li>
            <li class="nav-item {{ Request::is('about') ? 'active' : '' }}">
              <a class="nav-link" href="/about">About</a>
            </li>
            <li class="nav-item {{ Request::is('contact') ? 'active' : '' }}">
              <a class="nav-link" href="/contact">Contact</a>
            </li>
            <li class="nav-item {{ Request::is('gallery') ? 'active' : '' }}">
              <a class="nav-link" href="/gallery">Gallery</a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" href="javascript:void(0)">
                <img src="./images/search-normal.svg" />
              </a>
            </li> -->
          </ul>
        </div>
    </nav>
    <!-- END Navbar  -->