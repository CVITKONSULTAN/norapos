@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Delivery Settings")

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
            padding-bottom: 25px;
        }
        .image_title{
            text-align: center;
            margin-bottom: 5px !important;
            font-weight: bold;
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
            width: 150px;
            height: 150px;
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
            margin-top: 15%;
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
    </style>


@endsection

@section('content-header',"Delivery Settings")

@section('main_content')

    <div class="main_page">
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Delivery Name</th>
                        <th>Status</th>
                        <th>Description</th>
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
                <form id="form_data">
                    @csrf
                    <input type="hidden" name="item_id" value="0" />

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Delivery Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-briefcase"></i></span>
                                    <input required name="delivery_option_name" class="form-control" placeholder="Delivery option name" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="input-group">
                                    <span class="input-group-addon"></span>
                                    <select required name="delivery_option_active" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 action_form">
                            <button class="btn btn-primary"><i class="fas fa-plus"></i> New</button>
                            <button class="btn btn-primary"><i class="fas fa-save"></i> Save / Apply</button>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Description : </label>
                                <textarea name="delivery_option_description" class="form-control" rows="9"></textarea>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="dropzone-container">

                                <div class="drop-container">
                                    <p class="image_title">ACTIVE ICON</p>
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
                                    <div id="list-preview-image" class="list-preview-image">
                                        <div class="drop-item" id="template_active">
                                            <img data-dz-thumbnail class="image_uploaded" id="active_icon" />
                                            <div class="drop-overlay">
                                                <a href="javascript:void(0)" onclick="EditImage('active_icon')" ><i class="fas fa-pencil-alt"></i></a>
                                                <a href="javascript:void(0)" data-dz-remove><i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="drop-container">
                                    <p class="image_title">INACTIVE ICON</p>
                                    <div id="drop-area-inactive" class="drop-area">
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

                                    <div id="list-preview-image-inactive" class="list-preview-image">
                                        <div class="drop-item" id="template_inactive">
                                            <img data-dz-thumbnail class="image_uploaded" id="active_icon" />
                                            <div class="drop-overlay">
                                                <a href="javascript:void(0)" onclick="EditImage('inactive_icon')" ><i class="fas fa-pencil-alt"></i></a>
                                                <a href="javascript:void(0)" data-dz-remove><i class="fas fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                    <div class="row">
                        <div class="col-md-9">
                            <div id="image_editor_container" class="img-container">
                                <img id="image_editor" src="/images/testing.jpeg">
                            </div>
                        </div>

                        <div class="col-md-3">

                            {{-- Save Button --}}
                            <button type="button" id="save_image" class="btn btn-primary btn-block">Save Image</button>

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
                            
                                    <div class="btn-group">
                                    <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.reset()">
                                        <span class="fa fa-sync-alt"></span>
                                        </span>
                                    </button>
                                    <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                                        {{-- <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*"> --}}
                                        <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
                                        <span class="fa fa-upload"></span>
                                        </span>
                                    </label>
                                    <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
                                        <span class="docs-tooltip" data-toggle="tooltip" title="cropper.destroy()">
                                        <span class="fa fa-power-off"></span>
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

                    </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.js"></script>

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
                    image.src = type == "inactive_icon" ? data_image.inactive_icon : data_image.active_icon;
                    
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

        
        // Get the template HTML and remove it from the doument
        let previewNode = document.querySelector("#template_active");
        previewNode.id = "";
        let previewTemplate = previewNode.parentNode.innerHTML;
        // previewNode.parentNode.removeChild(previewNode);

        let data_image = {
            "active_icon":null,
            "inactive_icon":null,
        };
        let type = null;

        let active_options = { 
            url: "{{ route("tastypointsapi.upload","image") }}",
            clickable: ["#drop-area","#drop-area p","#drop-area i"],
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
                file.previewElement.outerHTML = "";
            },
            success: function(file, response){
                console.log(response);
                if(response.success){
                    type = "active_icon";
                    cropper.replace(response.link);
                    data_image.active_icon = response.link;
                    $("#list-preview-image img").attr("src",response.link);
                } else {
                    this.removeAllFiles();
                }
            },
        };

        previewNode = document.querySelector("#template_inactive");
        previewNode.id = "";
        previewTemplate = previewNode.parentNode.innerHTML;
        // previewNode.parentNode.removeChild(previewNode);

        let inactive_options = { 
            url: "{{ route("tastypointsapi.upload","image") }}",
            clickable: ["#drop-area-inactive","#drop-area-inactive p","#drop-area-inactive i"],
            previewsContainer: "#list-preview-image-inactive",
            previewTemplate: previewTemplate,
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
                file.previewElement.outerHTML = "";
            },
            success: function(file, response){
                console.log(response);
                if(response.success){
                    type = "inactive_icon";
                    cropper.replace(response.link);
                    data_image.inactive_icon = response.link;
                    $("#list-preview-image-inactive img").attr("src",response.link);
                } else {
                    this.removeAllFiles();
                }
            },
        };

        let myDropzone = $("#drop-area").dropzone(active_options);
        let myDropzone2 = $("#drop-area-inactive").dropzone(inactive_options);

        function EditImage(id_element) {
            type = id_element;
            let image_src = id_element == "active_icon" ? data_image.active_icon : data_image.inactive_icon;
            console.log(image_src,id_element);
            cropper.replace(image_src);
        }

        $("#save_image").click(function(){
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
                success(response) {
                    if(type == "active_icon"){
                        $("#list-preview-image img").attr("src",response.link);
                        data_image.active_icon = response.link;
                    } else {
                        $("#list-preview-image-inactive img").attr("src",response.link);
                        data_image.inactive_icon = response.link;
                    }
                },
                error(error) {
                    console.log('Upload error',error);
                },
            });
            }/*, 'image/png' */);
        });

    </script>

