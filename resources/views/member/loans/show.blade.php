@extends('adminlte::page')

@section('title', 'Detail Pinjaman - Koperasi')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Detail Pinjaman</h1>
    <a href="{{ route('member.loans.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Informasi Pinjaman</h3>
                </div>
                <table class="table table-striped mb-0">
                    <tr>
                        <th style="width: 40%">Jenis</th>
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
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-calendar-alt mr-2"></i>Jadwal Pembayaran</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive"><table id="payment-schedule-table" class="table table-striped mb-0">
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
                    </table></div>
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
