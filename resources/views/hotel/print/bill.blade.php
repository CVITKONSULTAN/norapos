<html>
    <head>
        <title>Bill</title>
    </head>
    <body>
        <div>
            <img height="100" src="/uploads/business_logos/{{$business->logo}}" />
            <h1 style="margin-bottom:0px; margin-top:0px;">{{$business->name ?? ""}}</h1>
            <p>
                {{$location->landmark ?? ""}}
                {{$location->city ?? ""}}
                {{$location->state ?? ""}}
                {{$location->country ?? ""}}
                <br />
                Telp : {{$location->mobile ?? ""}}
                <br />
                {{$location->website ?? ""}}
        </div>
        <table width="100%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>No. Transaksi</td>
                            <td>:</td>
                            <td>{{ $transaction->id }}</td>
                        </tr>
                        <tr>
                            <td>No. Pajak</td>
                            <td>:</td>
                            <td>{{ $transaction->ref_no }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $contact->name ?? "" }}</td>
                        </tr>
                        <tr>
                            <td>No. HP</td>
                            <td>:</td>
                            <td>{{ $contact->mobile ?? "" }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td>Kedatangan</td>
                            <td>:</td>
                            <td>{{ $transaction->id }}</td>
                        </tr>
                        <tr>
                            <td>Keberangkatan</td>
                            <td>:</td>
                            <td>{{ $transaction->ref_no }}</td>
                        </tr>
                        <tr>
                            <td>No. Kamar</td>
                            <td>:</td>
                            <td>{{ $contact->name ?? "" }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Tamu</td>
                            <td>:</td>
                            <td>{{ $contact->mobile ?? "" }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>