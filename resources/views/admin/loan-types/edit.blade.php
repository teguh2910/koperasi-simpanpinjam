@extends('adminlte::page')

@section('title', 'Edit Jenis Pinjaman - Admin')

@section('content_header')
<h1>Edit Jenis Pinjaman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.loan-types.update', $loanType) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label for="name">Nama Pinjaman</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $loanType->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $loanType->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="interest_rate">Suku Bunga (%)</label>
                            <input type="number" class="form-control @error('interest_rate') is-invalid @enderror" id="interest_rate" name="interest_rate" value="{{ old('interest_rate', $loanType->interest_rate) }}" step="0.01" required>
                            @error('interest_rate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="min_amount">Minimal Pinjaman (Rp)</label>
                            <input type="text" class="form-control input-rupiah @error('min_amount') is-invalid @enderror" id="min_amount" name="min_amount" value="{{ old('min_amount', $loanType->min_amount) }}" inputmode="numeric" required>
                            @error('min_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="max_amount">Maksimal Pinjaman (Rp)</label>
                            <input type="text" class="form-control input-rupiah @error('max_amount') is-invalid @enderror" id="max_amount" name="max_amount" value="{{ old('max_amount', $loanType->max_amount) }}" inputmode="numeric" required>
                            @error('max_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="min_tenure">Minimal Tenor (bulan)</label>
                            <input type="number" class="form-control @error('min_tenure') is-invalid @enderror" id="min_tenure" name="min_tenure" value="{{ old('min_tenure', $loanType->min_tenure) }}" required>
                            @error('min_tenure')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="max_tenure">Maksimal Tenor (bulan)</label>
                            <input type="number" class="form-control @error('max_tenure') is-invalid @enderror" id="max_tenure" name="max_tenure" value="{{ old('max_tenure', $loanType->max_tenure) }}" required>
                            @error('max_tenure')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="active" {{ (old('status', $loanType->status) == 'active') ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ (old('status', $loanType->status) == 'inactive') ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.loan-types.index') }}" class="btn btn-default">Batal</a>
            </form>
        </div>
    </div>
@stop
