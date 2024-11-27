@csrf
<div class="row">
    <div class="col-md-6">
        <h3>A. Identitas Siswa</h3>
        <div class="form-group">
            <label>NIS</label>
            <input value="{{ $data['detail']['nis'] ?? "" }}" type="number" class="form-control" name="detail[nis]" />
        </div>
        <div class="form-group">
            <label>NISN</label>
            <input value="{{ $data['nisn'] ?? "" }}" type="number" class="form-control" name="nisn" />
        </div>
        <div class="form-group">
            <label>Nama Lengkap</label>
            <input value="{{ $data['nama'] ?? "" }}" class="form-control" name="nama" />
        </div>
        <div class="form-group">
            <label>Nama Panggilan</label>
            <input value="{{ $data['detail']['nama_panggilan'] ?? "" }}" class="form-control" name="detail[nama_panggilan]" />
        </div>
        <div class="form-group">
            <label>Tempat Lahir</label>
            <input value="{{ $data['detail']['tempat_lahir'] ?? "" }}" class="form-control" name="detail[tempat_lahir]" />
        </div>
        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input value="{{ $data['detail']['tanggal_lahir'] ?? "" }}" type="date" class="form-control" name="detail[tanggal_lahir]" />
        </div>
        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select class="form-control" name="detail[jenis_kelamin]">
                <option {{ isset($data) && $data['detail']['jenis_kelamin'] == "Laki-laki" }} value="Laki-laki">Laki-laki</option>
                <option {{ isset($data) && $data['detail']['jenis_kelamin'] == "Perempuan" }} value="Perempuan">Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label>Agama</label>
            <select class="form-control" name="detail[agama]">
                <option {{ isset($data) && $data['detail']['agama'] == 'islam' ? 'selected' : '' }} value="islam">Islam</option>
                <option {{ isset($data) && $data['detail']['agama'] == 'kristen' ? 'selected' : '' }} value="kristen">Kristen</option>
                <option {{ isset($data) && $data['detail']['agama'] == 'konghucu' ? 'selected' : '' }} value="konghucu">Konghucu</option>
                <option {{ isset($data) && $data['detail']['agama'] == 'katolik' ? 'selected' : '' }} value="katolik">Katolik</option>
                <option {{ isset($data) && $data['detail']['agama'] == 'budha' ? 'selected' : '' }} value="budha">Budha</option>
                <option {{ isset($data) && $data['detail']['agama'] == 'hindu' ? 'selected' : '' }} value="hindu">Hindu</option>
                <option {{ isset($data) && $data['detail']['agama'] == 'lainnya' ? 'selected' : '' }} value="lainnya">Lainnya</option>
            </select>
        </div>
        <div class="form-group">
            <label>Pendidikan sebelumnya</label>
            <input value="{{ $data['detail']['pendidikan_sebelumnya'] ?? "" }}" class="form-control" name="detail[pendidikan_sebelumnya]" />
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input value="{{ $data['detail']['alamat'] ?? "" }}" class="form-control" name="detail[alamat]" />
        </div>
    </div>
    <div class="col-md-6">
        <h3>B. Orangtua/Wali Siswa</h3>
        <div class="form-group">
            <label>Nama Ayah</label>
            <input value="{{ $data['detail']['nama_ayah'] ?? "" }}" class="form-control" name="detail[nama_ayah]" />
        </div>
        <div class="form-group">
            <label>Nama Ibu</label>
            <input value="{{ $data['detail']['nama_ibu'] ?? "" }}" class="form-control" name="detail[nama_ibu]" />
        </div>
        <div class="form-group">
            <label>Pekerjaan Ayah</label>
            <input value="{{ $data['detail']['pekerjaan_ayah'] ?? "" }}" class="form-control" name="detail[pekerjaan_ayah]" />
        </div>
        <div class="form-group">
            <label>Pekerjaan Ibu</label>
            <input value="{{ $data['detail']['pekerjaan_ibu'] ?? "" }}" class="form-control" name="detail[pekerjaan_ibu]" />
        </div>
        <div class="form-group">
            <label>Alamat Orang tua</label>
            <input value="{{ $data['detail']['alamat_orang_tua'] ?? "" }}" class="form-control" name="detail[alamat_orang_tua]" />
        </div>
        <div class="form-group">
            <label>Kontak Ayah/Ibu</label>
            <input value="{{ $data['detail']['kontak_orang_tua'] ?? "" }}" maxlength="12" class="form-control" name="detail[kontak_orang_tua]" />
        </div>
        <div class="form-group">
            <label>Kontak Keluarga lainnya</label>
            <input value="{{ $data['detail']['kontak_keluarga'] ?? "" }}" maxlength="12" class="form-control" name="detail[kontak_keluarga]" />
        </div>
        <div class="form-group">
            <label>Wali Peserta didik</label>
            <select class="form-control" name="detail[wali]">
                <option {{ isset($data) && $data['detail']['wali'] == 'tidak' ? 'selected' : '' }} value="tidak">TIDAK</option>
                <option {{ isset($data) && $data['detail']['wali'] == 'ya' ? 'selected' : '' }} value="ya">YA</option>
            </select>
        </div>
        <div class="form-group">
            <label>Nama Wali</label>
            <input value="{{ $data['detail']['nama_wali'] ?? "" }}" class="form-control" name="detail[nama_wali]" />
        </div>
        <div class="form-group">
            <label>Pekerjaan</label>
            <input value="{{ $data['detail']['pekerjaan_wali'] ?? "" }}" class="form-control" name="detail[pekerjaan_wali]" />
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input value="{{ $data['detail']['alamat_wali'] ?? "" }}" class="form-control" name="detail[alamat_wali]" />
        </div>
        <div class="form-group">
            <label>Kontak</label>
            <input value="{{ $data['detail']['kontak_wali'] ?? "" }}" maxlength="12" class="form-control" name="detail[kontak_wali]" />
        </div>
    </div>
</div>
<div class="text-center">
    <a href="{{route('sekolah_sd.siswa.index')}}" type="button" class="btn btn-danger">Kembali</a>
    <button class="btn btn-primary">Simpan</button>
</div>