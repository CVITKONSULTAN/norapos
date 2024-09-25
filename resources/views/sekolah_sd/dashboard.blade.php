@extends('layouts.app')
@section('title', __('home.home'))

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.css" />    
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
	    <!-- /.col -->

  	</div>
    
  	<!-- sales chart start -->
  	<div class="row">
  		<div class="col-sm-12">
            <div class="box box-solid">
                <div class="box-header">
                    Grafik siswa/siswai SD Muhammadiyah 2 Pontianak
                </div>
                <div class="box-body">
                    <div id="chart"></div>
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
        var options = {
            series: [
                {
                    name: 'Laki-laki',
                    type: 'column',
                    data: [100,200,300,400]
                }, {
                    name: 'Perempuan',
                    type: 'column',
                    data: [150,100,200,500]
                },
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
                categories: [2021,2022,2023,2024],
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
  
          var chart = new ApexCharts(document.querySelector("#chart"), options);
          chart.render();
    </script>
    <script>
        $(document).ready(function(){
            $(".total_murid").html(10);
            $(".total_tendik").html(20);
            $(".total_tata_usaha").html(30);
        });
    </script>
@endsection

