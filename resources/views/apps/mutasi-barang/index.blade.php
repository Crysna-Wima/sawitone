@extends('partial.app')
@section('title', 'Mutasi Barang')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
    }

    .d-flex .flex-row-item {
        flex: 1 1 30%;
    }

    .text-secondary {
        color: #969DA4 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .btn-secondary {
        background-color: #A5A5A5 !important;
    }

    .nav-tabs .nav-item .nav-link {
        color: #A5A5A5;
    }

    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        background-color: #0A9447;
        border-color: transparent;
    }

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #FFFF;
    }

    @media (min-width: 992px) and (max-width: 1200px) {
        .flex-row-item {
            font-size: 12px;
        }

        .grand-text {
            font-size: .9rem;
        }
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Mutasi Barang</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="internal-tab" data-toggle="tab" href="#internal" role="tab" aria-controls="internal" aria-selected="true">Internal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="eksternal-tab" data-toggle="tab" href="#eksternal" role="tab" aria-controls="eksternal" aria-selected="false">Eksternal</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="internal" role="tabpanel" aria-labelledby="internal-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_internal" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Inv No</th>
                                            <th scope="col" class="text-center">Rono</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Tgl Terbit</th>
                                            <th scope="col" class="text-center">Tgl Berakhir</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 25%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="eksternal" role="tabpanel" aria-labelledby="eksternal-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_eksternal" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Inv No</th>
                                            <th scope="col" class="text-center">Dono</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Tgl Terbit</th>
                                            <th scope="col" class="text-center">Tgl Berakhir</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 25%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')

@endsection

@section('js')
<script>
    $('.modal').css('overflow-y', 'auto');
</script>

@endsection