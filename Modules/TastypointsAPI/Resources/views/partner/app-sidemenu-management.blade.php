@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Menu Items Management")

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
            padding: 24px 0px;
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
        .list_screen{
            background-color: #f5f5f5;
        }
        .list_action{
            text-align: center;
            padding: 10px 80px 10px 66px;
        }
        .item_preview {
            height: 300px;
            width: 60%;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            cursor: pointer;
        }
        .item_footer {
            height: 40px;
            padding: 10px;
            width: 60%;
            background: white;
            margin: 0 auto;
            margin-bottom: 15px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        #dataPage{
            height: 40vh;
            overflow-y: scroll;
            overflow-x: hidden;
            text-align: center;
        }
        #search_category{
            background-color: #f2f4f7;
            border: 1px #f2f4f7 solid;
            color: #2196f3;
        }
        #menu_level_list {
            min-height: 494px;
        }
        #dataPage {
            min-height: 427px;
        }
    </style>
@endsection

@section('content-header',"App Side-menu Management")

@section('main_content')

    <div class="main_page">
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Group Name</th>
                        <th>Description</th>
                        <th>Default</th>
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
            <div class="main_page">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Group Name</label>
                            <input class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Description</label>
                            <input class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Default</label>
                            <select class="form-control">
                                <option>True</option>
                                <option>False</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 action_form">
                        <button class="btn btn-primary btn-block"><i class="fas fa-save"></i> Save/Apply</button>
                    </div>
                    <div class="col-md-3">
                        <div class="list_screen">
                            <div class="list_action">
                                <div class="form-group">
                                    <div class="input-group">
                                        <select class="form-control" id="search_category">
                                            <option value="" selected disabled>Select template category</option>
                                            @for ($i = 0; $i < 10; $i++)
                                                <option value="{{ $i }}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        <div class="input-group-btn">
                                            <button style="border: none;" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="dataPage">
                                @for ($i = 0; $i < 10; $i++)  
                                    <div class="item">
                                        <img src="https://img.lovepik.com/free-template/bg/20200424/bg/8fd9bdc6c2eb4.png_detail.jpg" class="item_preview" />
                                        <div class="item_footer">
                                            <p>Promo page example</p>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
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
                                            <div class="input-group">
                                                <input type="text" class="form-control item-menu" id="href" name="href" placeholder="URL">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-primary">Builder Link</button>
                                                </div>
                                            </div>
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
                                        <div class="form-group">
                                            <label for="title">Screen data</label>
                                            {{-- <textarea rows="5" name="scrdata" class="form-control item-menu" id="scrdata" placeholder="Screen Data"></textarea> --}}
                                            <select id="scrdata" multiple="multiple" name="scrdata[]" class="form-control"></select>
                                        </div>
                                    </form>
                                </div>
                            <div class="panel-footer">
                                <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
                                <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default" id="menu_level_list">
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
</div>

@stop


@section('javascript')

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


        $(document).ready(function() {

            var data_option = [
                {id:"1010",text:"1010"},
                {id:"1011",text:"1011"},
                {id:"1012",text:"1012"},
                {id:"1013",text:"1013"},
            ];

            $('#scrdata').select2({
                // placeholder: "Select delivery option",
                allowClear: true,
                width:"100%",
                data:data_option,
            });

            // $('#search_category').select2({
            //     // placeholder: "Select delivery option",
            //     allowClear: true,
            //     width:"100%",
            // });

            let select_val = [];

            $('#scrdata').on("select2:select", function (evt) {
                var element = evt.params.data.element;
                var $element = $(element);
                
                $element.detach();
                $(this).append($element);
                $(this).trigger("change");

                select_val = $(evt.currentTarget).val();
                // renderDeliveryForm();
                
                // console.log(select_val);
            });

        });
    </script>
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
@endsection