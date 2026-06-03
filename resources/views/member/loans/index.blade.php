@extends('adminlte::page')

@section('title', 'Pinjaman Saya - Koperasi')

@section('content_header')
<h1>Pinjaman Saya</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pinjaman Saya</h3>
        </div>
        <div class="card-body">
            <a href="{{ route('member.loans.create') }}" class="btn btn-primary mb-3">Ajukan Pinjaman</a>

            <div class="table-responsive">
                <table id="member-loans-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Jenis Pinjaman</th>
                            <th>Jumlah</th>
                            <th>Bunga</th>
                            <th>Tenor</th>
                            <th>Cicilan/Bulan</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td>{{ optional($loan->loanType)->name ?? '-' }}</td>
                                <td>Rp {{ number_format($loan->amount, 0, ',', '.') }}</td>
                                <td>{{ $loan->interest_rate }}%</td>
                                <td>{{ $loan->tenure }} bulan</td>
                                <td>Rp {{ number_format($loan->monthly_payment, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($loan->outstanding_balance, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $loan->status == 'approved' ? 'info' : 
                                        ($loan->status == 'disbursed' ? 'success' : 
                                        ($loan->status == 'rejected' ? 'danger' : 'warning')) 
                                    }}">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('member.loans.show', $loan) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $('#member-loans-table').DataTable({
        responsive: true, autoWidth: false, order: [[1, 'desc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
