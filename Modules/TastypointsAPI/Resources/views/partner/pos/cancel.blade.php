@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Cancelation Reasons")

@section('page_css')
    <link rel="stylesheet" href="/tasty/js/Emojiarea/dist/reset.css">
    <link rel="stylesheet" href="/tasty/js/Emojiarea/dist/style.css">
    <style>
        #emoji_picker_subject{
            position: absolute;
            right: 40px;
            z-index: 10;
       }
       .emoji-picker{
           position: absolute;
           z-index: 9999;
       }
       .emoji-selector > li > a {
           padding: 0px;
       }
       .label_emoji{
           font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif !important;
       }
   </style>
    <style>
        .table_container{
            margin-top: 20px;
        }
        .action_form{
            padding-top: 25px;
        }
        .suggest{
            resize: none;
            padding-right: 35px;
        }
        .btn-act{
            height:70px;
        }
        .suggest_text{
            word-break: break-all;
            padding-right: 25px;
        }
        .trash_del{
            position:absolute;
            right: 10px;
            top:10px;
        }
    </style>
@endsection

@section('content-header',"Cancelation Reasons")

@section('main_content')
    <input type="file" name="file" accept="image/*" id="selectedFile" style="display: none;" />
    <div class="modal fade in" id="modal_editor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Cancelation Reason and Suggest</h4>
                </div>
                <form id="form_data" class="form-horizontal" method="POST">
                    <div class="modal-body">
                            @csrf
                            <input name="item_id" value="0" type="hidden" />
                            <div class="form-group">
                                <label class="col-sm-3">Cancelation reason</label>
                                <div class="col-sm-9">
                                    <input name="cancelation_reason" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3">Cancelation icon</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input type="url" name="cancelation_reason_icon" class="form-control" required />
                                        <span class="input-group-btn">
                                            <button onclick="browse_data(this,'image/*')" type="button" class="btn btn-primary">Browse</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3">Cancelation discounts (%)</label>
                                <div class="col-sm-9">
                                    <input name="cancelation_discount" type="number" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3">Consideration text</label>
                                <div class="col-sm-9">
                                    <input name="consideration_text" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3">Next screen</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="next_screen" required>
                                        <option value="0">None</option>
                                        <option value="SelectOutStock">Select Out Of Stock</option>
                                        <option value="ProposeItems">Propose Items</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" >
                                <label class="col-sm-3">Suggestion text</label>
                                <div class="col-sm-9">
                                    <div class="input-group"
                                    data-emojiarea data-type="unicode" 
                                    data-global-picker="false">
                                        <div class="emoji-button" id="emoji_picker_subject">&#x1f604;</div>
                                        <textarea id="suggest" class="form-control suggest label_emoji" rows="3"></textarea>
                                        <span class="input-group-btn">
                                            <button type="button" id="btn-plus" class="btn btn-default btn-act">+</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <ul id="cancelation_list" class="list-group"></ul>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save/Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="main_page">
        <div class="text-right mb-2">
            <button class="btn btn-success btn-lg" onclick="addNew()" >Add New</button>
        </div>
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Cancelation reason</th>
                        <th>Cancelation Reason Icon</th>
                        <th>Cancelation Discount</th>
                        <th>Consideration Text</th>
                        <th>Next Screen</th>
                        <th>Suggestion Text</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop


