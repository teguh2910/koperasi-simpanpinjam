<?php $__env->startSection('title', 'Kelola Anggota - Admin'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Kelola Anggota</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="members-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($member->name); ?></td>
                                <td><?php echo e($member->email); ?></td>
                                <td><?php echo e($member->phone ?? '-'); ?></td>
                                <td><?php echo e($member->created_at->format('d/m/Y')); ?></td>
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
    $('#members-table').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/members/index.blade.php ENDPATH**/ ?>