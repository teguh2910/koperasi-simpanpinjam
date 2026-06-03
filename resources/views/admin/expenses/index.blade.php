@extends('adminlte::page')

@section('title', 'Beban - Admin')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Data Beban</h1>
    <a href="{{ route('admin.reports.pnl') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali ke PnL</a>
</div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title text-white"><i class="fas fa-plus-circle mr-2"></i>Tambah Beban</h3>
                </div>
                <form method="POST" action="{{ route('admin.expenses.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description') }}" required>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="amount">Jumlah (Rp)</label>
                            <input type="text" class="form-control input-rupiah @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" inputmode="numeric" required>
                            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="expense_date">Tanggal</label>
                            <input type="date" class="form-control @error('expense_date') is-invalid @enderror" id="expense_date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}" required>
                            @error('expense_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-danger"><i class="fas fa-save mr-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-list mr-2"></i>Daftar Beban</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="expenses-table" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                                <th>Jumlah</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $e)
                                <tr>
                                    <td>{{ $e->expense_date->format('d/m/Y') }}</td>
                                    <td>{{ $e->description }}</td>
                                    <td>Rp {{ number_format($e->amount, 0, ',', '.') }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.expenses.destroy', $e) }}" class="d-inline" onsubmit="return confirm('Hapus beban ini?')">
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
                <div class="card-footer text-right">
                    <strong>Total: Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
    $('#expenses-table').DataTable({
        responsive: true, autoWidth: false, order: [[0, 'desc']],
        language: { url: '{{ asset('vendor/datatables/Indonesian.json') }}' }
    });
</script>
@endpush
