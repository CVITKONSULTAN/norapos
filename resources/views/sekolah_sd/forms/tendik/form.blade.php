    @csrf
    <div class="form-group col-sm-6">
        <label>NIP</label>
        <input value="{{$data['nip'] ?? ""}}" minlength="6" required name="nip" class="form-control" />
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
    <div class="text-right">
        <a href="{{route('sekolah_sd.tendik.index')}}" type="button" class="btn btn-danger">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
    </div>