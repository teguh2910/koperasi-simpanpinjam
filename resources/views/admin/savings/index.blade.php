@extends('adminlte::page')

@section('title', 'Kelola Simpanan - Admin')

@section('content_header')
<h1>Kelola Simpanan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="savings-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Anggota</th>
                            <th>Jenis</th>
                            <th>Saldo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($savings as $saving)
                            <tr>
                                <td>{{ $saving->id }}</td>
                                <td>{{ $saving->user->name }}</td>
                                <td>{{ ucfirst($saving->type) }}</td>
                                <td>Rp {{ number_format($saving->balance, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $saving->status == 'active' ? 'success' : 'danger' }}">
                                        {{ ucfirst($saving->status) }}
                                    </span>
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
    $('#savings-table').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
