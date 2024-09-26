<form>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>NISN</label>
                <input type="number" class="form-control" name="NISN" />
            </div>
            <div class="form-group">
                <label>Nama Siswa</label>
                <input class="form-control" name="Nama Lengkap" />
            </div>
            <div class="form-group">
                <label>Ekstrakurikuler</label>
                <select class="form-control" name="jenis_kelamin">
                    <option>Pramuka</option>
                </select>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <input value="Wajib" readonly class="form-control" name="Tempat Lahir" />
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea rows="5" class="form-control" name="Tempat Lahir">
                </textarea>
            </div>
        </div>
    </div>
    <div class="text-right">
        <a href="{{route('sekolah_sd.ekskul.index')}}" type="button" class="btn btn-danger">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
    </div>
</form>