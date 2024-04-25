@extends('itkonsultan.layouts.app')

@section('title','NORAPOS REGISTER')

@push('styles')
    
@endpush

@section('main') 

    <form class="container mt-3" action="{{ route('form.store') }}" method="POST">
        
        @csrf
        <input type="hidden" name="form_slug" value="norapos" />
        <input type="hidden" name="uid" value="{{$uid ?? ""}}" />
        <input type="hidden" name="category" value="{{$norapos ?? ""}}" />
        <input type="hidden" name="title" value="{{$title ?? ""}}" />

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input value="" name="name" required class="form-control" />
        </div>
        <div class="form-group">
            <label>No Handphone</label>
            <input value="" name="nohp" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input value="" type="email" name="email" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Provinsi</label>
            <select required name="provinsi" class="form-control" id="prov_dom">
                <option value="">--Pilih Provinsi--</option>
                @foreach ($provinsi as $item)
                    <option value="{{$item->kode."-".$item->nama}}">{{$item->nama}}</option>
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
            <textarea required name="alamat" required class="form-control"></textarea>
        </div>
        <div class="d-grid mt-3 mb-3">
            <button class="btn btn-norapos">Simpan</button>
        </div>
    </form>
@endsection

@push('js')
    <script>


        $("form").validate({
            submitHandler:function(form){
                const btn = $('button');
                $.ajax({
                    // url:"{{ route('itko.trx_store') }}",
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
                        setTimeout(() => {
                            window.ReactNativeWebView.postMessage(JSON.stringify({
                                goBack:true
                            }))
                        }, 1000);
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
@endpush