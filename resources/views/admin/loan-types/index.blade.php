@extends('adminlte::page')

@section('title', 'Jenis Pinjaman - Admin')

@section('content_header')
<h1>Jenis Pinjaman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Jenis Pinjaman</h3>
            <div class="card-tools">
                <a href="{{ route('admin.loan-types.create') }}" class="btn btn-primary btn-sm">Tambah Jenis</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="loan-types-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Bunga</th>
                            <th>Min Pinjam</th>
                            <th>Max Pinjam</th>
                            <th>Min Tenor</th>
                            <th>Max Tenor</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loanTypes as $lt)
                            <tr>
                                <td>{{ $lt->name }}</td>
                                <td>{{ $lt->interest_rate }}%</td>
                                <td>Rp {{ number_format($lt->min_amount, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($lt->max_amount, 0, ',', '.') }}</td>
                                <td>{{ $lt->min_tenure }} bln</td>
                                <td>{{ $lt->max_tenure }} bln</td>
                                <td>
                                    <span class="badge bg-{{ $lt->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($lt->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.loan-types.edit', $lt) }}" class="btn btn-sm btn-warning">Edit</a>
                                    @if($lt->status == 'active')
                                        <form method="POST" action="{{ route('admin.loan-types.destroy', $lt) }}" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Nonaktifkan jenis pinjaman ini?')">Nonaktifkan</button>
                                        </form>
                                    @endif
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
    $('#loan-types-table').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json'
        }
    });
</script>
@endpush
