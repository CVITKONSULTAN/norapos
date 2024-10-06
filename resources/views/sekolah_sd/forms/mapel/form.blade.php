<style>
    .input_mb{
        margin-bottom: 10px;
    }
</style>

@csrf
<table class="table table-bordered table-striped">
    <tr>
        <th colspan="2">Nama Mapel</th>
        <td>
            <input value="{{ $data['nama'] ?? ""  }}" name="nama" required class="form-control" />
        </td>
    </tr>
    <tr>
        <th colspan="2">Kategori Mapel</th>
        <td>
            <select name="kategori" required class="form-control">
                <option value="wajib" {{ isset($data) && $data['kategori'] == 'wajib' ? 'selected' : '' }} >Wajib</option>
                <option value="mulok" {{ isset($data) && $data['kategori'] == 'mulok' ? 'selected' : '' }} >Muatan Lokal</option>
                <option value="pilihan" {{ isset($data) && $data['kategori'] == 'pilihan' ? 'selected' : '' }} >Pilihan</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>
            Lingkup Materi
        </th>
        <th width="50" class="text-center">
            <button onclick="addLingkupMateri()" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
        </th>
        <td class="lingkup_materi_list">
            @if( isset($data) && count($data['lingkup_materi']) > 0)
                @foreach ($data['lingkup_materi'] as $key => $item)
                    <div class="input-group input_mb">
                        <div class="input-group-addon">LM{{ $key+1 }}</div>
                        <input name="lingkup_materi[]" required value="{{$item}}" type="text" class="form-control">
                    </div>
                @endforeach
            @endif
        </td>
    </tr>
    <tr>
        <th>Tujuan Pembelajaran (TP)</th>
        <th width="50" class="text-center">
            <button onclick="addTujuanPembelajaran()" type="button" class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
        </th>
        <td class="tujuan_pembelajaran_list">
            @if( isset($data) && count($data['tujuan_pembelajaran']) > 0)
                @foreach ($data['tujuan_pembelajaran'] as $key => $item)
                    <div class="input-group input_mb">
                        <div class="input-group-addon">TP{{ $key+1 }}</div>
                        <input name="tujuan_pembelajaran[]" required value="{{$item}}" type="text" class="form-control">
                    </div>
                @endforeach
            @endif
        </td>
    </tr>
</table>

<div class="text-right">
    <a href="{{route('sekolah_sd.mapel.index')}}" type="button" class="btn btn-danger">Kembali</a>
    <button class="btn btn-primary">Simpan</button>
</div>