<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

	<a href="{{route('home')}}" class="logo">
		<span class="logo-lg">{{ Session::get('business.name') }}</span>
	</a>

    <!-- Sidebar Menu -->
    @if(auth()->user()->business->business_category == "sekolah_sd")
      {!! Menu::render('admin-sidebar-sekolah_sd', 'adminltecustom'); !!}
    @elseif(auth()->user()->business->id == 11)
      {!! Menu::render('admin-sidebar-hotel', 'adminltecustom'); !!}
    @else
      {!! Menu::render('admin-sidebar-menu', 'adminltecustom'); !!}
    @endif

    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
