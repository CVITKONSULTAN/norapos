<html>
    <head>
        <title>Bill</title>
        <style>
            table.content tr td, 
            table.content tr th {
                border: 1px solid black;
                padding: 10px;
            }
        </style>
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
                            <td>{{ \Carbon::parse($transaction->transaction_date)->format("d/m/Y") }}</td>
                        </tr>
                        <tr>
                            <td>Keberangkatan</td>
                            <td>:</td>
                            <td>{{ \Carbon::parse($transaction->checkout_at)->format("d/m/Y") }}</td>
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

        <table class="content" width="100%" style="
            margin-top:20px;
            border-collapse: collapse;
            border: 1px solid black;
        ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction_sell_line as $k => $item)    
                    <tr>
                        <td>{{ $k+1 }}</td>
                        <td>{{ $item->created_at->format("d/m/Y") }}</td>
                        <td>{{ $item->product->name }}</td>
                        @if( str_contains( $item->product->name , "Room") )
                            <td>{{ $item->unit_price * $transaction->pay_term_number }}</td>
                        @else
                            <td>{{ $item->unit_price }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;font-weight:bold;">TOTAL</td>
                    <td>Rp. 1.000.000</td>
                </tr>
                <tr>
                    <td colspan="2">
                        Disetujui oleh :
                        <br>
                        <i>Approved by :</i>

                    </td>
                    <td colspan="2">
                        Perusahaan / <i>Company</i> : 
                        <br>
                        Alamat / <i>Adress</i> : 
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>