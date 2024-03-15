@extends('itkonsultan.layouts.app')

@push('styles')
    <style>
        .status_text{
            font-weight: bold;
        }
        table.detail_invoice td {
            padding: 5px 10px;
        }
    </style>
@endpush

@section('main')    
    @if( !empty($user) )
        <div class="container mt-3">
            <table class="detail_invoice">
                <tr>
                    <td style="padding-left: 0px;"><b>NO. ID - TANGGAL</b></td>
                    <td>:</td>
                    <td><b>#{{$data->id}} - {{ $data->created_at->format('Y-m-d H:i:s') }}</b></td>
                </tr>
                <tr>
                    <td style="padding-left: 0px;"><b>STATUS</b></td>
                    <td>:</td>
                    <td>
                        <span class="status_text"
                        style="color: 
                            @if($data->status === "selesai") green 
                            @elseif($data->status === "batal") red 
                            @else
                            blue
                            @endif
                        ;"
                        >{{ strtoupper($data->status) }}</span>
                    </td>
                </tr>
            </table>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <div class="input-group">
                    <input disabled value="{{$data->metadata['name'] ?? ""}}" required class="form-control" />
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['name'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            <div class="form-group">
                <label>Nomor KTP</label>
                <div class="input-group">
                    <input disabled value="{{$data->metadata['ktp'] ?? ""}}" required class="form-control" />
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['ktp'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            <div class="form-group">
                <label>No Handphone</label>
                <div class="input-group">
                    <input disabled value="{{$data->metadata['nohp'] ?? ""}}" required class="form-control" />
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['nohp'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <div class="input-group">
                    <input disabled value="{{$data->metadata['email'] ?? ""}}" required class="form-control" />
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['email'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            <div class="form-group">
                <label>Provinsi</label>
                <div class="input-group">
                    <input disabled value="{{$data->metadata['provinsi'] ?? ""}}" required class="form-control" />
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['provinsi'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            <div class="form-group">
                <label>Kota/Kabupaten</label>
                <div class="input-group">
                    <input disabled value="{{$data->metadata['kota_kab'] ?? ""}}" required class="form-control" />
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['kota_kab'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <div class="input-group">
                    <input disabled value="{{$data->metadata['kecamatan'] ?? ""}}" required class="form-control" />
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['kecamatan'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            <div class="form-group">
                <label>Kelurahan/Desa</label>
                <div class="input-group">
                    <input disabled value="{{$data->metadata['desa'] ?? ""}}" required class="form-control" />
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['desa'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <div class="input-group">
                    <textarea disabled required name="alamat" required class="form-control">{{$data->metadata['alamat'] ?? ""}}</textarea>
                    <button 
                        class="btn btn-outline-secondary btn-copy" 
                        data-clipboard-text="{{$data->metadata['alamat'] ?? ""}}"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Copy"
                    >Copy</button>
                </div>
            </div>
            @if(isset($product) && $data->category === "nidi")
                <div class="form-group">
                    <label>Pilih Produk/Layanan</label>
                </div>
                <div class="alert alert-warning mt-2">
                    <h5>Detail Layanan/Produk</h5>
                    <p id="deskripsi">{{ $product->description }}</p>
                    <p><b>Total : <span id="harga"> Rp. {{ number_format($product->price,0,',','.') }}</span></b></p>
                </div>
            @endif
            @if($data->status === "proses")
                <div class="d-grid mt-3 mb-3">
                    <button data-status="selesai" class="btn btn-action btn-success mb-3">SELESAI</button>
                    <button data-status="batal" class="btn btn-danger btn-action">BATAL</button>
                </div>
            @endif
        </div>
    @endif
@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    <script>
        new ClipboardJS('.btn-copy');
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        $(".btn-action").click(function(){
            const status = $(this).data('status');
            $.ajax({
                url:"{{ route('itko.change_status') }}",
                type:"post",
                data:{
                    status:status,
                    adminToken:"{{$token}}",
                    id:{{$data->id}}
                },
                beforeSend:function(){
                    $(this).attr('disabled',true);
                },
                complete:function(){
                    $(this).attr('disabled',false);
                },
                success:function(response){
                    swal("Info",response.message, response.status ? "success" : "info");
                    if(!response.status) return;
                    window.ReactNativeWebView.postMessage(JSON.stringify({
                        goBack:true
                    }))
                }
            })
        });
        @if( empty($user))
            window.ReactNativeWebView.postMessage(JSON.stringify({
                goBack:true
            }))
        @endif
    </script>
@endpush