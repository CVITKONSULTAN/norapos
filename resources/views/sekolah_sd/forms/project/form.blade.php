<form>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <label>NISN</label>
                    <input type="number" class="form-control" name="NISN" />
                </div>
                <div class="form-group col-md-4">
                    <label>Nama Siswa</label>
                    <input class="form-control" name="Nama Lengkap" />
                </div>
                <div class="form-group col-md-4">
                    <label>Kelas</label>
                    <input class="form-control" name="Nama Lengkap" />
                </div>
                <div class="form-group col-md-4">
                    <label>Fase</label>
                    <input class="form-control" name="Nama Lengkap" />
                </div>
                <div class="form-group col-md-4">
                    <label>Tahun</label>
                    <input class="form-control" name="Nama Lengkap" />
                </div>
            </div>
            <h3>Nilai Indikator Penilaian</h3>
            <div class="row">
                @for ($i = 1; $i <= 3; $i++)    
                    <div class="form-group col-md-4">
                        <label>
                            Indikator Penilaian {{$i}}.
                            <i 
                                data-toggle="tooltip" 
                                data-placement="top" 
                                title="Indikator Penilaian {{$i}} adalah bla bla bla bla bla bla bla bla"
                                class="fa fa-info-circle"
                            ></i>
                        </label>
                        <select class="form-control">
                            <option>Belum Berkembang (BB)</option>
                            <option>Mulai Berkembang (MB)</option>
                            <option>Berkembang Sesuai Harapan (BSH)</option>
                            <option>Sangat Baik (SB)</option>
                        </select>
                        {{-- <input type="number" class="form-control" name="Nama Lengkap" /> --}}
                    </div>
                @endfor
            </div>
        </div>
    </div>
    <div class="text-right">
        <a href="{{route('sekolah_sd.project.index')}}" type="button" class="btn btn-danger">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>