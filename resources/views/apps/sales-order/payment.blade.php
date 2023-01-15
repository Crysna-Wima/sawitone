@extends('partial.app')
@section('title','Payment')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
    }

    .d-flex .flex-row-item {
        flex: 1 1 30%;
    }

    .text-secondary{
        color: #969DA4!important;
    }

    .text-success{
        color: #28a745!important;
    }

    @media (min-width: 992px) and (max-width: 1200px){
        .flex-row-item{
            font-size: 12px;
        }

        .grand-text{
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
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-6 col-md-3 col-lg-3">
                            <div class="form-group mr-3">
                                <label>Date Order</label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" fdprocessedid="8ovz8a">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 col-lg-3">
                            <div class="form-group mr-3">
                                <label>Date Expired</label>
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" fdprocessedid="8ovz8a">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-lg-2">
                            <div class="form-group mr-3 d-flex-row">
                                <label>Total</label>
                                <div class="text mt-2">
                                    <h5 class="text-success grand-text" id="grand_total">Rp. 0,00</h5>                        
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-lg-2">
                            <div class="form-group mr-3 d-flex-row">
                                <label>Kekurangan</label>
                                <div class="text mt-2">
                                    <h5 class="text-danger grand-text" id="">Rp. 0,00</h5>                        
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-lg-2">
                            <div class="form-group mr-3 d-flex-row">
                                <label>Kembalian</label>
                                <div class="text mt-2">
                                    <h5 class="text-muted grand-text" id="">Rp. 0,00</h5>                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-body" style="padding-top: 30px!important;">
                    <form id="form_submit" action="/apps/sales-order/detail/store-update" method="POST" autocomplete="off">
                        <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                            <div class="form-group">
                                <label>Transport</label>
                                    <select class="form-control select2" name="fv_bankname" id="fv_bankname"></select>
                                </div>
                            </div>
                        <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                            <label>Servpay</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="" id="">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                            <div class="form-group">
                                <label>Alamat Muat</label>
                                <input type="text" class="form-control" value="" readonly>
                            </div>                    
                        </div>
                        <div class=" text-right">
                            <button class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Metode Pembayaran</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_payment"><i class="fa fa-plus mr-1"></i>Tambah Metode</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                <tr>
                                    <th scope="col" class="text-center">Kode Bayar</th>
                                    <th scope="col" class="text-center">Deskripsi Bayar</th>
                                    <th scope="col" class="text-center">Nominal</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button text-right">
                <a href="#" class="btn btn-success">Submit</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_payment" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-m" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Metode</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="" method="POST" autocomplete="off">
            <input type="text" name="type" id="type" hidden>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Kode Bayar</label>
                            <select class="form-control select2 required-field" name="" id=""></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Deskripsi Bayar</label>
                            <input type="text" class="form-control required-field" name="" id="" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Nominal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        Rp.
                                        </div>
                                    </div>
                                <input type="text" class="form-control" fdprocessedid="hgh1fp">
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="text" class="form-control datepicker" name="" id="" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <textarea name="" id="" style="height: 70px" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-success">Konfirmasi</button>
            </div>
        </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

</script>
@endsection