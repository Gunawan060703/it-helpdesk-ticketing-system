

<?php $__env->startSection('title', 'Detail Tiket #' . $ticket->ticket_number); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">
            <i class="bi bi-ticket-perforated"></i> Detail Tiket
            <small class="text-muted">#<?php echo e($ticket->ticket_number); ?></small>
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="<?php echo e(route('admin.tickets')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Ticket Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Informasi Tiket
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Nomor Tiket:</div>
                        <div class="col-md-9"><code><?php echo e($ticket->ticket_number); ?></code></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Pelapor:</div>
                        <div class="col-md-9">
                            <?php echo e($ticket->user->full_name); ?>

                            <?php if($ticket->user->department): ?>
                                <small class="text-muted">(<?php echo e($ticket->user->department); ?>)</small>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Judul Masalah:</div>
                        <div class="col-md-9"><?php echo e($ticket->title); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Kategori:</div>
                        <div class="col-md-9"><?php echo e($ticket->category->name); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Prioritas:</div>
                        <div class="col-md-9">
                            <span
                                class="badge bg-<?php echo e($ticket->priority == 'High' ? 'danger' : ($ticket->priority == 'Medium' ? 'warning' : 'success')); ?>">
                                <?php echo e($ticket->priority); ?>

                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            <span
                                class="badge bg-<?php echo e($ticket->status == 'Open' ? 'danger' : ($ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Resolved' ? 'success' : 'secondary'))); ?>">
                                <?php echo e($ticket->status); ?>

                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Tanggal Dibuat:</div>
                        <div class="col-md-9"><?php echo e($ticket->created_at->format('d F Y H:i')); ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Terakhir Update:</div>
                        <div class="col-md-9"><?php echo e($ticket->updated_at->format('d F Y H:i')); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 fw-bold">Deskripsi:</div>
                        <div class="col-md-9">
                            <div class="p-3 bg-light rounded">
                                <?php echo nl2br(e($ticket->description)); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Responses -->
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-chat-dots"></i> Riwayat Respon
                </div>
                <div class="card-body">
                    <?php if($ticket->responses->count() > 0): ?>
                        <div class="timeline">
                            <?php $__currentLoopData = $ticket->responses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $response): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="timeline-item">
                                    <div class="d-flex justify-content-between">
                                        <strong>
                                            <?php if($response->is_admin_response): ?>
                                                <i class="bi bi-shield-check text-primary"></i> IT Support -
                                                <?php echo e($response->user->full_name); ?>

                                            <?php else: ?>
                                                <i class="bi bi-person text-success"></i> <?php echo e($response->user->full_name); ?>

                                            <?php endif; ?>
                                        </strong>
                                        <small class="text-muted"><?php echo e($response->created_at->format('d F Y H:i')); ?></small>
                                    </div>
                                    <div class="mt-2 p-3 bg-light rounded">
                                        <?php echo nl2br(e($response->response)); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-chat-square-text fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada respon</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Update Status -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-pencil-square"></i> Update Status
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.ticket.update-status', $ticket->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label">Status Tiket</label>
                            <select name="status" class="form-select">
                                <option value="Open" <?php echo e($ticket->status == 'Open' ? 'selected' : ''); ?>>Open</option>
                                <option value="In Progress" <?php echo e($ticket->status == 'In Progress' ? 'selected' : ''); ?>>In
                                    Progress</option>
                                <option value="Resolved" <?php echo e($ticket->status == 'Resolved' ? 'selected' : ''); ?>>Resolved
                                </option>
                                <option value="Closed" <?php echo e($ticket->status == 'Closed' ? 'selected' : ''); ?>>Closed</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Add Response -->
            <?php if($ticket->status != 'Closed'): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="bi bi-reply"></i> Tambah Respon
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('admin.ticket.add-response', $ticket->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <textarea name="response" rows="5" class="form-control"
                                    placeholder="Tulis respon untuk pengguna..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-gradient w-100">
                                <i class="bi bi-send"></i> Kirim Respon
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Status Progress -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-clock-history"></i> Status Progress
                </div>
                <div class="card-body">
                    <div class="progress mb-3" style="height: 30px;">
                        <?php
                            $progress = 0;
                            if ($ticket->status == 'Open')
                                $progress = 25;
                            elseif ($ticket->status == 'In Progress')
                                $progress = 50;
                            elseif ($ticket->status == 'Resolved')
                                $progress = 75;
                            elseif ($ticket->status == 'Closed')
                                $progress = 100;
                        ?>
                        <div class="progress-bar progress-bar-striped bg-<?php echo e($ticket->status == 'Open' ? 'danger' : ($ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Resolved' ? 'success' : 'secondary'))); ?>"
                            style="width: <?php echo e($progress); ?>%">
                            <?php echo e($progress); ?>%
                        </div>
                    </div>

                    <div class="small text-muted mb-2">Langkah Penanganan:</div>
                    <div class="d-flex justify-content-between mb-2">
                        <div class="text-center" style="flex: 1;">
                            <i class="bi bi-circle-fill text-<?php echo e($ticket->status == 'Open' ? 'danger' : 'success'); ?>"></i>
                            <div>Open</div>
                        </div>
                        <div class="text-center" style="flex: 1;">
                            <i
                                class="bi bi-circle-fill text-<?php echo e($ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Open' ? 'secondary' : 'success')); ?>"></i>
                            <div>Progress</div>
                        </div>
                        <div class="text-center" style="flex: 1;">
                            <i
                                class="bi bi-circle-fill text-<?php echo e($ticket->status == 'Resolved' ? 'success' : ($ticket->status == 'Closed' ? 'success' : 'secondary')); ?>"></i>
                            <div>Resolved</div>
                        </div>
                        <div class="text-center" style="flex: 1;">
                            <i
                                class="bi bi-circle-fill text-<?php echo e($ticket->status == 'Closed' ? 'secondary' : 'secondary'); ?>"></i>
                            <div>Closed</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Logs -->
            <?php if($ticket->statusLogs->count() > 0): ?>
                <div class="card">
                    <div class="card-header">
                        <i class="bi bi-arrow-repeat"></i> Riwayat Perubahan Status
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $ticket->statusLogs->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between">
                                        <small>
                                            <?php if($log->old_status): ?>
                                                <?php echo e($log->old_status); ?> → <?php echo e($log->new_status); ?>

                                            <?php else: ?>
                                                <?php echo e($log->new_status); ?>

                                            <?php endif; ?>
                                        </small>
                                        <small class="text-muted"><?php echo e($log->created_at->format('d/m/Y H:i')); ?></small>
                                    </div>
                                    <div class="small text-muted">
                                        Oleh: <?php echo e($log->changer->full_name); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\it-helpdesk\resources\views/admin/ticket-detail.blade.php ENDPATH**/ ?>