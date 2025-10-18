@extends('layouts.app')
@section('title', __('home.home'))

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.css" />    
    <style>
        /* Skeleton Effect (Shimmer UI Loading) */
        .skeleton {
            display: inline-block;
            width: 100%;
            height: 24px;
            background: linear-gradient(90deg, #e3e3e3 25%, #f5f5f5 50%, #e3e3e3 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 4px;
        }
        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
    </style>
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
                <span class="info-box-number total_terbit">
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
                <span class="info-box-number total_pengajuan">
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
                <span class="info-box-number total_retribusi">
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
        // ✅ Apply skeleton at start
        $('.total_terbit, .total_pengajuan, .total_retribusi').addClass('skeleton');

        // ✅ Initial empty charts (placeholder)
        const chartRekap = new ApexCharts(document.querySelector("#chart"), {
            series: [
                { name: 'PBG & SLF Terbit', type: 'line', data: [] },
                { name: 'Jumlah Pengajuan', type: 'line', data: [] },
            ],
            xaxis: { categories: [] },
            chart: { height: 350, type: 'line', stacked: false },
            dataLabels: { enabled: false },
        });
        chartRekap.render();

        const chartJenis = new ApexCharts(document.querySelector("#donut-chart"), {
            series: [],
            labels: [],
            chart: { type: 'donut', height: 400 }
        });
        chartJenis.render();

        const chartBar = new ApexCharts(document.querySelector("#bar-chart"), {
            series: [{ name: 'Jumlah Pengajuan', data: [] }],
            xaxis: { categories: [] },
            chart: { type: 'bar', height: 380 }
        });
        chartBar.render();

        // ✅ Fetch Data Once
        $(document).ready(function () {
            loadDashboardData();
        });

        function loadDashboardData() {
            $.ajax({
                url: "{{ route('ciptakarya.dashboard') }}",
                method: "GET",
                success: function (res) {
                    if (res.status) {
                        const data = res.data;

                        // ✅ Remove skeleton
                        $('.total_terbit, .total_pengajuan, .total_retribusi').removeClass('skeleton');
                        console.log("data.total_terbit",data.total_terbit);
                        $('.total_terbit').text(data.total_terbit);
                        $('.total_pengajuan').text(data.total_pengajuan);
                        $('.total_retribusi').text(formatRupiah(data.total_retribusi));

                        // ✅ Update Line Chart
                        chartRekap.updateOptions({ xaxis: { categories: data.grafik_trend.tahun }});
                        chartRekap.updateSeries([
                            { name: 'PBG & SLF Terbit', data: data.grafik_trend.terbit },
                            { name: 'Jumlah Pengajuan', data: data.grafik_trend.pengajuan }
                        ]);

                        // ✅ Update Donut Chart
                        chartJenis.updateSeries(data.jenis_izin.map(i => i.total));
                        chartJenis.updateOptions({ labels: data.jenis_izin.map(i => i.fungsi_bangunan || 'Tidak diketahui') });

                        // ✅ Update Bar Chart
                        chartBar.updateOptions({ xaxis: { categories: data.wilayah.map(w => w.lokasi_bangunan || 'Tidak diketahui') }});
                        chartBar.updateSeries([{ data: data.wilayah.map(w => w.total) }]);
                    }
                }
            });
        }

        // ✅ Format Rupiah
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(angka);
        }
    </script>
@endsection

