@extends('tastypointsapi::geosettings.partials.master')
@section( 'page_name', "Geographic Settings - City")

@section('page_css')
    <style>
        .table_container{
            margin-top: 20px;
        }
        #add_new{
            margin-right: 20px;
        }
        #map{
            width: 100%;
            height: 50vh;
            margin: 10px 0px;
        }
        #map-control{
            margin-left: 10px;
        }
    </style>
@endsection

@section('content-header',"Geographic Settings")

@section('main_content')

    <div class="main_page">
        <form id="form_data">
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
                    <div id="map">
                        <div id="map-control">
                            <button type="button" id="delete-button" class="btn btn-danger"><i class="fas fa-trash"></i> selected shape</button>
                            <button type="button" id="clear-button" class="btn btn-primary"><i class="fas fa-redo"></i> Clear</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>CITY DOTS</label>
                        <textarea name="area_dots" id="area_dots" rows="5" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-save"></i> Save / Apply</button>
                    <button onclick="add()" type="button" class="btn btn-primary pull-right" id="add_new"><i class="fas fa-plus"></i> New</button>
                </div>
            </div>
        </form>

        <div class="table_container">
            <table class="table table-bordered table-striped" id="table_data">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>CITY NAME</th>
                        <th>STATE NAME</th>
                        <th>COUNTRY NAME</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

@stop

