@extends('layouts.app')
@section('title', "Ranking Kelas")

@section('css')
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
    />
    <style>
        .table thead {
            background-color: gray;
            color: white;
            font-weight: 500;
            text-align: center;
        }
        .unchecked{
            color: red;
        }
        .checked{
            color: green;
        }
        div.suggestion_selection_container::-webkit-scrollbar {
            height: 5px;              /* height of horizontal scrollbar ← You're missing this */
            width: 5px;               /* width of vertical scrollbar */
            border: 1px solid gray;
        }
        div.suggestion_selection_container{
            background: gray;
            height: 60px;
            padding: 10px 15px;

            white-space: nowrap;
            position: relative;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
        }
    </style>
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Ranking Kelas</h1>
</section>

<!-- Main content -->

<section class="content">

    <form id="form_filter">
        @component('components.filters', ['title' => __('report.filters')])
            <div class="col-md-12">
                <div class="filter">
                    <div class="form-group">
                        <label>Kelas</label>
                        <select name="kelas_id" class="kelas_selection_filter"></select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Lihat Data</button>
            </div>
        @endcomponent
    </form>

    @if(Request::has('kelas_id'))
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">{{ "Kelas $kelas->nama_kelas (Semester $kelas->semester - $kelas->tahun_ajaran)" }}</h2>
            <div>
                <p class="text-right">
                    <b>**Keterangan :<br />
                    0-74 = Perlu Bimbingan (PB)<br />
                    75-100 = Menunjukan Pemahaman (MP)
                    </b>
                </p>
            </div>
            <div class="table-responsive">
                <table id="product_table" class="table table-bordered table-striped ajax_view hide-footer">
                    <thead>
                        <tr>
                            <th>Ranking</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            @foreach ($mapel as $i => $item)
                                <th>{{ $item->nama }}</th>
                            @endforeach
                            <th>Nilai Total</th>
                            <th>Rata-Rata</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilai_siswa as $item)
                            <tr>
                                <td></td>
                                <td>{{$item['nis']}}</td>
                                <td>{{$item['nama']}}</td>
                                @foreach ($item['list_nilai'] as $val)
                                    <td class="text-center">
                                        {{ $val['nilai_rapor'] }}
                                        {{-- <span>{{ $val['ket'] }}</span> --}}
                                    </td>
                                @endforeach
                                <td>{{ $item['total'] }}</td>
                                <td data-sort="{{$item['avg']}}" class="text-center">{{$item['avg']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-center">Rata-Rata</th>
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                            @foreach ($mapel as $i => $item)
                                <th class="text-center"></th>
                            @endforeach
                            <th class="text-center"></th>
                            <th class="text-center"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endif


</section>
<!-- /.content -->

@endsection

@section('javascript')
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
    ></script>
    <script type="text/javascript">

        @if(count($kelas_perwalian) > 0)
            const list_kelas_id = "{!! json_encode($kelas_perwalian) !!}";
        @endif
        
        let selectizeInstanceKelasFilter;

        const onChangeData = (value) => {
            console.log(value);
            if(value == "" || value == null) {
                return;
            }
        }

        $(function () {

            selectizeInstanceKelasFilter = $(".kelas_selection_filter").selectize({
                placeholder: 'Cari disini...',
                maxItems: 1,
                create: false,
                valueField: 'id',         // Field to use as the value
                labelField: 'name',       // Field to use as the label
                searchField: 'name',      // Field to use for searching
                onChange: onChangeData,
                load: function(query, callback) {
                    if (!query.length) return callback();
                    let url = '/sekolah_sd/kelas-data?draw=4&columns%5B0%5D%5Bdata%5D=id&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=tahun_ajaran&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=semester&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=nama_kelas&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=id&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=25&search%5Bvalue%5D=';
                    @if(count($kelas_perwalian) > 0)
                        url = `/sekolah_sd/kelas-data?filter_list_id=${list_kelas_id}&draw=4&columns%5B0%5D%5Bdata%5D=id&columns%5B0%5D%5Bname%5D=&columns%5B0%5D%5Bsearchable%5D=true&columns%5B0%5D%5Borderable%5D=true&columns%5B0%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B0%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B1%5D%5Bdata%5D=tahun_ajaran&columns%5B1%5D%5Bname%5D=&columns%5B1%5D%5Bsearchable%5D=true&columns%5B1%5D%5Borderable%5D=true&columns%5B1%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B1%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B2%5D%5Bdata%5D=semester&columns%5B2%5D%5Bname%5D=&columns%5B2%5D%5Bsearchable%5D=true&columns%5B2%5D%5Borderable%5D=true&columns%5B2%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B2%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B3%5D%5Bdata%5D=nama_kelas&columns%5B3%5D%5Bname%5D=&columns%5B3%5D%5Bsearchable%5D=true&columns%5B3%5D%5Borderable%5D=true&columns%5B3%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B3%5D%5Bsearch%5D%5Bregex%5D=false&columns%5B4%5D%5Bdata%5D=id&columns%5B4%5D%5Bname%5D=&columns%5B4%5D%5Bsearchable%5D=true&columns%5B4%5D%5Borderable%5D=true&columns%5B4%5D%5Bsearch%5D%5Bvalue%5D=&columns%5B4%5D%5Bsearch%5D%5Bregex%5D=false&order%5B0%5D%5Bcolumn%5D=0&order%5B0%5D%5Bdir%5D=asc&start=0&length=25&search%5Bvalue%5D=`;
                    @endif
                    $.ajax({
                        url: url+query,
                        type: 'GET',
                        dataType: 'json',
                        error: function(error) {
                            console.log(error)
                            callback();
                        },
                        success: function(res) {
                            // console.log("Options Loaded:", res);
                            const results = res.data.map(item => ({
                                id: item.id,
                                name: `${item.nama_kelas} (Semester ${item.semester} - ${item.tahun_ajaran})`
                            }));
                            callback(results);
                        }
                    });
                }
            })[0].selectize;


        });

        $(document).ready( function(){
            @if(!empty($selected))
                selectizeInstanceKelasFilter.addOption({
                        id: {{$selected->id}},
                        name: `{{$selected->nama_kelas}} (Semester {{$selected->semester}} - {{$selected->tahun_ajaran}})`
                    });
                selectizeInstanceKelasFilter.setValue({{$selected->id}});
            @endif
        });

        @if(Request::has('kelas_id'))
            $(document).ready( function(){

                // product_table = $('#product_table').DataTable({
                //     pageLength:-1,
                //     order: [[
                //         {{count($mapel)+4}}, 
                //         'desc'
                //     ]],
                //     ordering: false,
                //     drawCallback: function(settings) {
                //         var api = this.api();

                //         // Loop melalui data yang sudah diurutkan
                //         api.rows({ order: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
                //             var row = $(this.node());

                //             // Tambahkan nomor urut ke kolom Ranking
                //             row.find('td:first').html(rowIdx + 1);

                //             // Terapkan warna untuk 5 baris teratas
                //             if (rowIdx === 0) {
                //                 row.css('background-color', '#FFD700'); // Emas
                //             } else if (rowIdx === 1) {
                //                 row.css('background-color', '#C0C0C0'); // Perak
                //             } else if (rowIdx === 2) {
                //                 row.css('background-color', '#ffc285'); // Perunggu
                //             } else if (rowIdx === 3) {
                //                 row.css('background-color', '#ADD8E6'); // Biru muda
                //             } else if (rowIdx === 4) {
                //                 row.css('background-color', '#90EE90'); // Hijau muda
                //             } else {
                //                 row.css('background-color', ''); // Reset warna untuk baris lainnya
                //             }
                //         });
                //     },
                //     footerCallback: function(row, data, start, end, display) {
                //         var api = this.api();

                //         // Set teks "Rata-Rata" di kolom pertama footer
                //         $(api.column(0).footer()).html('Rata-Rata');

                //         // Fungsi untuk menghitung rata-rata
                //         var calculateAverage = function(index) {
                //             var total = 0;
                //             var count = 0;

                //             // Iterasi melalui semua data pada kolom
                //             api.column(index, { page: 'current' }).data().each(function(value, i) {
                //                 var numericValue = parseFloat(value) || 0; // Konversi ke angka
                //                 total += numericValue;
                //                 count++;
                //             });

                //             return count > 0 ? (total / count).toFixed(2) : 0; // Rata-rata dengan 2 desimal
                //         };

                //         // Loop untuk menghitung rata-rata setiap kolom
                //         $(api.columns().footer()).each(function(index) {
                //             if (index > 2) { // Abaikan kolom non-numeric (contoh: Ranking, NIS, Nama Siswa)
                //                 $(this).html(calculateAverage(index));
                //             }
                //         });
                //     }
                // });

                product_table = $('#product_table').DataTable({
                    pageLength: -1,
                    ordering: true,
                    order: [[{{ count($mapel) + 4 }}, 'desc']],
                    columnDefs: [
                        {
                            targets: 0, // Kolom Ranking
                            searchable: false,
                            orderable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + 1;
                            }
                        }
                    ],
                    drawCallback: function(settings) {
                        var api = this.api();

                        // Tambahkan warna ke baris 5 teratas
                        api.rows({ order: 'applied' }).every(function(rowIdx, tableLoop, rowLoop) {
                            var row = $(this.node());

                            // Tambahkan warna sesuai ranking
                            if (rowIdx === 0) {
                                row.css('background-color', '#FFD700'); // Emas
                            } else if (rowIdx === 1) {
                                row.css('background-color', '#C0C0C0'); // Perak
                            } else if (rowIdx === 2) {
                                row.css('background-color', '#ffc285'); // Perunggu
                            } else if (rowIdx === 3) {
                                row.css('background-color', '#ADD8E6'); // Biru muda
                            } else if (rowIdx === 4) {
                                row.css('background-color', '#90EE90'); // Hijau muda
                            } else {
                                row.css('background-color', '');
                            }
                        });
                    },
                    footerCallback: function(row, data, start, end, display) {
                        var api = this.api();

                        // Tulis "Rata-Rata" di kolom pertama
                        $(api.column(0).footer()).html('Rata-Rata');

                        var calculateAverage = function(index) {
                            var total = 0, count = 0;
                            api.column(index, { page: 'current' }).data().each(function(value) {
                                var numericValue = parseFloat(value) || 0;
                                total += numericValue;
                                count++;
                            });
                            return count > 0 ? (total / count).toFixed(2) : 0;
                        };

                        $(api.columns().footer()).each(function(index) {
                            if (index > 2) {
                                $(this).html(calculateAverage(index));
                            }
                        });
                    }
                });


            });
        @endif


    </script>

@endsection