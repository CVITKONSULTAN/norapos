@extends('tastypointsapi::communications.partials.master')
@section( 'page_name', "Communications - Tasty Lovers")

@section('page_css')
    <style>
        .table_data{
            clear: both;
        }
        .image_user{
            border-radius: 10px;
            height: 50px;
            width: 50px;
        }
        .table_dom{
            width: 100%;
        }
        .table_dom tr th{
            padding: 10px 15px;
            background: #bbd2fe;
            color: #0f1d59;
        }
        .table_dom tr td{
            padding: 10px 15px;
        }
        .first_col{
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .end_col{
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .image_preview{
            border-radius: 100px;
            height: 100px;
            width: 100px;
        }
        .profile_thumb{
            text-align: center;
        }
        .profile_thumb h5{
            font-weight: bold;
            margin-top: 10px;
        }
        .action_control{
            text-align: center;
        }
        .action_control i{
            padding: 10px 10px;
            background: #bbd2fe;
            border-radius: 100px;
        }
        .achivements {
            margin-top: 20px;
        }
        .achivements .hint_text {
            font-size: 9pt;
            text-align: right;
            margin-bottom: 0px;
        }
        .achivements .progress {
            height: 10px;
        }
        .achivements .detail_points p {
            text-align: center;
            font-weight: bold;
            font-size: 13pt;
        }
        .most_engage{
            margin-top: 20px;
        }
        .most_engage > ul{
            list-style-type: none;
            padding-left: 0px;
        }
        .most_engage > ul > li {
            margin: 10px 0px;
        }
        .most_engage > ul > li > i {
            margin-right: 10px;
        }
        .most_engage > ul > li > span {
            float: right;
        }
        .most_engage > .title {
            font-weight: bold;
            font-size: 13pt;
        }
    </style>
@endsection

@section('content-header',"Tasty Lovers")

@section('main_content')

    <div class="main_page">
        <div class="row">
            <div class="col-md-9">
                <div class="filter_data">
                    <div class="pull-left">
                        <div class="form-group">
                            <select class="form-control" style="border: none;">
                                <option value="" selected disabled>Sort by status</option>
                            </select>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="form-inline">
                            <div class="form-group">
                                <div class="input-group">
                                    <input style="
                                            border-top-left-radius: 10px;
                                            border-bottom-left-radius: 10px;
                                            background: #eaeaea;
                                            border-right: none;
                                    " class="form-control" placeholder="Search" />
                                    <span style="
                                            border-top-right-radius: 10px;
                                            border-bottom-right-radius: 10px;
                                            background: #eaeaea;
                                            border-right: none;
                                    " class="input-group-addon"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                            <p style="display: inline-block;font-weight:bold;">Total patients : 57</p>
                        </div>
                    </div>
                </div>
                <div class="table_data">
                    <table class="table_dom">
                        <thead>
                            <tr>
                                <th class="first_col"> <input type="checkbox" /> </th>
                                <th></th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Status</th>
                                <th>Last Measurement</th>
                                <th>Last Visit</th>
                                <th class="end_col">Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 11; $i++)
                                <tr>
                                    <td> <input type="checkbox" /> </td>
                                    <td> <img class="image_user" src="https://www.hellobeauty.id/storage/images/cache/1cd2f08830fdc4ebf05973eb787d7b0b-250-250.png" /> </td>
                                    <td>David</td>
                                    <td>Barlett</td>
                                    <td>Active</td>
                                    <td>144/91<br/> xxx</td>
                                    <td>May 27, 2021</td>
                                    <td>
                                        <i class="fas fa-phone-alt"></i>
                                        <i class="fas fa-envelope"></i>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-3">
                <div class="profile_thumb">
                    <img class="image_preview" src="http://imoblar.com/site/img/demo/profile.jpg" />
                    <h5>David Barlett</h5>
                    <p>david.barlett@gmail.com</p>
                </div>
                <div class="action_control">
                    <i class="fas fa-cog"></i>
                    <i class="fas fa-envelope"></i>
                    <i class="fas fa-user"></i>
                </div>
                <div class="achivements">
                    <p class="hint_text">Engagement Rate 30/100%</p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-aqua" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                          <span class="sr-only">20% Complete</span>
                        </div>
                    </div>
                    <div class="row detail_points">
                        <div class="col-md-4">
                            <p>12</p>
                            <p>Points</p>
                        </div>
                        <div class="col-md-4">
                            <p>22</p>
                            <p>Cash</p>
                        </div>
                        <div class="col-md-4">
                            <p>243</p>
                            <p>Rewards</p>
                        </div>
                    </div>
                </div>
                <div class="most_engage">
                    <p class="title">Most Engagement</p>
                    <ul>
                        <li>
                            <i style="color: purple;" class="fas fa-circle-notch"></i> 
                            Marketing 
                            <span>80%</span>
                        </li>
                        <li>
                            <i style="color: red;" class="fas fa-circle-notch"></i> 
                            Stamps
                            <span>70%</span>
                        </li>
                        <li>
                            <i style="color: orange;" class="fas fa-circle-notch"></i> 
                            Take Out
                            <span>60%</span>
                        </li>
                        <li>
                            <i style="color: blue;" class="fas fa-circle-notch"></i> 
                            Discounts
                            <span>50%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')
    
@endsection