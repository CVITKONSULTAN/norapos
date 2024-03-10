<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JAP FORM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error{
            color: red;
            font-size: 10pt;
        }
        .form-group{
            margin-bottom: 5px;
        }
    </style>
  </head>
  <body>
    <form class="container mt-3">
        <input type="hidden" name="product_id" value="" />
        <input type="hidden" name="uid" value="{{$uid ?? ""}}" />
        <input type="hidden" name="category" value="{{$jap ?? ""}}" />
        <input type="hidden" name="title" value="{{$title ?? ""}}" />
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input value="{{$user->name ?? ""}}" name="name" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Nomor KTP</label>
            <input value="{{$user->ktp ?? ""}}" name="ktp" required class="form-control" />
        </div>
        <div class="form-group">
            <label>No Handphone</label>
            <input value="{{$user->nohp ?? ""}}" name="nohp" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input value="{{$user->email ?? ""}}" type="email" name="email" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Provinsi</label>
            <select required name="provinsi" class="form-control" id="prov_dom">
                <option value="">--Pilih Provinsi--</option>
                @foreach ($provinsi as $item)
                    <option {{ $item->kode."-".$item->nama === $user->provinsi ? 'selected' : '' }} value="{{$item->kode."-".$item->nama}}">{{$item->nama}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Kota/Kabupaten</label>
            <select required name="kota_kab" class="form-control" id="kota_kab">
                <option value="">--Pilih Kota/Kabupaten--</option>
            </select>
        </div>
        <div class="form-group">
            <label>Kecamatan</label>
            <select required name="kecamatan" class="form-control" id="kecamatan">
                <option value="">--Pilih Kecamatan--</option>
            </select>
        </div>
        <div class="form-group">
            <label>Kelurahan/Desa</label>
            <select required name="desa" class="form-control" id="desa">
                <option value="">--Pilih Desa/Kelurahan--</option>
            </select>
        </div>
        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea required name="alamat" required class="form-control">{{$user->alamat ?? ""}}</textarea>
        </div>
        @if(!empty($products))
            <div class="form-group">
                <label>Pilih Produk/Layanan</label>
                <select required name="produk_id" class="form-control" id="product">
                    <option value="">--Pilih--</option>
                    @foreach ($products as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="alert alert-warning mt-2">
                <h5>Detail Layanan/Produk</h5>
                <p id="deskripsi"></p>
                <p><b>Total : <span id="harga"></span></b></p>
            </div>
        @endif
        <div class="d-grid mt-3 mb-3">
            <button class="btn btn-warning">Simpan</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

        @if(!empty($products))
            let selected = null;
            const products = [
                @foreach ($products as $item)
                {
                    "id" : "{{$item["id"]}}",
                    "description" : "{{$item["description"]}}",
                    "price" : {{$item["price"]}},
                },
                @endforeach
            ];
            $("#product").change(function(){
                const data = products.find(elm => elm.id === $(this).val());
                if(!data) return;
                selected = data;
                $("input[name=product_id]").val(data.id);
                $("#deskripsi").text(data.description);
                $("#harga").text("Rp. "+data.price.toLocaleString());
            })
        @endif


        $("form").validate({
            submitHandler:function(form){
                const btn = $('button');
                $.ajax({
                    url:"{{ route('itko.trx_store') }}",
                    type:"post",
                    data:$(form).serialize(),
                    beforeSend:function(){
                        btn.attr('disabled', true);
                    },
                    complete:function(){
                        btn.attr('disabled', false);
                    },
                    success:function(response){
                        console.log("response>>",response);
                        const status = response.status ? "success" : "info";
                        swal ( "" ,  response.message , status)
                        if(response.data.redirect){

                            if(!response.data.data.token_url)
                            return swal ( "" ,  response.data.data.message , "info")

                            console.log("url>>",response.data.data.token_url)
                            window.location.href = response.data.data.token_url ;
                            // window.location.replace( response.data.data.token_url )
                            return;
                        }
                        // window.ReactNativeWebView.postMessage(JSON.stringify({
                        //     goBack:true
                        // }))
                    }
                })
                return false;
            }
        });

        $("#prov_dom").change(function(){
            const id_prov = $(this).val();
            const id = id_prov.split("-")[0];
            const target = $("#kota_kab");
            $.ajax({
                url:"/api/wilayah?id="+id,
                beforeSend:function(){
                    target.attr("disabled",true);
                },
                complete:function(){
                    target.attr("disabled",false);
                },
                success:function(response){

                    if(!response.status) return alert(response.message);
                    target.empty();
                    target.append(`<option value="">--Pilih Kota/Kabupaten--</option>`);
                    response?.data?.forEach(data => {
                        target.append(`<option value="${data.kode}-${data.nama}">${data.nama}</option>`);
                    });
                }
            })
        });

        $("#kota_kab").change(function(){
            const val = $(this).val();
            const id = val.split("-")[0];
            const target = $("#kecamatan");
            $.ajax({
                url:"/api/wilayah?id="+id,
                beforeSend:function(){
                    target.attr("disabled",true);
                },
                complete:function(){
                    target.attr("disabled",false);
                },
                success:function(response){

                    if(!response.status) return alert(response.message);
                    target.empty();
                    target.append(`<option value="">--Pilih Kecamatan--</option>`);
                    response?.data?.forEach(data => {
                        target.append(`<option value="${data.kode}-${data.nama}">${data.nama}</option>`);
                    });
                }
            })
        });

        $("#kecamatan").change(function(){
            const val = $(this).val();
            const id = val.split("-")[0];
            const target = $("#desa");
            $.ajax({
                url:"/api/wilayah?id="+id,
                beforeSend:function(){
                    target.attr("disabled",true);
                },
                complete:function(){
                    target.attr("disabled",false);
                },
                success:function(response){

                    if(!response.status) return alert(response.message);
                    target.empty();
                    target.append(`<option value="">--Pilih Desa/Kelurahan--</option>`);
                    response?.data?.forEach(data => {
                        target.append(`<option value="${data.kode}-${data.nama}">${data.nama}</option>`);
                    });
                }
            })
        });


    </script>
  </body>
</html>