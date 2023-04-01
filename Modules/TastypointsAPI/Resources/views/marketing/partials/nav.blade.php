
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
                <i class="fab fa-gratipay"></i>
                Marketing Campaigns
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    {{-- <li>
                        <a href="#">Funnels</a>
                    </li> --}}
                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Automation Flow
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                          <li><a href="{{ route("marketing.flow") }}">Funnels</a></li>
                          <li><a href="{{ route("marketing.flow.nodes_group") }}">Nodes Group</a></li>
                          <li><a href="{{ route("marketing.flow.create_nodes_screen") }}">Create Nodes</a></li>
                          <li><a href="{{ route("marketing.flow.node_containers") }}">Node Settings Containers</a></li>
                          {{-- <li><a href="{{ route("comunication.sms-originators") }}">Originators</a></li>
                          <li><a href="{{ route("comunication.sms_confirm_code") }}">Confirmation Code</a></li>
                          <li><a href="{{ route("comunication.sms_message_history") }}">Message History</a></li> --}}
                        </ul>
                    </li>
                    {{-- <li>
                        <a href="{{ route("marketing.embed") }}">Automation Flow</a>
                    </li> --}}
                    <li>
                        <a href="{{ route("marketing.landingpage") }}">Landing Page Builder</a>
                    </li>
                    {{-- <li>
                        <a href="{{ route("marketing.newsletter") }}">News Letter Builder</a>
                    </li> --}}
                    <li>
                        <a href="{{ route("marketing.newsletter") }}">Create new email message</a>
                    </li>
                    <li>
                        <a href="{{ route("marketing.pos") }}">POS Receipt Templates</a>
                    </li>
                    <li>
                        <a href="{{ route("marketing.stamp_campaigns") }}">Stamp Campaigns</a>
                    </li>

                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>