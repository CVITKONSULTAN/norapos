<html>
    <head>
        <title>Room List</title>
        <style>
            table.content{
                border-collapse: collapse;
                border: 1px solid black;
            }
            table.content tr {
                border-top:1px solid black;
            }
            table.content tr td, 
            table.content tr th {
                border: 1px solid black;
                padding: 10px;
            }
            /* table.table_data tr td{
                padding: 2px;
                vertical-align: top;
            } */
        </style>
    </head>
    <body>
        <table class="content">
            <thead>
                <tr>
                    <th>id</th>
                    <th>ROOM NAME</th>
                    <th>NOT FOR SELL</th>
                    <th>KET. KERUSAKAN</th>
                    <th>KEBERSIHAN</th>
                    <th>TIPE KAMAR</th>
                    <th>LAST CHECK IN</th>
                    <th>PRICE</th>
                    <th>SKU</th>
                    <th>TODAY AVAILABLE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($result as $k => $value)
                    <tr>
                        <td>{{ $value["id"] }}</td>
                        <td>{{ $value["ROOM NAME"] }}</td>
                        <td>{{ $value["NOT FOR SELL"] }}</td>
                        <td>{{ $value["KET. KERUSAKAN"] }}</td>
                        <td>{{ $value["KEBERSIHAN"] }}</td>
                        <td>{{ $value["TIPE KAMAR"] }}</td>
                        <td>{{ $value["LAST CHECK IN"] }}</td>
                        <td>{{ $value["PRICE"] }}</td>
                        <td>{{ $value["SKU"] }}</td>
                        <td>{{ $value["TODAY AVAILABLE"] }}</td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </body>
</html>