@extends('adminlte::page')

@section('title', 'Koperasi Simpan Pinjam')

@section('content_header')
@stop

@push('css')
<style>
    .main-sidebar, .nav-header, .brand-link { display: none !important; }
    .main-header { display: none !important; }
    .content-wrapper { margin-left: 0 !important; margin-top: 0 !important; }
    .content-header { display: none !important; }
</style>
@endpush

@section('content')
    <div class="jumbotron-fluid bg-primary text-white p-5 rounded mb-4">
        <div class="text-center py-5">
            <h1 class="display-4 font-weight-bold">Koperasi Simpan Pinjam</h1>
            <p class="lead mt-3">Solusi keuangan terpercaya untuk anggota koperasi</p>
            <hr class="my-4 bg-light" style="height:2px;max-width:200px;margin:auto;">
            <p class="mb-4">Bergabunglah bersama kami untuk meraih kemandirian finansial</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 mr-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Daftar Anggota</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-piggy-bank"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Simpanan Wajib</span>
                    <span class="info-box-number">Simpanan pokok yang wajib disetor setiap bulan</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pinjaman</span>
                    <span class="info-box-number">Ajukan pinjaman dengan bunga rendah dan cicilan terjangkau</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Simpanan Sukarela</span>
                    <span class="info-box-number">Simpan sesuai dengan keinginan dan kemampuan Anda</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shield-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Aman & Terpercaya</span>
                    <span class="info-box-number">Dikelola secara profesional dan transparan</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Bunga Kompetitif</span>
                    <span class="info-box-number">Nikmati bunga simpanan yang menguntungkan</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="info-box">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kebersamaan</span>
                    <span class="info-box-number">Gotong royong untuk kesejahteraan bersama</span>
                </div>
            </div>
        </div>
    </div>

    <div class="callout callout-info text-center">
        <h5><i class="fas fa-info-circle"></i> Tentang Koperasi</h5>
        <p class="mb-0">Koperasi Simpan Pinjam adalah lembaga keuangan mikro yang bergerak di bidang simpan pinjam untuk membantu anggota mencapai kesejahteraan finansial melalui produk simpanan dan pinjaman yang terjangkau.</p>
    </div>
@stop