@extends('adminlte::page')

@section('title', 'Simpanan Saya - Koperasi')

@section('content_header')
<h1>Simpanan Saya</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Simpanan Saya</h3>
        </div>
        <div class="card-body">
            <a href="{{ route('member.savings.create') }}" class="btn btn-primary mb-3">Tambah Simpanan</a>

            <div class="table-responsive">
                <table id="member-savings-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Saldo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($savings as $saving)
                            <tr>
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
@endsection

@push('js')
<script>
    $('#member-savings-table').DataTable({
        responsive: true, autoWidth: false,
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
