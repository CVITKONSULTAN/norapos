<style>
    .input_mb{
        margin-bottom: 10px;
    }
</style>

@csrf
<table class="table table-bordered table-striped">
    <tr>
        <th colspan="2">Urutan</th>
        <td>
            <input type="number" min="0" value="{{ $data['orders'] ?? "0"  }}" name="orders" required class="form-control" />
        </td>
    </tr>
    <tr>
        <th colspan="2">Nama Mapel</th>
        <td>
            <input value="{{ $data['nama'] ?? ""  }}" name="nama" required class="form-control" />
        </td>
    </tr>
    <tr>
        <th colspan="2">Kelas</th>
        <td>
            <select required name="kelas" class="form-control">
                @foreach ([
                        "1",
                        "2",
                        "3",
                        "4",
                        "5",
                        "6",
                        "1 CI",
                        "2 CI",
                        "3 CI",
                        "4 CI",
                        "5 CI",
                        "6 CI"
                    ] as $i)
                    <option 
                    {{ isset($data) && $data['kelas'] == $i ? 'selected' : '' }} 
                    value="{{$i}}">Kelas {{$i}}</option>
                @endforeach
            </select>
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
                    <div class="input-group input_mb lm_key_{{$key}}">
                        {{-- <div class="input-group-addon">LM{{ $key+1 }}</div> --}}
                        <input name="lingkup_materi[]" required value="{{$item}}" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button data-key="{{$key}}" class="btn btn-danger remove_LM" type="button"><i class="fa fa-trash"></i></button>
                        </span>
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
                    <div class="input-group input_mb tp_key_{{$key}}">
                        {{-- <div class="input-group-addon">TP{{ $key+1 }}</div> --}}
                        <input name="tujuan_pembelajaran[]" required value="{{$item}}" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button data-key="{{$key}}" class="btn btn-danger remove_TP" type="button"><i class="fa fa-trash"></i></button>
                        </span>
                    </div>
                @endforeach
            @endif
        </td>
    </tr>
</table>

<div class="text-center">
    <a href="{{route('sekolah_sd.mapel.index')}}" type="button" class="btn btn-danger">Kembali</a>
    <button class="btn btn-primary">Simpan</button>
</div>

@section('javascript')
    <script>
        const LMLIST = $(".lingkup_materi_list")
        let LM_INDEX = 0;
        @if( isset($data) && count($data['lingkup_materi']) > 0)
            LM_INDEX = {{count($data['lingkup_materi'])-1}};
        @endif
        const addLingkupMateri = () => {
            LM_INDEX++;
            const template_lingkup_materi = `
                <div class="input-group input_mb lm_key_${TP_INDEX}">
                    <input name="lingkup_materi[]" required placeholder="Lingkup materi..." type="text" class="form-control">
                    <span class="input-group-btn">
                    <button data-key="${TP_INDEX}" class="btn btn-danger remove_LM" type="button"><i class="fa fa-trash"></i></button>
                </span>
                </div>
            `
            // const template_lingkup_materi = `
            //     <div class="input-group input_mb">
            //         <div class="input-group-addon">LM${LM_INDEX}</div>
            //         <input name="lingkup_materi[]" required placeholder="Lingkup materi..." type="text" class="form-control">
            //     </div>
            // `
            LMLIST.append(template_lingkup_materi);
        }
        $(document).ready(function(){
            @if( !isset($data) )
                addLingkupMateri();
            @endif
        });

        const TPLIST = $(".tujuan_pembelajaran_list")
        let TP_INDEX = 0;
        const addTujuanPembelajaran = () => {
            TP_INDEX++;
            const template_lingkup_materi = `
                <div class="input-group input_mb tp_key_${TP_INDEX}">
                    <input name="tujuan_pembelajaran[]" required placeholder="Tujuan Pembelajaran..." type="text" class="form-control">
                    <span class="input-group-btn">
                        <button data-key="${TP_INDEX}" class="btn btn-danger remove_TP" type="button"><i class="fa fa-trash"></i></button>
                    </span>
                </div>
            `
            // const template_lingkup_materi = `
            //     <div class="input-group input_mb">
            //         <div class="input-group-addon">TP${TP_INDEX}</div>
            //         <input name="tujuan_pembelajaran[]" required placeholder="Tujuan Pembelajaran..." type="text" class="form-control">
            //     </div>
            // `
            TPLIST.append(template_lingkup_materi);
        }
        $(document).ready(function(){
            @if( !isset($data) )
                addTujuanPembelajaran();
            @endif
        });

        $(document).on('click','.remove_TP', function(){
            const key = $(this).data('key')
            $('.tp_key_'+key).remove();
            TP_INDEX--;
        });
        $(document).on('click','.remove_LM', function(){
            const key = $(this).data('key')
            LM_INDEX--;
            $('.lm_key_'+key).remove();
        });

    </script>
@endsection