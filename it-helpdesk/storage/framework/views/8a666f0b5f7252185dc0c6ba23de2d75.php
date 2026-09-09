

<?php $__env->startSection('title', 'Edit Tiket #' . $ticket->ticket_number); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">
            <i class="bi bi-pencil-square"></i> Edit Tiket
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
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Form Edit Tiket
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.ticket.update', $ticket->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-3">
                            <label class="form-label">Nomor Tiket</label>
                            <input type="text" class="form-control" value="<?php echo e($ticket->ticket_number); ?>" readonly disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pelapor</label>
                            <input type="text" class="form-control" value="<?php echo e($ticket->user->full_name); ?>" readonly
                                disabled>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e(old('category_id', $ticket->category_id) == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Masalah <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('title', $ticket->title)); ?>" required>
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Masalah <span
                                    class="text-danger">*</span></label>
                            <textarea name="description" rows="5"
                                class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required><?php echo e(old('description', $ticket->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="priority" class="form-label">Prioritas <span
                                        class="text-danger">*</span></label>
                                <select name="priority" class="form-select <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    required>
                                    <option value="Low" <?php echo e(old('priority', $ticket->priority) == 'Low' ? 'selected' : ''); ?>>
                                        Low</option>
                                    <option value="Medium" <?php echo e(old('priority', $ticket->priority) == 'Medium' ? 'selected' : ''); ?>>Medium</option>
                                    <option value="High" <?php echo e(old('priority', $ticket->priority) == 'High' ? 'selected' : ''); ?>>
                                        High</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="Open" <?php echo e(old('status', $ticket->status) == 'Open' ? 'selected' : ''); ?>>Open
                                    </option>
                                    <option value="In Progress" <?php echo e(old('status', $ticket->status) == 'In Progress' ? 'selected' : ''); ?>>In Progress</option>
                                    <option value="Resolved" <?php echo e(old('status', $ticket->status) == 'Resolved' ? 'selected' : ''); ?>>Resolved</option>
                                    <option value="Closed" <?php echo e(old('status', $ticket->status) == 'Closed' ? 'selected' : ''); ?>>
                                        Closed</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('admin.tickets')); ?>" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Informasi</div>
                <div class="card-body">
                    <p><strong>Dibuat:</strong> <?php echo e($ticket->created_at->format('d F Y H:i')); ?></p>
                    <p><strong>Update:</strong> <?php echo e($ticket->updated_at->format('d F Y H:i')); ?></p>
                    <?php if($ticket->completed_at): ?>
                    <p><strong>Selesai:</strong> <?php echo e($ticket->completed_at->format('d F Y H:i')); ?></p><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\it-helpdesk\resources\views/admin/edit-ticket.blade.php ENDPATH**/ ?>