<script>

    let json = {
        "scrdata_id": 1066,
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
        "scrdata_lab_category": [],
    };

    let temp_data = [];
    let otable = $("#table_data").DataTable({
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
                d.scr_name = "delivery_options";
                return d;
            },
            "dataSrc": function ( json ) {
                json.data.map((item,index)=>{
                    temp_data[item.delivery_option_id] == undefined ? temp_data[item.delivery_option_id] = item : temp_data[item.delivery_option_id] = item;
                });
                return json.data;
            },
        },
        "columns": [
            { 
                data: "delivery_option_name"
            },
            { 
                data: "delivery_option_description",
            },
            { 
                data: "delivery_option_active",
                render:function(data,type,row){
                    return data == 1 ? "Active" : "Inactive";
                }
            },
            { 
                data: "delivery_option_id",
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


    $("#form_data").validate({
        submitHandler:function(form){

            let input = {
                    "scrdata_id": 1067,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
            };
            let gotForm = getFormData($(form));
            input.item_id = gotForm.item_id;
            gotForm.delivery_option_photo = data_image.inactive_icon;
            gotForm.delivery_option_photo_selected = data_image.active_icon;
            input.delivery_options = [gotForm];
            console.log(input);

            Pace.track(function(){

                $.ajax({
                    url:'{{ route("tastypointsapi.testnet") }}',
                    type:"post",
                    data:{"input":JSON.stringify(input)},
                    success:function(response){
                        otable.draw(false);
                    },
                    error:function(error){
                        console.log(error);
                    }
                });

            });
            return false;
        }
    });

    function edit(id) {
        let data = {};
        try {
            data = temp_data[id];
        } catch (error) {
            console.log(error);
        }
        console.log(data);
        $("#form_data input[name=item_id]").val(data.delivery_option_id);
        $("#form_data input[name=delivery_option_name]").val(data.delivery_option_name);
        $("#form_data textarea[name=delivery_option_description]").val(data.delivery_option_description);
        $("#form_data select[name=delivery_option_active]").val(data.delivery_option_active);

        // set Image
        $("#list-preview-image img").attr("src",data.delivery_option_photo);
        data_image.active_icon = data.delivery_option_photo;
        $("#list-preview-image-inactive img").attr("src",data.delivery_option_photo_selected);
        data_image.inactive_icon = data.delivery_option_photo_selected;

    }

    function add() {
        $("#form_data input").val("");
        $("#form_data input[name=item_id]").val(0);
        $("#form_data textarea").val("");
        $("#form_data select").val("");
    }

    function destroy(id) {
        id = parseInt(id);
        let input = {
            "scrdata_id": 1067,
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
            "delivery_options": [
                {
                    "id": id,
                    "detele":1
                }
            ]
        };
        // console.log(input,JSON.stringify(input));
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
                                otable.draw(false);
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

</script>


    

@endsection