<form>
    <div class="row">
        <div class="col-md-6">
            <h3>A. Identitas Siswa</h3>
            <div class="form-group">
                <label>NIS</label>
                <input type="number" class="form-control" name="NIS" />
            </div>
            <div class="form-group">
                <label>NISN</label>
                <input type="number" class="form-control" name="NISN" />
            </div>
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input class="form-control" name="Nama Lengkap" />
            </div>
            <div class="form-group">
                <label>Nama Panggilan</label>
                <input class="form-control" name="Nama Panggilan" />
            </div>
            <div class="form-group">
                <label>Tempat Lahir</label>
                <input class="form-control" name="Tempat Lahir" />
            </div>
            <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" class="form-control" name="Tanggal Lahir" />
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                <select class="form-control" name="jenis_kelamin">
                    <option>Laki-laki</option>
                    <option>Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Agama</label>
                <select class="form-control" name="agama">
                    <option>Islam</option>
                    <option>Kristen</option>
                    <option>Konghucu</option>
                    <option>Katolik</option>
                    <option>Budha</option>
                    <option>Hindu</option>
                    <option>Lainnya</option>
                </select>
            </div>
            <div class="form-group">
                <label>Pendidikan sebelumnya</label>
                <input class="form-control" name="Pendidikan sebelumnya" />
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input class="form-control" name="Alamat" />
            </div>
        </div>
        <div class="col-md-6">
            <h3>B. Orangtua/Wali Siswa</h3>
            <div class="form-group">
                <label>Nama Ayah</label>
                <input class="form-control" name="Nama Ayah" />
            </div>
            <div class="form-group">
                <label>Nama Ibu</label>
                <input class="form-control" name="Nama Ibu" />
            </div>
            <div class="form-group">
                <label>Pekerjaan Ayah</label>
                <input class="form-control" name="Pekerjaan Ayah" />
            </div>
            <div class="form-group">
                <label>Pekerjaan Ibu</label>
                <input class="form-control" name="Pekerjaan Ibu" />
            </div>
            <div class="form-group">
                <label>Alamat Orang tua</label>
                <input class="form-control" name="Alamat Orang tua" />
            </div>
            <div class="form-group">
                <label>Kontak Ayah/Ibu</label>
                <input maxlength="12" class="form-control" name="Kontak Ayah/Ibu" />
            </div>
            <div class="form-group">
                <label>Kontak Keluarga lainnya</label>
                <input maxlength="12" class="form-control" name="Kontak Keluarga lainnya" />
            </div>
            <div class="form-group">
                <label>Wali Peserta didik</label>
                <select class="form-control" name="Wali Peserta didik">
                    <option>YA</option>
                    <option>TIDAK</option>
                </select>
            </div>
            <div class="form-group">
                <label>Nama Wali</label>
                <input class="form-control" name="Nama Wali" />
            </div>
            <div class="form-group">
                <label>Pekerjaan</label>
                <input class="form-control" name="Pekerjaan" />
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input class="form-control" name="Alamat" />
            </div>
            <div class="form-group">
                <label>Kontak</label>
                <input maxlength="12" class="form-control" name="Kontak" />
            </div>
        </div>
    </div>
    <div class="text-right">
        <a href="{{route('sekolah_sd.siswa.index')}}" type="button" class="btn btn-danger">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
    </div>
</form>