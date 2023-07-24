@extends('partial.app')
@section('title', 'Pembayaran dan Pelunasan')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    .bg-icon {
        background-color: #0000000d;
    }

    .fa-solid.fa-credit-card,
    .fa-solid.fa-chart-line,
    .fa.fa-balance-scale,
    .fa.fa-briefcase,
    .fa.fa-building,
    .fa.fa-cogs {
        color: #0A9447;
        font-size: 24px;
    }

    .card:hover .bg-icon,
    .card:hover .fa-solid.fa-chart-line,
    .card:hover .fa.fa-balance-scale,
    .card:hover .fa-solid.fa-credit-card,
    .card:hover .fa.fa-briefcase,
    .card:hover .fa.fa-building,
    .card:hover .fa.fa-cogs {
        color: white;
        background-color: #0A9447;
    }
</style>
@endsection
@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-4">
            <a href="#">
                <div class="card card-statistic-1" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Investasi</h4>
                        </div>
                        <div class="card-body">
                            Rp. 0
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <a href="#">
                <div class="card card-statistic-1" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa fa-briefcase"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Aset</h4>
                        </div>
                        <div class="card-body">
                            Rp. 0
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <a href="#">
                <div class="card card-statistic-1" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Hutang & Piutang</h4>
                        </div>
                        <div class="card-body">
                            Rp. 0
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <a href="#">
                <div class="card card-statistic-1" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Umum & Administrasi</h4>
                        </div>
                        <div class="card-body">
                            Rp. 0
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <a href="#">
                <div class="card card-statistic-1" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa fa-cogs"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Pemeliharaan & Penyusutan</h4>
                        </div>
                        <div class="card-body">
                            Rp. 0
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-12 col-lg-4">
            <a href="#">
                <div class="card card-statistic-1" style="cursor: pointer;">
                    <div class="card-icon bg-icon">
                        <i class="fa fa-balance-scale"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Beban Penjualan</h4>
                        </div>
                        <div class="card-body">
                            Rp. 0
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@section('modal')
@endsection

@section('js')
<script>
</script>
@endsection