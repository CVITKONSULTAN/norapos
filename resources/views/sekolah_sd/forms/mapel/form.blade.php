<style>
    .input_mb{
        margin-bottom: 10px;
    }
</style>
<form>
    <table class="table table-bordered table-striped">
        <tr>
            <th colspan="2">Nama Mapel</th>
            <td>
                <input class="form-control" />
            </td>
        </tr>
        <tr>
            <th>
                Lingkup Materi
            </th>
            <th width="50" class="text-center">
                <button class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
            </th>
            <td class="lingkup_materi_list">
                <div class="input-group">
                    <div class="input-group-addon">LM1</div>
                    <input type="text" class="form-control">
                </div>
            </td>
        </tr>
        <tr>
            <th>Tujuan Pembelajaran (TP)</th>
            <th width="50" class="text-center">
                <button class="btn btn-primary btn-xs"><i class="fa fa-plus"></i></button>
            </th>
            <td class="tujuan_pembelajaran_list">
                <div class="input-group">
                    <div class="input-group-addon">TP1</div>
                    <input type="text" class="form-control">
                </div>
            </td>
        </tr>
    </table>
    
    <div class="text-right">
        <a href="{{route('sekolah_sd.mapel.index')}}" type="button" class="btn btn-danger">Kembali</a>
        <button class="btn btn-primary">Simpan</button>
    </div>
</form>