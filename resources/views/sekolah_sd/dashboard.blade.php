@extends('layouts.app')
@section('title', __('home.home'))

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.css" />    
    <style>
        .table_profile_dashboard_sekolah{
            border-collapse: collapse;
            border: 1px solid black;
            border-radius: 5px;
        }
        .table_profile_dashboard_sekolah tr {
            border: 1px solid black;
        }
        .table_profile_dashboard_sekolah tr td {
            padding: 10px;
        }
    </style>
@endsection

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <p class="mb-0">Halo,</p>
    <h1 class="mb-0">{{ Session::get('user.first_name') }}</h1>
    <p>Selamat datang di KoneksiEdu, Sistem Informasi Sekolah SD Muhammadiyah 2 Pontianak!</p>
</section>
<!-- Main content -->
<section class="content content-custom no-print">
    <br>
	<br>
	<div class="row row-custom">
    	<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
	      <div class="info-box info-box-new-style">
	        <span class="info-box-icon">
                <img src="/sekolah/icon_sekolah_1.svg" />
            </span>

	        <div class="info-box-content">
	          <span class="info-box-text">Total Peserta Didik</span>
	          <span class="info-box-number total_murid"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
	      <div class="info-box info-box-new-style">
	        <span class="info-box-icon">
                <img src="/sekolah/icon_sekolah_2.svg" />
            </span>

	        <div class="info-box-content">
	          <span class="info-box-text">
                Total Tenaga Pendidik
            </span>
	          <span class="info-box-number total_tendik"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
{{--  
	    <div class="col-md-3 col-sm-6 col-xs-12 col-custom">
	      <div class="info-box info-box-new-style">
	        <span class="info-box-icon">
                <img src="/sekolah/icon_sekolah_3.svg" />
            </span>

	        <div class="info-box-content">
	          <span class="info-box-text">
                Total Tata Usaha
            </span>
	          <span class="info-box-number total_tata_usaha"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
 --}}
	    <!-- /.col -->

  	</div>
    
  	<!-- sales chart start -->
  	<div class="row">
  		<div class="col-sm-12 col-md-6">
            <div class="box box-solid">
                <div class="box-header">
                    Grafik siswa/siswai SD Muhammadiyah 2 Pontianak
                </div>
                <div class="box-body">
                    <div id="chart"></div>
                </div>
                <!-- /.box-body -->
            </div> 
            <div class="box box-solid">
                <div class="box-header">
                    Grafik kelas berdasarkan jumlah siswa
                </div>
                <div class="box-body">
                    <label>
                        Pilih tahun:
                        <select>
                            <option>2024</option>
                            <option>2025</option>
                            <option>2026</option>
                            <option>2027</option>
                            <option>2028</option>
                            <option>2029</option>
                            <option>2030</option>
                        </select>
                    </label>
                    <div id="chart_kelas"></div>
                </div>
                <!-- /.box-body -->
            </div>
  		</div>
        <div class="col-sm-12 col-md-6">
            <div class="box box-solid">
                <div class="box-header">
                    Profil Sekolah
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <td>Nama Instansi</td>
                            <td>:</td>
                            <td>SD Muhammadiyah 2 Pontianak</td>
                        </tr>
                        <tr>
                            <td>Nama Sekolah</td>
                            <td>:</td>
                            <td>SD Muhammadiyah 2 Pontianak</td>
                        </tr>
                        <tr>
                            <td>NISN/NIS/NSS</td>
                            <td>:</td>
                            <td>0135338985</td>
                        </tr>
                        <tr>
                            <td>NPSN</td>
                            <td>:</td>
                            <td>30105255</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>Jalan Jendral Ahmad Yani</td>
                        </tr>
                        <tr>
                            <td>Desa/Kelurahan</td>
                            <td>:</td>
                            <td>Akcaya</td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>:</td>
                            <td>Pontianak Selatan</td>
                        </tr>
                        <tr>
                            <td>Kota</td>
                            <td>:</td>
                            <td>Pontianak </td>
                        </tr>
                        <tr>
                            <td>Provinsi</td>
                            <td>:</td>
                            <td>Kalimantan Barat</td>
                        </tr>
                        <tr>
                            <td>Email Sekolah</td>
                            <td>:</td>
                            <td>sdmuh2ponsel@yahoo.co.id</td>
                        </tr>
                        <tr>
                            <td>Faks</td>
                            <td>:</td>
                            <td>(0561)747478</td>
                        </tr>
                        <tr>
                            <td>Kode POS</td>
                            <td>:</td>
                            <td>78121</td>
                        </tr>
                        <tr>
                            <td>Telp.</td>
                            <td>:</td>
                            <td>(0561)733539</td>
                        </tr>
                        <tr>
                            <td>Jumlah Peserta Didik</td>
                            <td>:</td>
                            <td>1050</td>
                        </tr>
                        <tr>
                            <td>Akreditasi Sekolah</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                        <tr>
                            <td>Kepala Sekolah / Penanggung Jawab</td>
                            <td>:</td>
                            <td>Ariansyah, S.Pd.I.</td>
                        </tr>
                        <tr>
                            <td>Tanggal terakhir Update</td>
                            <td>:</td>
                            <td>15 Desember 2023</td>
                        </tr>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
  	</div>

