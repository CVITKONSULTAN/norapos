    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    />
    <style>
        #kelas_mapel_container{
            margin-top: 20px;
        }
        #kelas_mapel_container label{
            margin: 0px;
        }
        .tabel_kelas_mapel_wrapper{
            border: 1px solid black;
            border-collapse: collapse;
        }
        .tabel_kelas_mapel_wrapper tr td{
            border: 1px solid black;
            padding: 5px 7px;
        }
    </style>
    @csrf
    <input type="hidden" name="mapel_id_list" value="" />
    <div class="form-group col-sm-6">
        <label>NIK</label>
        <input value="{{$data['nik'] ?? ""}}" minlength="6" required name="nik" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>NIP/NRG</label>
        <input value="{{$data['nip'] ?? ""}}" name="nip" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Nama Lengkap</label>
        <input value="{{$data['nama'] ?? ""}}" required name="nama" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Tempat lahir</label>
        <input value="{{$data['tempat_lahir'] ?? ""}}" required name="tempat_lahir" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Tanggal lahir</label>
        <input value="{{$data['tanggal_lahir'] ?? ""}}" required name="tanggal_lahir" type="date" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Pendidikan Terakhir</label>
        <input value="{{$data['pendidikan_terakhir'] ?? ""}}" required name="pendidikan_terakhir" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>No. HP/Telepon</label>
        <input value="{{$data['no_hp'] ?? ""}}" required name="no_hp" maxlength="12" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Jenis kelamin</label>
        <select required class="form-control" name="jenis_kelamin">
            <option {{isset($data['jenis_kelamin']) && $data['jenis_kelamin'] == "laki-laki" ? 'selected' : ''}} value="laki-laki">Laki-laki</option>
            <option {{isset($data['jenis_kelamin']) && $data['jenis_kelamin'] == "perempuan" ? 'selected' : ''}} value="perempuan">Perempuan</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label>Nama Bidang Studi</label>
        <input value="{{$data['bidang_studi'] ?? ""}}" required name="bidang_studi" class="form-control" />
    </div>
    <div class="form-group col-sm-12">
        <label>Status</label>
        <select required class="form-control" name="status">
            <option {{ isset($data['status']) && $data['status'] == 'tetap' ? 'selected' : "" }} value='tetap'>Tetap</option>
            <option {{ isset($data['status']) && $data['status'] == 'tidak tetap' ? 'selected' : "" }} value='tidak tetap'>Tidak Tetap</option>
            <option {{ isset($data['status']) && $data['status'] == 'honorer' ? 'selected' : "" }} value='honorer'>Honorer</option>
            <option {{ isset($data['status']) && $data['status'] == 'kontrak' ? 'selected' : "" }} value='kontrak'>Kontrak</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label>Alamat</label>
        <textarea rows="4" class="form-control" name="alamat">{{ $data['alamat'] ?? "" }}</textarea>
    </div>
    <div class="form-group col-sm-6">
        <label>Keterangan lain</label>
        <textarea rows="4" class="form-control" name="keterangan">{{ $data['keterangan'] ?? "" }}</textarea>
    </div>
    <div class="form-group col-sm-12">
        <label>Mata Pelajaran</label>
        <select required name="mapel_id" class="mapel_selection"></select>

        <div id="kelas_mapel_container">
            <label>List Kelas Mapel</label>
            <table class="tabel_kelas_mapel_wrapper"></table>
        </div>
    </div>
    <div class="col-sm-12">
        @if(isset($data['foto']))
            <img src="{{ $data['foto'] }}" class="foto" />
        @endif
        <div class="form-group">
            <label>Foto</label>
            <input 
            accept="image/*" 
            type="file" class="form-control" name="foto" />
        </div>
    </div>
    <div class="col-sm-12 text-center">
        <a href="{{route('sekolah_sd.tendik.index')}}" type="button" class="btn btn-danger">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
    </div>

    @section('javascript')
        <script
        src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
        ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script type="text/javascript">

            let user_kelas_khusus = {};
            @if(isset($data) && $data['kelas_khusus'])
                try {
                    user_kelas_khusus = JSON.parse('{!! json_encode($data['kelas_khusus']) !!}')
                } catch (error) {
                    user_kelas_khusus = {};
                }
            @endif

            let mapel_list = [];
            const onChangeData = (value) => {
                $.ajax({
                    url:"/sekolah_sd/data-mapel/data",
                    data:{"mapel_list":value},
                    success:res => {
                        mapel_list = res.data
                        const kelas_list = res.data.map(item => item.kelas);
                        getListKelas(kelas_list)
                    }
                })
            }

            let listKelas = [];
            const getListKelas = (list) => {
                $.ajax({
                    url:"/sekolah_sd/kelas-data",
                    data:{"kelas_list":list},
                    success:res => {
                        listKelas = res.data
                        renderListKelas()
                    }
                })
            }

            const renderListKelas = () => {
                const table = $(".tabel_kelas_mapel_wrapper")
                table.empty()
                mapel_list.map(val => {
                    const choices_before = user_kelas_khusus[val.id]
                    // console.log("choices_before",choices_before)
                    let template = `<tr>
                        <td>${val.nama}</td>
                        <td>`;
                    const kelasPerMapel = listKelas.filter(elm => elm.kelas == val.kelas);
                    kelasPerMapel.map(item => {
                        let checked = true;
                        if(choices_before){
                            checked = choices_before.includes(item.id+'');
                        }
                        const checked_str = checked ? 'checked' : ''
                        template += ` <label>
                                <input name="kelas_khusus[${val.id}][]" type="checkbox" value="${item.id}" ${checked_str} />
                                ${item.nama_kelas} (Semester ${item.semester} ${item.tahun_ajaran})
                            </label>`;
                    })
                    template += `</td></tr>`;
                    table.append(template);
                })
            }

            let selectizeInstanceKelas;
            $(function () {

                selectizeInstanceKelas = $(".mapel_selection").selectize({
                    onChange: onChangeData,
                    placeholder: 'Cari disini...',
                    maxItems: null,
                    create: false,
                    valueField: 'id',         // Field to use as the value
                    labelField: 'name',       // Field to use as the label
                    searchField: 'name',      // Field to use for searching
                    load: function(query, callback) {
                        if (!query.length) return callback();
                        $.ajax({
                            url: '/sekolah_sd/data-mapel/data?draw=1&columns%5B0%5D%5Bdata%5D=id&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=false&columns%5B0%5D%5Borderable%5D=false&columns%5B1%5D%5Bdata%5D=nama&columns%5B1%5D%5Bname%5D=&columns%5B2%5D%5Bdata%5D=kelas&columns%5B2%5D%5Bname%5D=&columns%5B3%5D%5Bdata%5D=kategori&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=false&columns%5B3%5D%5Borderable%5D=false&columns%5B4%5D%5Bdata%5D=id&columns%5B4%5D%5Bname%5D=&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=25&search%5Bvalue%5D='+query,
                            type: 'GET',
                            dataType: 'json',
                            error: function(error) {
                                console.log(error)
                                callback();
                            },
                            success: function(res) {
                                const results = res.data.map(item => ({
                                    id: item.id,
                                    name: `${item.nama} (Kelas ${item.kelas})`
                                }));
                                callback(results);
                            }
                        });
                    }
                })[0].selectize;

                @if(isset($data) && count($list_mapel) > 0)
                    const val = [
                        @foreach($list_mapel ?? [] as $key => $item)
                            {{$item->id}},
                        @endforeach
                    ];
                    @foreach($list_mapel ?? [] as $key => $item)
                        selectizeInstanceKelas.addOption({
                            id: {{$item->id}},
                            name: '{{$item->nama}} (Kelas {{$item->kelas}})'
                        });
                    @endforeach
                    selectizeInstanceKelas.setValue(val);
                @endif

            });

            $("form").validate({
                submitHandler:function(f){
                    const val = selectizeInstanceKelas.getValue()
                    console.log( val )
                    $('input[name=mapel_id_list]').val(JSON.stringify(val));
                    return true;
                }
            })

        </script>
    @endsection

