@extends('layouts.app')
@section('title', __('home.home'))

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.css" />    
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <p class="mb-0">{{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}</p>
    <h1>Dashboard Rekapitulasi</h1>
</section>

<!-- Main content -->
<section class="content content-custom no-print">
    <br>
	<br>
    <div class="row row-custom">
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-yellow"><i class="fa fa-star"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">PBG & SLF Terbit</span>
                <span class="info-box-number total_jalan">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Jumlah Pengajuan</span>
                <span class="info-box-number total_jembatan">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-aqua"><i class="fa fa-credit-card"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Total Retribusi (Rp)</span>
                <span class="info-box-number total_jembatan">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
	</div>
    <div class="row">
  		<div class="col-sm-12 col-md-8">
            <div class="box box-solid">
                <div class="box-header">
                    Grafik perbandingan rekapitulasi jumlah PBG & SLF Terbit dengan jumlah pengajuan (5Tahun Terakhir)
                </div>
                <div class="box-body">
                    <div id="chart"></div>
                </div>
                <!-- /.box-body -->
            </div> 
        </div>
  		<div class="col-sm-12 col-md-4">
            <div class="box box-solid">
                <div class="box-header">
                    Jenis izin bangunan
                </div>
                <div class="box-body">
                    <div id="donut-chart"></div>
                </div>
                <!-- /.box-body -->
            </div> 
        </div>
  		<div class="col-sm-12 col-md-12">
            <div class="box box-solid">
                <div class="box-header">
                    Data Rekap wilayah Pengajuan PBG & SLF terbanyak
                </div>
                <div class="box-body">
                    <div id="bar-chart"></div>
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
                    name: 'PBG & SLF Terbit',
                    type: 'line',
                    data: [10,15,10,0]
                }, 
                {
                    name: 'Jumlah Pengajuan',
                    type: 'line',
                    data: [20,30,80,0]
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
                width: [7, 7, 20]
            },
            yaxis: [
                {
                    seriesName: 'PBG & SLF Terbit',
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#8979FF'
                    },
                    labels: {
                        style: {
                        colors: '#8979FF',
                        }
                    },
                    title: {
                        text: "PBG & SLF Terbit",
                        style: {
                            color: '#8979FF',
                        }
                    },
                    tooltip: {
                        enabled: true
                    }
                },
                {
                    seriesName: 'Jumlah Pengajuan',
                    opposite: true,
                    axisTicks: {
                        show: true,
                    },
                    axisBorder: {
                        show: true,
                        color: '#FF928A'
                    },
                    labels: {
                        style: {
                        colors: '#FF928A',
                        }
                    },
                    title: {
                        text: "Jumlah Pengajuan",
                        style: {
                        color: '#FF928A',
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
        const chartRekap = new ApexCharts(document.querySelector("#chart"), options);
        chartRekap.render();

        const donutOptions = {
            series: [93, 80, 40, 32, 31],
            labels: ['Hunian', 'Usaha', 'Sosial Budaya', 'Keagamaan', 'Khusus'],
            chart: {
                type: 'donut',
                height: 400,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: () => '876' // Total ditengah
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: (val, opts) => {
                    const value = opts.w.config.series[opts.seriesIndex];
                    const total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                    const percent = ((value / total) * 100).toFixed(2);
                    return `${value} (${percent}%)`;
                }
            },
            legend: {
                position: 'bottom'
            },
            tooltip: {
                y: {
                    formatter: (value) => `${value}`
                }
            }
        };
        const chartJenis = new ApexCharts(document.querySelector("#donut-chart"), donutOptions);
        chartJenis.render();

        const barOptions = {
            series: [{
                name: 'Jumlah Pengajuan',
                data: [83, 75, 68, 72, 90, 55, 60, 48, 95] // <-- Ganti sesuai data real nanti
            }],
            chart: {
                type: 'bar',
                height: 380,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '45%',
                    distributed: true // <-- bikin warna tiap bar beda otomatis
                }
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                strokeDashArray: 4,
                borderColor: '#e5e7eb'
            },
            xaxis: {
                categories: [
                    'Sungai Raya',
                    'Rasau Jaya',
                    'Sungai Ambawang',
                    'Kuala Mandor B',
                    'Batu Ampar',
                    'Terentang',
                    'Kubu',
                    'Teluk Pakedai',
                    'Sungai Kakap'
                ],
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                max: 100, // <-- Bisa diubah jadi auto: remove line ini
                tickAmount: 5,
                labels: {
                    formatter: (val) => val.toFixed(0)
                }
            },
            colors: [
                '#6366F1', // Ungu
                '#22C55E', // Hijau
                '#F59E0B', // Kuning
                '#EF4444', // Merah
                '#3B82F6', // Biru
                '#8B5CF6', // Violet
                '#EC4899', // Pink
                '#14B8A6', // Aqua
                '#542e04'
            ],
            tooltip: {
                theme: 'light',
                y: {
                    formatter: (val) => `${val} Pengajuan`
                }
            },
            legend: {
                show: false
            }
        };

        const chartBar = new ApexCharts(document.querySelector("#bar-chart"), barOptions);
        chartBar.render();



    </script>
    {{-- <script>
        $(document).ready(function(){
            getDataDashboard();
        });

        const getDataDashboard = () => {
            $.ajax({
                url:"{{route('pejantan.home')}}",
                beforeSend:() => {
                    $('.total_murid').html('<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>');
                },
                success: response => {
                    console.log("response",response)
                    if(!response.status) return;
                    const {data} = response;
                    $(".total_jalan").html(data.jalan);
                    $(".total_jembatan").html(data.jembatan);
                }
            })
        }
    </script> --}}
@endsection

