@extends('adminlte::page')

@section('title', 'Dashboard Admin - Koperasi Simpan Pinjam')

@section('content_header')
<h1>Dashboard Admin</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-12">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ number_format($totalMembers) }}</h3>
                    <p>Total Anggota</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.members.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($totalSavings, 0, ',', '.') }}</h3>
                    <p>Total Simpanan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-piggy-bank"></i>
                </div>
                <a href="{{ route('admin.savings.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp {{ number_format($totalLoans, 0, ',', '.') }}</h3>
                    <p>Total Pinjaman</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="{{ route('admin.loans.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($pendingLoans) }}</h3>
                    <p>Pinjaman Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
                <a href="{{ route('admin.loans.index') }}" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@stop
