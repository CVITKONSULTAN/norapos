@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Menu Access Management")

@section('page_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/css/bootstrap-iconpicker.min.css"/>
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
        .select_assign{
            display: inline-block;
            width: 64%;
        }
        .assign_btn{
            display: inline-block;
            width: 29%;
            margin-top: 25px;
            float: right;
        }
        .desc_form{
            display: inline-block;
            width: 78%;
        }
        .save_form{
            display: inline-block;
            width: 18%;
            float: right;
            margin-top: 25px;
        }
    </style>
@endsection

@section('content-header',"Menu Access Management")

@section('main_content')

    <div class="main_page">
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Industry Name</th>
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
                <div class="row">
                    <form>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Admin Level Name</label>
                                <input class="form-control" value="" required/>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group desc_form">
                                <label>Description</label>
                                <input class="form-control" value="" required/>
                            </div>
                            <button type="submit" class="btn btn-primary save_form"><i class="fas fa-save"></i> Save / Apply</button>
                        </div>
                    </form>
                    <div class="col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">Edit item</div>
                                <div class="panel-body">
                                    <form id="frmEdit">
                                        <div class="form-group">
                                            <label for="text">Text</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control item-menu" placeholder="Text" id="text" name="text" aria-describedby="basic-addon2">
                                                <span class="input-group-addon"><span class="caret"></span></span>
                                            </div>
                                            <input type="hidden" name="icon" class="item-menu">
                                        </div>
                                        <div class="form-group">
                                            <label for="href">URL</label>
                                            <input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
                                        </div>
                                        <div class="form-group">
                                            <label for="target">Target</label>
                                            <select name="target" id="target" class="form-control item-menu">
                                                <option value="_self">Self</option>
                                                <option value="_blank">Blank</option>
                                                <option value="_top">Top</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Tooltip</label>
                                            <input type="text" name="title" class="form-control item-menu" id="title" placeholder="Tooltip">
                                        </div>
                                    </form>
                                </div>
                            <div class="panel-footer">
                                <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
                                <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">Admin Menu Level</div>
                                <div class="panel-body">
                                    <ul id="myEditor" class="sortableLists list-group">
                                    </ul>
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Partner</label>
                            <select class="form-control">
                                <option value="">Select Partner</option>
                                <option value="">Tok tok restaurant</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Select Staff</label>
                            <select class="form-control">
                                <option value="">Select Staff</option>
                                <option value="">Heru</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group select_assign">
                            <label>Select Admin Level to Assign</label>
                            <select class="form-control">
                                <option value="">Select admin level</option>
                                <option value="">Cashier</option>
                            </select>
                        </div>
                        <button class="btn btn-primary assign_btn">Assign</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $("#table_data").DataTable({
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
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-iconpicker/1.10.0/js/bootstrap-iconpicker.min.js"></script>
    <script src="/js/jquery-menu-editor.min.js"></script>
    <script>
        // icon picker options
        let iconPickerOptions = {searchText: "Buscar...", labelHeader: "{0}/{1}"};
        // sortable list options
        let sortableListOptions = {
            placeholderCss: {'background-color': "#cccccc"}
        };
        let editor = new MenuEditor('myEditor', 
        { 
            listOptions: sortableListOptions, 
            iconPicker: iconPickerOptions,
            maxLevel: 2 // (Optional) Default is -1 (no level limit)
            // Valid levels are from [0, 1, 2, 3,...N]
        });
        editor.setForm($('#frmEdit'));
        editor.setUpdateButton($('#btnUpdate'));
        //Calling the update method
        $("#btnUpdate").click(function(){
            editor.update();
        });
        // Calling the add method
        $('#btnAdd').click(function(){
            editor.add();
        });
        $(document).ready(()=>{
            let arrayJson = [{"href":"http://home.com","icon":"fas fa-home","text":"Home", "target": "_top", "title": "My Home"},{"icon":"fas fa-chart-bar","text":"Opcion2"},{"icon":"fas fa-bell","text":"Opcion3"},{"icon":"fas fa-crop","text":"Opcion4"},{"icon":"fas fa-flask","text":"Opcion5"},{"icon":"fas fa-map-marker","text":"Opcion6"},{"icon":"fas fa-search","text":"Opcion7","children":[{"icon":"fas fa-plug","text":"Opcion7-1","children":[{"icon":"fas fa-filter","text":"Opcion7-1-1"}]}]}];
            editor.setData(arrayJson);
        });
    </script>
@endsection