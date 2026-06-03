@extends('adminlte::page')

@section('title', 'Dashboard - Koperasi Simpan Pinjam')

@section('content_header')
<h1>Dashboard</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($totalBalance, 0, ',', '.') }}</h3>
                    <p>Total Simpanan Anda</p>
                </div>
                <div class="icon">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <a href="{{ route('member.savings.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp {{ number_format($activeLoans, 0, ',', '.') }}</h3>
                    <p>Sisa Pinjaman</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="{{ route('member.loans.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Rp {{ number_format($totalSHU, 0, ',', '.') }}</h3>
                    <p>Total SHU Anda</p>
                </div>
                <div class="icon">
                    <i class="fas fa-gift"></i>
                </div>
                <a href="{{ route('member.shu.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('member.savings.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> Tambah Simpanan</a>
            <a href="{{ route('member.loans.create') }}" class="btn btn-success"><i class="fas fa-plus-circle"></i> Ajukan Pinjaman</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-piggy-bank mr-2"></i>Simpanan Anda</h3>
            <div class="card-tools">
                <a href="{{ route('member.savings.index') }}" class="btn btn-tool"><i class="fas fa-external-link-alt"></i></a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive"><table id="dashboard-savings-table" class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Jenis</th>
                        <th>Saldo</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($savings as $saving)
                        <tr>
                            <td>{{ ucfirst($saving->type) }}</td>
                            <td>Rp {{ number_format($saving->balance, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ $saving->status == 'active' ? 'success' : 'danger' }}">
                                    {{ ucfirst($saving->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table></div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-hand-holding-usd mr-2"></i>Pinjaman Anda</h3>
            <div class="card-tools">
                <a href="{{ route('member.loans.index') }}" class="btn btn-tool"><i class="fas fa-external-link-alt"></i></a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive"><table id="dashboard-loans-table" class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Jumlah</th>
                        <th>Bunga</th>
                        <th>Tenor</th>
                        <th>Cicilan/Bulan</th>
                        <th>Sisa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $loan)
                        <tr>
                            <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                            <td>{{ $loan->interest_rate }}%</td>
                            <td>{{ $loan->tenure }} bulan</td>
                            <td>Rp {{ number_format($loan->monthly_payment, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($loan->outstanding_balance, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $loan->status == 'approved' ? 'info' : 
                                    ($loan->status == 'disbursed' ? 'success' : 
                                    ($loan->status == 'rejected' ? 'danger' : 'warning')) 
                                }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table></div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-gift mr-2"></i>Riwayat SHU</h3>
            <div class="card-tools">
                <a href="{{ route('member.shu.index') }}" class="btn btn-tool"><i class="fas fa-external-link-alt"></i></a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive"><table id="dashboard-shu-table" class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Simpanan</th>
                        <th>Bunga Dibayar</th>
                        <th>Kontribusi</th>
                        <th>SHU Diterima</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($shuRecords as $shu)
                        <tr>
                            <td>{{ $shu->period->name }}</td>
                            <td>Rp {{ number_format($shu->savings_balance, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($shu->loan_interest_paid, 0, ',', '.') }}</td>
                            <td>{{ number_format($shu->savings_percent + $shu->loan_percent, 2) }}%</td>
                            <td><strong>Rp {{ number_format($shu->shu_amount, 0, ',', '.') }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada SHU</td>
                        </tr>
                    @endforelse
                </tbody>
            </table></div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $('#dashboard-savings-table').DataTable({
        responsive: true, autoWidth: false, paging: false, searching: false, info: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
    $('#dashboard-loans-table').DataTable({
        responsive: true, autoWidth: false, paging: false, searching: false, info: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
    $('#dashboard-shu-table').DataTable({
        responsive: true, autoWidth: false, paging: false, searching: false, info: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
