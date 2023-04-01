
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
                <i class="fas fa-bullhorn"></i>
                Communications
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">

                    <li class="dropdown">
                        <a href="javascript:void(0)" class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          SMS
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                          <li><a href="{{ route("partner.index") }}">All Messages</a></li>
                          <li><a href="{{ route("comunication.send_sms") }}">Send Message</a></li>
                          <li><a href="{{ route("comunication.sms_template") }}">Message Template</a></li>
                          <li><a href="{{ route("comunication.sms-originators") }}">Originators</a></li>
                          <li><a href="{{ route("comunication.sms_confirm_code") }}">Confirmation Code</a></li>
                          <li><a href="{{ route("comunication.sms_message_history") }}">Message History</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route("partner.industry") }}">Email</a>
                    </li>
                    <li>
                        <a href="{{ route("comunication.send_push_notification") }}">Push Notifications</a>
                    </li>
                    <li>
                        <a href="{{ route("comunication.message-parameter") }}">Message Parameters</a>
                    </li>
                    <li>
                        <a href="{{ route("comunication.manage_tasty_group") }}">Manage Tasty Group</a>
                    </li>
                    <li>
                        <a href="{{ route("comunication.tasty_lovers") }}">Tasty Lovers</a>
                    </li>

                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>