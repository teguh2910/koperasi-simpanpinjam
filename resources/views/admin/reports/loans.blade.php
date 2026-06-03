@extends('adminlte::page')

@section('title', 'Laporan Pinjaman - Admin')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Laporan Data Pinjaman</h1>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
</div>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col-lg-3 col-12">
            <div class="small-box bg-info"><div class="inner"><h3>{{ $totals->count }}</h3><p>Total Pinjaman</p></div><div class="icon"><i class="fas fa-file-invoice"></i></div></div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="small-box bg-primary"><div class="inner"><h3>Rp {{ number_format($totals->disbursed, 0, ',', '.') }}</h3><p>Total Dicairkan</p></div><div class="icon"><i class="fas fa-money-bill-wave"></i></div></div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="small-box bg-success"><div class="inner"><h3>Rp {{ number_format($totals->paid, 0, ',', '.') }}</h3><p>Total Terbayar</p></div><div class="icon"><i class="fas fa-check-circle"></i></div></div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="small-box bg-warning"><div class="inner"><h3>Rp {{ number_format($totals->outstanding, 0, ',', '.') }}</h3><p>Sisa Pinjaman</p></div><div class="icon"><i class="fas fa-hourglass-half"></i></div></div>
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
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">Semua</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                <option value="disbursed" {{ request('status') == 'disbursed' ? 'selected' : '' }}>Dicairkan</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Lunas</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary"><i class="fas fa-filter mr-1"></i>Filter</button>
                <a href="{{ route('admin.reports.loans') }}" class="btn btn-default">Reset</a>
            </form>
            <div class="table-responsive"><table id="loans-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Anggota</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Tenor</th>
                        <th>Total</th>
                        <th>Terbayar</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Tanggal Cair</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loans as $l)
                        <tr>
                            <td>{{ $l->id }}</td>
                            <td>{{ $l->member }}</td>
                            <td>{{ $l->type }}</td>
                            <td>Rp {{ number_format($l->amount, 0, ',', '.') }}</td>
                            <td>{{ $l->tenure }} bln</td>
                            <td>Rp {{ number_format($l->total_payment, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($l->paid, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($l->outstanding, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $l->status == 'approved' ? 'info' : 
                                    ($l->status == 'disbursed' ? 'success' : 
                                    ($l->status == 'completed' ? 'primary' :
                                    ($l->status == 'rejected' ? 'danger' : 'warning'))) 
                                }}">
                                    {{ ucfirst($l->status) }}
                                </span>
                            </td>
                            <td>{{ $l->disbursed_at ? $l->disbursed_at->format('d/m/Y') : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table></div>
        </div>
    </div>
@stop

@push('js')
<script>
    $('#loans-table').DataTable({
        responsive: true, autoWidth: false, order: [[0, 'desc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
