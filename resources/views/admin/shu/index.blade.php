@extends('adminlte::page')

@section('title', 'SHU - Admin')

@section('content_header')
<h1>Sisa Hasil Usaha (SHU)</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.shu.create') }}" class="btn btn-primary"><i class="fas fa-plus-circle mr-1"></i>Buat Periode SHU Baru</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
            <table id="shu-table" class="table table-striped">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Tanggal</th>
                        <th>Laba</th>
                        <th>SHU Anggota</th>
                        <th>Dibagikan</th>
                        <th>Anggota</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($periods as $p)
                        <tr>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->period_start->format('d/m/Y') }} - {{ $p->period_end->format('d/m/Y') }}</td>
                            <td>Rp {{ number_format($p->total_profit, 0, ',', '.') }}</td>
                            <td>{{ $p->member_share_percent }}%</td>
                            <td>Rp {{ number_format($p->total_shu, 0, ',', '.') }}</td>
                            <td>{{ $p->members_count }}</td>
                            <td>
                                <span class="badge bg-{{ $p->status == 'completed' ? 'success' : 'warning' }}">
                                    {{ $p->status == 'completed' ? 'Selesai' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.shu.show', $p) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <form method="POST" action="{{ route('admin.shu.destroy', $p) }}" class="d-inline" onsubmit="return confirm('Hapus periode SHU ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
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
    $('#shu-table').DataTable({
        responsive: true, autoWidth: false, order: [[0, 'desc']],
        language: { url: '//cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json' }
    });
</script>
@endpush
