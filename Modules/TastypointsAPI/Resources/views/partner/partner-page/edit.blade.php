@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Edit partner")

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
        .img-preview, .img-preview-payment {
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

        .img-preview, .img-preview-payment {
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
        .image_title{
            text-align: center;
            margin-bottom: 5px !important;
            font-weight: bold;
        }
        .container_drop_show {
            display: inline-block;
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
        #drop-area, #drop-area-logo, .drop_thing{
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
            width: 210px;
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
        .drop-item_logo{
            width: 200px;
        }
        .drop-item_image {
            width: 355.56px;
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

@section('content-header',"Edit Business")

@section('content-subheader')
    <small>(Business owner can change their business details)</small>
@endsection

@section('main_content')

    <div class="modal fade" id="payment_modals">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Payments</h4>
                </div>
                <form id="payment_forms">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="item_id" value="0" />
                        <input type="hidden" name="id_tpartners" value="{{ isset($id) ? $id : 0 }}" />
                        <input type="hidden" name="delete" value="0" />
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Payment</label>
                                <select required class="form-control" name="id_payments" id="id_payments">
                                    <option value="" disabled selected>Select Payment</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Payment Name</label>
                                <input class="form-control" name="payment_name" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Fee (Percentage)</label>
                                <input class="form-control" name="fee" required type="number" />
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select required class="form-control" name="active">
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="1" >Active</option>
                                    <option value="0" >Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-6" style="margin-bottom: 10px;">
                                <div class="drop-container" id="payments_active_icon">
                                    <p class="image_title">PHOTO</p>
                                    <div id="drop-area-photo" class="drop_thing">
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
        
                                    <div class="container_drop_show" id="list-preview-photo"></div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-bottom: 10px;">
                                <div class="drop-container" id="payments_inactive_icon">
                                    <p class="image_title">PHOTO SELECTED</p>
                                    <div id="drop-area-photo-selected" class="drop_thing">
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
        
                                    <div class="container_drop_show" id="list-preview-photo-selected"></div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div id="image_editor_container_payment" class="img-container">
                                    <img id="image_editor_payment" src="/images/testing.jpeg">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- <h3>Preview:</h3> -->
                                <div class="docs-preview clearfix">
                                    <div class="img-preview-payment preview-lg"></div>
                                    <div class="img-preview-payment preview-md"></div>
                                    <div class="img-preview-payment preview-sm"></div>
                                    <div class="img-preview-payment preview-xs"></div>
                                </div>
                        
                                <!-- <h3>Data:</h3> -->
                                <div class="docs-data" id="image_editor_payment-data">
                                    <button type="button" onclick="applyImages(this)" style="margin-bottom: 10px;" class="btn btn-primary btn-block"><i class="fa fa-save"></i> Apply Image </button>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">X</span>
                                            <input type="number" class="form-control dataX" />
                                            <span class="input-group-addon">px</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Y</span>
                                            <input type="number" class="form-control dataY" />
                                            <span class="input-group-addon">px</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Width</span>
                                            <input type="number" class="form-control dataWidth" />
                                            <span class="input-group-addon">px</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Height</span>
                                            <input type="number" class="form-control dataHeight" />
                                            <span class="input-group-addon">px</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">Rotate</span>
                                            <input type="number" class="form-control dataRotate" />
                                            <span class="input-group-addon">deg</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">ScaleX</span>
                                            <input type="number" class="form-control dataScaleX" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon">ScaleX</span>
                                            <input type="number" class="form-control dataScaleY" />
                                        </div>
                                    </div>
                                </div>
        
                            </div>
                            <div class="col-md-12">
                                <div class="row" id="image_editor_payment-actions">
        
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
                                    
                                    </div>
                            
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="main_page">
        <h3>Payments</h3>
        <div class="text-right">
            <button class="btn btn-primary" id="open_payments"><i class="fas fa-plus"></i> Add</button>
        </div>
        <div class="table_container">
            <table class="table table-bordered table-striped" 
            id="payments_table"
            >
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Fee</th>
                        <th>Status</th>
                        <th>Photo</th>
                        <th>Photo Selected</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('new-box')

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

    <div class="col-sm-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="text-right">
                    <button onclick="$('#form_data').trigger('submit')" class="btn btn-success"> <i class="fas fa-save"></i> SUBMIT </button>
                </div>
                <form id="form_data">
                    <input type="hidden" name="item_id" value="{{ isset($id) ? $id : 0 }}" />
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
                                        <option selected value="">Select State</option>
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
                                            <input id="serial_number" name="pos_terminal[serial_number]" type="text" class="form-control" placeholder="Activation code here">
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
                                            <input id="pos_terminal_code" name="pos_terminal[code]" type="text" class="form-control">
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
                                            <input name="password_confirm" type="password" class="form-control" />
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
                        <button class="btn btn-primary"><i class="fas fa-plus"></i> Add</button>
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
                <div tabindex="-1" class="modal fade" id="add_new_staff" role="dialog" aria-hidden="true" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title">Staff Data</h4>
                        </div>
                        <form id="form_staff">
                            @csrf
                            <input type="hidden" name="item_id" value="0" />
                            <input type="hidden" name="tpartner_id" value="{{ isset($id) ? $id : -1 }}" />
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
                                                <input id="random_value" readonly type="number" required name="pin" class="form-control" placeholder="Staff pin" />
                                                <span class="input-group-btn">
                                                    <button id="randomPin" type="button" class="btn btn-primary" type="button"><i class="fas fa-random"></i></button>
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
            
                <div class="main_page">
                    <h3>Company Staff</h3>
                    <div class="text-right">
                        <button class="btn btn-primary" id="open_staff"><i class="fas fa-plus"></i> Add</button>
                    </div>
                    <div class="table_container">
                        <table class="table table-bordered table-striped" 
                        id="company_staff"
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
            // Tooltip
            $('[data-toggle="tooltip"]').tooltip();

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
            
        let industry_data = [];
        function load_industry(options) {
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

            if(options.selected !== undefined && options.selected !== null) elm.val(options.selected).trigger("change");

        }

        let currency_data = [];
        function load_currency(options) {
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

            if(options.selected !== undefined && options.selected !== null) elm.val(options.selected).trigger("change");

        }

        let country_data = [];
        function load_country(options) {
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
                },
                complete:function(){
                    if(options.selected !== undefined && options.selected !== null) {
                        country_selected = options.selected;
                        elm.val(options.selected).trigger("change");
                    }
                }
            });

        }

        let language_data = [];
        function load_language(options) {
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

                        elm.empty();
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

            if(options.selected !== undefined && options.selected !== null) elm.val(options.selected).trigger("change");

        }

        let country_selected = "";
        $("#country_id").change(function(e){
            let val = $(this).val();
            country_selected = val == null ? country_selected : val;
            country_selected = parseInt(country_selected);
            let options = {
                "filter_country_id":country_selected
            };

            let item = country_data[country_selected];

            if(item.currency !== null ) $("#currency_id").val(item.currency.currency_id).trigger("change");

            if(item.language !== null ){
                load_language({selected:item.language.language_id});
            }

            load_state(options);

            // if(state_selected !== "") options.filter_state_id = state_selected;
            state_selected = "";
            // city_selected = "";

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
            console.log(input);
            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);

                        elm.empty();
                        elm.append('<option selected value="">Select State</option>');

                        data.state.map((item,index)=>{
                            state_data[item.id] = item;
                            // elm.append(new Option(item.state_name, item.id));
                            elm.append('<option value="'+item.id+'" data-code="'+item.state_code+'">'+item.state_name+'</option>');
                        });
                        // elm.select2();
                        // if(state_selected == "") return ;
                        // let check = elm.find("option[value="+state_selected+"]");
                        // if(check.length == 0) elm.append('<option value="'+partners.state.id+'">'+partners.state.name+'</option>');
                        // elm.val(state_selected).trigger('change');

                    }
                },
                error:function(error){
                    console.log(error);
                },
                complete:function(){
                    if(state_selected == "") return ;
                    let check = elm.find("option[value="+state_selected+"]");
                    if(check.length == 0) elm.append('<option value="'+partners.state.id+'">'+partners.state.name+'</option>');
                    console.log(state_selected,check);
                    elm.val(state_selected).trigger('change');
                }
            });
        }

        let state_selected = "";
        $("#state_id").change(function(e){
            // state_selected = $(this).val();
            // state_selected = parseInt(state_selected);
            // load_city({
            //     "filter_state_id":state_selected
            // });
        });

        let city_data  = [];
        let city_selected = "";
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
                },
                complete:function(){
                    if(city_selected !== "") elm.val(city_selected).trigger('change');
                }
            });
        }

        $('#city_id').change(function(e){

            let val = $(this).val();
            let value = city_data[val];
            if(value == undefined) value.status_id = "";
            if(value.state_id == undefined) return ;
            state_selected = value.state_id;
            console.log(value.state_id,state_selected);
            $("#state_id").val(value.state_id).trigger("change");
            if(value.timezone_id !== undefined) $("#time_zone").val(value.timezone_id).trigger("change");

        });

        let timezone_data = [];
        function load_timezone(options) {
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
                },
                complete:function(){
                    if(options.selected !== undefined && options.selected !== null) elm.val(options.selected).trigger("change");
                }
            });
        }
        
        let status_data = [];
        function load_status(options) {
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
                },
                complete:function(){
                    if(options.selected !== undefined && options.selected !== null) elm.val(options.selected).trigger("change");
                }
            });
        }

        let partner_type_data = [];
        function load_partner_type(options) {
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
                },
                complete:function(){
                    if(options.selected !== undefined && options.selected !== null) elm.val(options.selected).trigger("change");
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
        
    </script>

    <script>
        let delivery_option_set = [];
        let partners = null;
        let page_id = {{ isset($id) ? $id : 0 }};
        function load_partner() {
            let input = {
                "scrdata_id": 1002,
                "sp_name": "OK",
                "session_id": "WAc039bb18-b5ea-4cf0-ad8f-f88f013575d5",
                "session_exp": "2021-04-07T08:01:27.899941",
                "status": "OK",
                "item_id": page_id,
                "max_row_per_page": 50,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3
            };

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);
                        if(data.partners == null) return ;
                        partners = data.partners[0];

                        let partner_groups = partners.partner_group;
                        $("#partner_groups").val(partner_groups.id).trigger("change");

                        let loc = {
                            "lat":parseFloat(partners.location.lat),
                            "lng":parseFloat(partners.location.lon)
                        };

                        $("#location_lat").val(loc.lat);
                        $("#location_lon").val(loc.lng);

                        if(marker !== null) marker.setPosition(loc);
                        if(map !== null) map.setCenter(loc);

                        let elm = $("#form_data");
                        for(key in partners){
                            let value = partners[key];
                            if(typeof value !== "array" && typeof value !== "object" ){
                                let result_elm = elm.find("[name="+key+"]");
                                if(result_elm.length >= 0){
                                    result_elm.val(value);
                                }
                            }
                        }

                        partners.phone.map((item)=>{
                            if(item.phone_type_id == 1) {
                                elm.find("[name=phone]").val(item.phone);
                            } else {
                                elm.find("[name=alternate_phone]").val(item.phone);
                            }
                        });

                        const pos_terminal = partners.pos_terminal[0];
                        elm.find("#serial_number").val(pos_terminal.serial_number);
                        elm.find("#pos_terminal_code").val(pos_terminal.code);

                        if(partners.images !== null){
                            partners.images.map((item)=>{
                                if(item.photo_type_id == 1){
                                    let elm = $("#list-preview-logo");
                                    elm.empty();
                                    let new_data = '<div class="drop-item drop-item_logo" id="template_logo">'+
                                                        '<img src="'+item.photo_link+'" class="image_uploaded" />'+
                                                        '<div class="drop-overlay">'+
                                                            '<a onclick="editImage('+"'logo'"+')" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a>'+
                                                            '<a onclick="deleteImage('+"'logo'"+')" href="javascript:void(0)" data-dz-remove><i class="fas fa-trash"></i></a>'+
                                                        '</div>'+
                                                    '</div>';
                                    elm.append(new_data);
                                    logo = item.photo_link;
                                    return;
                                } else {
                                    item.delete = 0;
                                    data_image.push(item);
                                }
                            });
                            renderImage();
                        }

                        partners.weekedays.map((item,index)=>{
                            oh_data[item.weekday_id] = {
                                "morning":{
                                    "open":item.morning_start_time,
                                    "close":item.morning_end_time,
                                },
                                "afternoon":{
                                    "open":item.evening_start_time,
                                    "close":item.evening_end_time,
                                },
                                "name":item.weekday_name,
                                "id":item.weekday_id,
                            };
                            $("#oh_content").append('<div class="oh_item" data-name="'+item.weekday_name+'" data-id="'+item.weekday_id+'">'+item.weekday_name+'</div>'); 
                        });

                        load_industry({selected:partners.industry.id});
                        load_currency({selected:partners.currency.id});
                        load_timezone({selected:partners.time_zone.id});
                        load_status({selected:partners.status.id});
                        load_partner_type({selected:partners.partner_type[0].id});

                        // state_selected = partners.state.id == 0 ? "" : partners.state.id;
                        // console.log(state_selected);
                        city_selected = partners.city.id;
                        // state_selected = 10;
                        load_country({selected:partners.country.id});

                        delivery_option_set = partners.delivery_option == null ? [] : partners.delivery_option;
                        select_val = delivery_option_set.map((item,index)=>{
                            return item.delivery_option_id;
                        });

                        load_delivery_option();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $(document).ready(function(e){
            load_partner();
            load_photo_type();
        });
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
        let map = null;

        function handleEventMarker(event) {
            var lat = event.latLng.lat();
            var lng = event.latLng.lng();
            $("#location_lat").val(lat);
            $("#location_lon").val(lng);
        }

        function initialize() {

            let myLatlng = { lat: -33.8688, lng: 151.2195 };

            map = new google.maps.Map(document.getElementById("map"), {
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
                        "photo_link":response.link,
                        "photo_id":0,
                    };
                    // data_image.push( response.link );
                    data_image.push( new_data );
                    console.log(data_image);
                    active_image = response.link;
                    active_image_index = data_image.length-1;
                    renderImage();

                    $("#image_type_editor").show();
                    $("#image_type_editor select").val(val).trigger("change");
                }
                
            },
        };

        function renderImage() {
            let elm = $("#list-preview-image");
            elm.empty();
            data_image.map((item,index)=>{
                let new_data = '<div class="drop-item drop-item_image" id="template_id_'+index+'">'+
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
                    // console.log(val);
                    val = parseInt(val);
                    // let new_data = {
                    //     "photo_type_id":val,
                    //     "photo_link":response.link
                    // };
                    $("#template_id_"+active_image_index+" img").attr("src",response.link);

                    let data = data_image[active_image_index];
                    if(data == undefined) return ;
                    data.photo_type_id = val;
                    data.photo_link = response.link;
                    console.log(data,data_image[active_image_index]);
                    data_image[active_image_index] = data;
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

        var myDropzone = new Dropzone(document.body, optionsDrop);

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
                                        '<img src="'+response.link+'" class="image_uploaded" style="width:200px;" />'+
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
                },
                complete:function(){
                    $('#delivery_option').val(select_val).trigger("change");
                    renderDeliveryForm();
                    delivery_option_set.map((item)=>{
                        let elm = $(".delivery_selected_"+item.delivery_option_id);
                        let input = elm.find("input");
                        input.val(item.fee).trigger("change");
                        // input.attr("data-doid",item.partner_delivery_option_id);
                    });
                }
            });
        }

        function renderDeliveryForm() {
            let string = "";
            $("#list_delivery").empty();
            select_val.map((item,index)=>{
                const result = searchDelivery(item);
                if(result){
                    let doid = searchDeliveryDataSet(item);
                    string = string+'<div class="delivery_item delivery_selected_'+result.id+'">'+
                                    '<div class="item_text"><span class="remove_data" onClick="removeDelivery('+result.id+')" >x</span> '+result.text+'</div>'+
                                    '<div class="form-group delivery_field">'+
                                        '<input type="number" value="'+doid.fee+'" data-doid="'+doid.partner_delivery_option_id+'" name="deliveryfee['+result.id+']" class="form-control" placeholder="Set delivery fee" required />'+
                                    '</div>'+
                                '</div>';
                }
            });
            $("#list_delivery").html(string);
        }

        function searchDelivery(value) {
            let data = false;
            data_option.map((item,index)=>{
                if(item.id == value) data = item;
            });
            return data;
        }

        function searchDeliveryDataSet(value) {
            let data = {"partner_delivery_option_id":0,"fee":0};
            delivery_option_set.map((item,index)=>{
                if(item.delivery_option_id == value) data = item;
            });
            return data;
        }

        function removeDelivery(id) {
            var wanted_option = $('#delivery_option option[value="'+ id +'"]');
            wanted_option.prop('selected', false);
            $(".delivery_selected_"+id).remove();
            select_val = select_val.map(Number);
            var index = select_val.indexOf(id);
            if (index !== -1) {
                select_val.splice(index, 1);
            }
            console.log(select_val);
            $('#delivery_option').trigger('change.select2');
        }

        let select_val = [];

        $(document).ready(function() {

            $('#delivery_option').on("select2:select", function (evt) {
                var element = evt.params.data.element;
                var $element = $(element);
                
                $element.detach();
                $(this).append($element);
                $(this).trigger("change");

                select_val = $(evt.currentTarget).val();
                select_val = select_val.map(Number);
                renderDeliveryForm();
                
                console.log(select_val);
            });

            $('#delivery_option').on("select2:unselect", function (evt) {
                select_val = $(evt.currentTarget).val();
                select_val = select_val.map(Number);
                renderDeliveryForm();
                console.log(select_val);
            });


        });

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
                            oh_data[item.name] = {
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
                           elm.append('<div class="oh_item" data-name="'+item.name+'" data-id="'+item.id+'">'+item.name+'</div>'); 
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $(document).ready(function(){
            // load_weekdays();
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

            console.log(oh_data);

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
            submitHandler:function(form){
                if(logo == null) {
                    swal("Please Upload Logo.",{icon:"error"});
                    return ;
                }
                let input = {
                        "scrdata_id": 1003,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = page_id;

                gotForm.location = {
                    "lat":$("#location_lat").val(),
                    "lon":$("#location_lon").val()
                };

                gotForm.partner_group = {"id":$("#partner_groups").val()};

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
                            let id = parseInt(matches[1]);
                            let fee = parseFloat($(this).val());
                            let doid = parseInt($(this).data("doid"));
                            let new_data =  {
                                "delivery_option_id": id,
                                "partner_delivery_option_id": doid,
                                "in_order": index+1,
                                "fee": fee,
                                "delete":0,
                            };
                            delivery_option.push(new_data);
                        }
                    });
                    gotForm.delivery_option = delivery_option;

                }

                delivery_option_set.map((item,index)=>{
                    let value = item.delivery_option_id;
                    // console.log(!select_val.includes(value) ,select_val,value);
                    // console.log(!select_val.includes(""+item.delivery_option_id), item.delivery_option_id);
                    if( !select_val.includes(value) ) {
                        item.delete = 1;
                        gotForm.delivery_option.push(item);
                    }
                });
                // console.log("delivery_option",gotForm.delivery_option);
                // console.log("data set",delivery_option_set);
                // return;

                gotForm.industry = industry_data[gotForm.industry_id];
                gotForm.country = country_data[gotForm.country_id];
                gotForm.city = city_data[gotForm.city_id];
                gotForm.currency = currency_data[gotForm.currency_id];
                gotForm.state = state_data[gotForm.state_id];
                gotForm.status = status_data[gotForm.status_id];

                let partner = partner_type_data[gotForm.partner_type_id];
                partner.delete = 0;
                gotForm.partner_type = [partner];

                gotForm.phone = partners.phone.map((item)=>{
                    item.phone = item.phone_type_id == 1 ? 
                    $("input[name=phone]").val() :
                    $("input[name=alternate_phone]").val();
                    item.delete = 0;
                    return item;
                });

                let id_images = data_image.map((item)=>{
                    return item.photo_id;
                });

                gotForm.images = data_image;
                if(partners.images !== null) {
                    let delete_images = [];
                    partners.images.map((item)=>{
                        if(!id_images.includes(item.photo_id)){
                            item.delete = 1;
                            gotForm.images.push(item);
                        }
                        // if(item.photo_type_id == 1){
                        //     item.photo_link = logo;
                        //     item.delete = 0;
                        //     gotForm.images.push(item);
                        // }
                    });
                }
                let count_logo = 0;
                gotForm.images.map((val,index)=>{
                    if(val.photo_type_id == 1){
                        count_logo += 1;
                        val.photo_link = logo;
                        val.delete = 0;
                        gotForm.images[index] = val;
                    }
                });
                if(count_logo <= 0) gotForm.images.push({
                    photo_link: logo,
                    photo_type_id: 1,
                    photo_id:0,
                    delete:0,
                });

                // console.log(gotForm.images);
                // return ;
                

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

    $("#open_staff").click(()=>{
        let elm = $("#form_staff");
        elm.find("input").val("");
        elm.find("select").val("");
        elm.find("[name=item_id]").val(0);
        $("#add_new_staff").modal("show");
    });

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
            gotForm.tpartner_id = parseInt(page_id);

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
        "filter_tpartner_id": page_id,
        "max_row_per_page": 50,
        "search_term": "0",
        "search_term_header": "0",
        "pagination": 1,
        "total_records": 3,
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
                    return '<button class="btn btn-primary btn-xs" onclick="editStaff('+
                    "'"+data+"'"+
                    ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroyStaff('+
                    "'"+data+"'"+
                    ')">Delete</button>';
                }
            }
        ],
    });

    function editStaff(id){
        let input = {
            "scrdata_id": 1046,
            "sp_name": "OK",
            "session_id": "WAa4a0f537-94ff-4773-a7cc-87fefa870e98",
            "session_exp": "2021-04-08T09:47:25.290374",
            "status": "OK",
            "item_id": parseInt(id),
            "filter_tpartner_id": page_id,
            "max_row_per_page": 50,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3
        };

        $.ajax({
            url:"{{ route('tastypointsapi.testnet') }}",
            type:"post",
            data:{"input":JSON.stringify(input)},
            success:function(response){
                response = JSON.parse(response);
                if(response.status){
                    
                    let data = JSON.parse(response.data);
                    let staff = data.staff[0];

                    let form = $("#form_staff");
                    for (key in staff) {
                        let field = form.find("[name="+key+"]");
                        const value = staff[key];
                        if(field.length > 0) field.val(value).trigger("change");
                    }

                    form.find("[name=item_id]").val(id);
                    
                    $("#add_new_staff").modal("show");

                }
            },
            error:function(error){
                console.log(error);
            }
        });
    }

    function destroyStaff(id) {
        id = parseInt(id);
        let staff = temp_data[id];
        staff.delete = 1;
        let input = {
            "scrdata_id": 1047,
            "session_id": json.session_id,
            "session_exp": json.session_exp,
            "delete": 1,
            "item_id":id,
            "status": "OK",
            "max_row_per_page": 50,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3,
            "staff": [
                staff
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
                            console.log("request delete",input);
                            if(response.status){
                                swal("Data has been deleted!", {
                                    icon: "success",
                                });
                                compay_table.draw(false);
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

    function makeid(length) {
        var result           = [];
        var characters       = '0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result.push(characters.charAt(Math.floor(Math.random() * 
            charactersLength)));
        }
        return result.join('');
    }

    $("#randomPin").click(function(){
        $("#random_value").val(makeid(4));
    });

