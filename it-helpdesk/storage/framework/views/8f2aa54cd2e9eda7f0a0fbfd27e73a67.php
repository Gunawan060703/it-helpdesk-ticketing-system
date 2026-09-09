

<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-primary-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-ticket-perforated"></i>
                </div>
                <div class="stat-value"><?php echo e($totalTickets); ?></div>
                <div class="stat-label">Total Tiket</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-danger-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-hourglass-top"></i>
                </div>
                <div class="stat-value"><?php echo e($openTickets); ?></div>
                <div class="stat-label">Open</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-warning-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <div class="stat-value"><?php echo e($inProgressTickets); ?></div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-success-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-value"><?php echo e($resolvedTickets); ?></div>
                <div class="stat-label">Resolved</div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-secondary-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-archive"></i>
                </div>
                <div class="stat-value"><?php echo e($closedTickets); ?></div>
                <div class="stat-label">Closed</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-info-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-value"><?php echo e($totalUsers); ?></div>
                <div class="stat-label">Total Users</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-success-gradient text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stat-value"><?php echo e($activeUsers); ?></div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card stat-card bg-dark text-white">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div class="stat-value"><?php echo e(number_format(($resolvedTickets / max($totalTickets, 1)) * 100, 1)); ?>%</div>
                <div class="stat-label">Resolution Rate</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row - Pie Chart Diperkecil -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-pie-chart"></i> Prioritas Tiket
            </div>
            <div class="card-body text-center">
                <div style="max-width: 250px; margin: 0 auto;">
                    <canvas id="priorityChart" height="200" width="200"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-bar-chart"></i> Statistik 7 Hari Terakhir
            </div>
            <div class="card-body">
                <canvas id="dailyChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="card">
    <div class="card-header">
        <i class="bi bi-clock-history"></i> Tiket Terbaru
    </div>
    <div class="card-body">
        <?php if($recentTickets->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No. Tiket</th>
                        <th>Pelapor</th>
                        <th>Judul</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recentTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><code class="ticket-number"><?php echo e($ticket->ticket_number); ?></code></td>
                        <td><?php echo e($ticket->user->full_name); ?></td>
                        <td><?php echo e(Str::limit($ticket->title, 50)); ?></td>
                        <td>
                            <span class="badge bg-<?php echo e($ticket->priority_color); ?>">
                                <?php echo e($ticket->priority); ?>

                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?php echo e($ticket->status_color); ?>">
                                <?php echo e($ticket->status); ?>

                            </span>
                        </td>
                        <td><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></td>
                        <td>
                            <a href="<?php echo e(route('admin.ticket.detail', $ticket->id)); ?>"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-2">Belum ada tiket</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Priority Chart - Ukuran kecil
    const priorityCtx = document.getElementById('priorityChart').getContext('2d');
    new Chart(priorityCtx, {
        type: 'doughnut',
        data: {
            labels: ['High', 'Medium', 'Low'],
            datasets: [{
                data: [
                    <?php echo e($priorityStats['High'] ?? 0); ?>,
                    <?php echo e($priorityStats['Medium'] ?? 0); ?>,
                    <?php echo e($priorityStats['Low'] ?? 0); ?>

                ],
                backgroundColor: ['#e74c3c', '#f39c12', '#27ae60'],
                borderWidth: 0,
                borderRadius: 5,
                spacing: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 11
                        },
                        padding: 10,
                        boxWidth: 10,
                        boxHeight: 10
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 10,
                    left: 10,
                    right: 10
                }
            }
        }
    });

    // Daily Chart
    <?php if($dailyStats->count() > 0): ?>
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dailyStats->pluck('date')->map(function($date) { return date('d/m', strtotime($date)); })->toArray()); ?>,
            datasets: [{
                    label: 'Total Tiket',
                    data: <?php echo json_encode($dailyStats->pluck('total')->toArray()); ?>,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52,152,219,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#3498db',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Resolved',
                    data: <?php echo json_encode($dailyStats->pluck('resolved')->toArray()); ?>,
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39,174,96,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#27ae60',
                    pointBorderColor: '#fff',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 11
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    <?php endif; ?>
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\it-helpdesk\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>