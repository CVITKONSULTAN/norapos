@extends('layouts.app')

@section( 'title', __('tastypointsapi::lang.tastypoints') . ' | Push Notification Testing' )

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.css" />
    <style type="text/css">
        .error{
            color: red;
        }
        #box{
            display: none;
        }
        #content_action{
            margin-bottom: 20px;
            margin-top: 20px;
        }
        .jsoneditor{
            height: 50vh;
            width: auto;
        }
        #request{
            margin-top: 50px;
        }
    </style>
@endsection


@section('content')

    @include('tastypointsapi::layouts.nav')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Push Notification Testing
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <div class="box box-solid">
                    <div class="box-body">
                        <form action="" method="post" id="form_data">
                            <div class="pull-right">
                                <button id="preview" type="button" class="btn btn-info" style="margin-bottom: 10px;">Preview</button>
                                <button id="preview_order" type="button" class="btn btn-info" style="margin-bottom: 10px;">Order Preview</button>
                            </div>
                            <div class="form-group">
                                <label for="send_to">Send To:</label>
                                <select name="send_to" id="send_to" class="form-control">
                                    <option value="single">Single Device</option>
                                    <option value="topic">Topic</option>
                                </select>
                            </div>
                            <div class="form-group" id="firebase_token_group">
                                <label for="firebase_token">Firebase Token:</label>
                                <input type="text" required="" class="form-control" id="firebase_token" placeholder="Enter Firebase Token" name="firebase_token">
                            </div>
                            <div class="form-group" style="display: none" id="topic_group">
                                <label for="topic">Topic Name:</label>
                                <input type="text" class="form-control" id="topic" placeholder="Enter Topic Name" name="topic">
                            </div>
                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" required="" class="form-control" id="title" placeholder="Enter Notification Title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="message">Message:</label>
                                <textarea required="" class="form-control" rows="2" id="message" placeholder="Enter Notification Message" name="message"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Main Click Action:</label>
                                <input type="text" required="" class="form-control" placeholder="Link or Screen Name" name="main_click_action">
                            </div>
                            <div class="form-group">
                                <label>Sound</label>
                                <select name="sound" class="form-control" required="">
                                    <option value="default">Default</option>
                                    <option value="eventually">Eventually</option>
                                    <option value="open_up">Open Up</option>
                                    <option value="soft_bells">Soft Bells</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Color</label>
                                <input name="color" required="" class="form-control color_picker" value="#ff7f32">
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox"id="include_image" name="include_image">Include Image</label>
                            </div>
                            <div class="form-group" style="display: none" id="image_url_group">
                                <label for="image_url">Image URL:</label>
                                <input type="url" class="form-control" id="image_url" placeholder="Enter Image URL" name="image_url">
                            </div>

                            <p>
                                Action on notif : 
                                <button id="add_action" type="button" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> Add
                                </button>
                            </p>
                            <div id="content_action"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="box box-solid">
                    <div class="box-body">
                        <div class="pull-right">
                            <button type="submit" onclick="submit_json()" class="btn btn-info">Submit</button>
                        </div>
                        <div class="jsoneditor" id="request"></div>
                        <div id="box">
                            <h2>Result :</h2>
                            <pre id="result"></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('javascript')

		<script src="https://cdnjs.cloudflare.com/ajax/libs/tinyColorPicker/1.1.1/colors.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/tinyColorPicker/1.1.1/jqColorPicker.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsoneditor/9.1.7/jsoneditor.min.js"></script>
		
		<script>

            let req_json = document.getElementById("request");
            let config = {
                mode: 'tree',
                modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
            };

            let req_editor = new JSONEditor(req_json,config);

			$('.color_picker').colorPicker({
			    opacity: false, // disables opacity slider
			    renderCallback: function($elm, toggled) {
			        $elm.val('#' + this.color.colors.HEX);
			    }
			});

			$('#include_image').change(function(e){
				if($(this).prop("checked")==true){
					$('#image_url_group').show();
					$("#image_url").prop('required',true);
				}else{
					$('#image_url_group').hide();
					$("#image_url").prop('required',false);
				}
			});

			let count = 0;
			$('#add_action').click(()=>{
				count = count+1;
				let format_form =
				'<div class="row" id="row_number_'+count+'">'+
					'<div class="col-md-3">'+
						'<div class="form-group">'+
							'<input type="number" name="action_order[]" class="form-control" required placeholder="Action Order (number)">'+
						'</div>'+
					'</div>'+
					'<div class="col-md-3">'+
						'<div class="form-group">'+
							'<input name="action_name[]" class="form-control" required placeholder="Action Name" maxlength="20">'+
						'</div>'+
					'</div>'+
					'<div class="col-md-2">'+
						'<div class="form-group">'+
							'<select name="action_type[]" class="form-control action_type" data-count="'+count+'" required>'+
								'<option value="S">Screen</option>'+
								'<option value="L">Link</option>'+
							'</select>'+
						'</div>'+
					'</div>'+
					'<div class="col-md-3">'+
						'<div class="form-group">'+
							'<input name="action[]" class="form-control action_placeholder_'+count+'" required placeholder="Link or Screen Name">'+
						'</div>'+
					'</div>'+
					'<div class="col-md-1"><button class="btn btn-danger" onClick="DeleteAction('+count+')">Delete</div>'+
				'</div>';

				$('#content_action').append(format_form);

			});


			function DeleteAction(value){
				$('#row_number_'+value).remove();
			}
				
			$('#send_to').change(function(e){
                var selectedVal = $("#send_to option:selected").val();
                if(selectedVal=='topic'){
                    $('#topic_group').show();
                    $("#topic").prop('required',true);
                    $('#firebase_token_group').hide();
                    $("#firebase_token").prop('required',false);
                }else{
                    $('#topic_group').hide();
                    $("#topic").prop('required',false);
                    $('#firebase_token_group').show();
                    $("#firebase_token").prop('required',true);
                }
            });

            $("#preview").click(function(e){
                processForm();
            });

            let input = {};
            function processForm() {
                var data = $('#form_data').serializeArray();

                var notification = {
                    "title":data[3].value,
                    'body':data[4].value,
                    'main_click_action':data[5].value,
                    'sound':data[6].value,
                    'color':data[7].value,
                }

                if (data[8].name == 'include_image' && data[8].value == 'on') {
                    notification.image = data[9].value;
                }

                for(key in notification){
                    const val = notification[key];
                    input.data[key] = val;
                }

                input.to = data[1].value;
                input.content_available = true;
                input.priority = 'high';

                var element = $("input[name='action_order[]']");
                let action = [];

                if (element !== undefined) {

                    var data_action_order = [];
                    element.map(function(item,index){
                        let value = $(this).val();
                        data_action_order.push(value);
                    }).get();

                    var data_action_name = [];
                    $("input[name='action_name[]']").map(function(item,index){
                        let value = $(this).val();
                        data_action_name.push(value);
                    }).get();

                    var data_action_type = [];
                    $("select[name='action_type[]']").map(function(item,index){
                        let value = $(this).val();
                        data_action_type.push(value);
                    }).get();

                    var data_action_target = [];
                    $("input[name='action[]']").map(function(item,index){
                        let value = $(this).val();
                        data_action_target.push(value);
                    }).get();

                    data_action_order.map((item,index)=>{
                        let new_data_action = {
                            action_order:item,
                            action_name:data_action_name[index],
                            action_type:data_action_type[index],
                            action:data_action_target[index],
                        }
                        action.push(new_data_action);
                    });
                }

                if (action.length > 0) {
                    input.data.action = action;
                }

                req_editor.set(input);
            }

			
            $('#form_data').validate({
				submitHandler:function(form){
                    input = req_editor.get();
                    processForm();
				
					$.ajax({
					  method: "POST",
					  url: '{{ route("tastypointsapi.fcm") }}',
					  headers: {
					        "Authorization":"key=AIzaSyCfkUjS-Ejimb2AMs91RgFU_OKKx5VWcMc",
					        "Content-Type":"application/json"
					   },
					  data: JSON.stringify(input),
					  success: function (response, text) {
					  	  $('#box').show('fade');
					  	  $('#result').html(JSON.stringify(response, null, 2));
					    //   console.log(response,text);
					  },
					  error: function (request, status, error) {
					  	  $('#box').hide('fade');
					      alert(request.responseText);
					  }
					});
				    
					return false;
				}
			});

            const submit_json = () => {

                input = req_editor.get();
				
                $.ajax({
                    method: "POST",
                    url: '{{ route("tastypointsapi.fcm") }}',
                    headers: {
                        "Authorization":"key=AIzaSyCfkUjS-Ejimb2AMs91RgFU_OKKx5VWcMc",
                        "Content-Type":"application/json"
                    },
                    data: JSON.stringify(input),
                    success: function (response, text) {
                        $('#box').show('fade');
                        $('#result').html(JSON.stringify(response, null, 2));
                    //   console.log(response,text);
                    },
                    error: function (request, status, error) {
                        $('#box').hide('fade');
                        alert(request.responseText);
                    }
                });
            }

            $("#preview_order").click(function(){
                
                input = {
                    "to": "d2fQU9nyR86waRQiUiGAKk:APA91bFFy_P9nBsvgxZMj-uQhW0-2nLiMBbQkYb3CvOlgE6eZkRQGoXFhRjOeLIu-3-uAB0DcS5Jh6k3cL_FqaJuLnH-_Y-l0TNhNFNYBlRSJhl8mW8IOmJLRDctHvfXy9Cti91gW8af",
                    "data": {
                        "title": "new order",
                        "body": "new order max expired 19:01",
                        "main_click_action": "new order",
                        "order": {
                        "scrdata_id": 813,
                        "session_id": "9bd73dd3-ded4-4968-b3b8-52809157cd2d",
                        "status": "OK",
                        "sent_at": "2021-10-25 18:24:30",
                        "acceptence_timer": 60,
                        "rejection_list": [
                            {
                            "id": 1,
                            "name": "Too Busy"
                            },
                            {
                            "id": 2,
                            "name": "Too far away"
                            },
                            {
                            "id": 3,
                            "name": "Total value to low"
                            }
                        ],
                        "order": {
                            "id": 12345678,
                            "total_items": 4,
                            "time": "2021-12-31 18:02",
                            "compensation": {
                            "earning": 15,
                            "points": 12
                            },
                            "currency": "$",
                            "distance": {
                            "value": 12,
                            "measurements": "km"
                            },
                            "partner": {
                            "id": 1,
                            "name": "Toktok Restaurant",
                            "phone": "+6282255985321",
                            "address": "Beverly Hills St",
                            "location": {
                                "lat": -101,
                                "lng": 109.888
                            }
                            },
                            "user": {
                            "id": 1,
                            "name": "Heru"
                            }
                        }
                        },
                        "sound": "default",
                        "color": "#ff7f32",
                        "image": "https://helpiewp.com/wp-content/uploads/2020/03/Loyalty-Points-and-Rewards-plugin.png",
                        "action": [
                        {
                            "action_order": "1",
                            "action_name": "YES",
                            "action_type": "L",
                            "action": "https://google.com"
                        },
                        {
                            "action_order": "2",
                            "action_name": "NO",
                            "action_type": "L",
                            "action": "https://google.com"
                        }
                        ]
                    },
                    "content_available": true,
                    "priority": "high"
                }

                processForm();

                req_editor.set(input);
            })
		</script>
@endsection