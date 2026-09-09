{{-- resources/views/admin/reports.blade.php --}}
@extends('layouts.admin')

@section('title', 'Laporan & Statistik')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">
            <i class="bi bi-graph-up"></i> Laporan & Statistik
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <button type="button" class="btn btn-success" onclick="window.print()">
                <i class="bi bi-printer"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filter Tanggal -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-funnel"></i> Filter Laporan
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control"
                        value="{{ request('date_from', date('Y-m-01')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to', date('Y-m-d')) }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistik Overview -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-ticket-perforated"></i>
                    </div>
                    <div class="stat-value">{{ $totalTickets ?? 0 }}</div>
                    <div class="stat-label">Total Tiket</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $resolvedTickets ?? 0 }}</div>
                    <div class="stat-label">Terselesaikan</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-warning text-white">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="stat-value">{{ $openTickets ?? 0 }}</div>
                    <div class="stat-label">Dalam Proses</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-value">{{ number_format($avgResolutionTime ?? 0, 1) }} jam</div>
                    <div class="stat-label">Rata-rata Resolusi</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-pie-chart"></i> Distribusi Status Tiket
                </div>
                <div class="card-body text-center">
                    <div style="max-width: 300px; margin: 0 auto;">
                        <canvas id="statusChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-bar-chart"></i> Distribusi Prioritas Tiket
                </div>
                <div class="card-body text-center">
                    <div style="max-width: 300px; margin: 0 auto;">
                        <canvas id="priorityChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik per Kategori -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-tags"></i> Tiket per Kategori
                </div>
                <div class="card-body">
                    @if(isset($categoryStats) && $categoryStats->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-end">Jumlah</th>
                                        <th class="text-end">Persentase</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categoryStats as $stat)
                                        <tr>
                                            <td>{{ $stat->name }}</td>
                                            <td class="text-end">{{ $stat->total }}</td>
                                            <td class="text-end">
                                                {{ number_format(($stat->total / max($totalTickets, 1)) * 100, 1) }}%
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-people"></i> Top 5 Pelapor Terbanyak
                </div>
                <div class="card-body">
                    @if(isset($topUsers) && $topUsers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th class="text-end">Jumlah Tiket</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topUsers as $user)
                                        <tr>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ $user->department ?? '-' }}</td>
                                            <td class="text-end">{{ $user->tickets_count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Harian/Mingguan -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-graph-up"></i> Tren Tiket 7 Hari Terakhir
        </div>
        <div class="card-body">
            <canvas id="dailyChart" height="150"></canvas>
        </div>
    </div>

    <!-- Statistik Bulanan -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-calendar-month"></i> Statistik Bulanan
        </div>
        <div class="card-body">
            @if(isset($monthlyStats) && $monthlyStats->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th class="text-end">Total Tiket</th>
                                <th class="text-end">Selesai</th>
                                <th class="text-end">Rate Resolusi</th>
                                <th class="text-end">Rata-rata Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyStats as $stat)
                                <tr>
                                    <td>{{ $stat->month_name }}</td>
                                    <td class="text-end">{{ $stat->total }}</td>
                                    <td class="text-end">{{ $stat->resolved }}</td>
                                    <td class="text-end">
                                        @php
                                            $rate = ($stat->total > 0) ? ($stat->resolved / $stat->total) * 100 : 0;
                                        @endphp
                                        <span class="badge bg-{{ $rate >= 70 ? 'success' : ($rate >= 40 ? 'warning' : 'danger') }}">
                                            {{ number_format($rate, 1) }}%
                                        </span>
                                    </td>
                                    <td class="text-end">{{ number_format($stat->avg_resolution_time ?? 0, 1) }} jam</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center">Belum ada data statistik bulanan</p>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Status Chart - Gunakan statusStatsAll
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Open', 'In Progress', 'Resolved', 'Closed'],
                    datasets: [{
                        data: [
                            {{ $statusStatsAll['open'] ?? 0 }},
                            {{ $statusStatsAll['in_progress'] ?? 0 }},
                            {{ $statusStatsAll['resolved'] ?? 0 }},
                            {{ $statusStatsAll['closed'] ?? 0 }}
                        ],
                        backgroundColor: ['#e74c3c', '#f39c12', '#27ae60', '#95a5a6'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Priority Chart - Gunakan priorityStatsAll
            const priorityCtx = document.getElementById('priorityChart').getContext('2d');
            new Chart(priorityCtx, {
                type: 'doughnut',
                data: {
                    labels: ['High', 'Medium', 'Low'],
                    datasets: [{
                        data: [
                            {{ $priorityStatsAll['high'] ?? 0 }},
                            {{ $priorityStatsAll['medium'] ?? 0 }},
                            {{ $priorityStatsAll['low'] ?? 0 }}
                        ],
                        backgroundColor: ['#e74c3c', '#f39c12', '#27ae60'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // Daily Chart
            const dailyCtx = document.getElementById('dailyChart').getContext('2d');
            new Chart(dailyCtx, {
                type: 'line',
                data: {
                    labels: @json($dailyLabels ?? []),
                    datasets: [
                        {
                            label: 'Total Tiket',
                            data: @json($dailyTotal ?? []),
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52,152,219,0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Terselesaikan',
                            data: @json($dailyResolved ?? []),
                            borderColor: '#27ae60',
                            backgroundColor: 'rgba(39,174,96,0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .stat-card {
                border: none;
                border-radius: 15px;
                overflow: hidden;
                position: relative;
                transition: transform 0.3s, box-shadow 0.3s;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            .stat-card .stat-icon {
                position: absolute;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 3rem;
                opacity: 0.2;
            }

            .stat-card .stat-value {
                font-size: 2rem;
                font-weight: 700;
                margin-bottom: 0;
            }

            .stat-card .stat-label {
                font-size: 0.85rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                opacity: 0.9;
            }

            @media print {

                .btn,
                .navbar,
                .sidebar,
                .card-header .btn,
                form {
                    display: none !important;
                }

                .sidebar {
                    display: none !important;
                }

                main {
                    margin-left: 0 !important;
                    padding: 0 !important;
                }

                .card {
                    break-inside: avoid;
                    page-break-inside: avoid;
                }
            }
        </style>
    @endpush
@endsection