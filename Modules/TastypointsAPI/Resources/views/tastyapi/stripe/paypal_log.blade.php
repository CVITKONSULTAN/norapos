@extends('tastypointsapi::tastyapi.stripe.index')
@section( 'page_name', "Payouts - Stripe")

@section('page_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.css" />
    <style>
        .jsoneditor{
            height: 80vh;
            width: auto;
        }
        .jsoneditor-selected {
            background-color: #e7e7e7 !important;
            color: black !important;
            font-weight: bold !important;
        }
        .table_container{
            margin-top: 20px;
        }
    </style>
@endsection

@section('content-header',"List Payouts")

@section('main_content')

    <div class="main_page">

        {{-- <form id="form_data">
            @csrf
            <input type="hidden" name="item_id" value="0" />

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>CITY NAME</label>
                        <input name="city_name" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>TIME ZONE</label>
                        <select id="timezone_id" class="form-control" name="timezone_id" required></select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>SELECT COUNTRY</label>
                        <select class="form-control" name="country_id" required>
                            <option value="" selected disabled>-- Select --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>SELECT STATE</label>
                        <select id="state_id" class="form-control" name="state_id">
                            <option value="" selected disabled>-- Select Country --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-save"></i> Save / Apply</button>
                    <button onclick="add()" type="button" class="btn btn-primary pull-right" id="add_new"><i class="fas fa-plus"></i> New</button>
                </div>
            </div>
        </form> --}}

        <div id="details" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">DETAILS</h4>
                </div>
                <div class="modal-body">
                    <div class="jsoneditor" id="edit_json"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        {{-- <h3>Balance : <span id="balance">0</span></h3>
        <p>Pending Balance : <span id="pending">0</span></p> --}}
        <div class="text-right">
            <button onclick="reload()" class="btn btn-primary">Refresh Data</button>
        </div>
        
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>USER ID</th>
                        {{-- <th>ORIGIN</th> --}}
                        <th>PAYMENT ID</th>
                        <th>SLUG</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>

@stop

@section('javascript')
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.js"></script>
    <script>

        let data = [];

        const loadData = async (config) => {
            config.type = "payouts";
            console.log("config",config);
            return $.ajax({
                url:"{{ route('stripe.list') }}",
                method:"POST",
                data:config,
                success:function(res){
                    res = JSON.parse(res)
                    data = res.data;
                    console.log(res);
                    $("#loading").hide();
                    $("#table_data tbody").empty();
                    res.data.map((item,index)=>{
                        const row = `
                        <tr>
                            <td>${item.id}</td>
                            <td>${item.amount}</td>
                            <td>${item.status}</td>
                            <td>${item.type}</td>
                            <td>${item.failure_code}</td>
                            <td>${item.failure_message}</td>
                            <td>${item.created}</td>
                            <td>${item.description}</td>
                            <td><button onclick="details(${index})" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i></button></td>
                        </tr>`;
                        $("#table_data tbody").append(row)
                    })

                    const {amount,currency} = res.balance.available[0];
                    const pending = res.balance.pending[0];
                    $("#balance").text(amount+" "+currency.toUpperCase());
                    $("#pending").text((pending.amount/100)+" "+pending.currency.toUpperCase());
                },
                error:function(e){
                    console.log(e)
                }
            })

        }

        const details = (index) => {
            const val = temp_data[index];
            // val.
            // console.log(val)
            jsoneditor.set(val);
            $("#details").modal("show");
        }

        const firstLoad = () => {
            $("#loadmore").hide();
            loadData({});
            $("#loadmore").show();
        }

        const loadMore = () => {
            const last_obj = data[data.length-1];
            loadData({"starting_after":last_obj});
        }

        const config = {
            mode: 'tree',
            modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
        };

        let jsoneditor = new JSONEditor(document.getElementById("edit_json"),config);

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
            "url": '{{ route("stripe.paypal_log.data") }}',
            "type": 'GET',
            "dataSrc": function ( json ) {
                temp_data = [];
                json.data.map((item,index)=>{
                    temp_data.push(item);
                });
                return json.data;
            },
        },
        "columns": [
            { 
                data: "id"
            },
            { 
                data: "user_id",
            },
            // { 
            //     data: "origin",
            // },
            { 
                data: "id_payment",
            },
            { 
                data: "slug",
            },
            { 
                data: "id",
                orderable:false,
                searchable:false,
                render:function(data,type,row,index){
                    return `<button onclick="details(${index.row})" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i></button>`;
                }
            }
        ],
    });

    const reload = () => {
        otable.ajax.reload();
    }
        

    </script>
    
@endsection