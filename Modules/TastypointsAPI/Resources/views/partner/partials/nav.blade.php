
<section class="no-print">
    <nav class="navbar navbar-default bg-white m-4">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" 
                href="{{
                    route("partner.index")
                }}">
                <i class="fas fa-briefcase"></i>
                Partner Management
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          All Partners
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                          <li><a href="{{ route("partner.index") }}">All Records</a></li>
                          <li><a href="{{ route("partner.staff-title") }}">Staff Title</a></li>
                          <li><a href="{{ route("partner.partner-groups") }}">Partner Groups</a></li>
                          <li><a href="{{ route("partner.dish-list") }}">Partner Dish List</a></li>
                          <li><a href="{{ route("partner.dish-category") }}">Partner Dish Category</a></li>
                          <li><a href="{{ route("partner.payment-management") }}">Payment Management</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route("partner.industry") }}">Industries</a>
                    </li>
                    <li>
                        <a href="{{ route("partner.partner-types") }}">Partner Types</a>
                    </li>
                    <li>
                        <a href="{{ route("partner.photo-types") }}">Photo Types</a>
                    </li>
                    <li>
                        <a href="{{ route("partner.phone-types") }}">Phone Types</a>
                    </li>
                    <li>
                        <a href="{{ route("partner.partner-status") }}">Status Settings</a>
                    </li>
                    <li>
                        <a href="{{ route("partner.week-days") }}">Weekdays</a>
                    </li>
                    <li>
                        <a href="{{ route("partner.delivery-settings") }}">Delivery Settings</a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            POS Management
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><a href="{{ route("partner.pos.setup") }}">Setup</a></li>
                            <li><a href="{{ route("partner.pos-management") }}">List Devices</a></li>
                            <li><a href="{{ route("partner.pos.data-order") }}">Data Order</a></li>
                            <li><a href="{{ route("partner.pos.order-status") }}">Order Status</a></li>
                            <li><a href="{{ route("partner.pos.cancel") }}">Cancelation Reasons & Suggest</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Menu Access Management
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><a href="{{ route("partner.admin-level") }}">Dashboard Admin Level</a></li>
                          <li><a href="{{ route("partner.menu-items") }}">Menu Items Management</a></li>
                          <li><a href="{{ route("partner.sidemenu-manage") }}">App Side-menu Management</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route("partner.rewards-settings") }}">Rewards Settings</a>
                    </li>

                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>