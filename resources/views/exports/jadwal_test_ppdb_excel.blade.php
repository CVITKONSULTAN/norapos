<table>
    <tr>
        <td colspan="3"><b>Jadwal Tes PPDB</b></td>
    </tr>
    <tr>
        <td colspan="3">Tanggal: 
            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        </td>
    </tr>
    <tr>
        <td colspan="3">Tipe Tes: 
            {{ strtoupper($tipe) }}
        </td>
    </tr>
</table>

@foreach ($data as $hari => $sessions)

    <br>
    <table border="1">
        <tr style="background:#c8e1ff;">
            <th colspan="3" style="font-weight:bold;">
                {{ $hari }}
            </th>
        </tr>

        @foreach ($sessions as $jam => $peserta)

        <tr style="background:#eee;">
            <th colspan="3">⏰ {{ $jam }}</th>
        </tr>

        <tr>
            <th>Nama Peserta</th>
            <th>No HP</th>
            <th>Kode Bayar</th>
            <th>Jadwal Pemetaan</th>
        </tr>

        @foreach ($peserta as $p)
        <tr>
            <td>{{ $p['nama'] }}</td>
            <td>{{ $p['no_hp'] }}</td>
            <td>{{ $p['kode_bayar'] }}</td>
            <td>
                {{ $p['pemetaan']['tanggal'] }}
                ({{ $p['pemetaan']['jam'] }})
            </td>
        </tr>
        @endforeach

        @endforeach
    </table>

@endforeach
