@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_header', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Card Total Siswa -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-graduate"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Siswa</span>
                        <span class="info-box-number">
                            {{ $totalSiswa }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <!-- Card Total Siswa Perempuan -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-female"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Siswa Perempuan</span>
                        <span class="info-box-number">
                            {{ $totalPerempuan }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <!-- Card Total Siswa Laki-laki -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon btn-warning elevation-1"><i class="fas fa-male"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Siswa Laki-laki</span>
                        <span class="info-box-number">
                            {{ $totalLaki }}
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>

        <div class="row">
            <!-- Diagram Donat: Jenis Kelamin -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Jumlah Siswa Berdasarkan Jenis Kelamin</div>
                    <div class="card-body">
                        <canvas id="chartJenisKelamin"></canvas>
                    </div>
                </div>
            </div>

            <!-- Diagram Pie: Asal Kota -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Jumlah Siswa Berdasarkan Asal Kota</div>
                    <div class="card-body">
                        <canvas id="chartKota"></canvas>
                    </div>
                </div>
            </div>

            <!-- Diagram Batang: Tahun Kelahiran -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Jumlah Siswa Berdasarkan Tahun Kelahiran</div>
                    <div class="card-body">
                        <canvas id="chartTahun"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Chart Jenis Kelamin
            var ctxJenisKelamin = document.getElementById('chartJenisKelamin').getContext('2d');
            new Chart(ctxJenisKelamin, {
                type: 'doughnut',
                data: {
                    labels: @json($jenisKelaminData['labels']),
                    datasets: [{
                        data: @json($jenisKelaminData['data']),
                        backgroundColor: ['#36A2EB', '#FF6384']
                    }]
                }
            });

            // Chart Asal Kota
            var ctxKota = document.getElementById('chartKota').getContext('2d');
            new Chart(ctxKota, {
                type: 'pie',
                data: {
                    labels: @json($kotaData->pluck('label')),
                    datasets: [{
                        data: @json($kotaData->pluck('total')),
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                            '#C9CBCF'
                        ]
                    }]
                }
            });

            // Chart Tahun Kelahiran
            var ctxTahun = document.getElementById('chartTahun').getContext('2d');
            new Chart(ctxTahun, {
                type: 'bar',
                data: {
                    labels: @json($tahunData->pluck('tahun')),
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: @json($tahunData->pluck('total')),
                        backgroundColor: '#36A2EB'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
