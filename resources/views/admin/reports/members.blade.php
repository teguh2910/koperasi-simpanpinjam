@extends('adminlte::page')

@section('title', 'Laporan Anggota - Admin')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Laporan Anggota</h1>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
</div>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-info"><div class="inner"><h3>{{ $totals->members }}</h3><p>Total Anggota</p></div><div class="icon"><i class="fas fa-users"></i></div></div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success"><div class="inner"><h3>Rp {{ number_format($totals->savings, 0, ',', '.') }}</h3><p>Total Simpanan</p></div><div class="icon"><i class="fas fa-piggy-bank"></i></div></div>
        </div>
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning"><div class="inner"><h3>Rp {{ number_format($totals->loans, 0, ',', '.') }}</h3><p>Total Pinjaman Aktif</p></div><div class="icon"><i class="fas fa-hand-holding-usd"></i></div></div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="GET" class="mb-3">
                <div class="input-group" style="max-width: 300px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari anggota..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <table id="members-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Total Simpanan</th>
                        <th>Pinjaman Aktif</th>
                        <th>Jumlah Pinjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $m)
                        <tr>
                            <td>{{ $m->name }}</td>
                            <td>{{ $m->email }}</td>
                            <td>{{ $m->phone ?? '-' }}</td>
                            <td>Rp {{ number_format($m->total_savings, 0, ',', '.') }}</td>
                            <td>{{ $m->loan_count }}</td>
                            <td>Rp {{ number_format($m->active_loans, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@push('js')
<script>
    $('#members-table').DataTable({
        responsive: true, autoWidth: false, order: [[0, 'asc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