</section>
<!-- /.content -->
@stop

@section('javascript')
    <script src="{{ asset('js/home.js?v=' . $asset_v) }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.js"></script>
    <script>

        const options = {
            series: [
                {
                    name: 'Laki-laki',
                    type: 'column',
                    data: [0,0,0,0]
                }, 
                {
                    name: 'Perempuan',
                    type: 'column',
                    data: [0,0,0,0]
                },
            ],
            xaxis: {
                categories: [2021,2022,2023,2024],
            },
            chart: {
                height: 350,
                type: 'line',
                stacked: false
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: [1, 1, 4]
            },
            yaxis: [
                {
                    seriesName: 'Laki-laki',
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#008FFB'
                    },
                    labels: {
                        style: {
                        colors: '#008FFB',
                        }
                    },
                    title: {
                        text: "Laki-laki",
                        style: {
                        color: '#008FFB',
                        }
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                {
                    seriesName: 'Perempuan',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#00E396'
                    },
                    labels: {
                        style: {
                        colors: '#00E396',
                        }
                    },
                    title: {
                        text: "Perempuan",
                        style: {
                        color: '#00E396',
                        }
                    },
                },
            ],
            tooltip: {
                fixed: {
                enabled: true,
                position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
                offsetY: 30,
                offsetX: 60
                },
            },
            legend: {
                horizontalAlign: 'left',
                offsetX: 40
            }
        };
  
        const chartSiswa = new ApexCharts(document.querySelector("#chart"), options);
        chartSiswa.render();

        const kelasOptions = {
        series: [
            {
                name: 'Kelas',
                type: 'column',
                data: [
                    0,
                    0,
                    0,
                    0,
                    0,
                    0,
                ]
            }
        ],
        chart: {
            height: 350,
            type: 'line',
            stacked: false
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            width: [1, 1, 4]
        },
        xaxis: {
            categories: [
                "I",
                "II",
                "III",
                "IV",
                "V",
                "VI",
            ],
        },
        yaxis: [
            {
                seriesName: 'Laki-laki',
                axisTicks: {
                    show: true,
                },
                axisBorder: {
                    show: true,
                    color: '#008FFB'
                },
                labels: {
                    style: {
                    colors: '#008FFB',
                    }
                },
                title: {
                    text: "Laki-laki",
                    style: {
                    color: '#008FFB',
                    }
                },
                tooltip: {
                    enabled: true
                }
            }
        ],
        tooltip: {
            fixed: {
            enabled: true,
            position: 'topLeft', // topRight, topLeft, bottomRight, bottomLeft
            offsetY: 30,
            offsetX: 60
            },
        },
        legend: {
            horizontalAlign: 'left',
            offsetX: 40
        }
        };

        const chartKelas = new ApexCharts(document.querySelector("#chart_kelas"),kelasOptions)
        chartKelas.render();

        $(document).ready(function(){
            getDataDashboard();
        });

        const getDataDashboard = () => {
            $.ajax({
                url:"{{route('sekolah_sd.dashboard.api')}}",
                beforeSend:() => {
                    $('.total_murid').html('<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                },
                success: response => {
                    console.log("response",response)
                    if(!response.status) return;
                    const {data} = response;
                    $(".total_murid").html(data.total_siswa);
                    $(".total_tendik").html(data.total_tendik);

                    let updateChartSiswa = {
                        series: [
                            {
                                name: 'Laki-laki',
                                type: 'column',
                                data: []
                            }, {
                                name: 'Perempuan',
                                type: 'column',
                                data: []
                            },
                        ],
                        xaxis: {
                            categories: [],
                        }
                    };
                    for(const k in data.list_tahun_interval){
                        const val = data.list_tahun_interval[k]
                        updateChartSiswa.xaxis.categories.push(k);
                        for(const j in val){
                            const value = val[j]
                            if(j == "laki-laki") updateChartSiswa.series[0].data.push(value)
                            if(j == "perempuan") updateChartSiswa.series[1].data.push(value)
                        }
                    }
                    chartSiswa.updateOptions(updateChartSiswa);

                    let updateChartKelas = {
                        series: [
                            {
                                name: 'Kelas',
                                type: 'column',
                                data: []
                            }
                        ],
                        xaxis: {
                            categories: [],
                        }
                    };
                    for(const k in data.list_jumlah_siswa_perkelas){
                        const val = data.list_jumlah_siswa_perkelas[k]
                        updateChartKelas.xaxis.categories.push(k);
                        updateChartKelas.series[0].data.push(val)
                    }
                    chartKelas.updateOptions(updateChartKelas);
                }
            })
        }
    </script>
@endsection

