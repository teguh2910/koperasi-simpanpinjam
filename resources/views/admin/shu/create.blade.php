@extends('adminlte::page')

@section('title', 'Buat Periode SHU - Admin')

@section('content_header')
<div class="d-flex justify-content-between">
    <h1>Buat Periode SHU</h1>
    <a href="{{ route('admin.shu.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i>Kembali</a>
</div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.shu.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Periode</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: SHU Tahun 2026" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="period_start">Tanggal Mulai</label>
                            <input type="date" class="form-control @error('period_start') is-invalid @enderror" id="period_start" name="period_start" value="{{ old('period_start') }}" required>
                            @error('period_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="period_end">Tanggal Selesai</label>
                            <input type="date" class="form-control @error('period_end') is-invalid @enderror" id="period_end" name="period_end" value="{{ old('period_end') }}" required>
                            @error('period_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="total_profit">Total Laba (Rp)</label>
                    <div class="input-group">
                        <input type="text" class="form-control input-rupiah @error('total_profit') is-invalid @enderror" id="total_profit" name="total_profit" value="{{ old('total_profit') }}" inputmode="numeric" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-info" id="btn-fetch-profit" onclick="fetchProfit()" title="Ambil dari laporan PnL"><i class="fas fa-calculator mr-1"></i>Ambil dari PnL</button>
                        </div>
                    </div>
                    @error('total_profit')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label for="member_share_percent">Persentase untuk Anggota (%)</label>
                    <input type="number" class="form-control @error('member_share_percent') is-invalid @enderror" id="member_share_percent" name="member_share_percent" value="{{ old('member_share_percent', 30) }}" min="0" max="100" step="0.01" required>
                    <small class="text-muted">Persentase laba yang dibagikan ke anggota</small>
                    @error('member_share_percent')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <hr>
                <h5><i class="fas fa-balance-scale mr-2"></i>Bobot Perhitungan</h5>
                <p class="text-muted">Proporsi kontribusi simpanan dan pinjaman dalam perhitungan SHU masing-masing anggota.</p>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="savings_weight">Bobot Simpanan (%)</label>
                            <input type="number" class="form-control @error('savings_weight') is-invalid @enderror" id="savings_weight" name="savings_weight" value="{{ old('savings_weight', 50) }}" min="0" max="100" step="0.01" required oninput="updateTotalWeight()">
                            @error('savings_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loan_weight">Bobot Pinjaman (%)</label>
                            <input type="number" class="form-control @error('loan_weight') is-invalid @enderror" id="loan_weight" name="loan_weight" value="{{ old('loan_weight', 50) }}" min="0" max="100" step="0.01" required oninput="updateTotalWeight()">
                            @error('loan_weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="alert alert-info" id="weight-total">Total bobot: <strong>100%</strong></div>

                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i>Buat & Hitung SHU</button>
            </form>
        </div>
    </div>
@stop

@push('js')
<script>
    function updateTotalWeight() {
        let s = parseFloat($('#savings_weight').val()) || 0;
        let l = parseFloat($('#loan_weight').val()) || 0;
        let total = s + l;
        let alert = $('#weight-total');
        alert.find('strong').text(total + '%');
        alert.removeClass('alert-info alert-danger');
        alert.addClass(total == 100 ? 'alert-info' : 'alert-danger');
    }

    function fetchProfit() {
        let from = $('#period_start').val();
        let to = $('#period_end').val();
        if (!from || !to) {
            alert('Isi tanggal mulai dan selesai terlebih dahulu');
            return;
        }
        let btn = $('#btn-fetch-profit');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i>Memuat...');
        $.get('{{ route("admin.reports.profit-data") }}', { from, to })
            .done(function(res) {
                let msg = 'Bunga: Rp ' + Number(res.total_interest).toLocaleString('id-ID') +
                    '\nBeban: Rp ' + Number(res.total_expenses).toLocaleString('id-ID') +
                    '\nLaba Bersih: Rp ' + Number(res.net_profit).toLocaleString('id-ID') +
                    '\n\nGunakan laba bersih ini?';
                if (confirm(msg)) {
                    let el = $('#total_profit');
                    el.val(Math.round(res.net_profit));
                    el.trigger('input');
                }
            })
            .fail(function(xhr) {
                alert('Gagal mengambil data laba');
            })
            .always(function() {
                btn.prop('disabled', false).html('<i class="fas fa-calculator mr-1"></i>Ambil dari PnL');
            });
    }
</script>
@endpush
