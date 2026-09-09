


<?php $__env->startSection('title', 'Semua Tiket'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">
            <i class="bi bi-ticket-perforated"></i> Semua Tiket
        </h1>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-funnel"></i> Filter Tiket
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                                <?php echo e($status); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Prioritas</label>
                    <select name="priority" class="form-select">
                        <option value="">Semua Prioritas</option>
                        <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($priority); ?>" <?php echo e(request('priority') == $priority ? 'selected' : ''); ?>>
                                <?php echo e($priority); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100 me-2">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="<?php echo e(route('admin.tickets')); ?>" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-repeat"></i> Reset
                    </a>
                </div>
            </form>

            <div class="row mt-3">
                <div class="col-md-6">
                    <form method="GET" class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari nomor tiket, judul, atau nama pelapor..." value="<?php echo e(request('search')); ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <div class="card">
        <div class="card-body">
            <?php if($tickets->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No. Tiket</th>
                                <th>Pelapor</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><code class="ticket-number"><?php echo e($ticket->ticket_number); ?></code></td>
                                    <td>
                                        <div><?php echo e($ticket->user->full_name); ?></div>
                                        <small class="text-muted"><?php echo e($ticket->user->department ?? '-'); ?></small>
                                    </td>
                                    <td><?php echo e(Str::limit($ticket->title, 40)); ?></td>
                                    <td><span class="badge bg-info"><?php echo e($ticket->category->name); ?></span></td>
                                    <td>
                                        <span
                                            class="badge bg-<?php echo e($ticket->priority == 'High' ? 'danger' : ($ticket->priority == 'Medium' ? 'warning' : 'success')); ?>">
                                            <?php echo e($ticket->priority); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-<?php echo e($ticket->status == 'Open' ? 'danger' : ($ticket->status == 'In Progress' ? 'warning' : ($ticket->status == 'Resolved' ? 'success' : 'secondary'))); ?>">
                                            <?php echo e($ticket->status); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($ticket->created_at->format('d/m/Y H:i')); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.ticket.detail', $ticket->id)); ?>"
                                                class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.ticket.edit', $ticket->id)); ?>"
                                                class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="<?php echo e(route('admin.ticket.delete', $ticket->id)); ?>" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus tiket <?php echo e($ticket->ticket_number); ?>?')">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                                    title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <?php echo e($tickets->withQueryString()->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2">Tidak ada tiket ditemukan</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\it-helpdesk\resources\views/admin/tickets.blade.php ENDPATH**/ ?>