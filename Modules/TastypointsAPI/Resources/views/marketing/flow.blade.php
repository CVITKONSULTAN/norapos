@extends('tastypointsapi::marketing.partials.master')
@section( 'page_name', "Marketing Campagins - Funnels")

@section('page_css')
    
@endsection

@section('content-header',"Funnels")

@section('main_content')

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-body">
            <div class="main_page">
                <div class="table-control text-right mb-2">
                    <a href="{{ route("marketing.add") }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add</a>
                </div>
                <div class="table_container table-responsive">
                    <table class="table table-bordered table-striped" id="table_data">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@stop



@section('javascript')

<script>

    let json = {
        "scrdata_id": 1162,
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
                d.scr_name = "flows";
                return d;
            },
            "dataSrc": function ( json ) {
                json.data.map((item,index)=>{
                    temp_data[item.id] == undefined ? temp_data[item.id] = item : temp_data[item.id] = item;
                });
                return json.data;
            },
        },
        "columns": [
            { 
                data: "flow_name"
            },
            { 
                data: "flow_description",
            },
            { 
                data: "date_time_created",
            },
            { 
                data: "date_time_updated",
            },
            { 
                data: "flow_active",
                orderable:false,
                searchable:false,
                render:function(data,type,row){
                    return `
                    <a href="{{ route("marketing.add") }}?flow_id=${row.flow_id}&session_id=${json.session_id}" class="btn btn-primary btn-xs">Edit</a>
                    <button class="btn btn-danger btn-xs">Delete</button>
                    `;
                }
            }
        ],
    });

    function destroy(id) {
        id = parseInt(id);
        let data = temp_data[id];
        data.delete = 1;
        let input = {
            "scrdata_id": 1163,
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
            "partners": [
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

    function edit(id) {
        window.location = '/tastypointsapi/partner-management/partner/'+id+'/edit';
    }
    
</script>

    
@endsection
