@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="my-4" style="font-weight: 600; opacity: 0.85;">Beranda</h1>
        </div>
    </div>

    <div class="row">
        @if(Auth::user()->role === "admin")
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/beranda') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">Beranda</h5>
                    <i class="ion-home"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/karyawan') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Karyawan 
                        <span>({{ $totalData->karyawan }})</span>
                    </h5>
                    <i class="ion-person-stalker"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/pelanggan') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Pelanggan
                        <span>({{ $totalData->pelanggan }})</span>
                    </h5>
                    <i class="ion-person-stalker"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/kategorijasa') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Kategori Jasa
                        <span>({{ $totalData->kategorijasa }})</span>
                    </h5>
                    <i class="ion-gear-b"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/servisorder') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Servis Order
                        {{-- <span>({{ $totalData->tugasteknisi }})</span> --}}
                    </h5>
                    <i class="ion-clipboard"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/tugasteknisi') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Pembagian Tugas Teknisi
                        <span>({{ $totalData->tugasteknisi }})</span>
                    </h5>
                    <i class="ion-clipboard"></i>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ url('/laporantugasteknisi') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">Laporan Tugas Teknisi</h5>
                    <i class="ion-ios-book"></i>
                </a>
            </div>
        @elseif(Auth::user()->role === "teknisi")
            <div class="col-md-4">
                <a href="{{ url('/beranda') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">Beranda</h5>
                    <i class="ion-home"></i>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ url('/daftartugas') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Daftar Tugas
                        <span>({{ $totalData->daftartugas }})</span>
                    </h5>
                    <i class="ion-clipboard"></i>
                </a>
            </div>
            <div class="col-md-4">
                <a href="{{ url('/daftartugasselesai') }}" class="card main-menu mb-3">
                    <h5 class="mb-0">
                        Tugas Selesai
                        <span>({{ $totalData->tugasselesai }})</span>
                    </h5>
                    <i class="ion-android-checkmark-circle"></i>
                </a>
            </div>
        @endif
    </div>

    @if(Auth::user()->role === "admin")
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="my-0" style="font-weight: 600;">Diagram Teknisi Tugas Selesai</h5>
                        <div>
                            <select id="filter_tanggal" name="filter_tanggal" class="form-control select" style="min-width: 190px; max-width: 200px;">
                                <option value="today">Hari Ini</option>
                                <option value="last7days">7 Hari Terakhir</option>
                                <option value="last30days">30 Hari Terakhir</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-bar" style="height: 250px;">
                            <canvas id="myBarChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('bodyScripts')
    <script src="{{asset('/js/chart.js/Chart.min.js')}}"></script>
    <script type="text/javascript">
        var barChart = null;
        function initChartBar(){
            var ctx = document.getElementById("myBarChart");
            if(ctx == null || ctx == undefined){
                return;
            }
            barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["initial data"],
                datasets: [{
                    label: "Total Tugas Selesai",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: [5],
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
                },
                scales: {
                xAxes: [{
                    // time: {
                    //     unit: 'month'
                    // },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 15
                    },
                        maxBarThickness: 150,
                }],
                yAxes: [{
                    ticks: {
                    min: 0,
                    max: 30,
                    maxTicksLimit: 5,
                    padding: 5,
                    callback: function(value, index, values) {
                        return value;
                    }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    caretPadding: 10,
                    // callbacks: {
                    //     label: function(tooltipItem, chart) {
                    //     var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                    //     return datasetLabel + ': ' + tooltipItem.yLabel;
                    //     }
                    // }
                },
            }
            });   
        }

        function updateChartBar(data = null){
            var dataLabels = [];
            var dataCount = [];
            data.forEach((val, i)=>{
                dataLabels.push(val.name);
                dataCount.push(val.tugasteknisiselesai_count);
            });
            barChart.config.data.labels = dataLabels;
            barChart.config.data.datasets[0].data = dataCount;
            barChart.update();
        }

        function fetchData(filter_tanggal = null){
            var url = `{{url('/apiBarChart')}}`;
            var filterTanggal = filter_tanggal == null ? "" : filter_tanggal;
            var dataString = `filter_tanggal=${filterTanggal}`;
            $.ajax({
                url : url,
                type:"GET",
                data: dataString,
                contentType: false,
                processData: false,
                success : function(data) {
                    if(barChart == null){
                        initChartBar();
                    }
                    updateChartBar(data.data);
                },
                error : function(data){
                }
            });
        }

        $('select').on('change', function (e) {
            var filter_tanggal = $('#filter_tanggal').val();

            fetchData(filter_tanggal);
        });

        var ctx = document.getElementById("myBarChart");
        if(ctx == null || ctx == undefined){
        } else {
            fetchData("today");
        }
    </script>
@endsection
