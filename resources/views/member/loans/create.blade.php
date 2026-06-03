@extends('adminlte::page')

@section('title', 'Ajukan Pinjaman - Koperasi')

@section('content_header')
<h1>Ajukan Pinjaman</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('member.loans.store') }}">
                @csrf

                <div class="form-group">
                    <label for="loan_type_id">Jenis Pinjaman</label>
                    <select class="form-control @error('loan_type_id') is-invalid @enderror" id="loan_type_id" name="loan_type_id" required>
                        <option value="">-- Pilih Jenis Pinjaman --</option>
                        @foreach($loanTypes as $type)
                            <option value="{{ $type->id }}" 
                                data-interest="{{ $type->interest_rate }}"
                                data-min-amount="{{ $type->min_amount }}"
                                data-max-amount="{{ $type->max_amount }}"
                                data-min-tenure="{{ $type->min_tenure }}"
                                data-max-tenure="{{ $type->max_tenure }}"
                                {{ old('loan_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }} ({{ $type->interest_rate }}% - Rp {{ number_format($type->min_amount, 0, ',', '.') }} ~ Rp {{ number_format($type->max_amount, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('loan_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div id="loan-details" class="{{ old('loan_type_id') ? '' : 'd-none' }}">
                    <div class="alert alert-info">
                        <strong id="display-loan-type-name">{{ old('loan_type_id') ? $loanTypes->firstWhere('id', old('loan_type_id'))->name ?? '' : '' }}</strong>
                        <div>Bunga: <span id="display-interest">{{ old('loan_type_id') ? $loanTypes->firstWhere('id', old('loan_type_id'))->interest_rate ?? 0 : 0 }}</span>% |
                        Minimal: Rp <span id="display-min-amount">{{ old('loan_type_id') ? number_format($loanTypes->firstWhere('id', old('loan_type_id'))->min_amount ?? 0, 0, ',', '.') : 0 }}</span> |
                        Maksimal: Rp <span id="display-max-amount">{{ old('loan_type_id') ? number_format($loanTypes->firstWhere('id', old('loan_type_id'))->max_amount ?? 0, 0, ',', '.') : 0 }}</span></div>
                        <div>Tenor: <span id="display-min-tenure">{{ old('loan_type_id') ? $loanTypes->firstWhere('id', old('loan_type_id'))->min_tenure ?? 0 : 0 }}</span> - <span id="display-max-tenure">{{ old('loan_type_id') ? $loanTypes->firstWhere('id', old('loan_type_id'))->max_tenure ?? 0 : 0 }}</span> bulan</div>
                    </div>

                    <div class="form-group">
                        <label for="amount">Jumlah Pinjaman (Rp)</label>
                        <input type="text" class="form-control input-rupiah @error('amount') is-invalid @enderror" 
                               id="amount" name="amount" value="{{ old('amount') }}" inputmode="numeric" required>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label for="tenure">Tenor (bulan)</label>
                        <input type="number" class="form-control @error('tenure') is-invalid @enderror" 
                               id="tenure" name="tenure" value="{{ old('tenure') }}" min="1" required>
                        @error('tenure')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Ajukan</button>
                    <a href="{{ route('member.loans.index') }}" class="btn btn-default">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
<script>
    $('#loan_type_id').on('change', function() {
        let opt = $(this).find(':selected');
        if (opt.val()) {
            $('#display-loan-type-name').text(opt.text().split(' (')[0]);
            $('#display-interest').text(opt.data('interest'));
            $('#display-min-amount').text(Number(opt.data('min-amount')).toLocaleString('id-ID'));
            $('#display-max-amount').text(Number(opt.data('max-amount')).toLocaleString('id-ID'));
            $('#display-min-tenure').text(opt.data('min-tenure'));
            $('#display-max-tenure').text(opt.data('max-tenure'));
            $('#amount').attr({'min': opt.data('min-amount'), 'max': opt.data('max-amount')});
            $('#tenure').attr({'min': opt.data('min-tenure'), 'max': opt.data('max-tenure')});
            $('#loan-details').removeClass('d-none');
        } else {
            $('#loan-details').addClass('d-none');
        }
    });
</script>
@endpush
