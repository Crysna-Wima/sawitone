@extends('partial.app')
@section('title', 'Detail Purchase Order')
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
                <div class="collapse show" id="mycard-collapse">
                    <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>PO No : {{ $data->fc_pono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Order : {{ date('d-m-Y', strtotime ($data->fd_podateinputuser)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6" style="white-space: nowrap;">
                                <div class="form-group">
                                    <label>Expired : {{ date('d-m-Y', strtotime($data->fd_poexpired)) }}
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
                                    <label>PO Type</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_potype }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <div class="collapse show" id="mycard-collapse2">
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
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_suppliername1 }}" readonly>
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
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $data->supplier->fc_supplier_npwpaddress1 }}" readonly>
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
                <div class="card-header">
                    <h4>Item Purchase Order</h4>
                </div>
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
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE RO --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Receiving Order</h4>
                    <div class="card-header-action">
                        <a href="/apps/receiving-order/create/{{ base64_encode($data->fc_pono) }}"><button type="button" class="btn btn-success"><i class="fa fa-plus mr-1"></i> Tambahkan RO</button></a>
                    </div>
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
    </div>
    <div class="text-right mb-4">
        <a href="/apps/receiving-order"><button type="button" class="btn btn-info mr-2">Back</button></a>
    </div>
</div>
@endsection

@section('js')
<script>
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
                data: 'fc_status'
            },
        ],
        rowCallback: function(row, data) {

            $('td:eq(7)', row).html(`<i class="${data.fc_status}"></i>`);
            if (data['fc_status'] == 'W') {
                $('td:eq(7)', row).html('<span class="badge badge-primary"><i class="fa fa-hourglass"></i> Menunggu</span>');
            } else if (data['fc_status'] == 'P') {
                $('td:eq(7)', row).html('<span class="badge badge-warning"><i class="fa fa-spinner"></i> Pending/span>');
            } else {
                $('td:eq(7)', row).html('<span class="badge badge-success"><i class="fa fa-check"></i> Selesai</span>');
            }
        }
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
                data: 'fc_rono',
            },
            {
                data: 'fd_roarivaldate',
                render: formatTimestamp
            },
            {
                data: 'fn_rodetail',
            },
            {
                data: 'fc_rostatus',
            },
            {
                data: null,
            },
        ],
        rowCallback: function(row, data) {
            let fc_rono = window.btoa(data.fc_rono)
            $('td:eq(4)', row).html(`<i class="${data.fc_postatus}"></i>`);
            if (data['fc_rostatus'] == 'P') {
                $('td:eq(4)', row).html('<span class="badge badge-primary">Paid Of</span>');
            } else {
                $('td:eq(4)', row).html('<span class="badge badge-success">Received</span>');
            }

            $('td:eq(5)', row).html(`
            <a href="/apps/receiving-order/pdf_ro/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            `);
        }
    });
</script>
@endsection