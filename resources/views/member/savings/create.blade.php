@extends('adminlte::page')

@section('title', 'Tambah Simpanan - Koperasi')

@section('content_header')
<h1>Tambah Simpanan</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('member.savings.store') }}">
                @csrf

                <div class="form-group">
                    <label for="type">Jenis Simpanan</label>
                    <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                        <option value="">Pilih Jenis</option>
                        <option value="wajib">Simpanan Wajib</option>
                        <option value="manasuka">Simpanan Manasuka</option>
                        <option value="sukarela">Simpanan Sukarela</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount">Jumlah (Rp)</label>
                    <input type="text" class="form-control input-rupiah @error('amount') is-invalid @enderror" 
                           id="amount" name="amount" inputmode="numeric" required>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('member.savings.index') }}" class="btn btn-default">Batal</a>
            </form>
        </div>
    </div>
@endsection
