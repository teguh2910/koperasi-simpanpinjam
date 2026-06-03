@extends('adminlte::page')

@section('title', 'Detail Pinjaman - Admin')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Detail Pinjaman #{{ $loan->id }}</h1>
    <a href="{{ route('admin.loans.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
</div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informasi Pinjaman</h3>
                </div>
                <table class="table table-striped mb-0">
                    <tr>
                        <th style="width: 40%">Anggota</th>
                        <td>{{ $loan->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Jenis</th>
                        <td>{{ optional($loan->loanType)->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Bunga</th>
                        <td>{{ $loan->interest_rate }}%</td>
                    </tr>
                    <tr>
                        <th>Tenor</th>
                        <td>{{ $loan->tenure }} bulan</td>
                    </tr>
                    <tr>
                        <th>Cicilan/Bulan</th>
                        <td>Rp {{ number_format($loan->monthly_payment, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>Rp {{ number_format($loan->total_payment, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Sisa</th>
                        <td>Rp {{ number_format($loan->outstanding_balance, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
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
                    <tr>
                        <th>Tanggal Cair</th>
                        <td>{{ $loan->disbursed_at ? $loan->disbursed_at->format('d/m/Y') : '-' }}</td>
                    </tr>
                </table>
            </div>

            @if($loan->status == 'disbursed' || $loan->status == 'completed')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plus-circle mr-2"></i>Catat Pembayaran</h3>
                    </div>
                    <form method="POST" action="{{ route('admin.loans.payments.store', $loan) }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="payment_date">Tanggal Bayar</label>
                                <input type="date" class="form-control @error('payment_date') is-invalid @enderror" id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                                @error('payment_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label for="amount">Jumlah Bayar (Rp)</label>
                                <input type="text" class="form-control input-rupiah @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', round($loan->monthly_payment)) }}" inputmode="numeric" required>
                                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i>Simpan Pembayaran</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Jadwal Pembayaran</h3>
                </div>
                <div class="card-body p-0">
                    <table id="payment-schedule-table" class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Bulan ke-</th>
                                <th>Jatuh Tempo</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedule as $item)
                                <tr class="{{ $item->is_paid ? 'table-success' : '' }}">
                                    <td>{{ $item->month }}</td>
                                    <td>{{ $item->due_date->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                    <td>
                                        @if($item->is_paid)
                                            <span class="badge bg-success">Lunas</span>
                                        @elseif($item->due_date->isPast())
                                            <span class="badge bg-danger">Terlambat</span>
                                        @else
                                            <span class="badge bg-warning">Belum Dibayar</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->paid_at ? $item->paid_at->format('d/m/Y') : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $('#payment-schedule-table').DataTable({
        responsive: true, autoWidth: false, paging: false, searching: false, info: false,
        order: [[0, 'asc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
