@extends('tastypointsapi::partner.partials.master')
@section( 'page_name', "Partner Management - Rewards & Commission Settings")

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
        .form-control{
            margin-bottom: 10px;
        }
        .header_section{
            font-size: 14pt;
            font-weight: bold;
            margin-bottom: 20px;
        }
        label.col-sm-3.control-label {
            font-weight: 400;
        }
        .seperated_line{
            border: 1px #3c8dbc solid;
        }
        .seperated_container{
            padding: 15px 30px;
        }
        .form-inline .form-group {
            margin: 0px 10px;
        }
        .form-inline .form-group label {
            vertical-align: super;
            font-weight: 400;
            margin: 0px 5px;
        }
        .form-inline .form-group label.plot_label{
            min-width: 220px;
            text-align: right;
        }
        .form-inline .form-group label.plot_label span{
            /* color: #3c8dbc; */
            color: blue;
            font-weight: bold;
        }
        .remove_devision {
            color: red;
            cursor: pointer;
            font-size: 13pt;
            margin-left: 10px;
            vertical-align: bottom;
        }
        #total_rewards_points_pot{
            border: none;
            font-weight:bold;
            font-size:15pt;
            padding-top:0px;
        }
        .select2-container {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content-header',"Rewards & Commission Settings")

@section('main_content')

    <div class="main_page">
        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>Type Name</th>
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

                    <div class="row">

                        <div class="col-md-8">
                            <p class="header_section">Simulation parameters</p>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select partner for simulation</label>
                                <div class="col-sm-9">
                                    <select name="partner_id" class="form-control" required>
                                        <option value="" disabled selected>-- Select --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Select product for simulation</label>
                                <div class="col-sm-9">
                                    <select name="dish_id" class="form-control" required>
                                        <option value="" disabled selected>-- Select --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Delivery</label>
                                <div class="col-sm-9">
                                    <select name="delivery_id" class="form-control" required>
                                        <option value="" disabled selected>-- Select --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="button" id="check" class="btn btn-primary">Check</button>
                                <button type="button" id="simulation" class="btn btn-primary">Simulation</button>
                                <button type="button" id="save" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        <div class="col-md-12 seperated_container">
                            <div class="seperated_line"></div>
                        </div>

                        <div class="col-md-9">
                            <div>
                                <p class="header_section" style="display: inline-block;">Commission revenue</p>
                                <div class="form-group" style="display: inline-block;width:200px;">
                                    <select name="commision_type" class="form-control" id="comm_type" style="border: none;">
                                        <option value="tpartner_delivery_commission_revenue">Tpartner Delivery</option>
                                        <option value="tpartner_commission_revenue">Tpartner</option>
                                        <option value="delivery_option_commission_revenue">Delivery Option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label style="min-width: 220px;">This is the margin field %</label>
                                    <input type="number" 
                                        id="user_margin_percent"
                                        min="0" max="100"
                                        name="commission_revenue[user_margin_percent]" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label style="min-width: 101px;">User pays</label>
                                    <input type="number"
                                        id="user_pay_commission"
                                        name="commission_revenue[user_pay_commission]" class="form-control" required />
                                    <label>For the items/food</label>
                                </div>
                            </div>
                            <div class="form-inline">
                                    <div class="form-group">
                                        <label>This is the restaurant commision %</label>
                                        <input type="number" 
                                            id="partner_commission_percent"
                                            min="0" max="100"
                                            name="commission_revenue[partner_commission_percent]" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Restaurant pays</label>
                                        <input type="number" 
                                            id="partner_pay_commission"
                                            name="commission_revenue[partner_pay_commission]" class="form-control" required />
                                    <label>In commissions</label>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12 seperated_container">
                            <div class="seperated_line"></div>
                        </div>

                        <div class="col-md-9">
                            <p class="header_section">Plot for rewards</p>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label class="plot_label">This is the rewards pot %</label>
                                    <input type="number" 
                                        id="rewards_pot_percent"
                                        min="0" max="100"
                                        name="pot_for_rewards[rewards_pot_percent]" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label style="width: 100px;">Is total $</label>
                                    <input type="number" 
                                        id="rewards_pot_total_usd"
                                        name="pot_for_rewards[rewards_pot_total_usd]" class="form-control" required />
                                    <label>Form commision</label>
                                </div>
                            </div>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label class="plot_label">Convertion rate to points is %</label>
                                    <input type="number" 
                                        id="convertion_rate_to_points_percent"
                                        min="0" max="100"
                                        name="pot_for_rewards[convertion_rate_to_points_percent]" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label style="width: 100px;">Is total $</label>
                                    <input type="number" 
                                        id="total_usd_rewards_pot"
                                        name="pot_for_rewards[total_usd_rewards_pot]" class="form-control" required />
                                    <label>From commission</label>
                                </div>
                            </div>
                            <div class="form-inline">
                                <div class="form-group">
                                    <label class="plot_label">Cents/Points C</label>
                                    <input type="number" 
                                        id="convertion_cent_to_points"
                                        name="pot_for_rewards[convertion_cent_to_points]" class="form-control" required />
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12 seperated_container">
                            <div class="seperated_line"></div>
                        </div>

                        <div class="col-md-9">

                            <div class="form-inline">
                                <div class="form-group">
                                    <label class="plot_label">Total rewards points pot</label>
                                    <input 
                                    id="total_rewards_points_pot"
                                    name="pot_for_rewards[total_rewards_points_pot]"
                                    class="form-control" value="33.6" />
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12 seperated_container" style="padding-top: 0px;">
                            <div class="seperated_line"></div>
                        </div>

                        <div class="col-md-9">
                            <p class="header_section">Rewards points devisions</p>
                            <div class="form-group">
                                <div class="input-group" style="padding-left: 103px;padding-right: 142px;">
                                    <input id="input_field_devision" class="form-control" placeholder="Add new devision" maxlength="10" />
                                    <div class="input-group-btn">
                                        <button onclick="addNewDevision()" type="button" class="btn btn-primary">Add New</button>
                                    </div>
                                </div>
                            </div>

                            <div id="list_devision">
                                <div class="form-inline">
                                    <div class="form-group">
                                        <label class="plot_label"><span>User</span> points share %</label>
                                        <input class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Is total points</label>
                                        <input class="form-control" />
                                        <label>Form rewards pot</label>
                                    </div>
                                </div>
    
                            </div>

                            
                            
                        </div>
                        <div class="col-md-12 seperated_container">
                            <div class="seperated_line"></div>
                        </div>

                        <div class="col-md-9">
                            <p class="header_section">Points to cash convertion</p>

                            <div class="form-inline">
                                <div class="form-group">
                                    <label class="plot_label">Points/Cents C</label>
                                    <input id="convertion_points_to_cent" name="points_to_cash_convertion[convertion_points_to_cent]" class="form-control" />
                                </div>
                            </div>

                            <div id="list_convertion">

                                <div class="form-inline">
                                    <div class="form-group">
                                        <label class="plot_label"><span>User</span> cash back $</label>
                                        <input class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label style="width: 85px;text-align:right;">Is %</label>
                                        <input class="form-control" />
                                        <label>Cash back</label>
                                    </div>
                                </div>

                            </div>

                            
                            
                        </div>
                        <div class="col-md-12 seperated_container">
                            <div class="seperated_line"></div>
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

        function deleteDevision(id){
            let dom = $(".data_devision_"+id);
            dom.fadeOut(300,function(){
                dom.remove();
            });
        }

        let dataDevision = [];
        let dataCashback = [];
        function addNewDevision() {
            let val = $("#input_field_devision").val();
            // console.log(val);
            if(val !== ""){

                let id = dataDevision.length + 1;
                let devision = '<div class="form-inline data_devision_'+id+'">'+
                                    '<div class="form-group">'+
                                        '<label class="plot_label"><span>'+val+'</span> points share %</label>'+
                                        '<input name="rewards_points_devisions['+val+'_points_share_percent]" style="margin-left: 4px;" class="form-control" />'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label>Is total points</label>'+
                                        '<input name="rewards_points_devisions['+val+'_total_points]" style="margin-left: 7px;margin-right: 5px;" class="form-control" />'+
                                        '<label>Form rewards pot <i class="fas fa-times-circle remove_devision" onclick="deleteDevision('+id+')"></i></label>'+
                                    '</div>'+
                                '</div>';
                $("#list_devision").append(devision);
                dataDevision.push({
                    id:id,
                    value:val
                });

                let cashback = '<div class="form-inline data_devision_'+id+'">'+
                                    '<div class="form-group">'+
                                        '<label class="plot_label"><span>'+val+'</span> cash back $</label>'+
                                        '<input name="points_to_cash_convertion['+val+'_cashback]" style="margin-left:4px;" class="form-control" />'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label style="width: 85px;text-align:right;">Is %</label>'+
                                        '<input name="points_to_cash_convertion['+index+'_cashback_percent]" style="margin-left:8px;margin-right:5px;" class="form-control" />'+
                                        '<label>Cash back</label>'+
                                    '</div>'+
                                '</div>';
                $("#list_convertion").append(cashback);

                dataCashback.push({
                    id:id,
                    value:val
                });

            }

        }

        function loadPartner() {
            let input = {
                "scrdata_id": 1002,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000000,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.partners.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.name+' ('+item.id+')</option>';
                            $("#form_data select[name=partner_id]").append(new_item);
                        });
                        $("#form_data select[name=partner_id]").select2();

                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function loadDishList() {
            let input = {
                "scrdata_id": 1138,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000000,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    $("#dataList").empty();
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.partner_dishes.map((item,index)=>{
                            let new_item = '<option value="'+item.id+'">'+item.name+' ('+item.id+')</option>';
                            $("#form_data select[name=dish_id]").append(new_item);
                        });
                        $("#form_data select[name=dish_id]").select2();
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function loadDelivery() {
            let input = {
                "scrdata_id": 1066,
                "sp_name": "OK",
                "session_id": "{{ Request::get("session")->session_id }}",
                "session_exp": "{{ Request::get("session")->session_exp }}",
                "status": "OK",
                "item_id": 0,
                "max_row_per_page": 1000000,
                "search_term": "0",
                "search_term_header": "0",
                "pagination": 1,
                "total_records": 3,
            };
            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                beforeSend:function(){
                    $("#dataList").empty();
                },
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        response.data.delivery_options.map((item,index)=>{
                            let new_item = '<option value="'+item.delivery_option_id+'">'+item.delivery_option_name+' ('+item.delivery_option_id+')</option>';
                            $("#form_data select[name=delivery_id]").append(new_item);
                        });
                    }
                    $("#form_data select[name=delivery_id]").select2();
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        $(document).ready(function(e){
            loadPartner();
            loadDishList();
            loadDelivery();
        });

        $("#check").click(function(e) {
            check();
        });

        $("#simulation").click(function(e) {
            senData("simulation");
        });

        $("#save").click(function(e) {
            senData("save");
        });

        function senData(type){
            
            let partner_id = $("#form_data [name=partner_id]").val();
            let dish_id = $("#form_data [name=dish_id]").val();
            let delivery_id = $("#form_data [name=delivery_id]").val();
            if(
                partner_id == "" ||
                dish_id == "" ||
                dish_id == ""
            ) {
                swal({
                    title: "Bad request",
                    text: "Please select dropdown",
                    icon: "error",
                });
            }

            let input = {
                "scrdata_id": 1150,
                "sp_name": "OK",
                "session_id": "WA1f716e9c-e95b-48f6-ab6e-4c0d9c626f07",
                "session_exp": "2021-03-02T15:00:51.945476",
                "status": "OK",
                "simulation": 1,
                "save": 0,
                "partner_id": parseInt(partner_id),
                "dish_id": parseInt(dish_id),
                "delivery_id": parseInt(delivery_id),
                "rewards_settings":{}
            };

            type == "save" ? input.save = 1 : input.save = 0;
            type == "simulation" ? input.simulation = 1 : input.simulation = 0;

            let commission_revenue = {};
            $("#form_data input[name^=commission_revenue]") .map(function(index,item){
                var matches = $(this).attr("name").match(/\[(.*?)\]/);
                if (matches) {
                    let objname = matches[1];
                    commission_revenue[objname] = parseFloat($(this).val());
                }
            });
            input.rewards_settings[commission_revenue_key] = commission_revenue;

            let pot_for_rewards = {};
            $("#form_data input[name^=pot_for_rewards]") .map(function(index,item){
                var matches = $(this).attr("name").match(/\[(.*?)\]/);
                if (matches) {
                    let objname = matches[1];
                    pot_for_rewards[objname] = parseFloat($(this).val());
                }
            });
            input.rewards_settings.pot_for_rewards = pot_for_rewards;
            
            let rewards_points_devisions = {};
            $("#form_data input[name^=rewards_points_devisions]") .map(function(index,item){
                var matches = $(this).attr("name").match(/\[(.*?)\]/);
                if (matches) {
                    let objname = matches[1];
                    rewards_points_devisions[objname] = parseFloat($(this).val());
                }
            });
            input.rewards_settings.rewards_points_devisions = rewards_points_devisions;
            input.rewards_settings.points_to_cash_convertion = {"convertion_points_to_cent":parseFloat($("#convertion_points_to_cent").val())};
            console.log("SEND DATA",input);

            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        temp_response = response.data;

                        renderField(response);
 
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });

        }

        let commission_revenue_key = "tpartner_delivery_commission_revenue";
        let temp_response = {};

        function check() {

            let partner_id = $("#form_data [name=partner_id]").val();
            let dish_id = $("#form_data [name=dish_id]").val();
            let delivery_id = $("#form_data [name=delivery_id]").val();

            let input = {
                "scrdata_id": 1150,
                "sp_name": "OK",
                "session_id": "WA1f716e9c-e95b-48f6-ab6e-4c0d9c626f07",
                "session_exp": "2021-03-02T15:00:51.945476",
                "status": "OK",
                "simulation": 0,
                "save": 0,
                "partner_id": parseInt(partner_id),
                "dish_id": parseInt(dish_id),
                "delivery_id": parseInt(delivery_id)
            };

            $.ajax({
                url:'{{ route("tastypointsapi.testnet") }}',
                type:"post",
                data:{"input":JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.data){
                        response.data = JSON.parse(response.data);
                        temp_response = response.data;

                        renderField(response);
 
                    }
                },
                error:function(error){
                    console.log(error);
                }
            });
        }

        function capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        $("#comm_type").change(function(e){
            let response = {"data":temp_response};
            // commission_revenue
            let value = $(this).val();

            let commission_revenue = response.data.rewards_settings[value];
            commission_revenue_key = value;

            $("#user_margin_percent")
            .val(commission_revenue.user_margin_percent);
            $("#user_pay_commission")
            .val(commission_revenue.user_pay_commission);
            $("#partner_commission_percent")
            .val(commission_revenue.partner_commission_percent);
            $("#partner_pay_commission")
            .val(commission_revenue.partner_pay_commission);
        });

        function renderField(response) {
            console.log(response.data);
            // commission_revenue
            let commission_revenue = response.data.rewards_settings.tpartner_delivery_commission_revenue;

            commission_revenue_key = "tpartner_delivery_commission_revenue";
            if(response.data.rewards_settings.tpartner_delivery_commission_revenue.user_margin_percent == null){
                commission_revenue = response.data.rewards_settings.tpartner_commission_revenue;
                commission_revenue_key = "tpartner_commission_revenue";
            }
            if(response.data.rewards_settings.tpartner_commission_revenue.user_margin_percent == null){
                commission_revenue = response.data.rewards_settings.delivery_option_commission_revenue;
                commission_revenue_key = "delivery_option_commission_revenue";
            }

            $("#comm_type").val(commission_revenue_key);


            $("#user_margin_percent")
            .val(commission_revenue.user_margin_percent);
            $("#user_pay_commission")
            .val(commission_revenue.user_pay_commission);
            $("#partner_commission_percent")
            .val(commission_revenue.partner_commission_percent);
            $("#partner_pay_commission")
            .val(commission_revenue.partner_pay_commission);

            let pot_for_rewards = response.data.rewards_settings.pot_for_rewards;
            $("#rewards_pot_percent")
            .val(pot_for_rewards.rewards_pot_percent);
            $("#rewards_pot_total_usd")
            .val(pot_for_rewards.rewards_pot_total_usd);
            $("#convertion_rate_to_points_percent")
            .val(pot_for_rewards.convertion_rate_to_points_percent);
            $("#convertion_cent_to_points")
            .val(pot_for_rewards.convertion_cent_to_points);
            $("#total_usd_rewards_pot")
            .val(pot_for_rewards.total_usd_rewards_pot);
            $("#total_rewards_points_pot")
            .val(pot_for_rewards.total_rewards_points_pot);

            let rewards_points_devisions = response.data.rewards_settings.rewards_points_devisions;

            $("#list_devision").empty();
            rewards_points_devisions.data.map((val,j)=>{
                let key = Object.keys( val );
                let index = key[0];
                let item = val[index];
                let label = capitalizeFirstLetter(index);

                let devision = '<div class="form-inline data_devision_'+index+'">'+
                                    '<div class="form-group">'+
                                        '<label class="plot_label"><span>'+label+'</span> points share %</label>'+
                                        '<input required value="'+item.points_share_percent+'" name="rewards_points_devisions['+index+'_points_share_percent]" style="margin-left: 4px;" class="form-control" />'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label>Is total points</label>'+
                                        '<input required value="'+item.total_points+'" name="rewards_points_devisions['+index+'_total_points]" style="margin-left: 7px;margin-right: 5px;" class="form-control" />'+
                                        '<label>Form rewards pot';
                if(index !== "user") 
                devision = devision+'<i class="fas fa-times-circle remove_devision" onclick="deleteDevision('+"'"+index+"'"+')"></i>';

                devision = devision+'</label></div></div>';
                $("#list_devision").append(devision);

                dataDevision.push({
                    id:index,
                    value:item
                });
            });

            let points_to_cash_convertion = response.data.rewards_settings.points_to_cash_convertion;

            $("#list_convertion").empty();
            points_to_cash_convertion.data.map((val,j)=>{
                let key = Object.keys( val );
                let index = key[0];
                let item = val[index];
                let label = capitalizeFirstLetter(index);
                let cashback = '<div class="form-inline data_devision_'+index+'">'+
                                    '<div class="form-group">'+
                                        '<label class="plot_label"><span>'+label+'</span> cash back $</label>'+
                                        '<input required value="'+item.cashback+'" name="points_to_cash_convertion['+index+'_cashback]" style="margin-left: 4px;" class="form-control" />'+
                                    '</div>'+
                                    '<div class="form-group">'+
                                        '<label>Is %</label>'+
                                        '<input required value="'+item.cashback_percent+'" name="points_to_cash_convertion['+index+'_cashback_percent]" style="margin-left: 7px;margin-right: 5px;" class="form-control" />'+
                                        '<label>Cash back</label>'+
                                    '</div>'+
                                '</div>';
                $("#list_convertion").append(cashback);

                dataCashback.push({
                    id:index,
                    value:item
                });
            });

            $("#convertion_points_to_cent").val(response.data.rewards_settings.points_to_cash_convertion.convertion_points_to_cent);

            
        }

    </script>
@endsection