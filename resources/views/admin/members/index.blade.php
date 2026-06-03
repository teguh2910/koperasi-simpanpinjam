@extends('adminlte::page')

@section('title', 'Kelola Anggota - Admin')

@section('content_header')
<h1>Kelola Anggota</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="members-table" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($members as $member)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone ?? '-' }}</td>
                                <td>{{ $member->created_at->format('d/m/Y') }}</td>
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
    $('#members-table').DataTable({
        responsive: true,
        autoWidth: false,
        language: { url: '{{ asset('vendor/datatables/Indonesian.json') }}' }
    });
</script>
@endpush
