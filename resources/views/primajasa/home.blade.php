@extends('layouts.app')
@section('title', __('home.home'))

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.css" />    
@endsection

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <h1>{{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}
    </h1>
</section>

<!-- Main content -->
<section class="content content-custom no-print">
  <br>
    <div class="row row-custom">
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-green"><i class="fa fa-check"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Total Pendapatan</span>
                <span class="info-box-number total_pendapatan">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-red"><i class="fa fa-truck"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Total Ritase</span>
                <span class="info-box-number total_ritase">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-black"><i class="fa fa-tint"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Total Penggunaan BBM</span>
                <span class="info-box-number total_bbm">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
		<div class="col-md-3 col-sm-6 col-xs-12 col-custom">
            <div class="info-box info-box-new-style">
              <span class="info-box-icon bg-aqua"><i class="fa fa-tags"></i></span>
  
              <div class="info-box-content">
                <span class="info-box-text">Total Reimburse</span>
                <span class="info-box-number total_reimburse">
                    <i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
	</div>

    <div class="row">
        <div class="col-sm-12 col-md-6">
          <div class="box box-solid">
              <div class="box-header">
                  Grafik Pendapatan
              </div>
              <div class="box-body">
                  <div id="chart"></div>
              </div>
              <!-- /.box-body -->
          </div> 
        </div>
        <div class="col-sm-12 col-md-6">
          <div class="box box-solid">
              <div class="box-header">
                  Grafik Ritase dan Penggunaan BBM
              </div>
              <div class="box-body">
                  <div id="chart_ritase"></div>
              </div>
              <!-- /.box-body -->
          </div> 
        </div>
        <div class="col-sm-12 col-md-6">
          <div class="box box-solid">
              <div class="box-header">
                Grafik Operasional
              </div>
              <div class="box-body">
                  <div id="chart_operasional"></div>
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
                    // $(".total_jalan").html(data.jalan);
                    // $(".total_jembatan").html(data.jembatan);
                }
            })
        }

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

        const chartRitase = new ApexCharts(document.querySelector("#chart_ritase"), options);
        chartRitase.render();

        const chartOperasional = new ApexCharts(document.querySelector("#chart_operasional"), options);
        chartOperasional.render();
    </script>

@endsection

