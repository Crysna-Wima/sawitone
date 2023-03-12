@extends('partial.app')
@section('title', 'New Receiving Order')
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
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <form id="form_submit" action="/apps/purchase-order/store-update" method="POST" autocomplete="off">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Order : {{ date('d-m-Y', strtotime ($data->fd_podateinputuser)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>PO No : {{ $data->fc_pono }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6" style="white-space: nowrap;">
                                    <div class="form-group">
                                        <label>Tipe : {{ $data->fc_pono }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" value="{{ auth()->user()->fc_username }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>No. Surat Jalan</label>
                                        <input type="text" value="{{ $ro_master->fc_sjno }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Penerima</label>
                                        <input type="text" value="{{ $ro_master->fc_receiver }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Diterima</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="" class="form-control datepicker" name="fd_roarivaldate" value="{{ $ro_master->fd_roarivaldate }}" required readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success" disabled>Buat RO</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Supplier</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body" style="height: 303px">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplierNPWP }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{  $data->supplier->fc_suppliername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Telepon</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplierphone1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->supplier_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-12">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_address_loading1 }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="po_detail" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Stockcode</th>
                                        <th scope="col" class="text-center">Nama Produk</th>
                                        <th scope="col" class="text-center">Unity</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Qty RO</th>
                                        <th scope="col" class="text-center">Bonus</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE SO PAY --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Item Receiving</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_ro" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No.</th>
                                        <th scope="col" class="text-center">RONO</th>
                                        <th scope="col" class="text-center">Tgl RO</th>
                                        <th scope="col" class="text-center">Item</th>
                                        <th scope="col" class="text-center">Status</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label>Transport</label>
                                <select class="form-control select2" name="" id="">
                                    <option value="" selected disabled>- Pilih Transport -</option>
                                    <option value="By Dexa">By Dexa</option>
                                    <option value="By Paket">By Paket</option>
                                    <option value="By Customer">By Customer</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Tanggal Surat Jalan</label>
                                <div class="input-group" data-date-format="dd-mm-yyyy">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <!-- {{-- input waktu sekarang format timestamp tipe hidden --}} -->
                                    <!-- <input type="hidden" class="form-control" name="fd_sodatesysinput"
                                            id="fd_sodatesysinput" value="{{ date('d-m-Y') }}"> -->
                                    <input type="text" id="" class="form-control datepicker" name="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-5">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-right mb-4">
        <a href="#"><button type="button" class="btn btn-success mr-2">Submit</button></a>
    </div>
</div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_select" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Detail Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="#" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="type" id="type" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Stock Code</label>
                                    <div class="input-group">
                                    <input type="text" id="" class="form-control"
                                            name="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <div class="input-group">
                                    <input type="text" id="" class="form-control"
                                            name="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Batch</label>
                                    <input type="text" id="" class="form-control"
                                            name="" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Qty</label>
                                    <input type="number" min="0" class="form-control" name=""
                                                id="">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Expired Date</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>

                                        <input type="text" id="" class="form-control datepicker"
                                            name="" required>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>CAT Number</label>
                                    <input type="text" id="" class="form-control"
                                            name="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success btn-submit">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function click_modal_select() {
        $('#modal_select').modal('show');
    }

    var tb = $('#po_detail').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/receiving-order/datatables/po_detail",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7]
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
                data: 'stock.fc_nameshort'
            },
            {
                data: 'namepack.fv_description'
            },
            {
                data: 'fn_po_qty'
            },
            {
                data: 'fn_ro_qty'
            },
            {
                data: 'fn_po_bonusqty'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            $('td:eq(7)', row).html(`
            <button class="btn btn-warning btn-sm" onclick="click_modal_select()">Pilih Item</button>
            `);
        },
    });

    var tb_ro = $('#tb_ro').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/receiving-order/datatables/ro",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, ]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: null,
            },
            {
                data: null,
            },
            {
                data: null,
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
            },
            {
                data: null,
                render: formatTimestamp
            },
            {
                data: null,
            },
        ],
    });
</script>
@endsection