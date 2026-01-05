<table>
    <tr>
        <td colspan="4"><b>Jadwal Tes PPDB</b></td>
    </tr>
    <tr>
        <td colspan="4">Tanggal: 
            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
        </td>
    </tr>
</table>

@foreach ($data as $hari => $testTypes)

    <br>

    {{-- HEADER HARI --}}
    <table border="1">
        <tr style="background:#c8e1ff;">
            <th colspan="4" style="font-weight:bold;">
                📅 {{ $hari }}
            </th>
        </tr>

        {{-- LOOP TIPE TES: IQ / MAP --}}
        @foreach ($testTypes as $tipeTes => $sessions)

            <tr style="background:#d5ffd5;">
                <th colspan="4" style="font-weight:bold;">
                    {{ $tipeTes === 'IQ' ? '🧠 Tes IQ' : '📘 Tes Pemetaan' }}
                </th>
            </tr>

            {{-- LOOP SESI --}}
            @foreach ($sessions as $jam => $peserta)

                <tr style="background:#eee;">
                    <th colspan="4">⏰ {{ $jam }}</th>
                </tr>

                <tr>
                    <th>Nama Peserta</th>
                    <th>No HP</th>
                    <th>Kode Bayar</th>
                    <th>
                        {{ $tipeTes === 'MAP' ? 'Jadwal Pemetaan' : 'Catatan' }}
                    </th>
                </tr>

                {{-- DAFTAR PESERTA --}}
                @foreach ($peserta as $p)
                    <tr>
                        <td>{{ $p['nama'] }}</td>
                        <td>{{ $p['no_hp'] }}</td>
                        <td>{{ $p['kode_bayar'] }}</td>

                        {{-- KOLOM 4: Untuk MAP tampilkan jadwal pemetaan --}}
                        <td>
                            @if ($tipeTes === 'MAP')
                                {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}
                                ({{ $jam }})
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach

            @endforeach

        @endforeach

    </table>

@endforeach
