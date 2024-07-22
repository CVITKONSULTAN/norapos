@php
    $tgl_checkout = \Carbon::parse($transaction->checkout_at)->format("d/m/Y");
    $total = 0;
    $p = $transaction_sell_line[0] ?? null;
@endphp
<html>
    <head>
        <title>Bill</title>
        <style>
            table.content tr td, 
            table.content tr th {
                border: 1px solid black;
                padding: 10px;
            }
            table.table_data tr td{
                padding: 2px;
                vertical-align: top;
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
                    <table class="table_data">
                        <tr>
                            <td>No. Transaksi <br />
                                <i>/ Transaction No.</i>
                            </td>
                            <td>:</td>
                            <td>{{ $transaction->id }}</td>
                        </tr>
                        <tr>
                            <td>No. Pajak <br />
                                <i>/ Tax No.</i></td>
                            <td>:</td>
                            <td>{{ $transaction->ref_no }}</td>
                        </tr>
                        <tr>
                            <td>Nama <br />
                                <i>/ Name</i></td>
                            <td>:</td>
                            <td>{{ $contact->name ?? "" }}</td>
                        </tr>
                        <tr>
                            <td>No. HP <br />
                                <i>/ Mobile No.</i></td>
                            <td>:</td>
                            <td>{{ $contact->mobile ?? "" }}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="table_data">
                        <tr>
                            <td>
                                Kedatangan <br />
                                <i>/ Arrival / Checkin</i>
                            </td>
                            <td>:</td>
                            <td>{{ \Carbon::parse($transaction->transaction_date)->format("d/m/Y") }}</td>
                        </tr>
                        <tr>
                            <td>
                                Keberangkatan <br /> 
                                <i>/ Departure / Checkout</i>
                            </td>
                            <td>:</td>
                            <td>{{ $tgl_checkout }}</td>
                        </tr>
                        <tr>
                            <td>
                                No. Kamar <br /> 
                                <i>/ Room No.</i>
                            </td>
                            <td>:</td>
                            <td>{{ $p->product->sku ?? "" }}</td>
                        </tr>
                        <tr>
                            <td>
                                Jumlah Tamu<br /> 
                                <i>/ No. Inparty</i>
                            </td>
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
                    @php
                        $price = $item->unit_price;
                        if(str_contains( $item->product->name , "Room")){
                            $price = $item->unit_price * $transaction->pay_term_number;
                        }
                        $total += $price;
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{ $k+1 }}</td>
                        <td style="text-align: center;">{{ $item->created_at->format("d/m/Y") }}</td>
                        <td style="text-align: center;">{{ $item->product->name }}</td>
                        <td style="text-align: right;">{{ number_format($price,0,",",".") }}</td>
                    </tr>
                @endforeach
                @if($transaction->misc_cost > 0 || $transaction->misc_note)
                    @php($total += $transaction->misc_cost)
                    <tr>
                        <td style="text-align: center;">{{ $k+2 }}</td>
                        <td style="text-align: center;">{{ $tgl_checkout }}</td>
                        <td style="text-align: center;"> Miscellaneous : {{ $transaction->misc_note }}</td>
                        <td style="text-align: right;">{{ number_format($transaction->misc_cost,0,",",".") }}</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;font-weight:bold;">TOTAL</td>
                    <td style="text-align: right;"><strong>Rp. {{ number_format($total,0,",",".") }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2" width="40%">
                        <p style="min-height:100px;">
                            Disetujui oleh :
                            <br>
                            <i>Approved by :</i>
                        </p>
                    </td>
                    <td colspan="2">
                        <p style="min-height:100px;">
                            Perusahaan / <i>Company</i> : 
                            <br>
                            Alamat / <i>Adress</i> : 
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" width="40%" >
                        <p style="text-align:justify;min-height:80px;font-size:8pt;">
                            Saya Setuju bahwa tanggung-jawab saya terhadap tagihan ini tidak aka
                            mendapat keringanan, dan saya setuju bahwa saya secara pribadi bertanggung-
                            jawab atas tagihan ini jika orang, perusahaan, atau asosiasi yang tercantum tidak
                            menyanggupi pembayaran sebagian dari atau seluruh tagihan ini <i>/ I Agree, that
                            my liability for this bill is not walved and agree to be held personality liable in the
                            event that the indicated person, company or association fails to pay for any part or
                            the full amount of these charges.</i>
                        </p>
                    </td>
                    <td colspan="2" style="vertical-align: top">
                        <p style="min-height:80px;">
                            Tanda Tangan / <i>Signature</i> :
                        </p>
                    </td>
                </tr>
            </tfoot>
        </table>

       
    </body>
</html>