<?php $__env->startSection('title', 'Detail SHU - Admin'); ?>

<?php $__env->startSection('content_header'); ?>
<div class="d-flex justify-content-between">
    <h1>Detail SHU: <?php echo e($shuPeriod->name); ?></h1>
    <div>
        <span class="badge bg-<?php echo e($shuPeriod->status === 'completed' ? 'success' : 'warning'); ?> mr-2" style="font-size:14px">
            <?php echo e($shuPeriod->status === 'completed' ? 'Selesai' : 'Draft'); ?>

        </span>
        <a href="<?php echo e(route('admin.shu.index')); ?>" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Periode</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Nama Periode:</strong>
                            <p class="text-muted"><?php echo e($shuPeriod->name); ?></p>
                        </div>
                        <div class="col-md-3">
                            <strong>Tanggal Mulai:</strong>
                            <p class="text-muted"><?php echo e($shuPeriod->period_start->format('d/m/Y')); ?></p>
                        </div>
                        <div class="col-md-3">
                            <strong>Tanggal Selesai:</strong>
                            <p class="text-muted"><?php echo e($shuPeriod->period_end->format('d/m/Y')); ?></p>
                        </div>
                        <div class="col-md-3">
                            <strong>Jumlah Anggota:</strong>
                            <p class="text-muted"><?php echo e($membersCount); ?> orang (<?php echo e($shuMembersCount); ?> penerima SHU)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Laporan Laba Rugi</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>Rp <?php echo e(number_format($interestIncome, 0, ',', '.')); ?></h3>
                                    <p>Pendapatan Bunga</p>
                                </div>
                                <div class="icon"><i class="fas fa-coins"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>Rp <?php echo e(number_format($totalExpenses, 0, ',', '.')); ?></h3>
                                    <p>Total Beban</p>
                                </div>
                                <div class="icon"><i class="fas fa-receipt"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>Rp <?php echo e(number_format($interestIncome - $totalExpenses, 0, ',', '.')); ?></h3>
                                    <p>Laba Bersih</p>
                                </div>
                                <div class="icon"><i class="fas fa-chart-line"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-hand-holding-usd mr-2"></i>Alokasi SHU</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>Rp <?php echo e(number_format($shuPeriod->total_profit, 0, ',', '.')); ?></h3>
                                    <p>Laba Bersih (Input)</p>
                                </div>
                                <div class="icon"><i class="fas fa-calculator"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3><?php echo e($shuPeriod->member_share_percent); ?>%</h3>
                                    <p>Bagian Anggota</p>
                                </div>
                                <div class="icon"><i class="fas fa-percentage"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>Rp <?php echo e(number_format($shuPeriod->total_shu, 0, ',', '.')); ?></h3>
                                    <p>SHU Dibagikan</p>
                                </div>
                                <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-secondary">
                                <div class="inner">
                                    <h3>Rp <?php echo e(number_format($retainedEarnings, 0, ',', '.')); ?></h3>
                                    <p>Laba Ditahan (<?php echo e(100 - $shuPeriod->member_share_percent); ?>%)</p>
                                </div>
                                <div class="icon"><i class="fas fa-piggy-bank"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="callout callout-info mt-3">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Bobot Simpanan:</strong>
                                <span class="badge bg-primary"><?php echo e($shuPeriod->savings_weight); ?>%</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Bobot Pinjaman:</strong>
                                <span class="badge bg-primary"><?php echo e($shuPeriod->loan_weight); ?>%</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Total Simpanan Aktif:</strong>
                                <span class="text-muted">Rp <?php echo e(number_format($totalSavings, 0, ',', '.')); ?></span>
                            </div>
                            <div class="col-md-3">
                                <strong>Total Pencairan Pinjaman:</strong>
                                <span class="text-muted">Rp <?php echo e(number_format($loanDisbursed, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-users mr-2"></i>SHU per Anggota</h3>
            <div class="card-tools">
                <span class="badge bg-warning">Total Dibagikan: Rp <?php echo e(number_format($totalDistributed, 0, ',', '.')); ?></span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table id="shu-members-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Anggota</th>
                        <th>Saldo Simpanan</th>
                        <th>% Simpanan</th>
                        <th>Bunga Dibayar</th>
                        <th>% Pinjaman</th>
                        <th>SHU Simpanan</th>
                        <th>SHU Pinjaman</th>
                        <th>Total SHU</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $shuPeriod->members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($m->user->name); ?></td>
                            <td>Rp <?php echo e(number_format($m->savings_balance, 0, ',', '.')); ?></td>
                            <td><?php echo e(number_format($m->savings_percent, 2)); ?>%</td>
                            <td>Rp <?php echo e(number_format($m->loan_interest_paid, 0, ',', '.')); ?></td>
                            <td><?php echo e(number_format($m->loan_percent, 2)); ?>%</td>
                            <td>Rp <?php echo e(number_format($shuPeriod->total_shu * ($shuPeriod->savings_weight / 100) * ($m->savings_percent / 100), 0, ',', '.')); ?></td>
                            <td>Rp <?php echo e(number_format($shuPeriod->total_shu * ($shuPeriod->loan_weight / 100) * ($m->loan_percent / 100), 0, ',', '.')); ?></td>
                            <td><strong>Rp <?php echo e(number_format($m->shu_amount, 0, ',', '.')); ?></strong></td>
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
    $('#shu-members-table').DataTable({
        responsive: true, autoWidth: false, order: [[7, 'desc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/admin/shu/show.blade.php ENDPATH**/ ?>