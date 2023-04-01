@extends('layouts.app')
@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | Screen Data Labs Table' )

@section('css')
    <link rel="stylesheet" href="https://bossanova.uk/jspreadsheet/v4/jexcel.css" type="text/css" /> 
    <link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" /> 
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Material+Icons" />
    <style>
        .action_filter{
            cursor: pointer;
        }
        .filter_choice {
            margin-right: 15px !important;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .filter_choice > i {
            margin-left: 0px;
        }

        #detail_data_section{
            margin-bottom: 20px;
        }
        #color-box {
            background-color: red;
            border-color: red;
        }
        #color-box-update {
            background-color: red;
            border-color: red;
        }
        #scrdata_id-error {
            display: block !important;
        }
        .data_respone_container.active {
            background-color: #ff9200;
            color: white;
        }
        .loading_data{
            color: #ff9200;
        }

        .jexcel_toolbar i.jexcel_toolbar_item {
            padding: 0px !important;
            margin: 10px;
        }

        .jexcel_overflow > tbody > tr {
            height:3em;
        }

        @media only screen and (min-width: 768px) {
            #detail_data_section{
                /* padding-left:7%; */
            }
        }
        
    </style>
@endsection

@section('content')

    @include('tastypointsapi::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Screen Data Labs Table
            <small>@lang( 'tastypointsapi::lang.setup_subtitle' )</small>
        </h1>
    </section>

    <div class="modal" id="comment_popup">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="comments_form" method="POST">
                    @csrf
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Comments</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Scrdata Comments</label>
                            <textarea name="scrdata_notes" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Request Comments</label>
                                    <textarea name="req_description" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Response Comments</label>
                                    <textarea name="res_description" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            
            <div class="col-md-12">

                <div class="box box-solid">
            
                    <div class="box-body">
                            <div class="row">

                                    <div class="col-md-12 main_server">
                                        {!!
                                            Form::open([
                                                'url' => route("tastypointsapi.setup.update"), 
                                                'method' => 'post', 
                                                'id' => 'setup_form',
                                                'files' => false
                                            ]) 
                                        !!}
                                        <p> Link main server : </p>
                                        <div class="input-group">
                                            <input 
                                            type="url"
                                            name="link" 
                                            class="form-control" 
                                            placeholder="Link main server"
                                            value="{{$config->link}}"
                                            >
                                            <span class="input-group-btn">
                                                {!! Form::submit("Update", ['class' => 'btn btn-primary']) !!}
                                            </span>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>

                                
                                    <div class="col-md-12 filter_section">
                                        {!!
                                            Form::open([
                                                'url' => "#", 
                                                'method' => 'post', 
                                                'id' => 'filter_form',
                                                "class" => "form-inline",
                                                'files' => false
                                            ]) 
                                        !!}

                                            <div class="form-group filter_choice">
                                                <label>SCRDATA NAME</label>
                                                <input class="form-control" name="scrdata_name" />
                                                {{-- <select class="form-control" name="scrdata_name">
                                                    <option value="GET REWARDS">GET REWARDS</option>
                                                </select> --}}
                                            </div>
                                            <div class="form-group filter_choice">
                                                <label>SCRDATA ID</label>
                                                <input class="form-control" name="scrdata_id" />
                                                {{-- <select class="form-control" name="scrdata_name">
                                                    <option value="10">10</option>
                                                </select> --}}
                                            </div>
                                            <div class="form-group filter_choice">
                                                <label>CATEGORY</label>
                                                <select class="form-control category_data" name="category_id"></select>
                                            </div>
                                            <div class="form-group filter_choice">
                                                <label>STATUS</label>
                                                <div class="input-group">
                                                    <select class="form-control status_data" name="status_id"></select>
                                                    <span class="input-group-addon color-box" id="color-box"> </span>
                                                </div>
                                            </div>
                                            <div class="checkbox filter_choice">
                                                <label>
                                                    <input type="checkbox" name="enabled"> ENABLED
                                                </label>
                                            </div>
                                            <div class="checkbox filter_choice">
                                                <label>
                                                    <input type="checkbox" name="production"> IN PRODUCTION
                                                </label>
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-xs filter_choice"><i class="fas fa-filter"></i> FILTER</button>
                                            <button type="button" id="create_new" class="btn btn-primary btn-xs filter_choice"><i class="fas fa-plus"></i> NEW</button>
                                            
                                        {!! Form::close() !!}
                                    </div>

                            </div>
                    </div>
            
                </div>
                
            </div>

            <div class="col-md-12">

                <div class="box box-solid">
            
                    <div class="box-body">
                        <!-- <button onclick="updateRowHeight()" class="btn btn-default">Row Height</button> -->
                        <div class="table-responsive">
                            <div id="spreadsheet"></div>
                        </div>
                    </div>
            
                </div>

            </div>
            
        </div>


    </section>
    <!-- /.content -->

@endsection

@section('javascript')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/df-number-format/2.1.6/jquery.number.min.js"></script>

    <script src="https://bossanova.uk/jspreadsheet/v4/jexcel.js"></script>
    <script src="https://jsuites.net/v4/jsuites.js"></script>

    <script>
        let url = "{{ route("tastypointsapi.testnet") }}";
        let scrdata_lab_category = [];
        let data_category = [];
        function loadCategory(){
            let json = {
                "scrdata_id": 1104,
                "sp_name": "OK",
                "session_id": "WA74edc6e2-7d9d-4ae5-b570-46d3b82b8fdc",
                "session_exp": "05/29/2015 05:50:06",
                "max_row_per_page": 10,
                "pagination": 1,
                "search_term": "0",
                "search_term_header": "0",
                "status": "OK",
                "item_id": 0
            };

            $.ajax({
                url:url,
                type:"POST",
                data:{"input":JSON.stringify(json)},
                success:function(result){
                    result = JSON.parse(result);
                    if(result.status){
                        let data = JSON.parse(result.data);
                        $(".category_data").empty();
                        data.scrdata_lab_category.map((item,index)=>{
                            let new_data = '<option value="'+item.id+'">'+item.name+'</option>';
                            $(".category_data").append(new_data);
                            scrdata_lab_category.push(item.name);
                        });
                        data_category = data.scrdata_lab_category;
                        $(".category_data").prepend('<option value="0" selected>Select category</option>');
                    }
                },
                error:function(error){

                }
            });
        }

        let scrdata_lab_status = [];
        let data_status = [];
        function loadStatus(){
            let json = {
                "scrdata_id" : 1106,
                "sp_name" : "OK",
                "session_id" : "WA74edc6e2-7d9d-4ae5-b570-46d3b82b8fdc",
                "session_exp" : "05/29/2015 05:50:06",
                "max_row_per_page" : 10,
                "pagination" : 1,
                "search_term" : "0",
                "search_term_header" : "0",
                "status" : "OK",
                "item_id" : 0
            };

            $.ajax({
                url:url,
                type:"POST",
                data:{"input":JSON.stringify(json)},
                success:function(result){
                    result = JSON.parse(result);
                    if(result.status){
                        let data = JSON.parse(result.data);
                        $(".status_data").empty();
                        data.scrdata_lab_status.map((item,index)=>{
                            let new_data = '<option value="'+item.id+'" data-color="'+item.color+'">'+item.name+'</option>';
                            $(".status_data").append(new_data);
                            $(".color-box").css("background-color","white");
                            $(".color-box").css("border-color","white");
                            scrdata_lab_status.push(item.name);
                        });
                        data_status = data.scrdata_lab_status;
                        $(".status_data").prepend('<option value="0" selected data-color="white">Select status</option>');
                    }
                },
                error:function(error){

                }
            });
        }

        $(".status_data").change(function(){
            let color = $(this).find(':selected').data("color");
            $(this).parent().find(".color-box").css("background-color",color);
            $(this).parent().find(".color-box").css("border-color",color);
        });

        $(document).ready(function(){
            loadCategory();
            loadStatus();
        });

        $("#comments_form").validate({
            submitHandler:function(form){
                const data = getFormData( $(form) );
                conValue.scrdata_notes = data.scrdata_notes;
                conValue.req_description = data.req_description;
                conValue.res_description = data.res_description;
                conValue.delete = false;
                let format_json = {
                    "scrdata_id" : 1059,
                    "session_id" : session_id,
                    "session_exp" : session_exp,
                    "item_id" : conValue.id,
                    "scrdata_lab_jsons" : [conValue]
                };

                $.ajax({
                    url:url,
                    type:form.method,
                    data:{"input":JSON.stringify(format_json)},
                    success:function(result){
                        let json = JSON.parse(result);
                        if(json.status){
                            const data_json = JSON.parse(json.data);
                            if(data_json.status == "OK"){
                                swal({
                                    title: "",
                                    text: "Data is saved",
                                    icon: "success",
                                });
                                data_table[parseInt(conCoor[0])] = conValue;
                                switch (parseInt(conCoor[0])) {
                                    case 1:
                                        spreadsheet.setComments(conCoor, conValue.scrdata_notes );
                                        break;
                                    case 6:
                                        spreadsheet.setComments(conCoor, conValue.req_description );
                                        break;
                                    case 7:
                                        spreadsheet.setComments(conCoor, conValue.res_description );
                                        break;
                                }
                                $("#comment_popup").modal("hide");
                            }
                        }
                    },
                    error:function(e){console.log(e);}
                });
            }
        });

        let all_rows = [];
        let session_id = "{{ Request::get("session")->session_id }}";
        let session_exp = "{{ Request::get("session")->session_exp }}";

        let columns = [
                {
                    type: 'number',
                    title:'ID',
                    name:"id",
                },
                {
                    type: 'number',
                    title:'SCRDATA ID',
                    name:"scrdata_id",
                },
                {
                    type: 'text',
                    title:'SCRDATA NAME',
                    name:"scrdata_name",
                },
                {
                    type: 'dropdown',
                    title:'CATEGORY',
                    name:"scrdata_category",
                    source:scrdata_lab_category
                },
                {
                    type: 'checkbox',
                    title:'ENABLED',
                    name:"enabled",
                },
                {
                    type: 'checkbox',
                    title:'IN PRODUCTION',
                    name:"in_production",
                },
                {
                    type: 'text',
                    title:'REQUEST',
                    name:"req_json_as_string"
                },
                {
                    type: 'text',
                    title:'RESPONSE',
                    name:"res_json_as_string"
                },
                {
                    type: 'dropdown',
                    title:'STATUS',
                    source:scrdata_lab_status,
                    name:"scrdata_status_name"
                }
        ];

        let data_table = [];

        const updateData = (data,y) => {
            if(data[0] == "" || data[0] == null) return;
            
            try {
                let data_labs = data_table[parseInt(y)];

                if(data_labs == undefined) data_labs = {};

                const category = data_category.filter(function (el) {
                    return el.name == data[3];
                });
                const status = data_status.filter(function (el) {
                    return el.name == data[8];
                });

                data_labs.id = data[0];
                data_labs.scrdata_id = parseInt(data[1]);
                data_labs.scrdata_name = parseInt(data[1]);
                data_labs.scrdata_category_id = category[0].id;
                data_labs.scrdata_category = data[3];
                data_labs.scrdata_status_id = parseInt(status[0].id);
                data_labs.scrdata_status_name = data[8];
                data_labs.enabled = data[4];
                data_labs.in_production = data[5];
                data_labs.req_json = JSON.parse(data[6]);
                data_labs.res_json = JSON.parse(data[7]);
                data_labs.delete = false;
                
                if(parseInt(data[0]) == 0) {
                    data_labs.scrdata_notes = "";
                    data_labs.req_description = "";
                    data_labs.res_description = "";
                }
                
                let format_json = {
                    "scrdata_id" : 1059,
                    "session_id" : session_id,
                    "session_exp" : session_exp,
                    "item_id" : parseInt(data[0]),
                    "scrdata_lab_jsons" : [data_labs]
                };

                $.ajax({
                    url:url,
                    type:"POST",
                    data:{"input":JSON.stringify(format_json)},
                    beforeSend:function(){
                        
                    },
                    success:function(result){
                        result = JSON.parse(result);
                        if(result.status){
                            let data = JSON.parse(result.data);
                            console.log(data);
                            if(data.status == "OK"){
                                swal({
                                    title: "",
                                    text: "Data is saved",
                                    icon: "success",
                                });
                                $("#filter_form").submit();
                            }
                        }
                    },
                    error:function(error){
                        console.log(error);
                    },
                    complete:function(){
                        
                    }
                });
            } catch (error) {
                console.log(error);
            }

        }

        const changed = function(instance, cell, x, y, value) {
            let rowData = spreadsheet.getRowData(y);
            y = parseInt(y) - 1;
            // let cellName = jexcel.getColumnNameFromId([x,y]);
            // console.log("Update this data "+cellName+" to "+rowData);
            if(rowData[0] == "" || rowData[0] == null) return;
            swal({
                title: "Are you sure?",
                text: "this action will change data on database.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    updateData(rowData,y);
                } else {
                    spreadsheet.undo();
                }
            });
        }

        const toolbars = [
            {
                type: 'i',
                content: 'undo',
                onclick: function() {
                    spreadsheet.undo();
                }
            },
            {
                type: 'i',
                content: 'redo',
                onclick: function() {
                    spreadsheet.redo();
                }
            },
            {
                type: 'select',
                k: 'font-family',
                v: ['Arial','Verdana']
            },
            {
                type: 'select',
                k: 'font-size',
                v: ['9px','10px','11px','12px','13px','14px','15px','16px','17px','18px','19px','20px']
            },
            {
                type: 'i',
                content: 'format_align_left',
                k: 'text-align',
                v: 'left'
            },
            {
                type:'i',
                content:'format_align_center',
                k:'text-align',
                v:'center'
            },
            {
                type: 'i',
                content: 'format_align_right', 
                k: 'text-align',
                v: 'right'
            },
            {
                type: 'i',
                content: 'format_bold',
                k: 'font-weight',
                v: 'bold'
            },
            {
                type: 'color',
                content: 'format_color_text',
                k: 'color'
            },
            {
                type: 'color',
                content: 'format_color_fill',
                k: 'background-color'
            },
        ];

        let comment = [];
        const commented = (elm, comments, title, cell, x, y) => {
            // const val = spreadsheet.getValueFromCoords(y,x);
            // const value = data_table[y];
            // console.log(value);
            const cellName = jexcel.getColumnNameFromId(cell);
            const insertComment = {
                coordinate:cell,
                cellName:cellName,
                comment:comments,
            };
            comment.push(insertComment);
            // console.log(comment);
        }

        let conValue = null;
        let conCoor = [0,0];
        const conMenu = (obj, x, y, e) => {
            conValue = data_table[y];
            var items = [];
            if (y == null) {
                // Insert a new column
                if (obj.options.allowInsertColumn == true) {
                    items.push({
                        title:obj.options.text.insertANewColumnBefore,
                        onclick:function() {
                            obj.insertColumn(1, parseInt(x), 1);
                        }
                    });
                }
    
                if (obj.options.allowInsertColumn == true) {
                    items.push({
                        title:obj.options.text.insertANewColumnAfter,
                        onclick:function() {
                            obj.insertColumn(1, parseInt(x), 0);
                        }
                    });
                }
    
                // Delete a column
                if (obj.options.allowDeleteColumn == true) {
                    items.push({
                        title:obj.options.text.deleteSelectedColumns,
                        onclick:function() {
                            obj.deleteColumn(obj.getSelectedColumns().length ? undefined : parseInt(x));
                        }
                    });
                }
    
                // Rename column
                if (obj.options.allowRenameColumn == true) {
                    items.push({
                        title:obj.options.text.renameThisColumn,
                        onclick:function() {
                            obj.setHeader(x);
                        }
                    });
                }
    
                // Sorting
                if (obj.options.columnSorting == true) {
                    // Line
                    items.push({ type:'line' });
    
                    items.push({
                        title:obj.options.text.orderAscending,
                        onclick:function() {
                            obj.orderBy(x, 0);
                        }
                    });
                    items.push({
                        title:obj.options.text.orderDescending,
                        onclick:function() {
                            obj.orderBy(x, 1);
                        }
                    });
                }
            } else {
                // Insert new row
                if (obj.options.allowInsertRow == true) {
                    items.push({
                        title:obj.options.text.insertANewRowBefore,
                        onclick:function() {
                            obj.insertRow(1, parseInt(y), 1);
                        }
                    });
                    
                    items.push({
                        title:obj.options.text.insertANewRowAfter,
                        onclick:function() {
                            obj.insertRow(1, parseInt(y));
                        }
                    });
                }
    
                if (obj.options.allowDeleteRow == true) {
                    items.push({
                        title:obj.options.text.deleteSelectedRows,
                        onclick:function() {
                            obj.deleteRow(obj.getSelectedRows().length ? undefined : parseInt(y));
                        }
                    });
                }
    
                if (x) {
                    if (obj.options.allowComments == true) {
                        items.push({ type:'line' });
    
                        var title = obj.records[y][x].getAttribute('title') || '';
    
                        items.push({
                            title: title ? obj.options.text.editComments : obj.options.text.addComments,
                            onclick:function() {
                                conCoor = [x,y];
                                $("#comment_popup [name=scrdata_notes]").val(conValue.scrdata_notes);
                                $("#comment_popup [name=req_description]").val(conValue.req_description);
                                $("#comment_popup [name=res_description]").val(conValue.res_description);
                                $("#comment_popup").modal("show");
                            }
                        });
    
                        // if (title) {
                        //     items.push({
                        //         title:obj.options.text.clearComments,
                        //         onclick:function() {
                        //             obj.setComments([ x, y ], '');
                        //         }
                        //     });
                        // }

                        if (title) {
                            items.push({
                                title:"Show Comments",
                                onclick:function() {
                                    let comments = conValue.scrdata_notes;
                                    switch (parseInt(x)) {
                                        case 6:
                                            comments = conValue.req_description;
                                            break;
                                        case 7:
                                            comments = conValue.res_description;
                                            break;
                                    }
                                    console.log(comments);
                                    alert(comments);
                                }
                            });
                        }
                    }
                }
            }
    
            // Line
            items.push({ type:'line' });
    
            // Save
            if (obj.options.allowExport) {
                items.push({
                    title: obj.options.text.saveAs,
                    shortcut: 'Ctrl + S',
                    onclick: function () {
                        obj.download();
                    }
                });
            }
    
            // About
            if (obj.options.about) {
                items.push({
                    title:obj.options.text.about,
                    onclick:function() {
                        console.log("about");
                    }
                });
            }
    
            return items;
        };

        const uTable = (instance, cell, col, row, val, label, cellName) => {
            const rowData = data_table[row];
            if(rowData == undefined) return;
            // const color = rowData.scrdata_status_color;
            // if(color == null || color == "") return;
            // let style = {};
            // style[cellName] = "background-color:  "+color+"";
            // instance.jexcel.setStyle(style);

            let comments = rowData.scrdata_notes;
            switch (parseInt(col)) {
                case 1:
                    spreadsheet.setComments([col,row], comments );
                    break;
                case 6:
                    comments = rowData.req_description;
                    spreadsheet.setComments([col,row], comments );
                    break;
                case 7:
                    comments = rowData.res_description;
                    spreadsheet.setComments([col,row], comments );
                    break;
            }
        };

        let spreadsheet = jspreadsheet(document.getElementById('spreadsheet'), {
            data:data_table,
            columns: columns,
            onchange:changed,
            allowComments:true,
            columnResize:true,
            toolbar:toolbars,
            defaultColWidth: '200px',
            rowResize:true,
            license: 'MWEzMTE4MGFkNWY5YzQzNjE4NjZiNmE1NThhM2M0Yjc1NmUyNGM2N2YzZjU2NDQ5ZjM1MGFiYWN',
            wordWrap:true,
            loadingSpin:true,
            updateTable: uTable,
            oncomments:commented,
            contextMenu:conMenu,
            allowInsertRow:true,
            allowInsertColumn:false,
            allowDeleteRow:false,
            allowDeleteColumn:false,
        });

        const updateRowHeight = () => {
            spreadsheet.setHeight(0, 2000);
            spreadsheet.setStyle({"A1":"background-color:  orange"});
            // for (let index = 0; index < data.length-1; index++) {
            //     spreadsheet.setHeight(index, heightCus);
            //     console.log(index,heightCus);
            // }
        }

        let loading = false;
        let isEmpty = false;
        const getData = (
            pagination, 
            max_item, 
            options
        ) => {

            options.scrdata_id = isNaN(options.scrdata_id) || options.scrdata_id == ""  ? 0 : parseInt(options.scrdata_id);

            let get_json = {
                "scrdata_id": 1058,
                "sp_name": "OK",
                "session_id": session_id,
                "session_exp": session_exp,
                "item_id": 0,
                "max_row_per_page": max_item,
                "scrdata_name_filter": options.scrdata_name,
                "scrdata_id_filter": options.scrdata_id,
                "scrdata_category_filter": parseInt(options.category_id),
                "scrdata_status_filter": parseInt(options.status_id),
                "scrdata_enable_filter": options.enabled,
                "scrdata_production_filter": options.production,
                "pagination": pagination,
                "search_term": "",
                "search_term_header": "",
            };

            $.ajax({
                url:url,
                data:{input:JSON.stringify(get_json)},
                type:"POST",
                beforeSend:function(){
                    loading = true;
                },
                success:function(result){
                    let json = JSON.parse(result);
                    if(json.status){

                        const data_json = JSON.parse(json.data);
                        let records = $.number(data_json.total_records);

                        let rows = data_json.scrdata_lab_jsons;

                        let string = '';
                        paginate = pagination;
                        if(pagination == 1){
                            data_table = [];
                            isEmpty = false;
                        }
                        if(rows !== null) {
                            data_table = [...data_table, ...rows];
                            spreadsheet.setData(data_table);
                        }
                        if(pagination > 1 && rows == null ) isEmpty = true;


                    }
                },
                error:function(error){
                    console.error();
                },
                complete:function(){
                    $(".loading_data").remove();
                    loading = false;
                }
            });
        }

        let options = {
            scrdata_name:"",
            scrdata_id:0,
            category_id:0,
            status_id:0,
            status:"",
            enabled:false,
            production:false,
        };

        $(document).ready(function(){

            getData(
                1,
                50,
                options
            );
        });

        $("#filter_form").on("submit",function(e){

            options = getFormData( $(this) );
            options.enabled = options.enabled == "on" ? true :  false;
            options.production = options.production == "on" ? true :  false;
            
            
            getData(
                1,
                50,
                options
            );
            return false;
        });

        let paginate = 0;
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                console.log(isEmpty);
                if(!loading && !isEmpty){
                    let loadmore = '<div class="text-center loading_data"> <i class="fas fa-circle-notch fa-spin fa-3x"></i> </div>';
                    $("#spreadsheet").append(loadmore);
                    paginate = paginate+1;
                    getData(paginate,50,options);
                }
            }
        });

    </script>

@endsection