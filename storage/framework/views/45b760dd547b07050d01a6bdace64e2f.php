<?php $__env->startSection('title', 'SHU - Admin'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Sisa Hasil Usaha (SHU)</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="mb-3">
        <a href="<?php echo e(route('admin.shu.create')); ?>" class="btn btn-primary"><i class="fas fa-plus-circle mr-1"></i>Buat Periode SHU Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
            <table id="shu-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Tanggal</th>
                        <th>Laba</th>
                        <th>SHU Anggota</th>
                        <th>Dibagikan</th>
                        <th>Anggota</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($p->name); ?></td>
                            <td><?php echo e($p->period_start->format('d/m/Y')); ?> - <?php echo e($p->period_end->format('d/m/Y')); ?></td>
                            <td>Rp <?php echo e(number_format($p->total_profit, 0, ',', '.')); ?></td>
                            <td><?php echo e($p->member_share_percent); ?>%</td>
                            <td>Rp <?php echo e(number_format($p->total_shu, 0, ',', '.')); ?></td>
                            <td><?php echo e($p->members_count); ?></td>
                            <td>
                                <span class="badge bg-<?php echo e($p->status == 'completed' ? 'success' : 'warning'); ?>">
                                    <?php echo e($p->status == 'completed' ? 'Selesai' : 'Draft'); ?>

                                </span>
                            </td>
                            <td>
                                <a href="<?php echo e(route('admin.shu.show', $p)); ?>" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <form method="POST" action="<?php echo e(route('admin.shu.destroy', $p)); ?>" class="d-inline" onsubmit="return confirm('Hapus periode SHU ini?')">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
    $('#shu-table').DataTable({
        responsive: true, autoWidth: false, order: [[0, 'desc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/shu/index.blade.php ENDPATH**/ ?>