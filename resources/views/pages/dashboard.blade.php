@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            <div class="row">
                {{-- Total User --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total User</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalUser }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kehadiran Hari Ini --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Kehadiran Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalHariIni }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Terlambat --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>User Sering Telat</h4>
                            </div>
                            <div class="card-body">
                                {{ $seringTelat->sum('total_telat') }} kali
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Disiplin --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>User Disiplin</h4>
                            </div>
                            <div class="card-body">
                                {{ $tepatWaktu->sum('total_tepat') }} kali
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- Surat Masuk Hari Ini --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Surat Masuk Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                {{ $todayIncomingLetter }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Surat Keluar Hari Ini --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Surat Keluar Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                {{ $todayOutgoingLetter }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Surat Disposisi Hari Ini --}}
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-secondary">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Surat Disposisi Hari Ini</h4>
                            </div>
                            <div class="card-body">
                                {{ $todayDispositionLetter }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            {{-- Diagram Kehadiran Total --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Kehadiran (Keseluruhan)</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="kehadiranChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik Transaksi Surat Hari Ini --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistik Transaksi Surat Hari Ini</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="suratChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
    <script src="{{ asset('js/page/index-0.js') }}"></script>

    <script>
        const kehadiranChart = document.getElementById("kehadiranChart").getContext("2d");

        const totalTelat = {{ $seringTelat->sum('total_telat') }};
        const totalTepat = {{ $tepatWaktu->sum('total_tepat') }};

        new Chart(kehadiranChart, {
            type: 'line',
            data: {
                labels: ['Terlambat', 'Tepat Waktu'],
                datasets: [{
                    label: 'Jumlah Kehadiran',
                    data: [totalTelat, totalTepat],
                    fill: true,
                    backgroundColor: 'rgba(99, 237, 122, 0.2)', // warna di bawah garis
                    borderColor: '#63ed7a',
                    tension: 0.4, // efek lengkung
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#63ed7a',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 8
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#777'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#eee'
                        },
                        ticks: {
                            stepSize: 1,
                            color: '#777'
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const suratChartCtx = document.getElementById('suratChart').getContext('2d');

        const suratChart = new Chart(suratChartCtx, {
            type: 'bar',
            data: {
                labels: ['Surat Masuk', 'Surat Keluar', 'Surat Disposisi'],
                datasets: [{
                    label: 'Jumlah Surat Hari Ini',
                    data: [
                        {{ $todayIncomingLetter }},
                        {{ $todayOutgoingLetter }},
                        {{ $todayDispositionLetter }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)', // biru
                        'rgba(255, 206, 86, 0.7)', // kuning
                        'rgba(153, 102, 255, 0.7)' // ungu
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
@endpush
