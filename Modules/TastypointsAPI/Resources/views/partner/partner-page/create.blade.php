@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Add new partner")

@section('page_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css" />
    <style>
        .table_container{
            margin-top: 20px;
        }
        #add_new{
            margin-right: 20px;
        }
        .action_form{
            padding-top: 25px;
        }
    </style>
    <style>

        #image_editor{
            /* Ensure the size of the image fit the container perfectly */
            display: block;

            /* This rule is very important, please don't ignore this */
            max-width: 100%;
        }

        .docs-demo {
            margin-bottom: 1rem;
            overflow: hidden;
            padding: 2px;
        }

        .img-container,
        .img-preview {
            background-color: #f7f7f7;
            text-align: center;
            width: 100%;
        }

        .img-container {
            max-height: 497px;
            min-height: 200px;
        }

        @media (min-width: 768px) {
            .img-container {
                min-height: 497px;
            }
        }

        .img-preview {
            float: left;
            margin-bottom: 0.5rem;
            margin-right: 0.5rem;
            overflow: hidden;
        }

        .img-container > img {
            max-width: 100%;
        }

        .docs-preview {
            margin-right: -1rem;
            padding-top: 10px;
        }

        .preview-lg {
            height: 9rem;
            width: 16rem;
        }

        .preview-md {
            height: 4.5rem;
            width: 8rem;
        }

        .preview-sm {
            height: 2.25rem;
            width: 4rem;
        }

        .preview-xs {
            height: 1.125rem;
            margin-right: 0;
            width: 2rem;
        }

        .docs-data {
            margin: 10px 0px;
        }

        #image_editor_container {
            margin: 10px 0px;
        }

        .docs-toolbar{
            margin: 20px 0px;
            text-align: center;
        }
    </style>
    <style>
        .oh_item{
            display: inline-block;
            vertical-align: middle;
            background-color: #2b80ec;
            color: white;
            border-radius: 5px;
            padding: 5px 20px;
            cursor: pointer;
            margin-right: 5px;
        }
        .oh_item:hover{
            background-color: #2f75ce;
        }
        .oh_item.active {
            background-color: gray;
        }
        #map{
            width: 100%;
            height: 73vh;
            margin: 10px 0px;
        }
        .oh_container{
            padding: 10px 0px;
            overflow-x: auto;
            overflow-y: hidden;
            width: 100%;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        .d-inline{
            display: inline-block;
            vertical-align: middle;
        }
        .lock_time{
            width: 40%;
            margin: 10px 0px;
        }
        .search_location{
            width: 50%;
            margin-top: 15px;
        }
        .mt-10{
            margin-top: 10px;
        }
        .clear_btn{
            margin-top: 35px !important;
        }
        .select2-selection{
            min-height: 34px !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" />
    <style>
        .d-none{
            display: none !important;
        }
        #drop-area, #drop-area-logo{
            width: 200px;
            height: 200px;
            display: inline-block;
            /* margin: 10px 5px; */
            vertical-align: middle;
            border: 2px black dotted;
            background-color: #f1f2f6;
            text-align: center;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        .drop-content{
            margin-top: 25%;
        }
        #list-preview-image, #list-preview-logo{
            display: inline-block;
            vertical-align: middle;
            overflow-y: hidden;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 75%;
            white-space: nowrap;
        }
        #list-preview-logo{
            width: 200px;
        }
        .drop-item{
            position: relative;
            display: inline-block;
            vertical-align: middle;
            /* width: 200px; */
            height: 200px;
            /* padding-top: 7px; */
            padding-left: 10px;
            cursor: pointer;
        }
        .dropzone{
            height: 100%;
        }
        .font-blue{
            color: #3c8dbc;
            font-weight: bold;
        }
        .image_uploaded{
            height: 100%;
            width: 100%;
        }
        .drop-overlay{
            position: absolute; 
            bottom: 0; 
            background: rgb(255 255 255 / 0.5);
            color: #f1f1f1; 
            height: 200px;
            width: 100%;
            line-height: 150px;
            transition: .5s ease;
            opacity:0;
            color: red !important;
            font-size: 20px;
            padding: 20px;
            text-align: center;
        }
        .drop-overlay > a {
            color: red !important;
        }

        .drop-item:hover .drop-overlay {
            opacity: 1;
        }

        .overlay {
            position: absolute; 
            bottom: 0; 
            background: rgb(0, 0, 0);
            background: rgba(0, 0, 0, 0.5); /* Black see-through */
            color: #f1f1f1; 
            width: 100%;
            height:100%;
            transition: .5s ease;
            opacity:0;
            color: white;
            font-size: 20px;
            padding: 20px;
            text-align: center;
        }
    </style>

    <style>
        #list_delivery{
            margin: 10px 0px;
        }
        .delivery_item{
            display: inline-block;
            margin-right: 10px;
        }
        .delivery_item > .item_text {
            background-color: #3c8dbc;
            border-color: #367fa9;
            padding: 1px 10px;
            color: #fff;
            display: inline-block;
            margin-right: 5px;
            border: 1px solid #aaa;
            border-radius: 4px;
            cursor: default;
        }
        .delivery_item > .delivery_field {
            display: inline-block;
        }
        .remove_data{
            cursor: pointer;
        }
    </style>
@endsection

@section('content-header',"Add New Business")

@section('content-subheader')
    <small>(Business owner can change their business details)</small>
@endsection

@section('main_content')

    <div class="main_page">
        <h3>Payments</h3>
        <div class="text-right">
            {{-- <button class="btn btn-primary" id="open_staff"><i class="fas fa-plus"></i> Add</button> --}}
        </div>
        <div class="table_container">
            <table class="table table-bordered table-striped table_data" 
            {{-- id="company_staff" --}}
            >
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Photo Selected</th>
                        <th>Fee</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('new-box')
    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="text-right">
                    <button onclick="$('#form_data').trigger('submit')" class="btn btn-success"> <i class="fas fa-save"></i> SUBMIT </button>
                </div>
                <form id="form_data">
                    <input type="hidden" name="item_id" value="0" />
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="text">Business Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                                    <input required type="text" class="form-control" placeholder="Business Name" name="name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">Start Date</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                                    <input disabled name="date_created" value="" type="text" class="form-control" placeholder="Start Date" />
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <label for="text">Upload Logo</label>
                                <div class="input-group">
                                    <input id="logo_link" readonly name="logo_link" type="text" class="form-control" placeholder="" required />
                                    <span class="input-group-btn">
                                        <button id="upload_logo" class="btn btn-primary" type="button"><i class="fas fa-folder-open"></i> Browse..</button>
                                    </span>
                                    <input accept="image/*" type="file" name="file" class="d-none" id="logo_file" />
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label for="text">Country</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-globe"></i></span>
                                    <select required class="form-control" name="country_id" id="country_id">
                                        <option value="" selected disabled>Select Country</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">City</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-city"></i></span>
                                    <select required class="form-control" name="city_id" id="city_id">
                                        <option value="" selected disabled>Select City</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">State</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-city"></i></span>
                                    <select disabled class="form-control" name="state_id" id="state_id">
                                        <option selected value="0">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">This location is a branch of</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-map-marker"></i></span>
                                    <input required  name="hq_branch_id" type="text" class="form-control" placeholder="the all in one cafe" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">Address</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-map-marker"></i></span>
                                    <input required  name="address" type="text" class="form-control" placeholder="" />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Map Location (lat)</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker"></i></span>
                                            <input id="location_lat" readonly required name="location[lat]" type="text" class="form-control" placeholder="Latitude" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>(long)</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-map-marker"></i></span>
                                            <input id="location_lon" readonly required name="location[lon]" type="text" class="form-control" placeholder="Latitude" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input
                                id="pac-input"
                                class="form-control search_location"
                                type="text"
                                placeholder="Searching near location..."
                            />
                            <div id="map">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="text">Website</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-globe"></i></span>
                                    <input type="url" name="general_website" required type="text" class="form-control" placeholder="Website" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">Currency</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-money-bill-alt"></i></span>
                                    <select readonly name="currency_id" required class="form-control" id="currency_id">
                                        <option value="" selected disabled>Select Currency</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tax %</label>
                                <input type="number" name="tax" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="text">Language</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-language"></i></span>
                                    <select name="language_id" required class="form-control" id="language_id">
                                        <option value="" selected disabled>Select Language</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">Industry</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-industry"></i></span>
                                    <select required class="form-control" name="industry_id" id="industry_id">
                                        <option value="" selected disabled>Select Industry</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">Zip code</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-map-marker"></i></span>
                                    <input name="zip_code" required type="text" class="form-control" placeholder="Zip/Postal Code" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">Business contact number</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-phone-alt"></i></span>
                                    <input name="phone" required type="text" class="form-control" placeholder="Business contact number" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">Alternate contact number</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-phone-alt"></i></span>
                                    <input name="alternate_phone" type="text" class="form-control" placeholder="Alternate contact number" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="text">Time zone:</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-clock"></i></span>
                                    <select disabled class="form-control" id="time_zone" name="timezone_id">
                                        <option selected value="" disabled>Select Timezone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Business description :</label>
                                <textarea name="description" class="form-control" required rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="text">Delivery Option :</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-shipping-fast"></i></span>
                                    <select required class="form-control" id="delivery_option" multiple="multiple" name="delivery[]"></select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button">Add Delivery Options</button>
                                    </span>
                                </div>
                                <div id="list_delivery"></div>
                            </div>
                            <div class="form-group">
                                <label>Opening Hours : </label>
                                <div class="oh_container" id="oh_content"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form_time">
                                        <label>Morning time :</label>
                                        <div class="time_container">
                                            <div class="time_content">
                                                <div class="lock_time d-inline">
                                                    <div class="input-group">
                                                        <input type="time" id="morning_open" class="form-control" placeholder="08:30 PM"/>
                                                    </div>
                                                </div>
                                                <p class="d-inline mt-10"><strong>to</strong></p>
                                                <div class="lock_time d-inline">
                                                    <div class="input-group">
                                                        <input type="time" id="morning_close" class="form-control" placeholder="08:30 PM"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-md-5">
                                    <div class="form_time">
                                        <label>Afternoon time :</label>
                                        <div class="time_container">
                                            <div class="time_content">
                                                <div class="lock_time d-inline">
                                                    <div class="input-group">
                                                        <input type="time" id="afternoon_open" class="form-control" placeholder="08:30 PM"/>
                                                    </div>
                                                </div>
                                                <p class="d-inline mt-10"><b>to</b></p>
                                                <div class="lock_time d-inline">
                                                    <div class="input-group">
                                                        <input type="time" id="afternoon_close" class="form-control" placeholder="08:30 PM"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-md-2" style="margin-top: 35px;padding:0px;">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="saveOh()">Save</button>
                                    <button type="button" class="btn btn-primary btn-sm" onclick="clearOh()">Clear</button>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>WIFI Option</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-wifi"></i></span>
                                            <select name="wifi" required class="form-control">
                                                <option value="1">Available</option>
                                                <option value="0">Unavailable</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Partner Type</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                            <select id="partner_type_id" name="partner_type_id" required class="form-control">
                                                <option value="" disabled selected>Select Partner Type</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="text">Partners Group :</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                        <select required class="form-control" id="partner_groups" name="partner_groups"></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Business Status</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                                            <select id="business_status" name="status_id" required class="form-control">
                                                <option value="" disabled selected>Select Status</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Assign POS Terminal</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-calculator"></i></span>
                                            <input name="pos_terminal[serial_number]" type="text" class="form-control" placeholder="Activation code here">
                                            <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Send Code</button>
                                            </span>
                                        </div><!-- /input-group -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>POS Serial Number</label>
                                        <div class="input-group">
                                            <input name="pos_terminal[code]" type="text" class="form-control">
                                            <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button">Add Serial #</button>
                                            </span>
                                        </div><!-- /input-group -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Access Token</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-info"></i></span>
                                            <input name="access_token" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Points to Dollar Step</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-info"></i></span>
                                            <input type="number" name="point_dollar_step" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Points Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-info"></i></span>
                                            <input type="number" name="point_amount" required class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Username</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                            <input name="username" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Password:*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                            <input id="password" name="password" type="password" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Staff Points</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                            <input type="number" name="staff_points" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password:*</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                            <input name="password_confirm" required type="password" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr/>
                        </div>
                        <div class="col-md-12">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tag Icon Link</label>
                                        <input name="tag_icon_link" type="url" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tag Icon Text</label>
                                        <input name="tag_icon_text" type="text" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Shop Web Link</label>
                                        <input name="shop_web_link" type="url" class="form-control" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-4">
                        <div class="drop-container">
                            <div class="form-group" style="width:200px;">
                                <select class="form-control">
                                    <option value="1" selected>LOGO</option>
                                </select>
                            </div>
                            <div id="drop-area-logo">
                                <div class="drop-content">
                                    <i class="fas fa-image fa-3x"></i>
                                    <p>
                                        Drop image here,
                                        <br/>
                                        <span class="font-blue">Select from library</span>
                                            or 
                                        <span class="font-blue">Upload</span>
                                    </p>
                                </div>
                            </div>

                            <div id="list-preview-logo"></div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="drop-container">
                            <div class="form-group" style="width:200px;">
                                <select class="form-control image_type" id="select_photo_type">
                                    {{-- <option value="" disabled selected>Select Photo Type</option> --}}
                                </select>
                            </div>
                            <div id="drop-area">
                                <div class="drop-content">
                                    <i class="fas fa-image fa-3x"></i>
                                    <p>
                                        Drop image here,
                                        <br/>
                                        <span class="font-blue">Select from library</span>
                                            or 
                                        <span class="font-blue">Upload</span>
                                    </p>
                                </div>
                            </div>

                            <div id="list-preview-image"></div>
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div id="image_editor_container" class="img-container">
                            <img id="image_editor" src="/images/testing.jpeg">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <!-- <h3>Preview:</h3> -->
                        <div class="docs-preview clearfix">
                        <div class="img-preview preview-lg"></div>
                        <div class="img-preview preview-md"></div>
                        <div class="img-preview preview-sm"></div>
                        <div class="img-preview preview-xs"></div>
                        </div>
                
                        <!-- <h3>Data:</h3> -->
                        <div class="docs-data">
                            <button type="button" id="save_image" style="margin-bottom: 10px;" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Apply Image </button>
                            <div class="form-group" id="image_type_editor">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-camera"></i></span>
                                    <select class="form-control image_type">
                                        <option value="" disabled selected>Select Photo Type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">X</span>
                                    <input id="dataX" type="number" class="form-control" />
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Y</span>
                                    <input id="dataY" type="number" class="form-control" />
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Width</span>
                                    <input id="dataWidth" type="number" class="form-control" />
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Height</span>
                                    <input id="dataHeight" type="number" class="form-control" />
                                    <span class="input-group-addon">px</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Rotate</span>
                                    <input id="dataRotate" type="number" class="form-control" />
                                    <span class="input-group-addon">deg</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">ScaleX</span>
                                    <input id="dataScaleX" type="number" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">ScaleX</span>
                                    <input id="dataScaleY" type="number" class="form-control" />
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-12">
                        <div class="row" id="actions">

                            <div class="col-md-9 docs-buttons text-center">
                                <!-- <h3>Toolbar:</h3> -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;move&quot;)">
                                        <span class="fa fa-arrows-alt"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.setDragMode(&quot;crop&quot;)">
                                        <span class="fa fa-crop-alt"></span>
                                    </span>
                                    </button>
                                </div>
                        
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(0.1)">
                                        <span class="fa fa-search-plus"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.zoom(-0.1)">
                                        <span class="fa fa-search-minus"></span>
                                    </span>
                                    </button>
                                </div>
                        
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(-10, 0)">
                                        <span class="fa fa-arrow-left"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(10, 0)">
                                        <span class="fa fa-arrow-right"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, -10)">
                                        <span class="fa fa-arrow-up"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.move(0, 10)">
                                        <span class="fa fa-arrow-down"></span>
                                    </span>
                                    </button>
                                </div>
                        
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(-45)">
                                        <span class="fa fa-undo-alt"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.rotate(45)">
                                        <span class="fa fa-redo-alt"></span>
                                    </span>
                                    </button>
                                </div>
                        
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleX(-1)">
                                        <span class="fa fa-arrows-alt-h"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.scaleY(-1)">
                                        <span class="fa fa-arrows-alt-v"></span>
                                    </span>
                                    </button>
                                </div>
                        
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.crop()">
                                        <span class="fa fa-check"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.clear()">
                                        <span class="fa fa-times"></span>
                                    </span>
                                    </button>
                                </div>
                        
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.disable()">
                                        <span class="fa fa-lock"></span>
                                    </span>
                                    </button>
                                    <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.enable()">
                                        <span class="fa fa-unlock"></span>
                                    </span>
                                    </button>
                                </div>
                                <input type="hidden" class="sr-only" id="inputImage" name="file" accept="image/*">
                                {{-- <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
                                        <span class="fa fa-sync-alt"></span>
                                    </span>
                                    </button>
                                    <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                                    <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                                        <span class="fa fa-upload"></span>
                                    </span>
                                    </label>
                                    <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
                                    <span class="docs-tooltip" data-toggle="tooltip" title="cropper.destroy()">
                                        <span class="fa fa-power-off"></span>
                                    </span>
                                    </button>
                                </div> --}}

                                <!-- Show the cropped image in modal -->
                                <div class="modal fade docs-cropped" id="getCroppedCanvasModal" role="dialog" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="getCroppedCanvasTitle">Cropped</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body"></div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <a class="btn btn-primary" id="download" href="javascript:void(0);" download="cropped.jpg">Download</a>
                                        </div>
                                    </div>
                                    </div>
                                </div><!-- /.modal -->

                                <div class="docs-toggles" style="display: inline;">
                                    
                                    <!-- <h3>Toggles:</h3> -->
                                    <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                                        <label class="btn btn-primary active">
                                            <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 16 / 9">
                                            16:9
                                            </span>
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 4 / 3">
                                            4:3
                                            </span>
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 1 / 1">
                                            1:1
                                            </span>
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: 2 / 3">
                                            2:3
                                            </span>
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="aspectRatio: NaN">
                                            Free
                                            </span>
                                        </label>
                                    </div>
                            
                                    <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
                                        <label class="btn btn-primary active">
                                            <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked>
                                            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 0">
                                            VM0
                                            </span>
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 1">
                                            VM1
                                            </span>
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 2">
                                            VM2
                                            </span>
                                        </label>
                                        <label class="btn btn-primary">
                                            <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
                                            <span class="docs-tooltip" data-toggle="tooltip" title="View Mode 3">
                                            VM3
                                            </span>
                                        </label>
                                    </div>
                            
                                    <div class="dropdown dropup docs-options" style="display: inline;">
                                        <button type="button" class="btn btn-primary dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
                                            Toggle Options
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="toggleOptions">
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="responsive" type="checkbox" name="responsive" checked>
                                                <label class="form-check-label" for="responsive">responsive</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="restore" type="checkbox" name="restore" checked>
                                                <label class="form-check-label" for="restore">restore</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="checkCrossOrigin" type="checkbox" name="checkCrossOrigin" checked>
                                                <label class="form-check-label" for="checkCrossOrigin">checkCrossOrigin</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="checkOrientation" type="checkbox" name="checkOrientation" checked>
                                                <label class="form-check-label" for="checkOrientation">checkOrientation</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="modal" type="checkbox" name="modal" checked>
                                                <label class="form-check-label" for="modal">modal</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="guides" type="checkbox" name="guides" checked>
                                                <label class="form-check-label" for="guides">guides</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="center" type="checkbox" name="center" checked>
                                                <label class="form-check-label" for="center">center</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="highlight" type="checkbox" name="highlight" checked>
                                                <label class="form-check-label" for="highlight">highlight</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="background" type="checkbox" name="background" checked>
                                                <label class="form-check-label" for="background">background</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="autoCrop" type="checkbox" name="autoCrop" checked>
                                                <label class="form-check-label" for="autoCrop">autoCrop</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="movable" type="checkbox" name="movable" checked>
                                                <label class="form-check-label" for="movable">movable</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="rotatable" type="checkbox" name="rotatable" checked>
                                                <label class="form-check-label" for="rotatable">rotatable</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="scalable" type="checkbox" name="scalable" checked>
                                                <label class="form-check-label" for="scalable">scalable</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="zoomable" type="checkbox" name="zoomable" checked>
                                                <label class="form-check-label" for="zoomable">zoomable</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="zoomOnTouch" type="checkbox" name="zoomOnTouch" checked>
                                                <label class="form-check-label" for="zoomOnTouch">zoomOnTouch</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="zoomOnWheel" type="checkbox" name="zoomOnWheel" checked>
                                                <label class="form-check-label" for="zoomOnWheel">zoomOnWheel</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="cropBoxMovable" type="checkbox" name="cropBoxMovable" checked>
                                                <label class="form-check-label" for="cropBoxMovable">cropBoxMovable</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="cropBoxResizable" type="checkbox" name="cropBoxResizable" checked>
                                                <label class="form-check-label" for="cropBoxResizable">cropBoxResizable</label>
                                            </div>
                                            </li>
                                            <li class="dropdown-item">
                                            <div class="form-check">
                                                <input class="form-check-input" id="toggleDragModeOnDblclick" type="checkbox" name="toggleDragModeOnDblclick" checked>
                                                <label class="form-check-label" for="toggleDragModeOnDblclick">toggleDragModeOnDblclick</label>
                                            </div>
                                            </li>
                                        </ul>
                                    </div><!-- /.dropdown -->
                            
                                </div><!-- /.docs-toggles -->

                                <button class="btn btn-success btn-block mt-10" id="submitForm"><i class="fas fa-save"></i> SUBMIT</button>
                            
                            </div>
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="main_page">
                    <h3>Branch Locations</h3>
                    <div class="text-right">
                        {{-- <button class="btn btn-primary"><i class="fas fa-plus"></i> Add</button> --}}
                    </div>
                    <div class="table_container">
                        <table class="table table-bordered table-striped table_data">
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <div tabindex="-1" class="modal fade docs-cropped" id="add_new_staff" role="dialog" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Add new staff</h4>
                        </div>
                        <form id="form_staff">
                            @csrf
                            <input type="hidden" name="item_id" value="0" />
                            <input type="hidden" name="tpartner_id" value="1" />
                            <div class="modal-body">
            
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Tasty Lover ID:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                                <input name="tid" required type="number" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Business Name:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                                                <input 
                                                readonly 
                                                name="tpartner_name" type="text" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Staff Status:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                                <select required name="staff_status" class="form-control">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Direct Phone #:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-phone-alt"></i></span>
                                                <input required name="direct_phone_num" type="number" class="form-control" placeholder="Alternate contact number" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Extension #:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-user"></i></span>
                                                <input required name="extension_num" type="number" placeholder="Extension number" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Email:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                                                <input required name="company_email" type="text" placeholder="Email" type="email" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text">Prefix:</label>
                                            <input name="prefix" type="text" placeholder="Mr / Mrs / Miss" 
                                            readonly 
                                            class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text">First Name:*</label>
                                            <input name="staff_first_name" type="text" placeholder="First Name" 
                                            readonly 
                                            class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text">Middle Name:</label>
                                            <input name="staff_middle_name" type="text" placeholder="Middle name" 
                                            readonly 
                                            class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text">Last Name:</label>
                                            <input name="staff_last_name" type="text" placeholder="Last Name" 
                                            readonly 
                                            class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Staff Title:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                                <select id="staff_title_id" name="staff_title_id" class="form-control">
                                                    <option>Select staff title</option>
                                                    {{-- <option value="1">COO</option>
                                                    <option value="2">CEO</option>
                                                    <option value="3">COQ</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Admin Level:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-users"></i></span>
                                                <select name="admin_level_id" id="admin_level"
                                                {{-- readonly  --}}
                                                class="form-control">
                                                    <option disabled selected>Select admin level</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="text">Pin:</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fas fa-info"></i></span>
                                                <input type="number" required name="pin" class="form-control" placeholder="Staff pin" />
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary" type="button"><i class="fas fa-random"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div><!-- /.modal -->
            
                <div class="modal fade" id="modals-debug">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <h4 class="modal-title">Modals Debug</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p>Request</p>
                                        <p id="json_req"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p>Response</p>
                                        <p id="json_res"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="main_page">
                    <h3>Company Staff</h3>
                    <div class="text-right">
                        {{-- <button class="btn btn-primary" id="open_staff"><i class="fas fa-plus"></i> Add</button> --}}
                    </div>
                    <div class="table_container">
                        <table class="table table-bordered table-striped table_data" 
                        {{-- id="company_staff" --}}
                        >
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Staff Title</th>
                                    <th>Admin Level</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.js"></script>

    <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBG7iJabCnW3Hn2GAAk7lgcTBox7igfJq4&callback=initialize&libraries=geometry,places&v=weekly"
    defer
    ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"></script>
    <script>

            var Cropper = window.Cropper;
            var URL = window.URL || window.webkitURL;
            var container = document.querySelector('.img-container');
            var image = container.getElementsByTagName('img').item(0);
            var download = document.getElementById('download');
            var actions = document.getElementById('actions');
            var dataX = document.getElementById('dataX');
            var dataY = document.getElementById('dataY');
            var dataHeight = document.getElementById('dataHeight');
            var dataWidth = document.getElementById('dataWidth');
            var dataRotate = document.getElementById('dataRotate');
            var dataScaleX = document.getElementById('dataScaleX');
            var dataScaleY = document.getElementById('dataScaleY');
            var options = {
                aspectRatio: 16 / 9,
                preview: '.img-preview',
                ready: function (e) {
                console.log(e.type);
                },
                cropstart: function (e) {
                console.log(e.type, e.detail.action);
                },
                cropmove: function (e) {
                console.log(e.type, e.detail.action);
                },
                cropend: function (e) {
                console.log(e.type, e.detail.action);
                },
                crop: function (e) {
                var data = e.detail;

                console.log(e.type);
                dataX.value = Math.round(data.x);
                dataY.value = Math.round(data.y);
                dataHeight.value = Math.round(data.height);
                dataWidth.value = Math.round(data.width);
                dataRotate.value = typeof data.rotate !== 'undefined' ? data.rotate : '';
                dataScaleX.value = typeof data.scaleX !== 'undefined' ? data.scaleX : '';
                dataScaleY.value = typeof data.scaleY !== 'undefined' ? data.scaleY : '';
                },
                zoom: function (e) {
                console.log(e.type, e.detail.ratio);
                }
            };
            var cropper = new Cropper(image, options);
            var originalImageURL = image.src;
            var uploadedImageType = 'image/jpeg';
            var uploadedImageName = 'cropped.jpg';
            var uploadedImageURL;

            // Tooltip
            $('[data-toggle="tooltip"]').tooltip();

            // Buttons
            if (!document.createElement('canvas').getContext) {
                $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
            }

            if (typeof document.createElement('cropper').style.transition === 'undefined') {
                $('button[data-method="rotate"]').prop('disabled', true);
                $('button[data-method="scale"]').prop('disabled', true);
            }

            // Download
            if (typeof download.download === 'undefined') {
                download.className += ' disabled';
                download.title = 'Your browser does not support download';
            }

            // Options
            actions.querySelector('.docs-toggles').onchange = function (event) {
                var e = event || window.event;
                var target = e.target || e.srcElement;
                var cropBoxData;
                var canvasData;
                var isCheckbox;
                var isRadio;

                if (!cropper) {
                return;
                }

                if (target.tagName.toLowerCase() === 'label') {
                target = target.querySelector('input');
                }

                isCheckbox = target.type === 'checkbox';
                isRadio = target.type === 'radio';

                if (isCheckbox || isRadio) {
                if (isCheckbox) {
                    options[target.name] = target.checked;
                    cropBoxData = cropper.getCropBoxData();
                    canvasData = cropper.getCanvasData();

                    options.ready = function () {
                    console.log('ready');
                    cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                    };
                } else {
                    options[target.name] = target.value;
                    options.ready = function () {
                    console.log('ready');
                    };
                }

                // Restart
                cropper.destroy();
                image.src = active_image;
                cropper = new Cropper(image, options);
                }
            };

            // Methods
            actions.querySelector('.docs-buttons').onclick = function (event) {
                var e = event || window.event;
                var target = e.target || e.srcElement;
                var cropped;
                var result;
                var input;
                var data;

                if (!cropper) {
                return;
                }

                while (target !== this) {
                if (target.getAttribute('data-method')) {
                    break;
                }

                target = target.parentNode;
                }

                if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
                return;
                }

                data = {
                method: target.getAttribute('data-method'),
                target: target.getAttribute('data-target'),
                option: target.getAttribute('data-option') || undefined,
                secondOption: target.getAttribute('data-second-option') || undefined
                };

                cropped = cropper.cropped;

                if (data.method) {
                if (typeof data.target !== 'undefined') {
                    input = document.querySelector(data.target);

                    if (!target.hasAttribute('data-option') && data.target && input) {
                    try {
                        data.option = JSON.parse(input.value);
                    } catch (e) {
                        console.log(e.message);
                    }
                    }
                }

                switch (data.method) {
                    case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        cropper.clear();
                    }

                    break;

                    case 'getCroppedCanvas':
                    try {
                        data.option = JSON.parse(data.option);
                    } catch (e) {
                        console.log(e.message);
                    }

                    if (uploadedImageType === 'image/jpeg') {
                        if (!data.option) {
                        data.option = {};
                        }

                        data.option.fillColor = '#fff';
                    }

                    break;
                }

                result = cropper[data.method](data.option, data.secondOption);

                switch (data.method) {
                    case 'rotate':
                    if (cropped && options.viewMode > 0) {
                        cropper.crop();
                    }

                    break;

                    case 'scaleX':
                    case 'scaleY':
                    target.setAttribute('data-option', -data.option);
                    break;

                    case 'getCroppedCanvas':
                    if (result) {
                        // Bootstrap's Modal
                        $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

                        if (!download.disabled) {
                        download.download = uploadedImageName;
                        download.href = result.toDataURL(uploadedImageType);
                        }
                    }

                    break;

                    case 'destroy':
                    cropper = null;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                        uploadedImageURL = '';
                        image.src = originalImageURL;
                    }

                    break;
                }

                if (typeof result === 'object' && result !== cropper && input) {
                    try {
                    input.value = JSON.stringify(result);
                    } catch (e) {
                    console.log(e.message);
                    }
                }
                }
            };

            document.body.onkeydown = function (event) {
                var e = event || window.event;

                if (e.target !== this || !cropper || this.scrollTop > 300) {
                return;
                }

                switch (e.keyCode) {
                case 37:
                    e.preventDefault();
                    cropper.move(-1, 0);
                    break;

                case 38:
                    e.preventDefault();
                    cropper.move(0, -1);
                    break;

                case 39:
                    e.preventDefault();
                    cropper.move(1, 0);
                    break;

                case 40:
                    e.preventDefault();
                    cropper.move(0, 1);
                    break;
                }
            };

            // Import image
            var inputImage = document.getElementById('inputImage');

            if (URL) {
                inputImage.onchange = function () {
                var files = this.files;
                var file;

                if (files && files.length) {
                    file = files[0];

                    if (/^image\/\w+/.test(file.type)) {
                    uploadedImageType = file.type;
                    uploadedImageName = file.name;

                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }

                    image.src = uploadedImageURL = URL.createObjectURL(file);

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(image, options);
                    inputImage.value = null;
                    } else {
                    window.alert('Please choose an image file.');
                    }
                }
                };
            } else {
                inputImage.disabled = true;
                inputImage.parentNode.className += ' disabled';
            }



    </script>

    <script>

        $(".table_data").DataTable({
            dom: "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'colvis',
                'csvHtml5',
                'pdfHtml5'
            ],
            responsive:true,
        });

        let marker = null;

        function handleEventMarker(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            $("#location_lat").val(lat);
            $("#location_lon").val(lng);
        }

        function initialize() {

            let myLatlng = { lat: -33.8688, lng: 151.2195 };

            const map = new google.maps.Map(document.getElementById("map"), {
                center: myLatlng,
                zoom: 13,
                mapTypeId: "roadmap",
            });

            $("#location_lat").val(myLatlng.lat);
            $("#location_lon").val(myLatlng.lng);

            // Place a draggable marker on the map
            marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                draggable:true,
                title:"Drag me!"
            });

            marker.addListener('drag', handleEventMarker);
            marker.addListener('dragend', handleEventMarker);

            // Create the search box and link it to the UI element.
            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            // Bias the SearchBox results towards current map's viewport.
            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener("places_changed", () => {

                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                marker.setPosition(place.geometry.location);

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                });
                map.fitBounds(bounds);
            });
        }

        let data_image = [];
        let active_image = "/images/testing.jpeg";
        let active_image_index = -1;

        let optionsDrop = { 
            url: "{{ route("tastypointsapi.upload","image") }}",
            clickable: ["#drop-area"],
            createImageThumbnails:false,
            acceptedFiles: 'image/*',
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                        this.removeAllFiles();
                        this.addFile(file);
                });
                
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
            success: function(file, response){
                
                file.previewElement.parentNode.removeChild(file.previewElement);

                if(response.success){

                    cropper.replace(response.link);
                    let val = $("#select_photo_type").val();
                    val = parseInt(val);
                    let new_data = {
                        "photo_type_id":val,
                        "photo_link":response.link
                    };
                    // data_image.push( response.link );
                    data_image.push( new_data );
                    active_image = response.link;
                    active_image_index = data_image.length-1;
                    renderImage();

                    $("#image_type_editor").show();
                    console.log(val);
                    $("#image_type_editor select").val(val).trigger("change");
                }
                
            },
        };

        function renderImage() {
            let elm = $("#list-preview-image");
            elm.empty();
            data_image.map((item,index)=>{
                let new_data = '<div class="drop-item" id="template_id_'+index+'">'+
                                    '<img src="'+item.photo_link+'" class="image_uploaded" />'+
                                    '<div class="drop-overlay">'+
                                        '<a onclick="editImage('+index+')" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a>'+
                                        '<a onclick="deleteImage('+index+')" href="javascript:void(0)" data-dz-remove><i class="fas fa-trash"></i></a>'+
                                    '</div>'+
                                '</div>';
                elm.append(new_data);
            });
        }

        function editImage(index) {
            if(index == "logo"){
                cropper.replace(logo);
                active_image = logo;
                active_image_index = "logo";
                $("#image_type_editor").hide();
                return;
            }
            let src = data_image[index];
            cropper.replace(src.photo_link);
            active_image = src.photo_link;
            active_image_index = index;
            $("#image_type_editor").show();
            $("#image_type_editor select").val(src.photo_type_id).trigger("change");
        }

        function deleteImage(index) {
            if(index == "logo"){
                $("#template_logo").remove();
                logo = null;
                return;
            }
            data_image.splice(index,1);
            $("#template_id_"+index).remove();
        }

        $("#save_image").click(function(){
            let elm = $(this);
            // Upload cropped image to server if the browser supports `HTMLCanvasElement.toBlob`.
            // The default value for the second parameter of `toBlob` is 'image/png', change it if necessary.
            cropper.getCroppedCanvas().toBlob((blob) => {
            const formData = new FormData();

            // Pass the image file name as the third parameter if necessary.
            formData.append('file', blob, 'image.png');

            // Use `jQuery.ajax` method for example
            $.ajax('{{ route("tastypointsapi.upload","image") }}', {
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend:function(){
                  elm.attr("disabled",true);  
                  elm.html('<i class="fas fa-circle-notch fa-spin"></i>');
                },
                success(response) {
                    if(active_image_index == "logo"){
                        logo = response.link;
                        $("#template_logo img").attr("src",response.link);    
                        return ;
                    }
                    let val = $("#image_type_editor select").val();
                    console.log(val);
                    val = parseInt(val);
                    let new_data = {
                        "photo_type_id":val,
                        "photo_link":response.link
                    };
                    data_image[active_image_index] = new_data;
                    $("#template_id_"+active_image_index+" img").attr("src",response.link);
                },
                error(error) {
                    console.log('Upload error',error);
                },
                complete:function(){
                    elm.removeAttr("disabled");
                    elm.html('<i class="fa fa-save"></i> Apply Image');
                }
            });
            }/*, 'image/png' */);
        });

        var myDropzone = new Dropzone(document.getElementById('drop-area'), optionsDrop);

        let logo = null;
        let optionsDropLogo = { 
            url: "{{ route("tastypointsapi.upload","image") }}",
            clickable: ["#drop-area-logo","#drop-area-logo p", "#drop-area-logo i"],
            createImageThumbnails:false,
            acceptedFiles: 'image/*',
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                        this.removeAllFiles();
                        // this.addFile(file);
                });
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
            },
            success: function(file, response){
                
                file.previewElement.parentNode.removeChild(file.previewElement);

                if(response.success){

                    cropper.replace(response.link);
                    logo = response.link;
                    active_image = response.link;
                    active_image_index = "logo";
                    
                    let elm = $("#list-preview-logo");
                    elm.empty();
                    let new_data = '<div class="drop-item" id="template_logo">'+
                                        '<img src="'+response.link+'" class="image_uploaded" />'+
                                        '<div class="drop-overlay">'+
                                            '<a onclick="editImage('+"'logo'"+')" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a>'+
                                            '<a onclick="deleteImage('+"'logo'"+')" href="javascript:void(0)" data-dz-remove><i class="fas fa-trash"></i></a>'+
                                        '</div>'+
                                    '</div>';
                    elm.append(new_data);

                    $("#image_type_editor").hide();

                    

                }
                
            },
        };

        var myDropzoneLogo = new Dropzone(document.getElementById("drop-area-logo"), optionsDropLogo);

        $("#open_staff").click(()=>{
            $("#add_new_staff").modal("show");
        });

    </script>

    <script>
        
        let industry_data = [];
        function load_industry() {
            let input = {
                "scrdata_id": 1012,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#industry_id");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        data.industry.map((item,index)=>{
                            industry_data[item.id] = item;
                            elm.append(new Option(item.name, item.id, false));
                        });
                        elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });

        }

        let currency_data = [];
        function load_currency() {
            let input = {
                "scrdata_id": 1036,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#currency_id");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);

                        data.currency.map((item,index)=>{
                            currency_data[item.id] = item;
                            elm.append(new Option(item.short_name, item.id,false));
                        });
                        elm.select2({
                            disabled:true
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let country_data = [];
        function load_country() {
            let input = {
                "scrdata_id": 1010,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#country_id");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        data.country.map((item,index)=>{
                            country_data[item.id] = item;
                            elm.append(new Option(item.name, item.id));
                        });
                        elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let language_data = [];
        function load_language() {
            let input = {
                "scrdata_id": 1034,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#language_id");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        data.language.map((item,index)=>{
                            language_data[item.id] = item;
                            elm.append(new Option(item.name, item.id));
                        });
                        elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let country_selected = "";
        $("#country_id").change(function(e){
            country_selected = $(this).val();
            country_selected = parseInt(country_selected);
            let options = {
                "filter_country_id":country_selected
            };

            let item = country_data[country_selected];
            console.log(item);
            if(item.currency !== null ) $("#currency_id").val(item.currency.currency_id).trigger("change");
            if(item.language !== null ) $("#language_id").val(item.language.language_id).trigger("change");

            load_state(options);

            options.filter_country_id;
            state_selected = "";
            if(state_selected !== "") options.filter_state_id = state_selected;

            load_city(options);
        });

        let state_data = [];
        function load_state(options) {
            let input = {
                "scrdata_id": 1084,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#state_id");

            if(options !== undefined) input = {...input, ...options};

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        console.log(input);
                        let data = JSON.parse(response.data);

                        elm.empty();
                        elm.append('<option selected value="">Select State</option>');

                        data.state.map((item,index)=>{
                            state_data[item.id] = item;
                            // elm.append(new Option(item.state_name, item.id));
                            elm.append('<option value="'+item.id+'" data-code="'+item.state_code+'">'+item.state_name+'</option>');
                        });
                        // elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let state_selected = "";
        $("#state_id").change(function(e){
            state_selected = $(this).val();
            state_selected = parseInt(state_selected);
            // load_city({
            //     "filter_state_id":state_selected
            // });
        });

        let city_data  = [];
        function load_city(options) {
            
            let input = {
                "scrdata_id": 1082,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            if(options !== undefined) input = {...input, ...options};

            let elm = $("#city_id");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);
                        console.log(input);
                        elm.empty();
                        elm.append('<option value="" selected disabled>Select City</option>');

                        data.city.map((item,index)=>{
                            city_data[item.id] = item;
                            // let status = item.country_id == country_selected ? 'selected' : '';
                            elm.append('<option value="'+item.id+'">'+item.city_name+'</option>');
                        });
                        elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
        
        $('#city_id').change(function(e){

            let val = $(this).val();
            let value = city_data[val];
            // $("#country_id").val(value.country_id).trigger("change");

            let elm = $("#state_id").find('[data-code="'+value.state_code+'"]');
            let sid = elm.val();
            $("#state_id").val(sid).trigger("change");
            if(value.timezone_id !== undefined) $("#time_zone").val(value.timezone_id).trigger("change");

            
            console.log();
        });

        let timezone_data = [];
        function load_timezone() {
            let input = {
                "scrdata_id": 1128,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#time_zone");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);
                        data.time_zones.map((item,index)=>{
                            timezone_data[item.id] = item;
                            elm.append(new Option(item.name, item.id));
                        });
                        elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
        
        let status_data = [];
        function load_status() {
            let input = {
                "scrdata_id": 1048,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#business_status");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);
                        data.partner_status.map((item,index)=>{
                            status_data[item.id] = item;
                            elm.append(new Option(item.name, item.id));
                        });
                        elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let partner_type_data = [];
        function load_partner_type() {
            let input = {
                "scrdata_id": 1038,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#partner_type_id");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);
                        data.partner_type.map((item,index)=>{
                            partner_type_data[item.id] = item;
                            elm.append(new Option(item.name, item.id));
                        });
                        elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let photo_type_data = [];
        function load_photo_type() {
            let input = {
                "scrdata_id": 1014,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $(".image_type");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);
                        data.photo_type.map((item,index)=>{
                            photo_type_data[item.id] = item;
                            // let status = item.id == 1 ? "selected" : "";
                            if(item.id > 1) elm.append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        elm.select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }
        
        $(document).ready(function() {
            load_industry();
            load_currency();
            load_country();
            load_state();
            load_city();
            load_timezone();
            load_partner_type();
            load_status();
            load_photo_type();
            load_language();
        })

        // $("#upload_logo").click(function(){
        //     $("#logo_file").trigger("click");
        // });

        // $("#logo_file").change(function(){

        //     let elm_btn = $("#upload_logo");

        //     var formData = new FormData();
        //     formData.append('file', $(this)[0].files[0]);
        //     $.ajax({
        //         url: "{{ route("tastypointsapi.upload","image") }}",
        //         type : 'POST',
        //         data : formData,
        //         processData: false,
        //         contentType: false,
        //         beforeSend:function(){
        //             elm_btn.html('<i class="fas fa-circle-notch fa-spin"></i>');
        //             elm_btn.attr('disabled',true);
        //         },
        //         success : function(response) {
        //             if(response.success){
        //                 $("#logo_link").val(response.link);
        //             }
        //         },
        //         complete:function(){
        //             elm_btn.html('<i class="fas fa-folder-open"></i> Browse..');
        //             elm_btn.removeAttr('disabled');
        //         }
        //     });
        // });
        
    </script>

    <script>

        var data_option = [];

        function load_delivery_option() {
            let input = {
                "scrdata_id": 1066,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": 1,
                "search_term_header": "delivery_option_active",
                "pagination": 1,
                "total_records": 3,
            };

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        data.delivery_options.map((item,index)=>{
                            data_option.push( {"id":item.delivery_option_id,"text":item.delivery_option_name} );
                        });

                        $('#delivery_option').select2({
                            placeholder: "Select delivery option",
                            allowClear: true,
                            width:"100%",
                            data:data_option,
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $(document).ready(function() {

            load_delivery_option();


            let select_val = [];

            $('#delivery_option').on("select2:select", function (evt) {
                var element = evt.params.data.element;
                var $element = $(element);
                
                $element.detach();
                $(this).append($element);
                $(this).trigger("change");

                select_val = $(evt.currentTarget).val();
                renderDeliveryForm();
                
                console.log(select_val);
            });

            $('#delivery_option').on("select2:unselect", function (evt) {
                select_val = $(evt.currentTarget).val();
                renderDeliveryForm();
                console.log(select_val);
            });

            function searchDelivery(value) {
                let data = false;
                data_option.map((item,index)=>{
                    if(item.id == value) data = item;
                });
                return data;
            }

            function renderDeliveryForm() {
                let string = "";
                $("#list_delivery").empty();
                select_val.map((item,index)=>{
                    const result = searchDelivery(item);
                    if(result){
                        string = string+'<div class="delivery_item delivery_selected_'+result.id+'">'+
                                        '<div class="item_text"><span class="remove_data" onClick="removeDelivery('+result.id+')" >x</span> '+result.text+'</div>'+
                                        '<div class="form-group delivery_field">'+
                                            '<input name="deliveryfee['+result.id+']" class="form-control" placeholder="Set delivery fee" required />'+
                                        '</div>'+
                                    '</div>';
                    }
                });
                $("#list_delivery").html(string);
            }


        });

        function removeDelivery(id) {
            var wanted_option = $('#delivery_option option[value="'+ id +'"]');
            wanted_option.prop('selected', false);
            $('#delivery_option').trigger('change.select2');
            $(".delivery_selected_"+id).remove();
        }

        var data_partner_groups = [];

        function load_partner_groups() {
            let input = {
                "scrdata_id": 1232,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": 1,
                "search_term_header": "delivery_option_active",
                "pagination": 1,
                "total_records": 3,
            };

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        data.partner_groups.map((item,index)=>{
                            data_partner_groups.push( {"id":item.id,"text":item.name} );
                        });

                        $('#partner_groups').select2({
                            placeholder: "Select Partner Groups",
                            allowClear: true,
                            width:"100%",
                            data:data_partner_groups,
                        });

                        $('#partner_groups').val("").trigger("change");
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $(document).ready(function(){
            load_partner_groups();
        });
    </script>

    <script>

        let oh_data = [];
        function load_weekdays() {
            let input = {
                "scrdata_id": 1078,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#oh_content");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);

                        elm.empty();
                        data.week_days.map((item,index)=>{
                            oh_data[item.id] = {
                                "morning":{
                                    "open":"00:00",
                                    "close":"00:00",
                                },
                                "afternoon":{
                                    "open":"00:00",
                                    "close":"00:00",
                                },
                                "name":item.name,
                                "id":item.id,
                            };
                           elm.append('<div class="oh_item" data-id="'+item.id+'">'+item.name+'</div>'); 
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $(document).ready(function(){
            load_weekdays();
        });

        let selected_oh = null;
        $(document).on('click','.oh_item', function(){

            let id = $(this).data("id");
            let data = oh_data[id];

            $(".oh_item").removeClass("active");
            $(this).addClass("active");

            $("#morning_open").val(data.morning.open);
            $("#morning_close").val(data.morning.close);
            $("#afternoon_open").val(data.afternoon.open);
            $("#afternoon_close").val(data.afternoon.close);
            
            selected_oh = id;

        });

        function saveOh() {

            let data = oh_data[selected_oh];

            data.morning.open = $("#morning_open").val();
            data.morning.close = $("#morning_close").val();

            data.afternoon.open = $("#afternoon_open").val();
            data.afternoon.close = $("#afternoon_close").val();

            oh_data[selected_oh] = data;

            swal("Times is saved",{icon:"success"});

        }

        function clearOh() {
            let data = oh_data[selected_oh];

            data.morning.open = "";
            data.morning.close = "";
            data.afternoon.open = "";
            data.afternoon.close = "";

            $("#morning_open").val("");
            $("#morning_close").val("");
            $("#afternoon_open").val("");
            $("#afternoon_close").val("");

            oh_data[id] = data;

        }

    </script>

    <script>
        $("#form_data").validate({
            rules : {
                password : {
                    minlength : 5
                },
                password_confirm : {
                    minlength : 5,
                    equalTo : "#password"
                }
            },
            submitHandler:function(form){
                let input = {
                        "scrdata_id": 1003,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = gotForm.item_id;

                gotForm.partner_group = {"id":$("#partner_groups").val()};

                gotForm.images = data_image;

                gotForm.location = {
                    "lat":$("#location_lat").val(),
                    "lon":$("#location_lon").val()
                };

                // processing delivery data
                let elm_pos = $("input[name^=pos_terminal]");
                gotForm.pos_terminal = [
                    {
                    "pos_id": 1,
                    "code": "",
                    "serial_number": "",
                    "delete": 0
                    }
                ];
                if(elm_pos !== undefined) {
                    elm_pos.map(function(index,item){

                        var matches = $(this).attr("name").match(/\[(.*?)\]/);
                        if (matches) {
                            let name = matches[1];
                            let value = $(this).val();
                            gotForm.pos_terminal[0][name] = value;
                        }
                    });

                }

                let elm_delivery = $("input[name^=deliveryfee]");
                if(elm_delivery !== undefined) {
                    let delivery_option = [];
                    elm_delivery.map(function(index,item){

                        var matches = $(this).attr("name").match(/\[(.*?)\]/);
                        if (matches) {
                            let id = matches[1];
                            let fee = parseFloat($(this).val());
                            let new_data =  {
                                "delivery_option_id": id,
                                "partner_delivery_option_id": 0,
                                "in_order": index+1,
                                "fee": fee
                            };
                            delivery_option.push(new_data);
                        }
                    });
                    gotForm.delivery_option = delivery_option;

                }

                gotForm.industry = industry_data[gotForm.industry_id];
                gotForm.country = country_data[gotForm.country_id];
                gotForm.city = city_data[gotForm.city_id];
                gotForm.currency = currency_data[gotForm.currency_id];
                gotForm.state = state_data[gotForm.state_id] ?? {"id":0,"name":null};
                gotForm.status = status_data[gotForm.status_id];

                let partner = partner_type_data[gotForm.partner_type_id];
                partner.delete = 0;
                gotForm.partner_type = [partner];

                gotForm.phone = [
                    {
                        "phone_id": 0,
                        "phone_type_id": 1,
                        "phone_type": "Office Phone",
                        "phone": $("input[name=phone]").val(),
                        "delete": false
                    }
                ];
                let alternate_phone = $("input[name=alternate_phone]").val();
                if(alternate_phone !== "") {
                    gotForm.phone.push({
                        "phone_id": 0,
                        "phone_type_id": 2,
                        "phone_type": "Alternate Phone",
                        "phone": alternate_phone,
                        "delete": false
                    });
                }

                let image = data_image;
                image.push({
                    "photo_type_id":1,
                    "photo_link":logo
                });
                // let images_form = image;

                gotForm.images = image;

                let week_days = [];
                oh_data.map((item,index)=>{

                    let new_data =  {
                        "weekday_id": item.id,
                        "weekday_name_id": item.id,
                        "morning_start_time": item.morning.open,
                        "morning_end_time": item.morning.close,
                        "evening_start_time": item.afternoon.open,
                        "evening_end_time": item.afternoon.close
                    };
                    week_days.push(new_data);

                });

                gotForm.weekdays = week_days;

                // clean from bracket
                for (var key in gotForm) {
                    if(key.includes("[")){
                        delete gotForm[key];
                    }
                    if(
                        key.includes("_id") ||
                        key.includes("wifi") ||
                        key.includes("staff_points") ||
                        key.includes("point_amount")
                    ){
                        let val = gotForm[key];
                        gotForm[key] = parseInt(val);
                    }
                }


                input.partners = [gotForm];
                console.log(input);

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            response = JSON.parse(response);
                            console.log(response);
                            if(response.status){
                                response.data = JSON.parse(response.data);
                                if(response.data.response_error !== undefined){
                                    swal(response.data.response_error, {
                                        icon: "error",
                                    });
                                    $("#json_req").html(JSON.stringify(input,null,2));
                                    $("#json_res").html(JSON.stringify(response.data,null,2));
                                    $("#modals-debug").modal("show");
                                    return ;
                                }
                                swal("Data has been recorded!", {
                                    icon: "success",
                                });
                                window.location = "{{ route('partner.index') }}";
                            }
                        },
                        error:function(error){
                            console.log(error);
                        }
                    });

                });

                return false;
            }
        });

        $("#submitForm").click(function(){
            $("#form_data").trigger("submit");
        });
    </script>

<script>
    // staff script
    $("#form_staff").validate({
        submitHandler:function(form){
            let input = {
                    "scrdata_id": 1047,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
            };
            let gotForm = getFormData($(form));
            input.item_id = parseInt(gotForm.item_id);

             // clean from bracket
             for (var key in gotForm) {
                if(
                    key.includes("_id") ||
                    key.includes("staff_status") ||
                    key.includes("point_amount") ||
                    key.includes("direct_phone_num") ||
                    key.includes("extension_num") ||
                    key.includes("pin") ||
                    key.includes("id")
                ){
                    let val = gotForm[key];
                    gotForm[key] = parseInt(val);
                }
            }

            gotForm.staff_title_name = $("#staff_title_id").find("option:selected").text();

            input.staff = [gotForm];
            console.log(input);

            Pace.track(function(){

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        response = JSON.parse(response);
                        if(response.status){
                            response.data = JSON.parse(response.data);
                            if(response.data.response_error){
                                $("#json_req").html(JSON.stringify(input,null,2));
                                $("#json_res").html(JSON.stringify(response.data,null,2));
                                $("#modals-debug").modal("show");
                                return;
                            }
                            swal("Data has been recorded!", {
                                icon: "success",
                            });
                            $("#add_new_staff").modal("hide");
                            compay_table.draw(false);
                        }
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            });

            return false;
        }
    });

    function load_staff_title() {
        let input = {
            "scrdata_id": 1086,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "",
            "search_term_header":"",
        };

        let elm = $("#staff_title_id");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);
                    // elm.empty();
                    data.staff_title.map((item,index)=>{
                        elm.append('<option value="'+item.id+'">'+item.name+'</option>');
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    function load_admin_level() {
        let input = {
            "scrdata_id": 1062,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "max_row_per_page": 1000,
            "search_term": "",
            "search_term_header":"",
        };

        let elm = $("#admin_level");

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);
                    // elm.empty();
                    data.admin_level.map((item,index)=>{
                        elm.append('<option value="'+item.admin_level_id+'">'+item.admin_level_name+'</option>');
                    });

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    $(document).ready(function(){
        load_staff_title();
        load_admin_level();
    });

    let json = {
        "scrdata_id": 1046,
        "sp_name": "OK",
        "session_id": "{{ Request::get("session")->session_id }}",
        "session_exp": "{{ Request::get("session")->session_exp }}",
        "status": "OK",
        "item_id": 0,
        "filter_tpartner_id": -1,
        "max_row_per_page": 50,
        "search_term": "0",
        "search_term_header": "0",
        "pagination": 1,
        "total_records": 3,
        "scrdata_lab_category": [],
    };

    let temp_data = [];
    let compay_table = $("#company_staff").DataTable({
        "dom": "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        "buttons": [
            'copyHtml5',
            'excelHtml5',
            'colvis',
            'csvHtml5',
            'pdfHtml5'
        ],
        "responsive":true,
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": '{{ route("tastypointsapi.datatables") }}',
            "type": 'POST',
            "data": function(d){
                d._token =  "{{ csrf_token() }}";
                d.input = JSON.stringify(json);
                d.scr_name = "staff";
                return d;
            },
            "dataSrc": function ( json ) {
                json.data.map((item,index)=>{
                    temp_data[item.id] = item;
                });
                return json.data;
            },
        },
        "columns": [
            { 
                data: "staff_first_name",
                render:function(data,type,row){
                    return data+" "+row.staff_last_name;
                }
            },
            { 
                data: "staff_title_name",
            },
            { 
                data: "admin_level_name",
            },
            { 
                data: "direct_phone_num",
                render:function(data,type,row){
                    return row.extension_num+" "+data;
                }
            },
            { 
                data: "id",
                orderable:false,
                searchable:false,
                render:function(data,type,row){
                    return '<button class="btn btn-primary btn-xs" onclick="edit('+
                    "'"+data+"'"+
                    ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                    "'"+data+"'"+
                    ')">Delete</button>';
                }
            }
        ],
    });

</script>

@endsection