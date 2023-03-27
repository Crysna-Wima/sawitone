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
                                <a class="nav-link active show" id="semua-tab" data-toggle="tab" href="#semua"
                                    role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pemesanan-tab" data-toggle="tab" href="#pemesanan" role="tab"
                                    aria-controls="pemesanan" aria-selected="false">Pemesanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                                    aria-controls="pending" aria-selected="false">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="terkirim-tab" data-toggle="tab" href="#terkirim" role="tab"
                                    aria-controls="terkirim" aria-selected="false">Terkirim</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="selesai-tab" data-toggle="tab" href="#selesai" role="tab"
                                    aria-controls="selesai" aria-selected="false">Selesai</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="semua" role="tabpanel"
                                aria-labelledby="semua-tab">
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
    <div class="modal fade" role="dialog" id="modal_nama" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Penanda Tangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="/apps/master-purchase-order/pdf" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="fc_pono" id="fc_pono_input" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="d-block">Nama</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="name_user" id="name_user"
                                            checked="">
                                        <label class="form-check-label" for="name_user">
                                            {{ auth()->user()->fc_username }}
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="name_user_lainnya"
                                            id="name_user_lainnya">
                                        <label class="form-check-label" for="name_user_lainnya">
                                            Lainnya
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success btn-submit">Konfirmasi </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // untuk form input nama penanggung jawab
        $(document).ready(function() {
            var isNamePjShown = false;

            $('#name_user_lainnya').click(function() {
                // Uncheck #name_user
                $('#name_user').prop('checked', false);

                // Show #form_pj
                if (!isNamePjShown) {
                    $('.form-group').append(
                        '<div class="form-group" id="form_pj"><label>Nama PJ</label><input type="text" class="form-control" name="name_pj" id="name_pj"></div>'
                    );
                    isNamePjShown = true;
                }
            });

            $('#name_user').click(function() {
                // Uncheck #name_user_lainnya
                $('#name_user_lainnya').prop('checked', false);

                // Hide #form_pj
                if (isNamePjShown) {
                    $('#form_pj').remove();
                    isNamePjShown = false;
                }
            });

            $('#name_pj').focus(function() {
                $('.form-group:last').toggle();
            });
        });

        // untuk memunculkan nama penanggung jawab
        function click_modal_nama(fc_pono) {
            // #fc_pono_input value
            $('#fc_pono_input').val(fc_pono);
            $('#modal_nama').modal('show');
        };

        var tb = $('#tb_semua').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [2, 'desc']
            ],
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
                } else if (data['fc_postatus'] == 'CC') {
                    $('td:eq(8)', row).html('<span class="badge badge-danger">Cancel</span>');
                } else if (data['fc_postatus'] == 'CL') {
                    $('td:eq(8)', row).html('<span class="badge badge-danger">Close</span>');
                } else {
                    $('td:eq(8)', row).html('<span class="badge badge-success">Selesai</span>');
                }

                $('td:eq(10)', row).html(`
                    <a href="/apps/master-purchase-order/detail/${fc_pono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_pono}')"><i class="fa fa-file"></i> PDF</button>
                    <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close PO</button>
                `);

                // $('td:eq(10)', row).html(`
            //         <a href="/apps/master-purchase-order/detail/${fc_pono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            //         <a href="/apps/master-purchase-order/pdf/${fc_pono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
            //     `);
            },
        });

        var tb = $('#tb_pemesanan').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [2, 'desc']
            ],
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
                    <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close PO</button>
                `);
            },
        });

        var tb = $('#tb_pending').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [2, 'desc']
            ],
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
                    <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close PO</button>
                `);
            },
        });

        var tb = $('#tb_terkirim').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [2, 'desc']
            ],
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
                    <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close PO</button>
                `);
            },
        });

        var tb = $('#tb_selesai').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            order: [
                [2, 'desc']
            ],
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
                    <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close PO</button>
                `);
            },
        });
    </script>
@endsection
