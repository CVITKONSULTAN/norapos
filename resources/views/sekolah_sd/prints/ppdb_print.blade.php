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
    .img_ppdb{
        max-width: 100px;
    }
    </style>
    
    <h1 style="text-align: center;">TANDA REGISTRASI PPDB SD MUHAMMADIYAH 2 KOTA PONTIANAK</h1>
    <table class="tabel_penilaian">
        @php
            $image_key = [
            'bukti_bayar_ppdb',
            'kartu_keluarga',
            'akta_lahir',
            'pas_foto',
        ];
        // $data->detail = array_reverse($data->detail);
        @endphp
        @foreach ($data->detail as $k => $item)    
            <tr>
                <td>{{$k}}</td>
                <td>:</td>
                @if(in_array($k,$image_key))
                    <td>
                        <img class="img_ppdb" src="{{$item}}" />
                    </td>
                @else
                    <td>{{ $item }}</td>
                @endif
            </tr>
        @endforeach
    </table>
    <script>
        window.onload = function() { window.print(); }
    </script>
    