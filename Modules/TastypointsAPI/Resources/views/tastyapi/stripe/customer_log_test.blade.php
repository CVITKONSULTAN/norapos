@extends('tastypointsapi::tastyapi.stripe.index')
@section( 'page_name', "Customer Log - Stripe")

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

@section('content-header',"Customer Log")

@section('main_content')

    <div class="main_page">

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

        <div class="text-right">
            <button onclick="firstLoad()" class="btn btn-primary">Refresh Data</button>
        </div>
        
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>CREATED_AT</th>
                        <th>USER_ID</th>
                        <th>TYPE</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="loading">
                        <td colspan="10" class="text-center">Loading...</td>
                    </tr>
                </tbody>
            </table>
            {{-- <button id="loadmore" onclick="loadMore()" class="btn btn-primary btn-block ">Load More</button> --}}
        </div>
    </div>

@stop

@section('javascript')
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.js"></script>
    <script>

        let data = [];

        const loadData = async (config) => {
            return $.ajax({
                url:"{{ route('stripe.list_test',['type'=>'customers-logs']) }}",
                method:"GET",
                success:function(res){
                    data = res.data;
                    console.log(res);
                    $("#loading").hide();
                    $("#table_data tbody").empty();
                    res.data.map((item,index)=>{
                        const row = `
                        <tr>
                            <td>${new Date(item.created_at).toString()}</td>
                            <td>${item.user_id}</td>
                            <td>${item.type}</td>
                            <td><button onclick="details(${index})" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i></button></td>
                        </tr>`;
                        $("#table_data tbody").append(row)
                    })
                },
                error:function(e){
                    console.log(e)
                }
            })

        }

        const details = (index) => {
            const val = data[index];
            jsoneditor.set(JSON.parse(val.response));
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

        $(document).ready(function(){

            firstLoad();

        });
        

    </script>
    
@endsection