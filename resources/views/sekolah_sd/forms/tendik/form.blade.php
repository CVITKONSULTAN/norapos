<form>
    <div class="form-group">
        <label>Nama Lengkap</label>
        <input class="form-control" name="Nama Lengkap" />
    </div>
    <div class="form-group">
        <label>Tempat lahir</label>
        <input class="form-control" name="Tempat lahir" />
    </div>
    <div class="form-group">
        <label>Tanggal lahir</label>
        <input type="date" class="form-control" name="Tanggal lahir" />
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <textarea rows="4" class="form-control" name="Alamat"></textarea>
    </div>
    <div class="form-group">
        <label>Pendidikan Terakhir</label>
        <input class="form-control" name="Pendidikan Terakhir" />
    </div>
    <div class="form-group">
        <label>No. Telepon</label>
        <input maxlength="12" class="form-control" name="No." />
    </div>
    <div class="form-group">
        <label>Jenis kelamin</label>
        <select class="form-control" name="jenis_kelamin">
            <option>Laki-laki</option>
            <option>Perempuan</option>
        </select>
    </div>
    <div class="form-group">
        <label>Nama Bidang Studi</label>
        <input class="form-control" name="Nama Bidang" />
    </div>
    <div class="form-group">
        <label>Status</label>
        <select class="form-control" name="jenis_kelamin">
            <option>Tetap</option>
            <option>Tidak Tetap</option>
            <option>Honorer</option>
            <option>Kontrak</option>
        </select>
    </div>
    <div class="form-group">
        <label>Keterangan lain</label>
        <textarea rows="4" class="form-control" name="Alamat"></textarea>
    </div>
    <div class="form-group">
        <label>Foto</label>
        <input type="file" class="form-control" name="Foto" />
    </div>
    <div class="text-right">
        <a href="{{route('sekolah_sd.tendik.index')}}" type="button" class="btn btn-danger">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
    </div>
</form>