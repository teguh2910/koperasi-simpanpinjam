@extends('adminlte::page')

@section('title', 'Laporan Simpanan - Admin')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Laporan Transaksi Simpanan</h1>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
</div>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success"><div class="inner"><h3>Rp {{ number_format($totals->deposits, 0, ',', '.') }}</h3><p>Total Setoran</p></div><div class="icon"><i class="fas fa-arrow-down"></i></div></div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-danger"><div class="inner"><h3>Rp {{ number_format($totals->withdrawals, 0, ',', '.') }}</h3><p>Total Penarikan</p></div><div class="icon"><i class="fas fa-arrow-up"></i></div></div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info"><div class="inner"><h3>{{ $totals->count }}</h3><p>Jumlah Transaksi</p></div><div class="icon"><i class="fas fa-exchange-alt"></i></div></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Dari Tanggal</label>
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Anggota</label>
                            <select name="member_id" class="form-control">
                                <option value="">Semua</option>
                                @foreach($members as $m)
                                    <option value="{{ $m->id }}" {{ request('member_id') == $m->id ? 'selected' : '' }}>{{ $m->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tipe</label>
                            <select name="type" class="form-control">
                                <option value="">Semua</option>
                                <option value="deposit" {{ request('type') == 'deposit' ? 'selected' : '' }}>Setoran</option>
                                <option value="withdrawal" {{ request('type') == 'withdrawal' ? 'selected' : '' }}>Penarikan</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary"><i class="fas fa-filter mr-1"></i>Filter</button>
                <a href="{{ route('admin.reports.savings') }}" class="btn btn-default">Reset</a>
            </form>
            <table id="savings-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Anggota</th>
                        <th>Tipe</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $t)
                        <tr>
                            <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ optional($t->savingAccount->user)->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $t->type == 'deposit' ? 'success' : 'danger' }}">
                                    {{ $t->type == 'deposit' ? 'Setoran' : 'Penarikan' }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($t->amount, 0, ',', '.') }}</td>
                            <td>{{ $t->description ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@push('js')
<script>
    $('#savings-table').DataTable({
        responsive: true, autoWidth: false, order: [[0, 'desc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
