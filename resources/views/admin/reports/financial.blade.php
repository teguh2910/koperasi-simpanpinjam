@extends('adminlte::page')

@section('title', 'Rekap Keuangan - Admin')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Rekap Keuangan</h1>
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
                                <a href="{{ route('admin.reports.financial') }}" class="btn btn-default">Reset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title text-white"><i class="fas fa-piggy-bank mr-2"></i>Simpanan</h3>
                </div>
                <table class="table table-striped mb-0">
                    <tr>
                        <th>Total Setoran</th>
                        <td class="text-right">Rp {{ number_format($recap->total_deposits, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Penarikan</th>
                        <td class="text-right">Rp {{ number_format($recap->total_withdrawals, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-{{ $recap->net_savings >= 0 ? 'success' : 'danger' }} text-white">
                        <th>Saldo Bersih Simpanan</th>
                        <td class="text-right">Rp {{ number_format($recap->net_savings, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning">
                    <h3 class="card-title text-white"><i class="fas fa-hand-holding-usd mr-2"></i>Pinjaman</h3>
                </div>
                <table class="table table-striped mb-0">
                    <tr>
                        <th>Total Dicairkan</th>
                        <td class="text-right">Rp {{ number_format($recap->total_loan_disbursed, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total Pembayaran</th>
                        <td class="text-right">Rp {{ number_format($recap->total_payments_collected, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="bg-warning">
                        <th>Sisa Pinjaman</th>
                        <td class="text-right">Rp {{ number_format($recap->total_outstanding, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info">
            <h3 class="card-title text-white"><i class="fas fa-chart-pie mr-2"></i>Ringkasan</h3>
        </div>
        <div class="table-responsive"><table class="table table-striped mb-0">
            <tr>
                <th style="width: 50%">Total Anggota</th>
                <td class="text-right">{{ $recap->total_members }} orang</td>
            </tr>
            <tr>
                <th>Pinjaman Aktif</th>
                <td class="text-right">{{ $recap->active_loans }} pinjaman</td>
            </tr>
            <tr class="bg-info text-white">
                <th>Dana Kelolaan (Simpanan + Piutang)</th>
                <td class="text-right">Rp {{ number_format($recap->net_savings + $recap->total_outstanding, 0, ',', '.') }}</td>
            </tr>
        </table></div>
    </div>
@stop