@section('javascript')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBG7iJabCnW3Hn2GAAk7lgcTBox7igfJq4&callback=initialize&libraries=drawing&v=weekly"
        defer
    ></script>
    <script>
        var polygon = null;
        let drawManage = null;
        function initialize() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom:10,
                center: new google.maps.LatLng(-34.397, 150.644),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                noClear:true
            });

            map.controls[google.maps.ControlPosition.LEFT_TOP]
            .push(document.getElementById('map-control'));
            
            var polyOptions = {
                strokeWeight: 3,
                fillOpacity: 0.2
            };
            
            var shapes = {

                collection:{},

                selectedShape:null,

                setShapetoMap:function(coordinate){
                    var that = this;
                    console.log(coordinate);
                    let shape = new google.maps.Polygon({
                        paths: coordinate,
                    });

                    shape.type = "polygon";
                    shape.id = new Date().getTime()+'_'+Math.floor(Math.random()*1000);
                    shape.setMap(map);
                    
                    this.collection[shape.id] = shape;

                    this.setSelection(shape);

                    google.maps.event.addListener(shape,'click',function(){
                        that.setSelection(this);
                        that.save();
                    });
                    google.maps.event.addListener(shape,'dragend',function(){
                        that.save();
                    });
                    shape.getPaths().forEach(function(path, index){

                        google.maps.event.addListener(path, 'insert_at', function(){
                            that.save();
                        });

                        google.maps.event.addListener(path, 'remove_at', function(){
                            that.save();
                        });

                        google.maps.event.addListener(path, 'set_at', function(){
                            that.save();
                        });

                    });

                    let center = this.getCenter(shape);
                    map.setCenter(center);

                    this.save();
                },

                add:function(e){
                    var shape = e.overlay,
                        that = this;
                    shape.type = e.type;
                    shape.id = new Date().getTime()+'_'+Math.floor(Math.random()*1000);
                    this.collection[shape.id] = shape;
                    this.setSelection(shape);
                    google.maps.event.addListener(shape,'click',function(){
                        that.setSelection(this);
                        that.save();
                    });
                    google.maps.event.addListener(shape,'dragend',function(){
                        that.save();
                    });
                    shape.getPaths().forEach(function(path, index){

                        google.maps.event.addListener(path, 'insert_at', function(){
                            that.save();
                        });

                        google.maps.event.addListener(path, 'remove_at', function(){
                            that.save();
                        });

                        google.maps.event.addListener(path, 'set_at', function(){
                            that.save();
                        });

                    });
                    this.save();
                },

                setSelection:function(shape){
                    if(this.selectedShape!==shape){
                        this.clearSelection();
                        this.selectedShape = shape;
                        shape.set('draggable',true);
                        shape.set('editable',true);
                    }
                },

                deleteSelected:function(){
                
                    if(this.selectedShape){
                    var shape= this.selectedShape;
                    this.clearSelection();
                    shape.setMap(null);
                    delete this.collection[shape.id];
                    this.save();
                    }
                },
                
                clearSelection:function(){
                    if(this.selectedShape){
                    this.selectedShape.set('draggable',false);
                    this.selectedShape.set('editable',false);
                    this.selectedShape=null;
                    this.save();
                    }
                },

                getCoordinate:function(shape){
                    var v = shape.getPath();
                    let coordinate = [];
                    for (var i=0; i < v.getLength(); i++) {
                        var xy = v.getAt(i);
                        // console.log('Cordinate lat: ' + xy.lat() + ' and lng: ' + xy.lng());
                        coordinate.push({
                            "lat":xy.lat(),
                            "lng":xy.lng()
                        });
                    }
                    return coordinate;
                },

                getCenter:function(poly){
                    const vertices = poly.getPath();

                    // put all latitudes and longitudes in arrays
                    let longitudes = [];
                    let latitudes = [];

                    for (var i=0; i < vertices.getLength(); i++) {
                        var xy = vertices.getAt(i);
                        latitudes.push(xy.lat());
                        longitudes.push(xy.lng());
                    }

                    // sort the arrays low to high
                    latitudes.sort();
                    longitudes.sort();

                    // get the min and max of each
                    const lowX = latitudes[0];
                    const highX = latitudes[latitudes.length - 1];
                    const lowy = longitudes[0];
                    const highy = longitudes[latitudes.length - 1];

                    // center of the polygon is the starting point plus the midpoint
                    const centerX = lowX + ((highX - lowX) / 2);
                    const centerY = lowy + ((highy - lowy) / 2);

                    return (new google.maps.LatLng(centerX, centerY));
                },

                save:function(){
                    var collection=[];
                    for(var k in this.collection){
                        var shape = this.collection[k],
                            types=google.maps.drawing.OverlayType;
                        switch(shape.type){
                            case types.POLYGON:

                                collection.push({ 
                                    coordinate:this.getCoordinate(shape),
                                    id:shape.id,
                                });
                            break;
                            default:
                            alert('implement a storage-method for '+shape.type)
                        }
                    }
                    //collection is the result
                    // console.log(collection);
                    $("#area_dots").val(JSON.stringify(collection));
                },

                clearShape:function(){
                    // console.log(this.collection);
                    for(var k in this.collection){
                        var shape = this.collection[k];
                        shape.setMap(null);
                    }
                    this.collection = {};
                    this.save();
                },
            };

            polygon = shapes;
            
            var drawingManager = new google.maps.drawing.DrawingManager({
                drawingControl: true,
                drawingControlOptions: {
                    drawingModes: [google.maps.drawing.OverlayType.POLYGON],
                    position: google.maps.ControlPosition.TOP_CENTER,
                },
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                polygonOptions: polyOptions,
                map: map
            });

            drawManage = drawingManager;

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
                drawingManager.setDrawingMode(null);
                shapes.add(e);
            });


            google.maps.event.addListener(drawingManager, 
                                        'drawingmode_changed', 
                                        function(){shapes.clearSelection();});
            google.maps.event.addListener(map, 
                                        'click', 
                                        function(){shapes.clearSelection();});
            google.maps.event.addDomListener(document.getElementById('delete-button'), 
                                        'click', 
                                        function(){shapes.deleteSelected();});
            google.maps.event.addDomListener(document.getElementById('clear-button'), 
                                        'click', 
                                        function(){shapes.clearShape();});
            google.maps.event.addDomListener(document.getElementById('save-button'), 
                                        'click', 
                                        function(){shapes.save();});

        }
    </script>
    
    <script>

        let json = {
            "scrdata_id": 1082,
            "sp_name": "OK",
            "session_id": "{{ Request::get("session")->session_id }}",
            "session_exp": "{{ Request::get("session")->session_exp }}",
            "item_id": 0,
            "max_row_per_page": 50,
            "search_term": "",
            "search_term_header": "",
            "pagination": 1,
            "sp_name": "OK",
            "status": "OK",
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
                    d.scr_name = "city";
                    return d;
                },
                "dataSrc": function ( json ) {
                    json.data.map((item,index)=>{
                        temp_data[item.id] == undefined ? temp_data[item.id] = item : temp_data[item.id] = item;
                    });
                    return json.data;
                }  
            },
            "columns": [
                { 
                    data: "id",
                },
                { 
                    data: "city_name",
                },
                { 
                    data: "state_name",
                },
                { 
                    data: "country_name",
                },
                { 
                    data: "id",
                    orderable:false,
                    searchable:false,
                    render:function(data,type,row){
                        return '<button class="btn btn-primary btn-xs" onclick="edit('+
                        "'"+row.id+"'"+
                        ')">Edit</button> <button class="btn btn-danger btn-xs" onclick="destroy('+
                        "'"+row.id+"'"+
                        ')">Delete</button>';
                    }
                }
            ],
        });


        $("#form_data").validate({
            submitHandler:function(form){

                let input = {
                    "scrdata_id": 1083,
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                };
                let gotForm = getFormData($(form));
                input.item_id = gotForm.item_id;
                
                try {
                    let con_id = parseInt(gotForm.country_id);
                    gotForm.country_name = country[con_id].name;

                    let timezone_id = parseInt(gotForm.timezone_id);
                    gotForm.timezone_name = time_zones[timezone_id].name;

                    let state_id = parseInt(gotForm.state_id);
                    gotForm.state_name = state[state_id].state_name;
                    gotForm.state_code = state[state_id].state_code;

                } catch (error) {
                    gotForm.country_name = null;
                    gotForm.state_name = null;
                    gotForm.state_code = null;
                }

                gotForm.area_dots = [];
                try {    
                    let dots = JSON.parse($("#area_dots").val());
                    dots.map((item,index)=>{
                        item.coordinate.map((val,i)=>{
                            let newdata = {
                                "order":i+1,
                                "lat":val.lat,
                                "lon":val.lng
                            };
                            gotForm.area_dots.push(newdata);
                        });
                    });
                } catch (error) {
                    gotForm.area_dots = [];
                }

                input.city = [gotForm];
                console.log(JSON.stringify(input));
                
                Pace.track(function(){

                    $.ajax({
                        url:'{{ route("tastypointsapi.testnet") }}',
                        type:"post",
                        data:{"input":JSON.stringify(input)},
                        success:function(response){
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
        
        let state_id = "";
        function edit(id) {
            let data = [];
            try {
                data = temp_data[id];
            } catch (error) {
                console.log(error);
            }
            $("#form_data input[name=item_id]").val(id);
            $("#form_data input[name=city_name]").val(data.city_name);

            let location = [{"coordinate":[]}];
            
            try {

                polygon.clearShape();
                if(data.area_dots == null) data.area_dots = [];

                data.area_dots.map((item,index)=>{
                    location[0].coordinate.push(
                        {
                            "lat":item.lat,
                            "lng":item.lon
                        }
                    );
                });
                if(location[0].coordinate.length > 0) polygon.setShapetoMap(location[0].coordinate);
                
            } catch (error) {
                console.log(error);    
            }

            drawManage.setDrawingMode(null);
            $("#area_dots").val(JSON.stringify(location));

            state_id = data.state_code;
            
            $("#form_data select[name=country_id]").val(data.country_id);
            $("#form_data select[name=country_id]").trigger("change");

            $("#form_data select[name=timezone_id]").val(data.timezone_id).trigger("change");
        }

        function add() {
            $("#form_data input").val("");
            $("#form_data select").val("");
            $("#form_data textarea").val("");
            $("#form_data input[name=item_id]").val(0);
            polygon.clearShape();
        }

        function destroy(id) {
            let data = temp_data[id];
            data.delete = 1;
            let input = {
                "scrdata_id": 1082,
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
                "city":data,
            };
            console.log(JSON.stringify(input));

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

        let country = [];
        function load_country() {
            let input = {
                "scrdata_id": 1010,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "item_id": 0,
                "max_row_per_page": 100000,
                "search_term": "",
                "search_term_header": "",
                "pagination": 1,
                "sp_name": "OK",
                "status": "OK",
            };
            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{input:JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        $("#form_data select[name=country_id]").empty();
                        $("#form_data select[name=country_id]").append('<option value="" disabled selected>-- Select --</option>');
                        data.country.map((item,index)=>{
                            country[item.id] = item;
                            $("#form_data select[name=country_id]").append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        $("#form_data select[name=country_id]").select2();
                    }
                },
                error:function(error){

                }
            });
        }

        let time_zones = [];
        function load_timezone() {
            let input = {
                "scrdata_id": 1128,
                "session_id": json.session_id,
                "session_exp": json.session_exp,
                "item_id": 0,
                "max_row_per_page": 100000,
                "search_term": "",
                "search_term_header": "",
                "pagination": 1,
                "sp_name": "OK",
                "status": "OK",
            };
            let elm = $("#timezone_id");
            $.ajax({
                url:"{{ route('tastypointsapi.testnet') }}",
                type:"post",
                data:{input:JSON.stringify(input)},
                success:function(response){
                    response = JSON.parse(response);
                    if(response.status){
                        let data = JSON.parse(response.data);
                        // $("#form_data select[name=country_id]").empty();
                        elm.empty();
                        elm.append('<option value="" disabled selected>-- Select --</option>');
                        data.time_zones.map((item,index)=>{
                            time_zones[item.id] = item;
                            elm.append('<option value="'+item.id+'">'+item.name+'</option>');
                        });
                        // elm.select2("destroy");
                        elm.select2();
                    }
                },
                error:function(error){

                }
            });
        }

        let state = [];
        $("#form_data select[name=country_id]").change(function(e){
            let id = $(this).val();
            if(id !== null) {
                id = parseInt(id);
                let input = {
                    "scrdata_id": 1084,
                    "sp_name": "OK",
                    "session_id": "{{ Request::get("session")->session_id }}",
                    "session_exp": "{{ Request::get("session")->session_exp }}",
                    "item_id": 0,
                    "max_row_per_page": 50,
                    "search_term": "",
                    "search_term_header": "",
                    "filter_country_id": id,
                    "pagination": 1,
                    "sp_name": "OK",
                    "status": "OK",
                };
                $.ajax({
                    url:"{{ route('tastypointsapi.testnet') }}",
                    type:"post",
                    data:{input:JSON.stringify(input)},
                    success:function(response){
                        response = JSON.parse(response);
                        if(response.status){
                            let data = JSON.parse(response.data);
                            $("#form_data select[name=state_id]").empty();
                            $("#form_data select[name=state_id]").append('<option value="" selected>-- Select country --</option>');
                            data.state.map((item,index)=>{
                                state[item.id] = item;
                                $("#form_data select[name=state_id]").append('<option data-code="'+item.state_code+'" value="'+item.id+'">'+item.state_name+'</option>');
                            });
                            if(state_id !== ""){
                                $("#state_id option[data-code='" + state_id + "']").prop("selected", true);
                                // console.log(state_id,$("#state_id option[data-code='" + state_id + "']"));
                            }
                            $("#form_data select[name=state_id]").select2();
                        }
                    },
                    error:function(error){

                    }
                });
            }
        });

        $(document).ready(function(){
            load_country();
            load_timezone();
        });

    </script>
@endsection