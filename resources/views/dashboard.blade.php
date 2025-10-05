@extends('layouts.app')
@section('title', 'Dashboard - Statistik Mata Kuliah')
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-center mb-4" style="font-size: 1.8rem;">📊 Dashboard Statistik</h1>
        </div>
    </div>

    <!-- Cards Statistik -->
    <div class="row mb-4 justify-content-center">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-card shadow border-0 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-center text-white rounded">
                    <div class="mb-2">
                        <i class="fas fa-chalkboard-teacher" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="card-title mb-2" style="font-family: 'Montserrat', sans-serif; font-weight: bold;">Total Dosen</h6>
                    <div class="display-5 fw-bold">{{ $totalDosen ?? count($labels) }}</div>
                    <small class="opacity-75">Dosen Terdaftar</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-card shadow border-0 h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-center text-white rounded">
                    <div class="mb-2">
                        <i class="fas fa-book" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="card-title mb-2" style="font-family: 'Montserrat', sans-serif; font-weight: bold;">Total Mata Kuliah</h6>
                    <div class="display-5 fw-bold">{{ $totalMataKuliah ?? array_sum($data) }}</div>
                    <small class="opacity-75">Mata Kuliah</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-card shadow border-0 h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-center text-white rounded">
                    <div class="mb-2">
                        <i class="fas fa-users" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="card-title mb-2" style="font-family: 'Montserrat', sans-serif; font-weight: bold;">Total Mahasiswa</h6>
                    <div class="display-5 fw-bold">{{ $totalMahasiswa ?? 0 }}</div>
                    <small class="opacity-75">Mahasiswa</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card dashboard-card shadow border-0 h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body text-center text-white rounded">
                    <div class="mb-2">
                        <i class="fas fa-chart-line" style="font-size: 2rem;"></i>
                    </div>
                    <h6 class="card-title mb-2" style="font-family: 'Montserrat', sans-serif; font-weight: bold;">Rata-rata MK/Dosen</h6>
                    <div class="display-5 fw-bold">{{ $avgMataKuliahPerDosen ?? (count($labels) ? round(array_sum($data)/count($labels),2) : 0) }}</div>
                    <small class="opacity-75">Per Dosen</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row">
        <div class="col-12">
            <div class="chart-container mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 style="font-size: 1.5rem; color: #355c7d;">📈 Distribusi Mata Kuliah per Dosen</h3>
                    <div class="btn-group" role="group" aria-label="Chart type">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="changeChartType('bar')" id="barBtn">
                            <i class="fas fa-chart-bar me-1"></i>Bar
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="changeChartType('line')" id="lineBtn">
                            <i class="fas fa-chart-line me-1"></i>Line
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="changeChartType('pie')" id="pieBtn">
                            <i class="fas fa-chart-pie me-1"></i>Pie
                        </button>
                    </div>
                </div>
                
                @if(count($labels) > 0)
                    <div style="overflow-x:auto;">
                        <canvas id="chartMatkul" style="min-width:600px;max-width:100%;height:400px;"></canvas>
                    </div>
                    
                    <!-- Legend Info -->
                    <div class="stats-legend mt-4 p-3">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <small class="text-muted">Dosen Aktif:</small>
                                <div class="fw-bold text-primary">{{ count($labels) }}</div>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">Total MK:</small>
                                <div class="fw-bold text-success">{{ array_sum($data) }}</div>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">MK Terbanyak:</small>
                                <div class="fw-bold text-warning">{{ count($data) ? max($data) : 0 }}</div>
                            </div>
                            <div class="col-md-3">
                                <small class="text-muted">MK Tersedikit:</small>  
                                <div class="fw-bold text-info">{{ count($data) ? min($data) : 0 }}</div>
                            </div>
                        </div>
                        
                        @if(isset($dosenTerbanyak) && $dosenTerbanyak)
                        <div class="row mt-3 text-center">
                            <div class="col-md-6">
                                <small class="text-muted">🏆 Dosen dengan MK Terbanyak:</small>
                                <div class="fw-bold text-success">{{ $dosenTerbanyak->nama }} ({{ $dosenTerbanyak->mata_kuliah_count }} MK)</div>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">📚 Dosen dengan MK Tersedikit:</small>
                                <div class="fw-bold text-primary">{{ $dosenTersedikit->nama ?? '-' }} ({{ $dosenTersedikit->mata_kuliah_count ?? 0 }} MK)</div>
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada data untuk ditampilkan</h5>
                        <p class="text-muted">Silakan tambahkan data dosen dan mata kuliah terlebih dahulu.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Font Awesome untuk Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
    // Data dari Laravel
    const chartLabels = @json($labels);
    const chartData = @json($data);
    
    // Cek apakah ada data untuk ditampilkan
    if (chartLabels.length === 0 || chartData.length === 0) {
        console.log('Tidak ada data untuk chart');
        // Sembunyikan tombol chart jika tidak ada data
        document.querySelector('.btn-group').style.display = 'none';
        // Exit dari script
        // return;
    }
    
    // Color palette yang menarik
    const colors = [
        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7', 
        '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9',
        '#F8C471', '#82E0AA', '#F1948A', '#85C1E9', '#D7BDE2'
    ];
    
    const backgroundColors = colors.slice(0, chartData.length);
    const borderColors = backgroundColors.map(color => color.replace('0.8)', '1)'));
    
    // Konfigurasi Chart (hanya jika ada data)
    let chart;
    const chartElement = document.getElementById('chartMatkul');
    
    if (chartLabels.length > 0 && chartData.length > 0 && chartElement) {
        const ctx = chartElement.getContext('2d');
        chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Mata Kuliah',
                data: chartData,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
                maxBarThickness: 50,
                hoverBackgroundColor: backgroundColors.map(color => color + 'CC'),
                hoverBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: { 
                    display: false 
                },
                title: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#355c7d',
                    borderWidth: 2,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            return 'Dosen: ' + context[0].label;
                        },
                        label: function(context) {
                            return 'Mata Kuliah: ' + context.parsed.y + ' MK';
                        },
                        afterLabel: function(context) {
                            const total = chartData.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed.y / total) * 100).toFixed(1);
                            return 'Persentase: ' + percentage + '%';
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { 
                        color: '#355c7d', 
                        font: { weight: 'bold', size: 11 },
                        maxRotation: 45,
                        minRotation: 0
                    },
                    grid: { 
                        display: false 
                    },
                    title: {
                        display: true,
                        text: 'Nama Dosen',
                        color: '#355c7d',
                        font: { weight: 'bold', size: 14 }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: { 
                        color: '#355c7d', 
                        font: { weight: 'bold', size: 11 },
                        stepSize: 1
                    },
                    grid: { 
                        color: 'rgba(53,92,125,0.1)',
                        lineWidth: 1
                    },
                    title: {
                        display: true,
                        text: 'Jumlah Mata Kuliah',
                        color: '#355c7d',
                        font: { weight: 'bold', size: 14 }
                    }
                }
            },
            onHover: (event, activeElements) => {
                event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
            }
        }
    });
    } // End of if statement for chart initialization
    
    // Function untuk mengubah tipe chart
    function changeChartType(type) {
        if (!chart || chartLabels.length === 0) {
            console.log('Chart tidak tersedia atau tidak ada data');
            return;
        }
        // Update button states
        document.querySelectorAll('.btn-group .btn').forEach(btn => {
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-outline-primary');
        });
        document.getElementById(type + 'Btn').classList.remove('btn-outline-primary');
        document.getElementById(type + 'Btn').classList.add('btn-primary');
        
        // Destroy existing chart
        chart.destroy();
        
        // Create new chart with different type
        let newConfig = {
            type: type,
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Mata Kuliah',
                    data: chartData,
                    backgroundColor: type === 'pie' ? backgroundColors : backgroundColors.map(color => color + '80'),
                    borderColor: borderColors,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: { 
                        display: type === 'pie',
                        position: 'right',
                        labels: {
                            boxWidth: 15,
                            padding: 15,
                            font: { size: 11 }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: '#355c7d',
                        borderWidth: 2,
                        cornerRadius: 8,
                        callbacks: {
                            title: function(context) {
                                return 'Dosen: ' + context[0].label;
                            },
                            label: function(context) {
                                if (type === 'pie') {
                                    const total = chartData.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed + ' MK (' + percentage + '%)';
                                }
                                return 'Mata Kuliah: ' + context.parsed.y + ' MK';
                            }
                        }
                    }
                }
            }
        };
        
        // Add scales for bar and line charts
        if (type !== 'pie') {
            newConfig.options.scales = {
                x: {
                    ticks: { 
                        color: '#355c7d', 
                        font: { weight: 'bold', size: 11 },
                        maxRotation: 45
                    },
                    grid: { display: type === 'line' },
                    title: {
                        display: true,
                        text: 'Nama Dosen',
                        color: '#355c7d',
                        font: { weight: 'bold', size: 14 }
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: { 
                        color: '#355c7d', 
                        font: { weight: 'bold', size: 11 },
                        stepSize: 1
                    },
                    grid: { color: 'rgba(53,92,125,0.1)' },
                    title: {
                        display: true,
                        text: 'Jumlah Mata Kuliah',
                        color: '#355c7d',
                        font: { weight: 'bold', size: 14 }
                    }
                }
            };
        }
        
        // Special config for line chart
        if (type === 'line') {
            newConfig.data.datasets[0].fill = true;
            newConfig.data.datasets[0].backgroundColor = 'rgba(54, 162, 235, 0.1)';
            newConfig.data.datasets[0].borderColor = '#36A2EB';
            newConfig.data.datasets[0].pointBackgroundColor = backgroundColors;
            newConfig.data.datasets[0].pointBorderColor = borderColors;
            newConfig.data.datasets[0].pointRadius = 6;
            newConfig.data.datasets[0].pointHoverRadius = 8;
            newConfig.data.datasets[0].tension = 0.4;
        }
        
        // Special config for bar chart
        if (type === 'bar') {
            newConfig.data.datasets[0].borderRadius = 8;
            newConfig.data.datasets[0].maxBarThickness = 50;
        }
        
        chart = new Chart(ctx, newConfig);
    }
    
    // Set default button state (hanya jika ada data)
    if (chartLabels.length > 0 && document.getElementById('barBtn')) {
        document.getElementById('barBtn').classList.remove('btn-outline-primary');
        document.getElementById('barBtn').classList.add('btn-primary');
        
        // Add loading animation
        window.addEventListener('load', function() {
            if (chart) {
                setTimeout(() => {
                    chart.update('active');
                }, 100);
            }
        });
    }
</script>
@endsection