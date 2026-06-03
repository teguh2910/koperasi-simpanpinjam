@extends('adminlte::page')

@section('title', 'Laporan Laba/Rugi - Admin')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Laporan Laba / Rugi (PnL)</h1>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
</div>
@stop

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Dari Tanggal</label>
                            <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sampai Tanggal</label>
                            <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button class="btn btn-primary"><i class="fas fa-filter mr-1"></i>Filter</button>
                                <a href="{{ route('admin.reports.pnl') }}" class="btn btn-default">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title text-white"><i class="fas fa-arrow-down mr-2"></i>Pendapatan</h3>
                </div>
                <table class="table table-striped mb-0">
                    <tr>
                        <th>Bunga Pinjaman</th>
                        <td class="text-right">Rp {{ number_format($report->total_interest, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Pokok Pinjaman</th>
                        <td class="text-right">Rp {{ number_format($report->total_principal, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-success text-white">
                        <th>Total Pendapatan</th>
                        <td class="text-right">Rp {{ number_format($report->total_revenue, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title text-white"><i class="fas fa-arrow-up mr-2"></i>Beban</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.expenses.index') }}" class="btn btn-tool text-white" title="Kelola Beban"><i class="fas fa-cog"></i></a>
                    </div>
                </div>
                <table class="table table-striped mb-0">
                    @forelse($expenses as $e)
                        <tr>
                            <td>{{ $e->expense_date->format('d/m/Y') }}</td>
                            <td>{{ $e->description }}</td>
                            <td class="text-right">Rp {{ number_format($e->amount, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-muted text-center">Belum ada data beban</td>
                        </tr>
                    @endforelse
                    <tr class="bg-danger text-white">
                        <th colspan="2">Total Beban</th>
                        <th class="text-right">Rp {{ number_format($report->expenses, 0, ',', '.') }}</th>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-{{ $report->net_profit >= 0 ? 'success' : 'danger' }}">
                    <h3 class="card-title text-white"><i class="fas fa-chart-line mr-2"></i>Laba / Rugi Bersih</h3>
                </div>
                <table class="table mb-0">
                    <tr>
                        <th>Total Pendapatan</th>
                        <td class="text-right">Rp {{ number_format($report->total_revenue, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Beban</th>
                        <td class="text-right">Rp {{ number_format($report->expenses, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-{{ $report->net_profit >= 0 ? 'success' : 'danger' }} text-white">
                        <th style="font-size: 1.1em">
                            {{ $report->net_profit >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}
                        </th>
                        <td class="text-right" style="font-size: 1.1em">
                            Rp {{ number_format(abs($report->net_profit), 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    @if($daily->count())
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar-day mr-2"></i>Rincian Harian</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive"><table id="daily-table" class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Bunga</th>
                        <th>Pokok</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daily as $d)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($d->date)->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($d->interest, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($d->principal, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($d->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table></div>
        </div>
    </div>
    @endif
@stop

@push('js')
<script>
    $('#daily-table').DataTable({
        responsive: true, autoWidth: false, paging: false, searching: false, info: false,
        order: [[0, 'asc']],
        language: { url: '{{ asset('vendor/datatables/Indonesian.json') }}' }
    });
</script>
@endpush
