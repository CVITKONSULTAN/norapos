<ul class="nav navbar-nav">
    <li class="{{Request::URL() == route("tastypointsapi.geosettings") ? "active" : "" }}">
      <a href="{{ route("tastypointsapi.geosettings") }}">@lang('tastypointsapi::lang.country')</a>
    </li>
    <li class="{{Request::URL() == route("tastypointsapi.geosettings.state") ? "active" : "" }}">
      <a href="{{ route("tastypointsapi.geosettings.state") }}">State</a>
    </li>
    <li class="{{Request::URL() == route("tastypointsapi.geosettings.city") ? "active" : "" }}">
        <a href="{{ route("tastypointsapi.geosettings.city") }}">City</a>
    </li>
    <li class="{{Request::URL() == route("tastypointsapi.geosettings.subcity") ? "active" : "" }}">
        <a href="{{ route("tastypointsapi.geosettings.subcity") }}">Sub City Areas</a>
    </li>
    <li class="{{Request::URL() == route("tastypointsapi.geosettings.language") ? "active" : "" }}">
        <a href="{{ route("tastypointsapi.geosettings.language") }}">Language</a>
    </li>
    <li class="{{Request::URL() == route("tastypointsapi.geosettings.currency") ? "active" : "" }}">
        <a href="{{ route("tastypointsapi.geosettings.currency") }}">Currency</a>
    </li>
    <li class="{{Request::URL() == route("tastypointsapi.geosettings.timezone") ? "active" : "" }}">
        <a href="{{ route("tastypointsapi.geosettings.timezone") }}">Timezone</a>
    </li>
</ul>