@section('javascript')
    <script src="/tasty/js/Emojiarea/dist/jquery.emojiarea.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>

        function addNew() {
            let modals = $("#modal_editor");
            let form = modals.find("form");
            form.find("input").val("");
            form.find("select").val("0");
            form.find("textarea").val("");
            form.find("input[name=item_id]").val(0);
            temp_suggest = [];
            $(".suggest_text").remove();
            modals.modal("show");
        }

        let temp_suggest = [];
        $("#btn-plus").click(function(e){
            let input = $("#suggest");
            let val = input.val();
            if(val == "") return ;
            temp_suggest.push(val);
            const index = temp_suggest.length - 1;
            $("#cancelation_list").prepend(`<li class="list-group-item suggest_text">${val} <a href="javascript:void(0)" onclick="deleteSuggest(this,${index})" class="trash_del"><i class="fa fa-trash"></i></a></li>`);
            input.val("");
        });
        
        function deleteSuggest(elm,index) {
            elm = $(elm);
            elm.parent().remove();
            temp_suggest.splice(index,1);
        }

        let json = {
            "scrdata_id": 1268,
            "sp_name": "OK",
            "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
            "session_exp": "05/29/2015 05:50:06",
            "max_row_per_page": 0,
            "search_term": "0",
            "search_term_header": "0",
            "pagination": 0,
            "status": "OK",
            "lab_test": 1,
            "item_id": 0
        };

        let temp_elm;
        let temp_elm_btn;
        function browse_data(elm,type) {
            temp_elm_btn = $(elm);
            let input = $(elm).parent().parent().find("input");
            temp_elm = input;
            $("#selectedFile").attr("accept",type);
            $("#selectedFile").trigger("click");
        }

        $("#selectedFile").change(function(e){
            let val = $(this).val();
            let formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            $.ajax({
                url: "{{ route("tastypointsapi.upload","others") }}",
                type : 'POST',
                data : formData,
                processData: false,
                contentType: false,
                beforeSend:function(){
                    temp_elm_btn.html('<i class="fas fa-circle-notch fa-spin"></i>');
                    temp_elm_btn.attr('disabled',true);
                },
                success : function(response) {
                    if(response.success){
                        temp_elm.val(response.link);
                        $("#selectedFile").val("");
                    }
                },
                complete:function(){
                    temp_elm_btn.html('Browse');
                    temp_elm_btn.removeAttr('disabled');
                }
            });
        });

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
                    d.scr_name = "cancelation_reason";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data[item.reason_id] = item;
                    });
                    return json.data;
                },
            },
            "columns": [
                { 
                    data: "cancelation_reason"
                },
                { 
                    data: "cancelation_reason_icon",
                    render:function(data,type,row){
                        return `<img src="${data}" style="height:25px;width:25px;margin:0 auto;" />`;
                    },
                    className:"text-center"
                },
                { 
                    data: "cancelation_discount",
                },
                { 
                    data: "consideration_text",
                },
                { 
                    data: "next_screen",
                },
                { 
                    data: "cancelation_auto_suggestion_text",
                    render:function(data,type,row){
                        let string = "<ol>";
                        data.map((item,index)=>{
                            string += `<li>${item}</li>`;
                        });
                        string += "</ol>";
                        return string;
                    }
                },
                { 
                    data: "reason_id",
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
                    "scrdata_id": 1269,
                    "sp_name": "OK",
                    "session_id": "WAfd8b19b7-144d-42ac-beee-bad44b1d7b23",
                    "session_exp": "05/29/2015 05:50:06",
                    "lab_test": 1,
                    "item_id": 0,
                    "cancelation_reason": [
                        {
                        "cancelation_reason_icon": "https://tastypoints.io/akm/tasty_images/sbRHspPL.png",
                        "next_screen": "SelectOutStock",
                        "cancelation_reason": "Some items are out of stock",
                        "cancelation_discount": 10,
                        "consideration_text": "Consideration Discounts",
                        "cancelation_auto_suggestion_text": [
                            "suggest 1",
                            "suggest 2",
                            "Do not want to serve you 🤑"
                        ]
                        }
                    ]
                };
                // let input = {
                //         "scrdata_id": 1268,
                //         "session_id": "{{ Request::get("session")->session_id }}",
                //         "session_exp": "{{ Request::get("session")->session_exp }}",
                // };
                // let gotForm = getFormData($(form));
                // input.item_id = parseInt(gotForm.item_id);
                // input.pos_terminals = [gotForm];

                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
                            swal("","Data has changed","success");
                            $("#modal_editor").modal("hide");
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
            let modals = $("#modal_editor");
            let form = modals.find("form");

            for(key in data){
                let value = data[key];
                if(key == "reason_id") key = "item_id";
                if(key == "next_screen") form.find("select[name="+key+"]").val(value);
                if(key == "cancelation_auto_suggestion_text"){
                    $(".suggest_text").remove();
                    value.map((item,index)=>{
                        $("#cancelation_list").append(`<li class="list-group-item suggest_text">${item} <a href="javascript:void(0)" onclick="deleteSuggest(this,${index})" class="trash_del"><i class="fa fa-trash"></i></a></li>`);
                    });
                    temp_suggest = value;
                    continue;
                } 

                form.find("input[name="+key+"]").val(value);
            }
            
            modals.modal("show");

        }

        function destroy(id) {
            id = parseInt(id);
            let input = {
                "scrdata_id": 1269,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "delete": 1,
                "item_id":id,
                "pos_terminals": [
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

        $(document).ready(function(){
            let list = $("#cancelation_list");
            list.sortable({
                stop: function(event, ui) {
                    temp_suggest = [];
                    list.find("li").each(function(i, el){
                        let text = $(el).text();
                        temp_suggest.push(text);
                    });
                }
            });
            list.disableSelection();
        });

    </script>
@endsection