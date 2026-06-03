@extends('adminlte::page')

@section('title', 'SHU Saya - Koperasi')

@section('content_header')
<h1>SHU Saya</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @forelse($periods as $period)
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">{{ $period->name }}</h3>
                <div class="card-tools">
                    <span class="badge bg-success">{{ $period->period_start->format('d/m/Y') }} - {{ $period->period_end->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="card-body">
                @php $member = $period->members->first(); @endphp
                @if($member && $member->shu_amount > 0)
                    <div class="row">
                        <div class="col-md-4">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>Rp {{ number_format($member->shu_amount, 0, ',', '.') }}</h3>
                                    <p>Total SHU Anda</p>
                                </div>
                                <div class="icon"><i class="fas fa-gift"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ number_format($period->savings_weight, 0) }}% / {{ number_format($period->loan_weight, 0) }}%</h3>
                                    <p>Bobot Simpanan / Pinjaman</p>
                                </div>
                                <div class="icon"><i class="fas fa-balance-scale"></i></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>{{ number_format($member->savings_percent + $member->loan_percent, 2) }}%</h3>
                                    <p>Kontribusi Anda</p>
                                </div>
                                <div class="icon"><i class="fas fa-chart-pie"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive"><table class="table table-bordered">
                        <tr>
                            <th>Simpanan Anda</th>
                            <td>Rp {{ number_format($member->savings_balance, 0, ',', '.') }}</td>
                            <td>Kontribusi: {{ number_format($member->savings_percent, 2) }}%</td>
                        </tr>
                        <tr>
                            <th>Bunga Pinjaman Dibayar</th>
                            <td>Rp {{ number_format($member->loan_interest_paid, 0, ',', '.') }}</td>
                            <td>Kontribusi: {{ number_format($member->loan_percent, 2) }}%</td>
                        </tr>
                    </table></div>
                @else
                    <p class="text-muted mb-0">Anda tidak mendapatkan SHU pada periode ini.</p>
                @endif
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body">
                <p class="text-muted mb-0">Belum ada periode SHU.</p>
            </div>
        </div>
    @endforelse
@stop
