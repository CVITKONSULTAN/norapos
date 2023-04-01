@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Admin Level Menu Access Management")

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
        .menu_item{
            border: 1px #cecece solid;
            padding: 0px 15px;
            border-radius: 10px;
            margin: 5px 0px;
        }
        #rootmenu{
            margin-top: 30px;
        }
    </style>
@endsection

@section('content-header',"Admin Level Menu Access Management")

@section('main_content')

    <div class="main_page">
        <div class="table-control text-right">
            <a href="{{ route("partner.create") }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
        </div>
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Admin Level Name</th>
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
                <form>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Admin Level Name</label>
                                        <input class="form-control" value="" required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input class="form-control" value="" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 action_form">
                            {{-- <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> New</button> --}}
                            <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Save / Apply</button>
                        </div>
                        <div class="col-md-4">
                            {{-- root menu --}}
                            <div id="rootmenu"></div>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center">Side-menu</p>
                            {{-- side menu --}}
                            <div id="sidemenu"></div>
                        </div>
                        <div class="col-md-4">
                            <p class="text-center">Top-menu</p>
                            {{-- top menu --}}
                            <div id="topmenu"></div>
                        </div>
                    </div>
                </form>
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

        let menu = {
            "rootmenu":[
                {
                    "id":1,
                    "name":"Tastypoints API",
                    "color":null,
                    "child":[],
                },
                {
                    "id":6,
                    "name":"Partner Management",
                    "color":null,
                    "child":[],
                },
                {
                    "id":7,
                    "name":"Communications",
                    "color":null,
                    "child":[],
                },
            ],
            "sidemenu":[
                {
                    "id":2,
                    "name":"All Partners",
                    "color":"#00aeef",
                    "child":[
                        {
                            "id":3,
                            "name":"Child 1",
                            "color":null,
                        },
                        {
                            "id":4,
                            "name":"Child 2",
                            "color":null,
                        }
                    ],
                }
            ],
            "topmenu":[
                {
                    "id":5,
                    "name":"Top Menu",
                    "color":"#0ca651",
                    "child":[],
                }
            ]
        };

        function checkColor(item) {
            return item.color == null ? "" : 'style="border-left: 5px '+item.color+' solid;"';
        }
        function renderMenu(key) {
            let string = "";
            $("#"+key).empty();
            let data = menu[key];
            data.map((item,index)=>{
                const styling = checkColor(item);
                let new_data = '<div class="menu_item" '+styling+'>'+
                                    '<div class="checkbox">'+
                                        '<label><input type="checkbox" value="'+item.id+'">'+item.name+'</label>'+
                                    '</div>'+
                                '</div>';
                item.child.map((item,index)=>{
                    const styling = checkColor(item);
                    let child = '<div class="menu_item" style="margin-left:10px;'+styling+'">'+
                                    '<div class="checkbox">'+
                                        '<label><input type="checkbox" value="'+item.id+'">'+item.name+'</label>'+
                                    '</div>'+
                                '</div>';
                    new_data = new_data+child;
                });
                string = string+new_data;
            });
            $("#"+key).html(string);
        }

        $(document).ready(function(){
            renderMenu("rootmenu");
            renderMenu("sidemenu");
            renderMenu("topmenu");
        });
    </script>
@endsection