@extends('adminlte::page')

@section('title', 'Kelola Pinjaman - Admin')

@section('content_header')
<h1>Kelola Pinjaman</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="loans-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Anggota</th>
                            <th>Jenis Pinjaman</th>
                            <th>Jumlah</th>
                            <th>Bunga</th>
                            <th>Tenor</th>
                            <th>Cicilan/Bulan</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $loan)
                            <tr>
                                <td>{{ $loan->id }}</td>
                                <td>{{ $loan->user->name }}</td>
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
                                    <a href="{{ route('admin.loans.show', $loan) }}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>

                                    @if($loan->status == 'pending')
                                        <form method="POST" action="{{ route('admin.loans.approve', $loan) }}" class="d-inline">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-success">Approve</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.loans.reject', $loan) }}" class="d-inline">
                                            @csrf @method('PUT')
                                            <button class="btn btn-sm btn-danger">Reject</button>
                                        </form>
                                    @elseif($loan->status == 'approved')
                                        <form method="POST" action="{{ route('admin.loans.disburse', $loan) }}" class="d-inline">
                                            @csrf @method('PUT')
                                            <input type="date" name="disbursed_at" class="form-control form-control-sm d-inline-block mw-100" style="width:auto;min-width:140px" value="{{ date('Y-m-d') }}" required>
                                            <button class="btn btn-sm btn-primary">Cairkan</button>
                                        </form>
                                    @endif

                                    <form method="POST" action="{{ route('admin.loans.destroy', $loan) }}" class="d-inline" onsubmit="return confirm('Hapus pinjaman ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $('#loans-table').DataTable({
        responsive: true,
        autoWidth: false,
        order: [[0, 'desc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
