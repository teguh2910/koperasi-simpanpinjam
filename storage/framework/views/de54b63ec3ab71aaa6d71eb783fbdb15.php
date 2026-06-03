<?php $__env->startSection('title', 'Dashboard Admin - Koperasi Simpan Pinjam'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Dashboard Admin</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3><?php echo e(number_format($totalMembers)); ?></h3>
                    <p>Total Anggota</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="<?php echo e(route('admin.members.index')); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp <?php echo e(number_format($totalSavings, 0, ',', '.')); ?></h3>
                    <p>Total Simpanan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <a href="<?php echo e(route('admin.savings.index')); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp <?php echo e(number_format($totalLoans, 0, ',', '.')); ?></h3>
                    <p>Total Pinjaman</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="<?php echo e(route('admin.loans.index')); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3><?php echo e(number_format($pendingLoans)); ?></h3>
                    <p>Pinjaman Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="<?php echo e(route('admin.loans.index')); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>