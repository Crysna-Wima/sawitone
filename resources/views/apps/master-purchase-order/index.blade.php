@extends('partial.app')
@section('title', 'Master Purchase Order')
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
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Master Purchase Order</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="semua-tab" data-toggle="tab" href="#semua" role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pemesanan-tab" data-toggle="tab" href="#pemesanan" role="tab" aria-controls="pemesanan" aria-selected="false">Pemesanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="terkirim-tab" data-toggle="tab" href="#terkirim" role="tab" aria-controls="terkirim" aria-selected="false">Terkirim</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="selesai-tab" data-toggle="tab" href="#selesai" role="tab" aria-controls="selesai" aria-selected="false">Selesai</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_semua" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">PONO</th>
                                            <th scope="col" class="text-center">Tgl</th>
                                            <th scope="col" class="text-center">Expired</th>
                                            <th scope="col" class="text-center">Tipe</th>
                                            <th scope="col" class="text-center">Legal Status</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pemesanan" role="tabpanel" aria-labelledby="pemesanan-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_pemesanan" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">PONO</th>
                                            <th scope="col" class="text-center">Tgl</th>
                                            <th scope="col" class="text-center">Expired</th>
                                            <th scope="col" class="text-center">Tipe</th>
                                            <th scope="col" class="text-center">Legal Status</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_pending" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">PONO</th>
                                            <th scope="col" class="text-center">Tgl</th>
                                            <th scope="col" class="text-center">Expired</th>
                                            <th scope="col" class="text-center">Tipe</th>
                                            <th scope="col" class="text-center">Legal Status</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="terkirim" role="tabpanel" aria-labelledby="terkirim-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_terkirim" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">PONO</th>
                                            <th scope="col" class="text-center">Tgl</th>
                                            <th scope="col" class="text-center">Expired</th>
                                            <th scope="col" class="text-center">Tipe</th>
                                            <th scope="col" class="text-center">Legal Status</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_selesai" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">PONO</th>
                                            <th scope="col" class="text-center">Tgl</th>
                                            <th scope="col" class="text-center">Expired</th>
                                            <th scope="col" class="text-center">Tipe</th>
                                            <th scope="col" class="text-center">Legal Status</th>
                                            <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
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
    var tb = $('#tb_semua').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        order: [[2, 'desc']],
        ajax: {
            url: "/apps/master-purchase-order/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 4, 5, 6, 7, 8, 9]
        }, {
            className: 'text-nowrap',
            targets: [2, 3, 5, 10]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'fd_podateinputuser',
                render: formatTimestamp
            },
            {
                data: 'fd_poexpired',
                render: formatTimestamp
            },
            {
                data: 'fc_potype'
            },
            {
                data: 'supplier.fc_supplierlegalstatus'
            },
            {
                data: 'supplier.fc_suppliername1',
            },
            {
                data: 'fn_podetail',
            },
            {
                data: 'fc_postatus',
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_pono = window.btoa(data.fc_pono);
            $('td:eq(8)', row).html(`<i class="${data.fc_postatus}"></i>`);
            if (data['fc_postatus'] == 'F') {
                $('td:eq(8)', row).html('<span class="badge badge-primary">Pemesanan</span>');
            } else if (data['fc_postatus'] == 'P') {
                $('td:eq(8)', row).html('<span class="badge badge-warning">Pending</span>');
            } else if (data['fc_postatus'] == 'L') {
                $('td:eq(8)', row).html('<span class="badge badge-danger">Lock</span>');
            } else if (data['fc_postatus'] == 'S') {
                $('td:eq(8)', row).html('<span class="badge badge-info">Terkirim</span>');
            } else {
                $('td:eq(8)', row).html('<span class="badge badge-success">Selesai</span>');
            }

            $('td:eq(10)', row).html(`
                    <a href="/apps/master-purchase-order/detail/${fc_pono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <a href="/apps/master-purchase-order/pdf/${fc_pono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                `);
        },
    });

    var tb = $('#tb_pemesanan').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        order: [[2, 'desc']],
        ajax: {
            url: "/apps/master-purchase-order/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 4, 5, 6, 7, 8, 9]
        }, {
            className: 'text-nowrap',
            targets: [2, 3, 5, 10]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'fd_podateinputuser',
                render: formatTimestamp
            },
            {
                data: 'fd_poexpired',
                render: formatTimestamp
            },
            {
                data: 'fc_potype'
            },
            {
                data: 'supplier.fc_supplierlegalstatus'
            },
            {
                data: 'supplier.fc_suppliername1',
            },
            {
                data: 'fn_podetail',
            },
            {
                data: 'fc_postatus',
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_pono = window.btoa(data.fc_pono);
            $('td:eq(8)', row).html(`<i class="${data.fc_postatus}"></i>`);
            if (data['fc_postatus'] == 'F') {
                $('td:eq(8)', row).html('<span class="badge badge-primary">Pemesanan</span>');
            } else {
                $(row).hide();
            }

            $('td:eq(10)', row).html(`
                    <a href="/apps/master-purchase-order/detail/${fc_pono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <a href="/apps/master-purchase-order/pdf/${fc_pono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                `);
        },
    });

    var tb = $('#tb_pending').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        order: [[2, 'desc']],
        ajax: {
            url: "/apps/master-purchase-order/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 4, 5, 6, 7, 8, 9]
        }, {
            className: 'text-nowrap',
            targets: [2, 3, 5, 10]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'fd_podateinputuser',
                render: formatTimestamp
            },
            {
                data: 'fd_poexpired',
                render: formatTimestamp
            },
            {
                data: 'fc_potype'
            },
            {
                data: 'supplier.fc_supplierlegalstatus'
            },
            {
                data: 'supplier.fc_suppliername1',
            },
            {
                data: 'fn_podetail',
            },
            {
                data: 'fc_postatus',
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_pono = window.btoa(data.fc_pono);
            $('td:eq(8)', row).html(`<i class="${data.fc_postatus}"></i>`);
            if (data['fc_postatus'] == 'P') {
                $('td:eq(8)', row).html('<span class="badge badge-warning">Pending</span>');
            } else {
                $(row).hide();
            }

            $('td:eq(10)', row).html(`
                    <a href="/apps/master-purchase-order/detail/${fc_pono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <a href="/apps/master-purchase-order/pdf/${fc_pono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                `);
        },
    });

    var tb = $('#tb_terkirim').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        order: [[2, 'desc']],
        ajax: {
            url: "/apps/master-purchase-order/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 4, 5, 6, 7, 8, 9]
        }, {
            className: 'text-nowrap',
            targets: [2, 3, 5, 10]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'fd_podateinputuser',
                render: formatTimestamp
            },
            {
                data: 'fd_poexpired',
                render: formatTimestamp
            },
            {
                data: 'fc_potype'
            },
            {
                data: 'supplier.fc_supplierlegalstatus'
            },
            {
                data: 'supplier.fc_suppliername1',
            },
            {
                data: 'fn_podetail',
            },
            {
                data: 'fc_postatus',
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_pono = window.btoa(data.fc_pono);
            $('td:eq(8)', row).html(`<i class="${data.fc_postatus}"></i>`);
            if (data['fc_postatus'] == 'S') {
                $('td:eq(8)', row).html('<span class="badge badge-info">Terkirim</span>');
            } else {
                $(row).hide();
            }

            $('td:eq(10)', row).html(`
                    <a href="/apps/master-purchase-order/detail/${fc_pono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <a href="/apps/master-purchase-order/pdf/${fc_pono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                `);
        },
    });

    var tb = $('#tb_selesai').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        order: [[2, 'desc']],
        ajax: {
            url: "/apps/master-purchase-order/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 4, 5, 6, 7, 8, 9]
        }, {
            className: 'text-nowrap',
            targets: [2, 3, 5, 10]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'fd_podateinputuser',
                render: formatTimestamp
            },
            {
                data: 'fd_poexpired',
                render: formatTimestamp
            },
            {
                data: 'fc_potype'
            },
            {
                data: 'supplier.fc_supplierlegalstatus'
            },
            {
                data: 'supplier.fc_suppliername1',
            },
            {
                data: 'fn_podetail',
            },
            {
                data: 'fc_postatus',
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_pono = window.btoa(data.fc_pono);
            $('td:eq(8)', row).html(`<i class="${data.fc_postatus}"></i>`);
            if (data['fc_postatus'] == 'C') {
                $('td:eq(8)', row).html('<span class="badge badge-success">Selesai</span>');
            } else {
                $(row).hide();
            }

            $('td:eq(10)', row).html(`
                    <a href="/apps/master-purchase-order/detail/${fc_pono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <a href="/apps/master-purchase-order/pdf/${fc_pono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                `);
        },
    });
</script>
@endsection