</script>

    <script>
        let json_edit = {
            "scrdata_id": 1146,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "status": "OK",
            "item_id": 0,
            "id_partners": page_id,
            "id_payment": 0,
            "max_row_per_page": 50,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 1,
            "total_records": 3,
        };
        let temp_payments = [];
        let payments_table = $("#payments_table").DataTable({
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
                    d.input = JSON.stringify(json_edit);
                    d.scr_name = "partner_payments";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_payments[item.id] = item;
                    });
                    return json.data;
                },
            },
            "columns": [
                { 
                    data: "payment_name"
                },
                { 
                    data: "fee",
                },
                { 
                    data: "active",
                },
                { 
                    data: "photo",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return `<img src=${data} style="height:100px;width:100px;" />`;
                    }
                },
                { 
                    data: "photo_selected",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return `<img src=${data} style="height:100px;width:100px;" />`;
                    }
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="editPaymens('+
                        "'"+data+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroyPayments('+
                        "'"+data+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });

        
        // payments script
        $("#payment_forms").validate({
            submitHandler:function(form){
                let input = {
                        "scrdata_id": 1147,
                        "session_id": "{{ Request::get("session")->session_id }}",
                        "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                delete gotForm._token;
                gotForm.item_id = parseInt(gotForm.item_id);

                // clean from bracket
                for (var key in gotForm) {
                    if(
                        key.includes("delete") ||
                        key.includes("active") ||
                        key.includes("fee") ||
                        key.includes("id")
                    ){
                        let val = gotForm[key];
                        gotForm[key] = parseInt(val);
                    }
                }
                gotForm.photo = data_image_payments.active_icon;
                gotForm.photo_selected = data_image_payments.inactive_icon;
                input.partner_payments = [gotForm];
                input.item_id = gotForm.item_id;

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
                                $("#payment_modals").modal("hide");
                                payments_table.draw(false);
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

        $("#open_payments").click( () => {
            $("#payment_forms input").val("");
            $("#payment_forms [name=item_id]").val(0);
            $("#payment_forms [name=id_tpartners]").val(page_id);
            $("#payment_forms [name=delete]").val(0);
            $("#payment_forms select").val("");
            data_image_payments = {
                "active_icon":"/images/testing.jpeg",
                "inactive_icon":"/images/testing.jpeg",
            };
            loadPaymentPhoto();
            $("#payment_modals").modal("show")
        });
        
        let temp_payment_options = [];
        function load_payments() {
            let input = {
                "scrdata_id": 1148,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000,
                "search_term": "",
                "search_term_header":"",
            };

            let elm = $("#id_payments");

            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        
                        let data = JSON.parse(response.data);
                        // elm.empty();
                        data.payment_options.map((item,index)=>{
                            elm.append('<option data-photo="'+item.photo+'" data-photo_selected="'+item.photo_selected+'" value="'+item.id+'">'+item.name+'</option>');
                            temp_payment_options[item.id] = item;
                        });

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $("#id_payments").change(function(e){
            let elm = $(this).find("option:selected");
            const text = elm.text();
            const id = elm.val();
            const photo = elm.data("photo");
            const photo_selected = elm.data("photo_selected");
            if(photo !== null && photo !== undefined && photo !== "undefined"){
                $("#list-preview-photo img").attr("src",photo);
                cropper_payment.replace(photo);
                data_image_payments.active_icon = photo;
            }
            if(photo_selected !== null && photo_selected !== undefined && photo_selected !== "undefined"){
                $("#list-preview-photo img").attr("src",photo_selected);
                data_image_payments.inactive_icon = photo_selected;
            } 
            let form = $("#payment_forms");
            form.find("[name=payment_name]").val(text);
        });

        $(document).ready(function(){
            load_payments();
        });

        function editPaymens(id) {
            try {
                const data = temp_payments[id];
                console.log(data);
                let form = $("#payment_forms");
                for(key in data){
                    const val = data[key];
                    form.find("[name="+key+"]").val(val);
                }
                form.find("[name=item_id]").val(data.id);
                data_image_payments.active_icon = data.photo;
                data_image_payments.inactive_icon = data.photo_selected;
                loadPaymentPhoto();
                $("#payment_modals").modal("show");
            } catch (error) {
                console.log(error);
            }

        }

        function destroyPayments(id) {
            try {
                id = parseInt(id);
                const data = temp_payments[id];
                data.delete = 1;
                let input = {
                    "scrdata_id": 1147,
                    "session_id": json.session_id,
                    "session_exp": json.session_exp,
                    "delete": 1,
                    "item_id":id,
                    "status": "OK",
                    "max_row_per_page": 50,
                    "search_term": "0",
                    "search_term_header": "0",
                    "pagination": 1,
                    "total_records": 3,
                    "partner_payments": [
                        data
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
                                    console.log("request delete",input);
                                    if(response.status){
                                        swal("Data has been deleted!", {
                                            icon: "success",
                                        });
                                        payments_table.draw(false);
                                    }
                                },
                                error:function(error){
                                    console.log(error);
                                }
                            });
                        });
                    }
                });

            } catch (error) {
                console.log(error);
            }
        }

            // Tooltip
            $('[data-toggle="tooltip"]').tooltip();
            
            var container = document.getElementById('image_editor_container_payment');
            var image = container.getElementsByTagName('img').item(0);
            var actions = document.getElementById('image_editor_payment-actions');
            let field_data = $("#image_editor_payment-data");

            var options = {
                aspectRatio: 16 / 9,
                preview: '.img-preview-payment',
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

                    data.rotate = data.rotate !== undefined ? data.rotate : '';
                    data.scaleX = data.scaleX !== undefined ? data.scaleX : '';
                    data.scaleY = data.scaleY !== undefined ? data.scaleY : '';
                    
                    field_data.find(".dataX").val( Math.round(data.x));
                    field_data.find(".dataY").val( Math.round(data.y));
                    field_data.find(".dataHeight").val( Math.round(data.height));
                    field_data.find(".dataWidth").val( Math.round(data.width));
                    field_data.find(".dataRotate").val( Math.round(data.rotate));
                    field_data.find(".dataScaleX").val( Math.round(data.scaleX));
                    field_data.find(".dataScaleY").val( Math.round(data.scaleY));

                },
                zoom: function (e) {
                    console.log(e.type, e.detail.ratio);
                }
            };

            let data_image_payments = {
                "active_icon":"/images/testing.jpeg",
                "inactive_icon":"/images/testing.jpeg",
            };
            let type_payments = "active_icon";
            
            var cropper_payment = null;

            $('#payment_modals').on('shown.bs.modal', function () {
                image.src = data_image_payments[type_payments];
                if(cropper_payment !== null) cropper_payment.destroy();
                cropper_payment = new Cropper(image, options);
            });

            var originalImageURL = image.src;
            var uploadedImageType = 'image/jpeg';
            var uploadedImageName = 'cropped.jpg';
            var uploadedImageURL;

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

                if (!cropper_payment) {
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
                        cropBoxData = cropper_payment.getCropBoxData();
                        canvasData = cropper_payment.getCanvasData();

                        options.ready = function () {
                            console.log('ready');
                            cropper_payment.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                        };
                    } else {
                        options[target.name] = target.value;
                            options.ready = function () {
                            console.log('ready');
                    };
                }

                    // Restart
                    cropper_payment.destroy();
                    image.src = data_image_payments[type_payments];
                    cropper_payment = new Cropper(image, options);
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

                if (!cropper_payment) {
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

                cropped = cropper_payment.cropped;

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
                                cropper_payment.clear();
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

                    result = cropper_payment[data.method](data.option, data.secondOption);

                    switch (data.method) {
                        case 'rotate':
                            if (cropped && options.viewMode > 0) {
                                cropper_payment.crop();
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
                            cropper_payment = null;

                            if (uploadedImageURL) {
                                URL.revokeObjectURL(uploadedImageURL);
                                uploadedImageURL = '';
                                image.src = originalImageURL;
                            }

                        break;
                    }

                    if (typeof result === 'object' && result !== cropper_payment && input) {
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

                if (e.target !== this || !cropper_payment || this.scrollTop > 300) {
                return;
                }

                switch (e.keyCode) {
                case 37:
                    e.preventDefault();
                    cropper_payment.move(-1, 0);
                    break;

                case 38:
                    e.preventDefault();
                    cropper_payment.move(0, -1);
                    break;

                case 39:
                    e.preventDefault();
                    cropper_payment.move(1, 0);
                    break;

                case 40:
                    e.preventDefault();
                    cropper_payment.move(0, 1);
                    break;
                }
            };

            function initDropzone(elm_id,type_image,show_elm) {
                let payments_options = { 
                    url: "{{ route("tastypointsapi.upload","image") }}",
                    clickable: ["#"+elm_id,"#"+elm_id+" p","#"+elm_id+" i"],
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
                        file.previewElement.outerHTML = "";
                    },
                    success: function(file, response){
                        if(response.success){
                            
                            type_payments = type_image;
                            cropper_payment.replace(response.link);
                            data_image_payments[type_image] = response.link;
                            let elm = $("#"+show_elm);
                            elm.empty();
                            let new_data = '<div class="drop-item">'+
                                                '<img src="'+response.link+'" class="image_uploaded" style="width:200px;" />'+
                                                '<div class="drop-overlay">'+
                                                    '<a onclick="editImagePayments('+"'"+type_image+"'"+')" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a>'+
                                                    '<a onclick="deleteImagePayments('+"'"+show_elm+"'"+')" href="javascript:void(0)" data-dz-remove><i class="fas fa-trash"></i></a>'+
                                                '</div>'+
                                            '</div>';
                            elm.append(new_data);
                        } else {
                            this.removeAllFiles();
                        }
                    },
                };
                return new Dropzone(document.getElementById(elm_id), payments_options);
            }

            function loadPaymentPhoto() {
                for(key in data_image_payments){
                    const val = data_image_payments[key];
                    const show_elm = key == "active_icon" ? "list-preview-photo" : "list-preview-photo-selected";
                    console.log(show_elm);
                    let elm = $("#"+show_elm);
                    elm.empty();
                    let new_data = '<div class="drop-item">'+
                                        '<img src="'+val+'" class="image_uploaded" style="width:200px;" />'+
                                        '<div class="drop-overlay">'+
                                            '<a onclick="editImagePayments('+"'"+key+"'"+')" href="javascript:void(0)"><i class="fas fa-pencil-alt"></i></a>'+
                                            '<a onclick="deleteImagePayments('+"'"+show_elm+"'"+')" href="javascript:void(0)" data-dz-remove><i class="fas fa-trash"></i></a>'+
                                        '</div>'+
                                    '</div>';
                    elm.append(new_data);
                }
            }

            const dropPhoto =  initDropzone("drop-area-photo","active_icon","list-preview-photo");
            const dropPhotoSelected =  initDropzone("drop-area-photo-selected","inactive_icon","list-preview-photo-selected");

            function applyImages(elm) {
                elm = $(elm);
                // Upload cropped image to server if the browser supports `HTMLCanvasElement.toBlob`.
                // The default value for the second parameter of `toBlob` is 'image/png', change it if necessary.
                cropper_payment.getCroppedCanvas().toBlob((blob) => {
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
                        data_image_payments[type_payments] = response.link;
                        console.log($("#payments_"+type_payments+" img"),data_image_payments[type_payments]);
                        $("#payments_"+type_payments+" img").attr("src",response.link);
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
            }

            function editImagePayments(type_image) {
                type_payments = type_image;
                const img = data_image_payments[type_image];
                cropper_payment.replace(img);
            }

            function deleteImagePayments(container_elm) {
                $("#"+container_elm).empty();
            }

    </script>

@endsection