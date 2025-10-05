@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row mb-4 justify-content-center">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center bg-info text-white rounded">
                    <h5 class="card-title mb-2">Total Dosen</h5>
                    <div class="display-5 fw-bold">{{ count($labels) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center bg-success text-white rounded">
                    <h5 class="card-title mb-2">Total Mata Kuliah</h5>
                    <div class="display-5 fw-bold">{{ array_sum($data) }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow border-0 h-100">
                <div class="card-body text-center bg-warning rounded">
                    <h5 class="card-title mb-2">Rata-rata Mata Kuliah/Dosen</h5>
                    <div class="display-5 fw-bold">{{ count($labels) ? round(array_sum($data)/count($labels),2) : 0 }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow border-0 p-4 mb-4">
        <h5 class="mb-3">Grafik Jumlah Mata Kuliah per Dosen</h5>
        <div style="overflow-x:auto;">
            <canvas id="chartMatkul" style="min-width:600px;max-width:100%;height:300px;"></canvas>
        </div>
    </div>
</div>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartMatkul').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Mata Kuliah',
                data: @json($data),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                borderRadius: 6,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Distribusi Mata Kuliah per Dosen',
                    font: { size: 18, weight: 'bold' },
                    color: '#355c7d'
                }
            },
            scales: {
                x: {
                    ticks: { color: '#355c7d', font: { weight: 'bold', size: 12 } },
                    grid: { display: false }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: '#355c7d', font: { weight: 'bold', size: 12 } },
                    grid: { color: 'rgba(53,92,125,0.1)' }
                }
            }
        }
    });
</script>
@endsection