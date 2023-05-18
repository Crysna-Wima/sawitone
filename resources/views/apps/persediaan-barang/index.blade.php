@extends('partial.app')
@section('title', 'Persediaan Barang')
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

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #0A9447;
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
                    <h4>Data Persediaan Barang</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="dexa-tab" data-toggle="tab" href="#dexa" role="tab" aria-controls="dexa" aria-selected="true">DEXA Utama</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gudanglain-tab" data-toggle="tab" href="#gudanglain" role="tab" aria-controls="gudanglain" aria-selected="false">Gudang Lain</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="dexa" role="tabpanel" aria-labelledby="dexa-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_dexa" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Kode Barang</th>
                                            <th scope="col" class="text-center">Nama Barang</th>
                                            <th scope="col" class="text-center">Sebutan</th>
                                            <th scope="col" class="text-center">Brand</th>
                                            <th scope="col" class="text-center">Sub Group</th>
                                            <th scope="col" class="text-center">Tipe Barang</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="gudanglain" role="tabpanel" aria-labelledby="gudanglain-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_gudanglain" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Kode Barang</th>
                                            <th scope="col" class="text-center">Nama Barang</th>
                                            <th scope="col" class="text-center">Sebutan</th>
                                            <th scope="col" class="text-center">Brand</th>
                                            <th scope="col" class="text-center">Sub Group</th>
                                            <th scope="col" class="text-center">Tipe Barang</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center" style="width: 10%">Actions</th>
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
<div class="modal fade" role="dialog" id="modal_inventory_dexa" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Nama Barang e</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_inventory_dexa" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Expired Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Qty</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_inventory_gudanglain" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Nama Barang e</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_inventory_gudanglain" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Expired Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Qty</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function click_modal_inventory_dexa() {
        $('#modal_inventory_dexa').modal('show');
        table_inventory_dexa();
    }

    function click_modal_inventory_gudanglain() {
        $('#modal_inventory_gudanglain').modal('show');
        table_inventory_gudanglain();
    }

    var tb_dexa = $('#tb_dexa').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/persediaan-barang/datatables-dexa",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 4]
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
                data: 'stock.fc_namelong'
            },
            {
                data: 'stock.fc_nameshort'
            },
            {
                data: 'stock.fc_brand'
            },
            {
                data: 'stock.fc_subgroup'
            },
            {
                data: 'stock.fc_typestock2'
            },
            {
                data: null,
                defaultContent: '',
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            $('td:eq(8)', row).html(`
                <button class="btn btn-warning btn-sm" onclick="click_modal_inventory_dexa()"><i class="fa fa-eye"> </i> Detail</button>
                `);
        },
    });

    var tb_gudanglain = $('#tb_gudanglain').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/persediaan-barang/datatables-gudanglain",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 4]
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
                data: 'stock.fc_namelong'
            },
            {
                data: 'stock.fc_nameshort'
            },
            {
                data: 'stock.fc_brand'
            },
            {
                data: 'stock.fc_subgroup'
            },
            {
                data: 'stock.fc_typestock2'
            },
            {
                data: null,
                defaultContent: '',
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            $('td:eq(8)', row).html(`
                <button class="btn btn-warning btn-sm" onclick="click_modal_inventory_gudanglain()"><i class="fa fa-eye"> </i> Detail</button>
                `);
        },
    });

    function table_inventory_dexa() {
        var tb_inventory_dexa = $('#tb_inventory_dexa').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/persediaan-barang/datatables-inventory-dexa",
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3]
            }, ],
            columns: [{
                    data: 'fc_stockcode'
                },
                {
                    data: 'fd_expired'
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_quantity'
                },
            ],
        });
    }

    function table_inventory_gudanglain() {
        var tb_inventory_gudanglain = $('#tb_inventory_gudanglain').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/persediaan-barang/datatables-inventory-gudanglain",
                type: 'GET' 
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3]
            }, ],
            columns: [{
                    data: 'fc_stockcode'
                },
                {
                    data: 'fd_expired'
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_quantity'
                },
            ],
        });
    }

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection