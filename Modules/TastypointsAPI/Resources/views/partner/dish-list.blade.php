@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Partner Dish List")

@section('page_css')
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
        #dataList > .item {
            margin: 10px 0px;
        }
        #dataList .image_container {
            display: inline-block;
            height: 100px;
            width: 200px;
            margin-right: 10px;
        }
        #dataList .image_container > .image_header {
            height: 100px;
            width: 200px;
        }
        #dataList .overlay {
            position: absolute; 
            top: 0; 
            background: rgb(0, 0, 0);
            background: rgb(154 154 154 / 50%); /* Black see-through */
            color: #f1f1f1; 
            width: 200px;
            height: 100px;
            transition: .5s ease;
            opacity:0;
            color: white;
            font-size: 20px;
            padding-top: 30px;
            text-align: center;
        }
        #dataList .image_container:hover .overlay {
            opacity: 1;
        }
        #dataList .title_item {
            display: inline-block;
            vertical-align: top;
        } 
        #dataList .title_item .item_name {
            border-radius: 0;
            box-shadow: none;
            border-color: #d2d6de;
            font-size: 20px;
            padding-right: 0px;
        }
        #dataList .title_item .item_name:disabled {
            background: white;
            border: none;
        }
        #dataList .title_item .dolar_sign {
            padding-left: 0px;
            padding-right: 2px;
            color: #ff7700;
            font-size: 20px;
            border-top: none;
            border-left: none;
            border-bottom: none;
        }
        #dataList .title_item .price {
            padding-left: 0px;
            background: white;
            color: #ff7700;
            font-size: 20px;
            border-color: #d2d6de;
        }
        #dataList .title_item .price:disabled {
            border: none;
        }
        #dataList .collapse_icon {
            display: inline-block;
            vertical-align: middle;
            font-size: 22px;
            padding-right: 20px;
            cursor: pointer;
        }
        #dataList .control_item {
            display: inline-block;
            vertical-align: middle;
            float: right;
            line-height: 107px;
            cursor: pointer;
            font-size: 18px;
        }
        #dataList .control_item i {
            margin-right: 10px;
        }
        /* #dataList .b-none {
            border: none !important;
        } */
        #dataList .item_container {
            position: relative;
        }
        #dataList .dish_container {
            margin-left: 250px;
            background: #efefef;
            padding-bottom: 20px;
        }
        #dataList .dish_head {
            background: #424242;
            color: white;
            padding: 15px;
            font-size: 15pt;
        }
        #dataList .subitem {
            margin: 10px 10px;
        }
        #dataList .subitem_collapse {
            display: inline-block;
            font-size: 15pt;
            cursor: pointer;
        }
        #dataList .subitem_name {
            display: inline-block;
            font-size: 15pt;
            margin-left: 5px;
        }
        #dataList .subitem_control {
            display: inline-block;
            float: right;
        }
        #dataList .subitem_control > i {
            margin: 0px 5px;
        }
        #dataList .subitem_menu {
            margin-left: 18px;
        }
        #dataList .menuitem_data {
            margin: 10px 0px;
        }
        #dataList .menuitem_control {
            float: right;
            padding-top: 20px;
        }
        #dataList .menuitem_control > i {
            margin: 0px 5px;
        }
        #dataList .menuitem_detail {
            /* display: inline-block; */
        }
        #dataList .menuitem_data .menuitem_name {
            font-size: 14pt;
            padding-right: 0px;
        }
        #dataList .menuitem_data .menuitem_name:disabled{
            border: none;
            background: #efefef;
        }
        #dataList .menuitem_data .dolar_sign {
            border: none;
            background: #efefef;
            font-size: 14pt;
            padding-right: 0px;
            color: #ff7701;
            padding-left: 0px;
        }
        #dataList .menuitem_data .price {
            font-size: 14pt;
            padding-left: 0px;
            color: #ff7701;
        }
        #dataList .menuitem_data .price:disabled {
            background: #efefef;
            border: none;
        }
        #dataList .dish_container{
            display: none;
        }
        #dataList .subitem_menu{
            display: none;
        }

    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css" />
    <link rel="stylesheet" href="/tasty/css/cropper.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" />

    <style>
        .d-none{
            display: none !important;
        }
        .drop-area{
            width: 100%;
            height: 145px;
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
            margin-top: 3vh;
            padding:0px 10px;
        }
        .list-preview-image{
            display: inline-block;
            vertical-align: middle;
        }
        .drop-item{
            position: relative;
            display: inline-block;
            vertical-align: middle;
            width: 150px;
            height: 150px;
            margin-left: 10px;
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
            height: 150px;
            width: 150px;
            line-height: 120px;
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

        .drop-container{
            display: inline-block;
            vertical-align: middle;
            margin-bottom: 10px;
        }
        #image_editor_container{
            margin-top: 0px;
        }
    </style>

    <style>
        .inline{
            display: inline-block !important;
        }
        .block{
            display: block !important;
        }
        .dish_description{
            width: 100% !important;
        }
        .dish_description:disabled{
            border: none;
            background:white;
        }
        .measurement{
            margin-bottom: 0px;
            width:15%;
        }
        .measurement_input {
            padding-right: 0px;
            background: white;
        }
        .measurement_input:disabled {
            border: none;
            background: #efefef;
        }
        .measurement_select {
            padding-left: 0px;
            min-width:100px;
        }
        .measurement_select:disabled {
            background: #efefef;
            border:none;
        }
        .info_con{
            background: #efefef !important;
            padding-right: 0px;
            border: none;
        }
        .info_con.active {
            background: white !important;
            border: 1px solid #ccc;
            border-right: 0px;
            padding: 0px 5px;
        }
        .info_desc {
            width: 40%;
        }
        .info_desc_input{
            padding-left: 5px;
        }
        .info_desc_input:disabled{
            background: #efefef;
            border: none;
        }
        #save_image {
            margin-top: 20px;
        }
        .subitem_control{
            cursor: pointer;
        }
        .menuitem_control{
            cursor: pointer;
        }
    </style>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .d-inline {
            display: inline;
        }
        #sortable_list{
            padding-left: 20px;
        }
        #list_upsell_dish, #list_propose_dish{
            margin-top: 15px;
            padding-left: 0px;
        }
        .upsells{
            margin-bottom: 10px;
            background: #ffffff;
        }
        .upsells::marker{
            content: "\f0b2"; /* FontAwesome Unicode */
            font-family: 'Font Awesome 5 Free';
        }
        .upsells .picture_dishes{
            display: inline-block;
            height: 100px;
            width: 200px;
            margin-left: 0px;
            /* vertical-align: top; */
        }
        .upsells .picture_dishes_x{
            margin-left: 15px;
        }
        .upsells .detail_dishes{
            display: inline-block;
            margin-left: 10px;
            width: 58%;
            vertical-align: top;
        }
        .upsells .detail_dishes_x{
            width: 65%;
        }
        .upsells .detail_dishes .name_dishes{
            font-size: 12pt;
        }
        .upsells .detail_dishes .desc_dishes{
            font-size: 11pt;
        }
        .upsells .detail_dishes .name_dishes .price_dishes{
            color: #ff7701;
        }
        .upsells .detail_dishes .action_dishes {
            float: right;
            flex-direction: row;
        }
        .upsell_choice::marker {
            content:"";
        }
    </style>
   
@endsection

@section('content-header',"Partner Dish List")

@section('main_content')

    <div class="modal fade" id="add_dish_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4>Add Dish Item</h4>
                </div>
                <form id="add_dish_form">
                    @csrf
                    <input type="hidden" name="item_id" value="0"/>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Partner</label>
                            <select class="form-control" name="id_tpartners">

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" name="category_id">

                            </select>
                        </div>
                        <div class="form-group">
                            <label>Dish name</label>
                            <input class="form-control" name="name" required />
                        </div>
                        <div class="form-group">
                            <label>Dish price</label>
                            <input type="number" min="0.01" step="0.01" class="form-control" name="dish_price" required />
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea rows="5" class="form-control" name="description"></textarea>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="dish_category_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4>Dish Item</h4>
                </div>
                <form id="dish_category_form">
                    @csrf
                    <input type="hidden" name="item_id" value="0"/>
                    <input type="hidden" name="id_dishes" value="0"/>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Dish Item name</label>
                            <input class="form-control" name="name" required />
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="menu_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4>Dish Menu</h4>
                </div>
                <form id="dish_menu_form">
                    @csrf
                    <input type="hidden" name="item_id" value="0"/>
                    <input type="hidden" name="id_dish_items" value="0"/>
                    <input type="hidden" name="id_dishes" value="0"/>

                    <div class="modal-body">
                        <div class="form-group">
                            <label>Dish option name</label>
                            <input class="form-control" name="name" required />
                        </div>
                        <div class="form-group">
                            <label>Dish option price</label>
                            <input type="number" min="0.01" step="0.01" class="form-control" name="price" required />
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Weight</label>
                                    <input type="number" min="1" class="form-control" name="limit" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Measurement</label>
                                    <select class="form-control" name="measurement" required>
                                        <option value="Gr">Gr</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Lbs">Lbs</option>
                                        <option value="Gal">Gal</option>
                                        <option value="Pound">Pound</option>
                                        <option value="Oz">Oz</option>
                                        <option value="Inch">Inch</option>
                                        <option value="Cent">Cent</option>
                                        <option value="Foot">Foot</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Dish option info</label>
                            <input class="form-control" name="info" required />
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_image">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <p>Image Editor</p>
                    <div class="row">

                        <div class="col-md-9">
                            <div id="image_editor_container" class="img-container">
                                <img id="image_editor" src="/images/testing.jpeg">
                            </div>
                            <div class="row" id="actions">
        
                                <div class="col-md-12 docs-buttons text-center">
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
        
                                    <div class="docs-toggles text-center">
                                    
                                    <!-- <h3>Toggles:</h3> -->
                                    <div class="btn-group d-flex flex-nowrap mt-10" data-toggle="buttons">
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
                            
                                    <div class="btn-group d-flex flex-nowrap mt-10" data-toggle="buttons">
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
                            
                                    <div class="dropdown dropup docs-options mt-10">
                                        <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
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
                                    
                                </div>
                            
                            </div>
                        </div>
        
                        <div class="col-md-3">
        
                            <div id="drop-area" class="drop-area">
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
                            <form id="edit_image_form">
                                @csrf
                                <input type="hidden" name="item_id" value="0" />
                                <input type="hidden" name="photo_link" value="" />
                                <input type="hidden" name="dish_background_image" value="" />
                            </form>

                            <button id="save_image" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Save</button>
        
                            <!-- <h3>Preview:</h3> -->
                            <div class="docs-preview clearfix">
                                <div class="img-preview preview-lg"></div>
                                <div class="img-preview preview-md"></div>
                                <div class="img-preview preview-sm"></div>
                                <div class="img-preview preview-xs"></div>
                            </div>
                    
                            <!-- <h3>Data:</h3> -->
                            <div class="docs-data">
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
                                        <span class="input-group-addon">ScaleY</span>
                                        <input id="dataScaleY" type="number" class="form-control" />
                                    </div>
                                </div>
                            </div>
        
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="upsell_modals">
        <input id="tpartner_id_upsells" type="hidden" name="tpartner_id" value="0" />
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4>Add Upsell For</h4>
                </div>
                <div class="modal-body">
                    <div class="upsells">
                        <img class="picture_dishes picture_dish_upsell" src="/images/testing.jpeg" />
                        <div class="detail_dishes">
                            <p class="name_dishes"><span class="name_dish_upsell"></span> - <span style="color: #ff7701">$</span><span class="price_dishes price_dish_upsell"></span></p>
                            <p class="desc_dishes desc_dish_upsell"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Choose Item :</p>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-industry"></i></div>
                                    <select class="form-control" id="upsells_category">
                                        <option selected value="0">Select Dish Category</option>
                                    </select>
                                </div>
                                <ul id="list_upsell_dish"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button onclick="saveUpsell(this)" class="btn btn-primary pull-right btn-sm"><i class="fas fa-save"></i> Save</button>
                            <p>Upsell Items :</p>
                            <ul style="margin-top: 20px;" id="sortable_list" class="list_upsell"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="propose_modals">
        <input id="tpartner_id_propose" type="hidden" name="tpartner_id" value="0" />
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h4>Add Propose For</h4>
                </div>
                <div class="modal-body">
                    <div class="upsells">
                        <img class="picture_dishes picture_dish_upsell" src="/images/testing.jpeg" />
                        <div class="detail_dishes">
                            <p class="name_dishes"><span class="name_dish_upsell"></span> - <span style="color: #ff7701">$</span><span class="price_dishes price_dish_upsell"></span></p>
                            <p class="desc_dishes desc_dish_upsell"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p>Choose Item :</p>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-industry"></i></div>
                                    <select class="form-control" id="propose_category">
                                        <option selected value="0">Select Dish Category</option>
                                    </select>
                                </div>
                                <ul id="list_propose_dish"></ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button onclick="savePropose(this)" class="btn btn-primary pull-right btn-sm"><i class="fas fa-save"></i> Save</button>
                            <p>Propose Items :</p>
                            <ul style="margin-top: 20px;" id="sortable_list_propose" class="list_upsell"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="main_page">
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fas fa-industry"></i></div>
                        <select class="form-control" id="dish_partner_list">
                            <option selected value="">Select Partner</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon"><i class="fas fa-industry"></i></div>
                        <select class="form-control" id="dish_category_list">
                            <option selected value="">Select Dish Category</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button onclick="addDish()" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Add</button>
            </div>
            <div class="col-md-12">
                <div id="dataList">
                    <div class="item">
                        <div class="item_container">
                            <div class="collapse_icon rows" data-id="1" id="item_1" ><i class="fas fa-angle-right"></i></div>
                            <div class="image_container">
                                <img src="https://www.biggerbolderbaking.com/wp-content/uploads/2019/07/15-Minute-Pizza-WS-Thumbnail.png" class="image_header" />
                                <div class="overlay">
                                    <button onclick="$('#edit_image').modal('show')" class="btn btn-default"><i class="fas fa-pencil-alt"></i></button>
                                </div>
                            </div>
                            <div class="form-inline title_item">
                                <div class="form-group">
                                    <input class="form-control item_name" value="Turkez Pizza Donor Donor" />
                                </div>
                                <p class="inline">-</p>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon dolar_sign">$</span>
                                        <input class="form-control price" value="11.50" />
                                    </div>
                                </div>
                                <div class="form-group block">
                                    <textarea rows="3" class="form-control dish_description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent sed neque tincidunt, fermentum lectus sed, mattis orci. Donec blandit libero a auctor bibendum.</textarea>
                                </div>
                            </div>
                            <div class="control_item">
                                <i class="fas fa-pencil-alt"></i>
                                <i class="fas fa-trash"></i>
                                <input type="checkbox" />
                            </div>
                            <div class="dish_container" id="item_detail_1">
                                <div class="dish_head">
                                    <div class="title_list">Dish Item List <button class="btn btn-primary pull-right"><i class="fas fa-plus"></i> Add</button></div>
                                </div>
                                <div class="subitem_list">
                                    <div class="subitem">
                                        <div class="subitem_collapse sub_rows" data-id="1" id="subitem_1"><i class="fas fa-angle-right"></i></div>
                                        <div class="subitem_name">Dish Item 1</div>
                                        <div class="subitem_control">
                                            <button class="btn btn-primary btn-xs"><i class="fas fa-plus"></i> Add</button>
                                            <i class="fas fa-pencil-alt"></i>
                                            <i class="fas fa-trash"></i>
                                            <input type="checkbox" />
                                        </div>
                                        <div class="subitem_menu">
                                            <div class="menuitem_data">
                                                <div class="menuitem_control">
                                                    <i class="fas fa-pencil-alt"></i>
                                                    <i class="fas fa-trash"></i>
                                                    <input type="checkbox" />
                                                </div>
                                                <div class="menuitem_detail">
                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <input class="form-control menuitem_name" value="Crust-Dipper Chili Cheese" />
                                                        </div>
                                                        <p class="inline">-</p>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon dolar_sign">$</span>
                                                                <input class="form-control price" value="1.20" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group measurement">
                                                        <div class="input-group">
                                                            <input class="form-control measurement_input" value="40.0" />
                                                            <div class="input-group-btn">
                                                                <select class="form-control measurement_select">
                                                                    <option>Gr</option>
                                                                    <option>Kg</option>
                                                                    <option>Lbs</option>
                                                                    <option>Gal</option>
                                                                    <option>Pound</option>
                                                                    <option>Oz</option>
                                                                    <option>Inch</option>
                                                                    <option>Cent</option>
                                                                    <option>Foot</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group info_desc">
                                                        <div class="input-group">
                                                            <span class="input-group-addon info_con"><i class="fas fa-info-circle"></i></span>
                                                            <input class="form-control info_desc_input" value="This is a very spice food." />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('javascript')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
            let data_image = "/images/testing.jpeg";
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
                    // console.log(e.type);
                },
                cropstart: function (e) {
                    // console.log(e.type, e.detail.action);
                },
                cropmove: function (e) {
                    // console.log(e.type, e.detail.action);
                },
                cropend: function (e) {
                    // console.log(e.type, e.detail.action);
                },
                crop: function (e) {
                    var data = e.detail;

                    // console.log(e.type);
                    dataX.value = Math.round(data.x);
                    dataY.value = Math.round(data.y);
                    dataHeight.value = Math.round(data.height);
                    dataWidth.value = Math.round(data.width);
                    dataRotate.value = typeof data.rotate !== 'undefined' ? data.rotate : '';
                    dataScaleX.value = typeof data.scaleX !== 'undefined' ? data.scaleX : '';
                    dataScaleY.value = typeof data.scaleY !== 'undefined' ? data.scaleY : '';
                },
                zoom: function (e) {
                    // console.log(e.type, e.detail.ratio);
                }
            };
            
            var cropper = null;

            $('#edit_image').on('shown.bs.modal', function () {
                image.src = data_image;
                if(cropper !== null) cropper.destroy();
                cropper = new Cropper(image, options);
            });

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
                    image.src = data_image;
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

    </script>

    <script>

        let dropzone_options = { 
            url: "{{ route("tastypointsapi.upload","image") }}",
            clickable: ["#drop-area","#drop-area p","#drop-area i"],
            createImageThumbnails:false,
            maxFiles:1,
            acceptedFiles: 'image/*',
            init: function() {
                this.on("maxfilesexceeded", function(file) {
                        this.removeAllFiles();
                        this.addFile(file);
                });
            },
            sending: function(file, xhr, formData) {
                formData.append("_token", "{{ csrf_token() }}");
                $('.dz-preview').remove();
            },
            success: function(file, response){
                console.log(response);
                if(response.success){
                    cropper.replace(response.link);
                    data_image = response.link;
                } else {
                    this.removeAllFiles();
                }
            },
            complete:function(){
                $('.dz-preview').remove();
            }
        };

        let myDropzone = $("#drop-area").dropzone(dropzone_options);
    </script>

    <script>
        function loadCategory() {
            let input = {
                "scrdata_id": 1144,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "max_row_per_page": 1000000,
                "search_term": "",
                "search_term_header": "",
                "pagination": 1,
                "item_id": 0,
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.dish_category.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.name+'</option>';
                            $("#dish_category_list").append(new_item);
                            $("#add_dish_form select[name=category_id]").append(new_item);
                            $("#upsells_category").append(new_item);
                            $("#propose_category").append(new_item);
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function loadPartner() {
            let input = {
                "scrdata_id": 1002,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000000,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.partners.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.name+'</option>';
                            $("#dish_partner_list").append(new_item);
                            $("#add_dish_form select[name=id_tpartners]").append(new_item);
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let partner_id = null;
        let category_id = null;

        $("#dish_partner_list").change(function(e){
            let val = $(this).val();
            partner_id = val == "" ? null:val;
            loadDishList();
        });
        $("#dish_category_list").change(function(e){
            let val = $(this).val();
            category_id = val == "" ? null:val;
            loadDishList();
        });
        
        let data_dish_list = [];
        function loadDishList() {
            let input = {
                "scrdata_id": 1138,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "filter_category_id": category_id,
                "filter_tpartner_id": partner_id,
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    $("#dataList").empty();
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.partner_dishes.map((item,index)=>{
                            data_dish_list[item.id] = item;
                            let new_item = '<div class="item">'+
                                '<div class="item_container" id="item_dish_'+item.id+'">'+
                                    '<div class="collapse_icon rows" onclick="selectItem('+item.id+')" id="item_'+item.id+'" ><i class="fas fa-angle-right"></i></div>'+
                                    '<div class="image_container">'+
                                        '<img src="'+item.photo_link+'" class="image_header" id="image_header_'+item.id+'" />'+
                                        '<div class="overlay">'+
                                            '<button onclick="editImage('+item.id+')" class="btn btn-default"><i class="fas fa-pencil-alt"></i></button>'+
                                        '</div>'+
                                    '</div>'+
                                    '<form class="form-inline title_item" id="item_form_'+item.id+'">'+
                                        '<input name="id_tpartners" value="'+item.id_tpartners+'" type="hidden" />'+
                                        '<input name="item_id" value="'+item.id+'" type="hidden" />'+
                                        '<div class="form-group">'+
                                            '<input name="name" class="form-control item_name" disabled value="'+item.name+'" />'+
                                        '</div>'+
                                        '<p class="inline">-</p>'+
                                        '<div class="form-group">'+
                                            '<div class="input-group">'+
                                                '<span class="input-group-addon dolar_sign">$</span>'+
                                                '<input type="number" min="0.01" step="0.01" name="dish_price" class="form-control price" disabled value="'+item.dish_price+'" />'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="form-group block">'+
                                            '<textarea name="description" disabled rows="3" class="form-control dish_description">'+item.description+'</textarea>'+
                                        '</div>'+
                                    '</form>'+
                                    '<div class="control_item">'+
                                        '<i onclick="proposeDish('+item.id+',this)" class="fas fa-paper-plane"></i>'+
                                        '<i onclick="upsellDish('+item.id+',this)" class="fas fa-arrow-up"></i>'+
                                        '<i onclick="editDish('+item.id+',this)" class="fas fa-pencil-alt"></i>'+
                                        '<i onclick="deleteDish('+item.id+')" class="fas fa-trash"></i>'+
                                        '<input type="checkbox" />'+
                                    '</div>'+
                                    '<div class="dish_container" id="item_detail_'+item.id+'">'+
                                        '<div class="dish_head">'+
                                            '<div class="title_list">Dish Item List <button onclick="addsubitem('+item.id+')" class="btn btn-primary pull-right"><i class="fas fa-plus"></i> Add</button></div>'+
                                        '</div>'+
                                        '<div class="subitem_list"></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                            $("#dataList").append(new_item);
                        });
                    }
                    // console.log(data_dish_list);
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $(document).ready(function(e) {
            loadCategory();
            loadPartner();
            loadDishList();
        });
    </script>

    <script>
        let item_active = null;

        function selectItem(id) {

            subitem_active = null;
            getSubCategory(id);

            let icon_elm = $("#item_"+id);
            let sublist_elm = $("#item_detail_"+id);

            $(".dish_container").hide();
            $(".collapse_icon").find("i").addClass("fas fa-angle-right");

            icon_elm.find("i").removeClass();

            if(item_active == id){
                item_active = null;
                sublist_elm.hide("fade");
                icon_elm.find("i").addClass("fas fa-angle-right");
            } else {
                item_active = id;
                icon_elm.find("i").addClass("fas fa-angle-down");
                sublist_elm.show("fade");
            }
            
        }

        let data_sub_category = [];
        function getSubCategory(id) {
            let input = {
                "scrdata_id": 1140,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000000,
                "search_term": "",
                "search_term_header": "",
                "filter_id_dishes":parseInt(id),
                "pagination": 1,
                "dish_items": [
                    {
                    "id": 2,
                    "id_dishes": 3,
                    "name": "Dish item 3",
                    "delete": 1
                    }
                ]
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    $("#item_detail_"+id+" .subitem_list").empty();
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.dish_items.map((item,index)=>{
                            data_sub_category[item.id] = item;
                            let new_item = '<div class="subitem sub_'+item.id+'">'+
                                        '<div class="subitem_collapse sub_rows subitem_'+item.id+'" onclick="selectSubCategory('+item.id+','+id+')"><i class="fas fa-angle-right"></i></div>'+
                                        '<div class="subitem_name">'+item.name+'</div>'+
                                        '<div class="subitem_control">'+
                                            '<button onclick="addMenu('+item.id+","+id+')" class="btn btn-primary btn-xs"><i class="fas fa-plus"></i> Add</button>'+
                                            '<i onclick="editSub('+item.id+","+id+','+"'"+item.name+"'"+')" class="fas fa-pencil-alt"></i>'+
                                            '<i onclick="deleteSub('+item.id+')" class="fas fa-trash"></i>'+
                                            '<input type="checkbox" />'+
                                        '</div>'+
                                        '<div class="subitem_menu subitem_detail_'+item.id+'"></div>'+
                                    '</div>';
                            $("#item_detail_"+id+" .subitem_list").append(new_item);
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let subitem_active = null;
        function selectSubCategory(id,parent_id) {
            
            getMenu(id,parent_id);

            let icon_elm = $("#item_detail_"+parent_id+" .subitem_"+id);
            let sublist_elm = $("#item_detail_"+parent_id+" .subitem_detail_"+id);
            
            $(".subitem_menu").hide();
            $(".subitem_collapse").find("i").addClass("fas fa-angle-right");

            icon_elm.find("i").removeClass();

            if(subitem_active == id){
                subitem_active = null;
                sublist_elm.hide("fade");
                icon_elm.find("i").addClass("fas fa-angle-right");
            } else {
                subitem_active = id;
                sublist_elm.show("fade");
                icon_elm.find("i").addClass("fas fa-angle-down");
            }
        }

        let data_menu = [];
        function getMenu(sub_id,root_id) {
            let input = {
                "scrdata_id": 1142,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000000,
                "search_term": "",
                "search_term_header": "",
                "pagination": 1,
                "filter_id_dish_items":parseInt(sub_id),
            };
            let st = "#item_detail_"+root_id+" .subitem_detail_"+sub_id;
            let element_list = $(st);

            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    element_list.empty();
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);

                        response.data.dish_items_options.map((item,index)=>{
                            data_menu[item.id] = item;
                            let new_item = '<div class="menuitem_data menuitem_'+item.id+'">'+
                                                '<div class="menuitem_control">'+
                                                    '<i onclick="editMenu('+item.id+',this,'+root_id+')" class="fas fa-pencil-alt"></i>'+
                                                    '<i onclick="deleteMenu('+item.id+','+root_id+','+item.id_dish_items+')" class="fas fa-trash"></i>'+
                                                    '<input type="checkbox" />'+
                                                '</div>'+
                                                '<div class="menuitem_detail">'+
                                                    '<form class="form_menu_'+item.id+'">'+
                                                        '<input type="hidden" name="item_id" value="'+item.id+'" />'+
                                                        '<input type="hidden" name="id_dish_items" value="'+item.id_dish_items+'" />'+
                                                        '<div class="form-inline">'+
                                                            '<div class="form-group">'+
                                                                '<input name="name" disabled class="form-control menuitem_name" value="'+item.name+'" />'+
                                                            '</div>'+
                                                            '<p class="inline">-</p>'+
                                                            '<div class="form-group">'+
                                                                '<div class="input-group">'+
                                                                    '<span class="input-group-addon dolar_sign">$</span>'+
                                                                    '<input type="number" min="0.01" step="0.01" name="price" disabled class="form-control price" value="'+item.price+'" />'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="form-group measurement">'+
                                                            '<div class="input-group">'+
                                                                '<input type="number" min="1" name="limit" disabled class="form-control measurement_input" value="'+item.limit+'" />'+
                                                                '<div class="input-group-btn">'+
                                                                    '<select name="measurement" disabled class="form-control measurement_select">'+
                                                                        '<option>Gr</option>'+
                                                                        '<option>Kg</option>'+
                                                                        '<option>Lbs</option>'+
                                                                        '<option>Gal</option>'+
                                                                        '<option>Pound</option>'+
                                                                        '<option>Oz</option>'+
                                                                        '<option>Inch</option>'+
                                                                        '<option>Cent</option>'+
                                                                        '<option>Foot</option>'+
                                                                    '</select>'+
                                                                '</div>'+
                                                            '</div>'+
                                                        '</div>'+
                                                        '<div class="form-group info_desc">'+
                                                            '<div class="input-group">'+
                                                                '<span class="input-group-addon info_con"><i class="fas fa-info-circle"></i></span>'+
                                                                '<input name="info" disabled class="form-control info_desc_input" value="'+item.info+'" />'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</form>'+
                                                '</div>'+
                                            '</div>';
                                element_list.append(new_item);
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function editImage(id) {
            let data = data_dish_list[id];
            data_image = data.photo_link;
            $("#edit_image_form input[name=item_id]").val(id);
            $("#edit_image").modal("show");
            
        }

        $("#save_image").click(function(e){
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
                        $("#save_image").attr("disabled",true);
                    },
                    success(response) {
                        $("#edit_image_form input[name=photo_link]").val(response.link);
                        $("#edit_image_form input[name=dish_background_image]").val(response.link);
                        $("#edit_image_form").trigger("submit");
                    },
                    error(error) {
                        console.log('Upload error',error);
                    },
                });
            }/*, 'image/png' */);
        });
        
        $("#edit_image_form").submit(function(e){
            let data = getFormData($(this));
            let item = data_dish_list[data.item_id];
            item.photo_link = data.photo_link;
            let input = {
                "scrdata_id": 1139,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": item.id,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "partner_dishes":[
                    item
                ]
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                complete:function(){
                    $("#save_image").removeAttr("disabled");
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        response.data = JSON.parse(response.data);
                        if(response.data.status == "OK"){
                            let elm = $("#image_header_"+response.data.item_id);
                            elm.attr("src",item.photo_link);
                            console.log(elm,"#item_"+response.data.item_id+" .image_header");
                            $("#edit_image").modal("hide");
                        }
                    }
                },
                error:function(error){

                }
            });
            return false;
        });

        $("#add_dish_form").validate({
            submitHandler:function(form){
                let input = {
                    "scrdata_id": 1139,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.partner_dishes = [gotForm];
                input.item_id = parseInt(gotForm.item_id);

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        swal("","Data is Saved and apply","success");
                        loadDishList();
                        $("#add_dish_modal").modal("hide");
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            }
        });

        function addDish(){
            $("#add_dish_modal input").val("");
            $("#add_dish_modal textarea").val("");
            $("#add_dish_modal input[name=item_id]").val("0");
            $("#add_dish_modal").modal("show");
        }

        let editable_dish = [];
        function editDish(id,elm) {
            elm = $(elm);
            elm.removeClass();
            console.log(elm);
            if(editable_dish.includes(id)){


                $("#item_form_"+id).validate({
                    submitHandler:function(form){
                        let input = {
                            "scrdata_id": 1139,
                            "session_id": "{{ Request::get("session")->session_id }}",
                            "session_exp": "{{ Request::get("session")->session_exp }}",
                        };
                        let gotForm = getFormData($(form));
                        gotForm.item_id = parseInt(gotForm.item_id);
                        gotForm.delete = 0;
                        gotForm.photo_link = $("#image_header_"+id).attr("src");

                        input.partner_dishes = [gotForm];
                        input.item_id = gotForm.item_id;
                        console.log(JSON.stringify(input));
                        $.ajax({
                            url:'{{ route("tastypointsapi.testnet") }}',
                            type:"post",
                            data:{"input":JSON.stringify(input)},
                            success:function(response){

                                const index = editable_dish.indexOf(id);
                                if (index > -1) {
                                    editable_dish.splice(index, 1);
                                }

                                $("#item_form_"+id+" input").attr("disabled",true);
                                $("#item_form_"+id+" textarea").attr("disabled",true);
                                elm.addClass("fas fa-pencil-alt");
                            },
                            error:function(error){
                                console.log(error);
                            }
                        });
                    }
                });

                $("#item_form_"+id).trigger("submit");

            } else {

                editable_dish.push(id);
                $("#item_form_"+id+" input").removeAttr("disabled");
                $("#item_form_"+id+" textarea").removeAttr("disabled");
                elm.addClass("fas fa-save");

            }
        }

        function deleteDish(id) {
            id = parseInt(id);
            let input = {
                "scrdata_id": 1139,
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "item_id":id,
                "partner_dishes": [
                    {
                        "id": id,
                        "delete":1
                    }
                ]
            };

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    Pace.track(function(){
                        $.ajax({
                            url:"{{ route('tastypointsapi.testnet') }}",
                            type:"post",
                            data:{"input":JSON.stringify(input)},
                            success:function(response){
                                response = JSON.parse(response);
                                if(response.status){
                                    swal("Data has been deleted!", {
                                        icon: "success",
                                    });
                                    $("#item_dish_"+id).remove();
                                }
                            },
                            error:function(error){
                                console.log(error);
                            }
                        });
                    });
                }
            });
        }

        function addsubitem(id) {
            $("#dish_category_modal h4").html("Add Dish Item");
            $("#dish_category_modal input").val("");
            $("#dish_category_modal input[name=item_id]").val(0);
            $("#dish_category_modal input[name=id_dishes]").val(id);
            $("#dish_category_modal").modal("show");
        }

        function editSub(item_id,parent_id,name) {
            $("#dish_category_modal h4").html("Edit Dish Item");
            $("#dish_category_modal input").val("");
            $("#dish_category_modal input[name=name]").val(name);
            $("#dish_category_modal input[name=item_id]").val(item_id);
            $("#dish_category_modal input[name=id_dishes]").val(parent_id);
            $("#dish_category_modal").modal("show");
        }

        function deleteSub(id) {
            id = parseInt(id);
            let input = {
                "scrdata_id": 1141,
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "item_id": id,
                "dish_items": [
                    {
                    "id": id,
                    "delete": 1
                    }
                ]
            };

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    Pace.track(function(){
                        $.ajax({
                            url:"{{ route('tastypointsapi.testnet') }}",
                            type:"post",
                            data:{"input":JSON.stringify(input)},
                            success:function(response){
                                response = JSON.parse(response);
                                if(response.status){
                                    swal("Data has been deleted!", {
                                        icon: "success",
                                    });
                                    $(".sub_"+id).remove();
                                }
                            },
                            error:function(error){
                                console.log(error);
                            }
                        });
                    });
                }
            });
        }


        $("#dish_category_modal form").validate({
            submitHandler:function(form){
                let input = {
                    "scrdata_id": 1141,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                gotForm.id_dishes = parseInt(gotForm.id_dishes);
                gotForm.delete = 0;

                input.item_id = parseInt(gotForm.item_id);
                input.dish_items = [gotForm];

                console.log(input);

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        swal("","Data is Saved and apply","success");
                        getSubCategory(gotForm.id_dishes);
                        $("#dish_category_modal").modal("hide");
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            }
        });

        function addMenu(id_dish_items,id_dishes) {
            $("#menu_modal h4").html("Add Dish Menu");
            $("#menu_modal input").val("");
            $("#menu_modal input[name=item_id]").val(0);
            $("#menu_modal input[name=id_dish_items]").val(id_dish_items);
            $("#menu_modal input[name=id_dishes]").val(id_dishes);
            $("#menu_modal").modal("show");
        }

        function editMenu(id,elm,root_id) {

            elm = $(elm);
            elm.removeClass();

            let elm_form = $("#item_dish_"+root_id+" .form_menu_"+id);

            if(editable_dish.includes(id)){


                elm_form.validate({
                    submitHandler:function(form){
                        let input = {
                            "scrdata_id": 1143,
                            "session_id": "{{ Request::get("session")->session_id }}",
                            "session_exp": "{{ Request::get("session")->session_exp }}",
                        };
                        let gotForm = getFormData($(form));
                        gotForm.item_id = parseInt(gotForm.item_id);
                        gotForm.delete = 0;

                        input.dish_items_options = [gotForm];
                        input.item_id = gotForm.item_id;
                        console.log(JSON.stringify(input));
                        $.ajax({
                            url:'{{ route("tastypointsapi.testnet") }}',
                            type:"post",
                            data:{"input":JSON.stringify(input)},
                            success:function(response){

                                const index = editable_dish.indexOf(id);
                                if (index > -1) {
                                    editable_dish.splice(index, 1);
                                }

                                elm_form.find("input").attr("disabled",true);
                                elm_form.find("textarea").attr("disabled",true);
                                elm_form.find("select").attr("disabled",true);

                                elm_form.find(".info_con").removeClass("active");

                                elm.addClass("fas fa-pencil-alt");
                            },
                            error:function(error){
                                console.log(error);
                            }
                        });
                    }
                });

                elm_form.trigger("submit");

            } else {

                editable_dish.push(id);
                elm_form.find("input").removeAttr("disabled");
                elm_form.find("textarea").removeAttr("disabled");
                elm_form.find("select").removeAttr("disabled");

                elm_form.find(".info_con").addClass("active");
                
                elm.addClass("fas fa-save");

            }
        }

        function deleteMenu(id,root_id,id_dish_items) {
            let elm = $("#item_dish_"+root_id+" .menuitem_"+id);
            id = parseInt(id);
            let input = {
                "scrdata_id": 1143,
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "item_id":id,
                "dish_items_options": [
                    {
                        "id": id,
                        "id_dish_items":id_dish_items,
                        "delete":1
                    }
                ]
            };

            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    Pace.track(function(){
                        $.ajax({
                            url:"{{ route('tastypointsapi.testnet') }}",
                            type:"post",
                            data:{"input":JSON.stringify(input)},
                            success:function(response){
                                response = JSON.parse(response);
                                if(response.status){
                                    swal("Data has been deleted!", {
                                        icon: "success",
                                    });
                                    elm.remove();
                                }
                            },
                            error:function(error){
                                console.log(error);
                            }
                        });
                    });
                }
            });
        }

        $("#menu_modal form").validate({
            submitHandler:function(form){
                let input = {
                    "scrdata_id": 1143,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                gotForm.id_dish_items = parseInt(gotForm.id_dish_items);

                input.item_id = parseInt(gotForm.item_id);
                input.dish_items_options = [gotForm];

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        swal("","Data is Saved and apply","success");
                        getMenu(gotForm.id_dish_items,gotForm.id_dishes);
                        $("#menu_modal").modal("hide");
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            }
        });

        let temp_upsell = [];
        let dish_item_upsell = {};
        function upsellDish(id,elm) {
            id = parseInt(id);
            let cat_id = $("#upsells_category").val();
            let input = {
                "scrdata_id": 1138,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": id,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 0,
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        const data = JSON.parse(response.data);
                        const dish_item = data.partner_dishes[0];
                        dish_item_upsell = dish_item;
                        $(".picture_dish_upsell").attr("src",dish_item.photo_link);
                        $(".name_dish_upsell").text(dish_item.name);
                        $(".price_dish_upsell").text(dish_item.dish_price);
                        $(".desc_dish_upsell").text(dish_item.description);
                        $("#tpartner_id_upsells").val(data.id_tpartners);
                        temp_upsell = dish_item.upsells !== null ? dish_item.upsells : [];
                        load_upsell_item();
                        load_upsell_select_item(cat_id);
                        $("#upsell_modals").modal("show");
                    }
                },
                error:function(error){

                }
            });
        }

        $(document).ready(function(){
            let list = $("#sortable_list");
            list.sortable({
                stop: function(event, ui) {
                    var data = [];

                    list.find("li").each(function(i, el){
                        let id = $(el).data("id");
                        const result = searchUpsell(id);
                        if(result) data.push(result);
                    });

                    temp_upsell = data;
                    console.log(temp_upsell);
                }
            });
            list.disableSelection();
        });

        function load_upsell_item() {
            let list = $("#sortable_list");
            list.empty();
            temp_upsell.map((item,index)=>{
                if(item.delete == 1) return;
                let dom = `<li class="upsells upsell_item_${index}" data-id="${item.id}">
                    <img class="picture_dishes picture_dishes_x" src="${item.photo_link}" />
                    <div class="detail_dishes">
                        <div class="action_dishes">
                            <div class="checkbox d-inline">
                                <label>
                                    <input checked onclick="activatedUpsell(${index},this)" type="checkbox" name="active"> Active
                                </label>
                            </div>
                            <button onclick="deleteUpsell(${index})" class="btn btn-danger btn-xs d-inline"><i class="fas fa-trash"></i></button>
                        </div>
                        <p class="name_dishes">${item.name} -<span class="price_dishes">$${item.dish_price}</span></p>
                        <p class="desc_dishes">${item.description}</p>
                    </div>
                </li>`;
                list.append(dom);
            });
        }

        $("#upsells_category").change(function(e){
            load_upsell_select_item($(this).val());
        });

        function searchUpsell(id) {
            let status = false;
            temp_upsell.map((item,index)=>{
                if(item.id == id ){
                    item.index = index;
                    status = item;
                } 
            });
            return status;
        }

        function addUpsell(id) {
            const result = searchUpsell(id);
            let data = !result ? temp_upsell_dish_list[id] : result;
            const item = {
                "id_dishes_upsell":data.id,
                "active":1,
                "delete":0,
            };
            data = {...data,...item};
            !result ? temp_upsell.push(data) : temp_upsell[data.index] = data;
            load_upsell_item();
        }

        function deleteUpsell(index) {
            let list = $("#sortable_list");
            let elm_class = ".upsell_item_"+index;
            let elm  = list.find(elm_class);
            elm.remove();
            let data = temp_upsell[index];
            data.delete = 1;
            data.active = 0;
            temp_upsell[index] = data;
            console.log("delete",temp_upsell);
        }

        function activatedUpsell(index,elm) {
            let check = $(elm).is(":checked");
            let data = temp_upsell[index];
            data.active = check ? 1:0;
            temp_upsell[index] = data;
            console.log("activated",data);
        }

        let temp_upsell_dish_list = [];
        function load_upsell_select_item(category) {
            let partner = $("#tpartner_id_upsells").val();
            let input = {
                "scrdata_id": 1138,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "filter_category_id": parseInt(category),
                "filter_tpartner_id": parseInt(partner),
            };
            let list_elm = $("#list_upsell_dish");
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    list_elm.empty();
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.partner_dishes?.map((item,index)=>{
                            temp_upsell_dish_list[item.id] = item;
                            let dom = `<li class="upsells upsell_item_${item.id} upsell_choice">
                                <img class="picture_dishes" src="${item.photo_link}" />
                                <div class="detail_dishes detail_dishes_x">
                                    <div class="action_dishes">
                                        <button onclick="addUpsell(${item.id})" class="btn btn-primary btn-sm">Add to Upsell</button>
                                    </div>
                                    <p class="name_dishes">${item.name} -<span class="price_dishes">$${item.dish_price}</span></p>
                                    <p class="desc_dishes">${item.description}</p>
                                </div>
                            </li>`;
                            list_elm.append(dom);
                        });
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function saveUpsell(elm) {
            elm = $(elm);
            let data = dish_item_upsell;
            data.upsells = temp_upsell;
            let input = {
                "scrdata_id": 1139,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": data.id,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "partner_dishes":[data]
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    elm.attr("disabled",true);
                    elm.html(`<i class="fas fa-circle-notch fa-spin"></i>`);
                },
                complete:function(){
                    elm.removeAttr("disabled");
                    elm.html(`<i class="fas fa-save"></i> Save`);
                    $("#upsell_modals").modal("hide");
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        swal("","Data is Saved and apply","success");
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        let temp_propose = [];
        let dish_item_propose = {};
        function proposeDish(id,elm){
            id = parseInt(id);
            let cat_id = $("#upsells_category").val();
            let modals = $("#propose_modals");
            let input = {
                "scrdata_id": 1272,
                "sp_name": "OK",
                "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                "session_exp": "05/29/2015 05:50:06",
                "status": "OK",
                "item_id": 1,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "lab_test":1,
                "total_records": 0
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){

                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        const data = JSON.parse(response.data);
                        const dish_item = data.partner_dishes[0];
                        dish_item_propose = dish_item;
                        modals.find(".picture_dish_upsell").attr("src",dish_item.photo_link);
                        modals.find(".name_dish_upsell").text(dish_item.name);
                        modals.find(".price_dish_upsell").text(dish_item.dish_price);
                        modals.find(".desc_dish_upsell").text(dish_item.description);
                        $("#tpartner_id_propose").val(data.id_tpartners);
                        temp_propose = dish_item.proposes !== undefined && dish_item.proposes !== null ? dish_item.proposes : [];
                        console.log(temp_propose);
                        load_propose_item();
                        load_propose_select_item(cat_id);
                        modals.modal("show");
                    }
                },
                error:function(error){

                }
            });
        }

        function load_propose_item() {
            let list = $("#sortable_list_propose");
            list.empty();
            temp_propose.map((item,index)=>{
                if(item.delete == 1) return;
                let dom = `<li class="upsells upsell_item_${index}" data-id="${item.id}">
                    <img class="picture_dishes picture_dishes_x" src="${item.photo_link}" />
                    <div class="detail_dishes">
                        <div class="action_dishes">
                            <div class="checkbox d-inline">
                                <label>
                                    <input checked onclick="activatedPropose(${index},this)" type="checkbox" name="active"> Active
                                </label>
                            </div>
                            <button onclick="deletePropose(${index})" class="btn btn-danger btn-xs d-inline"><i class="fas fa-trash"></i></button>
                        </div>
                        <p class="name_dishes">${item.name} -<span class="price_dishes">$${item.dish_price}</span></p>
                        <p class="desc_dishes">${item.description}</p>
                    </div>
                </li>`;
                list.append(dom);
            });
        }

        let temp_propose_dish_list = [];
        function load_propose_select_item(category) {
            let partner = $("#tpartner_id_upsells").val();
            let input = {
                "scrdata_id": 1138,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "filter_category_id": parseInt(category),
                "filter_tpartner_id": parseInt(partner),
            };
            let list_elm = $("#list_propose_dish");
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    list_elm.empty();
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.partner_dishes?.map((item,index)=>{
                            temp_propose_dish_list[item.id] = item;
                            let dom = `<li class="upsells upsell_item_${item.id} upsell_choice">
                                <img class="picture_dishes" src="${item.photo_link}" />
                                <div class="detail_dishes detail_dishes_x">
                                    <div class="action_dishes">
                                        <button onclick="addPropose(${item.id})" class="btn btn-primary btn-sm">Add to Propose</button>
                                    </div>
                                    <p class="name_dishes">${item.name} -<span class="price_dishes">$${item.dish_price}</span></p>
                                    <p class="desc_dishes">${item.description}</p>
                                </div>
                            </li>`;
                            list_elm.append(dom);
                        });
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $("#propose_category").change(function(e){
            load_propose_select_item($(this).val());
        });

        function searchPropose(id) {
            let status = false;
            temp_propose.map((item,index)=>{
                if(item.id == id ){
                    item.index = index;
                    status = item;
                } 
            });
            return status;
        }

        $(document).ready(function(){
            let list = $("#sortable_list_propose");
            list.sortable({
                stop: function(event, ui) {
                    var data = [];

                    list.find("li").each(function(i, el){
                        let id = $(el).data("id");
                        const result = searchPropose(id);
                        if(result) data.push(result);
                    });

                    temp_propose = data;
                }
            });
            list.disableSelection();
        });

        function addPropose(id) {
            const result = searchPropose(id);
            let data = !result ? temp_propose_dish_list[id] : result;
            const item = {
                "id_dishes_upsell":data.id,
                "active":1,
                "delete":0,
            };
            data = {...data,...item};
            !result ? temp_propose.push(data) : temp_propose[data.index] = data;
            load_propose_item();
        }

        function activatedPropose(index,elm) {
            let check = $(elm).is(":checked");
            let data = temp_propose[index];
            data.active = check ? 1:0;
            temp_propose[index] = data;
        }

        function deletePropose(index) {
            let list = $("#sortable_list_propose");
            let elm_class = ".upsell_item_"+index;
            let elm  = list.find(elm_class);
            elm.remove();
            let data = temp_propose[index];
            data.delete = 1;
            data.active = 0;
            temp_propose[index] = data;
            console.log("delete",temp_propose);
        }

        function savePropose(elm) {
            elm = $(elm);
            let data = dish_item_propose;
            data.proposes = temp_propose;
            let input = {
                "scrdata_id": 1273,
                "sp_name": "OK",
                // "session_id": "{{ Request::get("session")->session_id }}",
                // "session_exp": "{{ Request::get("session")->session_exp }}",
                "session_id": "WA9778d400-2a0b-4f43-a91f-ba69e5dbf31d",
                "session_exp": "2021-08-06T05:39:22.06322",
                "lab_test":1,
                "status": "OK",
                "item_id": data.id,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
                "partner_dishes":[data]
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    elm.attr("disabled",true);
                    elm.html(`<i class="fas fa-circle-notch fa-spin"></i>`);
                },
                complete:function(){
                    elm.removeAttr("disabled");
                    elm.html(`<i class="fas fa-save"></i> Save`);
                    $("#propose_modals").modal("hide");
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        swal("","Data is Saved and apply","success");
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }


    </script>

@endsection