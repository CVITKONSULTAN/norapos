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
            <input disabled value="{{$data->metadata['name'] ?? ""}}" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Nomor KTP</label>
            <input disabled value="{{$data->metadata['ktp'] ?? ""}}" required class="form-control" />
        </div>
        <div class="form-group">
            <label>No Handphone</label>
            <input disabled value="{{$data->metadata['nohp'] ?? ""}}" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Email</label>
            <input disabled value="{{$data->metadata['email'] ?? ""}}" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Provinsi</label>
            <input disabled value="{{$data->metadata['provinsi'] ?? ""}}" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Kota/Kabupaten</label>
            <input disabled value="{{$data->metadata['kota_kab'] ?? ""}}" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Kecamatan</label>
            <input disabled value="{{$data->metadata['kecamatan'] ?? ""}}" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Kelurahan/Desa</label>
            <input disabled value="{{$data->metadata['desa'] ?? ""}}" required class="form-control" />
        </div>
        <div class="form-group">
            <label>Alamat Lengkap</label>
            <textarea disabled required name="alamat" required class="form-control">{{$data->metadata['alamat'] ?? ""}}</textarea>
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
            @if($data->category === "nidi" && $data->status === "menunggu pembayaran")
                <div class="d-grid mt-3 mb-3">
                    <a href="{{ route('itko.next_payment',[
                        'uid' => $data->metadata['uid'],
                        'id' => $data->id,
                    ]) }}" class="btn btn-warning">Lanjutkan Pembayaran</a>
                </div>
            @endif
        @endif
    </div>
@endsection

@push('js')
    <script>


    </script>
@endpush