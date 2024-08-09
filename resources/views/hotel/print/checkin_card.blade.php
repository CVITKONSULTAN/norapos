@php
    $tgl_checkout = \Carbon::parse($transaction->checkout_at)->format("d/m/Y");
@endphp

<html>
    <head>
        <title>Registered Card</title>
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
                /* border: 1px solid black; */
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
            <tr>
                <td colspan="3">
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
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <p style="text-align: center;font-weight:bold;">
                        REGISTERED CARD
                    </p>
                </td>
            </tr>
            <tr>
                <td>Nama Tamu <br />
                    <i>/ Guest Name</i>
                </td>
                <td>:</td>
                <td>{{ $transaction->contact->name }}</td>
            </tr>
            <tr>
                <td>No. HP <br />
                    <i>/ Mobile No.</i></td>
                <td>:</td>
                <td>{{ $transaction->contact->mobile ?? "-" }}</td>
            </tr>
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
                    Travel Agen <br /> 
                    <i>/ Online Travel Agent (OTA)</i>
                </td>
                <td>:</td>
                <td>{{ $transaction->service_custom_field_2 ?? "-" }}</td>
            </tr>
            <tr>
                <td>
                    Tipe Kamar <br /> 
                    <i>/ Room Type</i>
                </td>
                <td>:</td>
                <td>{{ $transaction->sell_lines[0]->product->brand->name ?? "-" }}</td>
            </tr>
            <tr>
                <td>
                    No. Kamar <br /> 
                    <i>/ Room Number</i>
                </td>
                <td>:</td>
                <td>{{ $transaction->sell_lines[0]->product->name ?? "-" }}</td>
            </tr>
            <tr>
                <td>
                    Metode Pembayaran <br /> 
                    <i>/ Payment Method</i>
                </td>
                <td>:</td>
                <td>{{ $transaction->service_custom_field_1 ?? "-" }}</td>
            </tr>
            <tr>
                <td>
                    Deposit <br /> 
                    <i>/ Deposit</i>
                </td>
                <td>:</td>
                <td>{{ number_format($transaction->service_custom_field_3,0,",",".") }}</td>
            </tr>
            <tr>
                <td colspan="3" style="vertical-align: top">
                    <p style="min-height:80px;">
                        Tanda Tangan Tamu / <i>Signature</i> :
                    </p>
                </td>
            </tr>
        </table>
       
    </body>
</html>