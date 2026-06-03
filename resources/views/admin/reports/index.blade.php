@extends('adminlte::page')

@section('title', 'Laporan - Admin')

@section('content_header')
<h1>Laporan</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4 col-12">
            <a href="{{ route('admin.reports.members') }}" class="small-box bg-info">
                <div class="inner">
                    <h3>Anggota</h3>
                    <p>Laporan Data Anggota</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
        <div class="col-lg-4 col-12">
            <a href="{{ route('admin.reports.savings') }}" class="small-box bg-success">
                <div class="inner">
                    <h3>Simpanan</h3>
                    <p>Laporan Transaksi Simpanan</p>
                </div>
                <div class="icon"><i class="fas fa-piggy-bank"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
        <div class="col-lg-4 col-12">
            <a href="{{ route('admin.reports.loans') }}" class="small-box bg-warning">
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
            <a href="{{ route('admin.reports.financial') }}" class="small-box bg-danger">
                <div class="inner">
                    <h3>Keuangan</h3>
                    <p>Rekap Keuangan</p>
                </div>
                <div class="icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
        <div class="col-lg-4 col-12">
            <a href="{{ route('admin.reports.pnl') }}" class="small-box bg-primary">
                <div class="inner">
                    <h3>Laba/Rugi</h3>
                    <p>Laporan Laba & Rugi (PnL)</p>
                </div>
                <div class="icon"><i class="fas fa-chart-line"></i></div>
                <div class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></div>
            </a>
        </div>
    </div>
@stop
