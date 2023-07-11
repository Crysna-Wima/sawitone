@extends('partial.app')
@section('title', 'Detail ' . $inv_mst->fc_invno)
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
        @if($inv_mst->fc_invtype == 'SALES')
        <div class="col-12 col-md-4 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. DO : {{ $inv_mst->fc_child_suppdocno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. SO : {{ $inv_mst->fc_suppdocno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Delivery : {{ \Carbon\Carbon::parse( $inv_mst->domst->fd_dodate )->isoFormat('D MMMM Y'); }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Diterima : {{ \Carbon\Carbon::parse( $inv_mst->domst->fd_arrivaldate )->isoFormat('D MMMM Y'); }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Tipe SO</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->fc_sotype }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Sales</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->sales->fc_salesname1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Customer Code</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" value="{{ $inv_mst->somst->customer->fc_membercode }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->member_tax_code->fv_description }} ({{ $inv_mst->somst->member_tax_code->fc_action }}%)" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Customer</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body" style="height: 303px">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_membernpwp_no ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->member_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_membertypebusiness }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_membername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_memberaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Piutang</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fn_memberAgingAP }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->member_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_memberaddress_loading1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Piutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ number_format( $inv_mst->somst->customer->fm_memberAP,0,',','.') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($inv_mst->fc_invtype == 'PURCHASE')
        <div class="col-12 col-md-4 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. BPB : {{ $inv_mst->fc_child_suppdocno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. PO : {{ $inv_mst->fc_suppdocno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. SJ : {{ $inv_mst->romst->fc_sjno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. GR : {{ $inv_mst->romst->fc_grno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl PO : {{ date('d-m-Y', strtotime($inv_mst->pomst->fd_podateinputuser)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Diterima : {{ date('d-m-Y', strtotime($inv_mst->romst->fd_roarivaldate)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Basis Gudang</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->romst->warehouse->fc_rackname }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->pomst->supplier->supplier_tax_code->fv_description }} ({{ $inv_mst->pomst->supplier->supplier_tax_code->fc_action }}%)" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Supplier</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->pomst->supplier->fc_supplierNPWP }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->pomst->supplier->supplier_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->pomst->supplier->supplier_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->pomst->supplier->fc_suppliername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->pomst->supplier->fc_supplier_npwpaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Hutang</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->pomst->supplier->fn_supplierAgingAR }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->pomst->supplier->supplier_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Hutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ $inv_mst->pomst->supplier->fm_supplierAR }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-12 col-md-4 col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. DO : {{ $inv_mst->fc_child_suppdocno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. SO : {{ $inv_mst->fc_suppdocno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Delivery : {{ \Carbon\Carbon::parse( $inv_mst->domst->fd_dodate )->isoFormat('D MMMM Y'); }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Diterima : {{ \Carbon\Carbon::parse( $inv_mst->domst->fd_arrivaldate )->isoFormat('D MMMM Y'); }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Tipe SO</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->fc_sotype }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Sales</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->sales->fc_salesname1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Customer Code</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" value="{{ $inv_mst->somst->customer->fc_membercode }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->member_tax_code->fv_description }} ({{ $inv_mst->somst->member_tax_code->fc_action }}%)" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Customer</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body" style="height: 303px">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_membernpwp_no ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->member_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_membertypebusiness }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_membername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_memberaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Piutang</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fn_memberAgingAP }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->member_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <input type="text" class="form-control" value="{{ $inv_mst->somst->customer->fc_memberaddress_loading1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Piutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ number_format( $inv_mst->somst->customer->fm_memberAP,0,',','.') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                @if($inv_mst->fc_invtype == 'SALES')
                <div class="card-header">
                    <h4>Barang Terkirim</h4>
                </div>
                @elseif($inv_mst->fc_invtype == 'PURCHASE')
                <div class="card-header">
                    <h4>Barang Diterima</h4>
                </div>
                @else
                <div class="card-header">
                    <h4>Barang Terkirim</h4>
                </div>
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            @if($inv_mst->fc_invtype == 'SALES')
                            <table class="table table-striped" id="tb_do" width="100%">
                            @elseif($inv_mst->fc_invtype == 'PURCHASE')
                            <table class="table table-striped" id="tb_ro" width="100%">
                            @else
                            <table class="table table-striped" id="tb_do" width="100%">
                            @endif
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Exp. Date</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Total</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Biaya Lainnya</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_lain" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($inv_mst->fc_invtype == 'SALES')
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Transportasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transport</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_sotransport" id="fc_sotransport" value="{{ $inv_mst->domst->fc_sotransport }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transporter</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_transporter" id="fc_transporter" value="{{ $inv_mst->domst->fc_transporter }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Biaya Transport</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $inv_mst->fm_servpay }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Penerima</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_custreceiver" id="fc_custreceiver" value="{{ $inv_mst->domst->fc_custreceiver }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fd_dodatesysinput" id="fd_dodatesysinput" value="{{ $inv_mst->domst->fv_description ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_memberaddress_loading" id="fc_memberaddress_loading" value="{{ $inv_mst->domst->fc_memberaddress_loading }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($inv_mst->fc_invtype == 'PURCHASE')
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Transportasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transport</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_potransport" id="fc_potransport" value="{{ $inv_mst->pomst->fc_potransport }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Penerima</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_receiver" id="fc_receiver" value="{{ $inv_mst->romst->fc_receiver }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Biaya Transport</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $inv_mst->fm_servpay }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label>Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fv_description" id="fv_description" value="{{ $inv_mst->romst->fv_description ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Alamat Penerimaan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_address_loading" id="fc_address_loading" value="{{ $inv_mst->romst->fc_address_loading }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Transportasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transport</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_sotransport" id="fc_sotransport" value="{{ $inv_mst->domst->fc_sotransport }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transporter</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_transporter" id="fc_transporter" value="{{ $inv_mst->domst->fc_transporter }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Biaya Transport</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $inv_mst->fm_servpay }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Penerima</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_custreceiver" id="fc_custreceiver" value="{{ $inv_mst->domst->fc_custreceiver }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fd_dodatesysinput" id="fd_dodatesysinput" value="{{ $inv_mst->domst->fv_description ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Alamat Pengiriman</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_memberaddress_loading" id="fc_memberaddress_loading" value="{{ $inv_mst->domst->fc_memberaddress_loading }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($inv_mst->fc_invtype == 'SALES')
        {{-- TOTAL HARGA --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Kalkulasi</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_dodetail">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_calculate">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($inv_mst->fc_invtype == 'PURCHASE')
        {{-- TOTAL HARGA --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Kalkulasi</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_dodetail">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_calculate">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        {{-- TOTAL HARGA --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Kalkulasi</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_dodetail">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_calculate">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="button text-right mb-4">
        <button type="button" class="btn btn-info">Back</button>
    </div>
</div>
@endsection

@section('modal')

@endsection

@section('js')
<script>
    var dono = "{{ $inv_mst->fc_child_suppdocno }}";
    var encode_dono = window.btoa(dono);
    var tb_do = $('#tb_do').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/daftar-invoice/datatables-do-detail/" + encode_dono,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7, 8]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'invstore.stock.fc_stockcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'invstore.stock.fc_namepack'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired',
                render: formatTimestamp
            },
            {
                data: 'fn_qty_do'
            },
            {
                data: 'fn_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fn_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
        ],
        rowCallback: function(row, data) {

        },
        footerCallback: function(row, data, start, end, display) {
            
        }
    });

    var invno = "{{ $inv_mst->fc_invno }}";
    var encode_invno = window.btoa(invno);
    var tb_lain = $('#tb_lain').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/daftar-invoice/datatables-inv-detail/" + encode_invno,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 2, 3, 4, 5, 6]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_detailitem'
            },
            {
                data: 'fc_unityname'
            },
            {
                data: 'fm_unityprice',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fn_itemqty'
            },
            {
                data: 'fm_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
        ],
        rowCallback: function(row, data) {

        },
        footerCallback: function(row, data, start, end, display) {

        }
    });

    var rono = "{{ $inv_mst->fc_child_suppdocno }}";
    var encode_rono = window.btoa(rono);
    var tb_ro = $('#tb_ro').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/daftar-invoice/datatables-ro-detail/" + encode_rono,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7, 8]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_stockcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'fc_namepack'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired_date',
                render: formatTimestamp
            },
            {
                data: 'fn_qty_ro'
            },
            {
                data: 'fn_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fn_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
        ],
        rowCallback: function(row, data) {

        },
        footerCallback: function(row, data, start, end, display) {

        }
    });
</script>
@endsection