<style>
table.tabel_penilaian{
    margin-top: 10px;
    width: 100%;
    border-collapse: collapse;
    border: 1px solid black;
}
table.tabel_penilaian tr td {
    border: 1px solid black;
    padding: 5px 10px;
    /* vertical-align: top; */
}
table.tabel_penilaian tr th
{
    background-color: rgb(199, 199, 199);
    color: black;
    border: 1px solid black;
    text-align: center;
    padding: 5px 10px;
}
</style>

<table class="tabel_penilaian">
    <thead>
        <tr>
            @foreach ($kolom as $item)
                <th>{{$item}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
