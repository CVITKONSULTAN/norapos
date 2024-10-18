<form class="row" action="{{route('sekolah_sd.tendik.store')}}" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="form-group col-sm-6">
        <label>NIP</label>
        <input minlength="6" required name="nip" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Nama Lengkap</label>
        <input required name="nama" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Tempat lahir</label>
        <input required name="tempat_lahir" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Tanggal lahir</label>
        <input required name="tanggal_lahir" type="date" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Pendidikan Terakhir</label>
        <input required name="pendidikan_terakhir" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>No. HP/Telepon</label>
        <input required name="no_hp" maxlength="12" class="form-control" />
    </div>
    <div class="form-group col-sm-6">
        <label>Jenis kelamin</label>
        <select required class="form-control" name="jenis_kelamin">
            <option value="laki-laki">Laki-laki</option>
            <option value="perempuan">Perempuan</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label>Nama Bidang Studi</label>
        <input required name="bidang_studi" class="form-control" />
    </div>
    <div class="form-group col-sm-12">
        <label>Status</label>
        <select required class="form-control" name="status">
            <option value='tetap'>Tetap</option>
            <option value='tidak tetap'>Tidak Tetap</option>
            <option value='honorer'>Honorer</option>
            <option value='kontrak'>Kontrak</option>
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label>Alamat</label>
        <textarea rows="4" class="form-control" name="alamat"></textarea>
    </div>
    <div class="form-group col-sm-6">
        <label>Keterangan lain</label>
        <textarea rows="4" class="form-control" name="keterangan"></textarea>
    </div>
    <div class="form-group col-sm-12">
        <label>Foto</label>
        <input 
        accept="image/*" 
        type="file" class="form-control" name="foto" />
    </div>
    <div class="text-right">
        <a href="{{route('sekolah_sd.tendik.index')}}" type="button" class="btn btn-danger">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
    </div>
</form>