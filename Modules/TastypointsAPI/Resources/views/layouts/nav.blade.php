<script>
    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }
</script>

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
                    route("tastypointsapi.index")
                }}">
                <i class="fas fa-exchange-alt"></i>
                {{__('tastypointsapi::lang.tastypoints')}}
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <li
                        @if( 
                            request()->segment(1) == 'tastypointsapi' && 
                            empty(request()->segment(2))
                        ) 
                            class="active" 
                        @endif 
                    >
                        <a href="{{
                            route("tastypointsapi.index")
                        }}">@lang('tastypointsapi::lang.dashboard')
                        </a>
                    </li>

                    <li
                        @if( 
                            request()->segment(1) == 'tastypointsapi' && 
                            request()->segment(2) == "setup"
                        ) 
                            class="active" 
                        @endif 
                    >
                        <a href="{{
                            route("tastypointsapi.setup")
                        }}"> JSON Debugger
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Screen Data Labs
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                          <li><a href="{{ route("tastypointsapi.scdata_labs") }}">Lab Testing</a></li>
                          <li><a href="{{ route("tastypointsapi.scdata_labs_table") }}">Lab Testing Table</a></li>
                          <li><a href="{{ route("tastypointsapi.push_testing") }}">Push Notification Testing</a></li>
                          <li><a href="{{ route("tastypointsapi.sclab_category") }}">Category</a></li>
                          <li><a href="{{ route("tastypointsapi.sclab_status") }}">Status</a></li>
                          <li><a href="{{ route("stripe.index") }}">Payment</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route("tastypointsapi.geosettings") }}">Geographic Settings</a></li>

                    <li>
                        <a href="{{
                            route("tastypointsapi.sample-profile-image")
                        }}">Sample Profile Images
                        </a>
                    </li>

                    <li><a href="{{ route("tastypointsapi.app-screens") }}">App Screens Management</a></li>

                    <li><a href="{{ route("partner.settings") }}">System Settings</a></li> 

                    <li>
                        <a href="{{
                            route("tastypointsapi.logout")
                        }}"><i class="fa fa-sign-out-alt"></i> @lang('tastypointsapi::lang.logout')
                        </a>
                    </li>

                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>