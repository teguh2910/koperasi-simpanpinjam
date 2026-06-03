<?php $__env->startSection('title', 'Laporan - Admin'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Laporan</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-4 col-12">
            <a href="<?php echo e(route('admin.reports.members')); ?>" class="small-box bg-info">
                <div class="inner">
                    <h3>Anggota</h3>
                    <p>Laporan Data Anggota</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
        <div class="col-lg-4 col-12">
            <a href="<?php echo e(route('admin.reports.savings')); ?>" class="small-box bg-success">
                <div class="inner">
                    <h3>Simpanan</h3>
                    <p>Laporan Transaksi Simpanan</p>
                </div>
                <div class="icon"><i class="fas fa-piggy-bank"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
        <div class="col-lg-4 col-12">
            <a href="<?php echo e(route('admin.reports.loans')); ?>" class="small-box bg-warning">
                <div class="inner">
                    <h3>Pinjaman</h3>
                    <p>Laporan Data Pinjaman</p>
                </div>
                <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-12 offset-lg-2">
            <a href="<?php echo e(route('admin.reports.financial')); ?>" class="small-box bg-danger">
                <div class="inner">
                    <h3>Keuangan</h3>
                    <p>Rekap Keuangan</p>
                </div>
                <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
        <div class="col-lg-4 col-12">
            <a href="<?php echo e(route('admin.reports.pnl')); ?>" class="small-box bg-primary">
                <div class="inner">
                    <h3>Laba/Rugi</h3>
                    <p>Laporan Laba & Rugi (PnL)</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/reports/index.blade.php ENDPATH**/ ?>