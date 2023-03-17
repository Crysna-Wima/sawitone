@extends('partial.app')
@section('title', 'Master Receiving Order')
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
                    <h4>Data Receiving Order</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="semua-tab" data-toggle="tab" href="#semua" role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="terbayar-tab" data-toggle="tab" href="#terbayar" role="tab" aria-controls="terbayar" aria-selected="false">Terbayar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="diterima-tab" data-toggle="tab" href="#diterima" role="tab" aria-controls="diterima" aria-selected="false">Diterima</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_semua" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">RONO</th>
                                            <th scope="col" class="text-center">Surat Jalan</th>
                                            <th scope="col" class="text-center">PONO</th>
                                            <th scope="col" class="text-center">Supplier</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Tgl Diterima</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center" style="width: 15%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="terbayar" role="tabpanel" aria-labelledby="terbayar-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_terbayar" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">RONO</th>
                                            <th scope="col" class="text-center">Surat Jalan</th>
                                            <th scope="col" class="text-center">PONO</th>
                                            <th scope="col" class="text-center">Supplier</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Tgl Diterima</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center" style="width: 15%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="diterima" role="tabpanel" aria-labelledby="diterima-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_diterima" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">RONO</th>
                                            <th scope="col" class="text-center">Surat Jalan</th>
                                            <th scope="col" class="text-center">PONO</th>
                                            <th scope="col" class="text-center">Supplier</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Tgl Diterima</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center" style="width: 15%">Actions</th>
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
    @endsection

    @section('modal')

    @endsection

    @section('js')
    <script>
        var tb = $('#tb_semua').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-receiving-order/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8]
            }, {
                className: 'text-nowrap',
                targets: [2, 6]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_rono'
                },
                {
                    data: 'fc_sjno'
                },
                {
                    data: 'fc_pono'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return row.pomst.supplier.fc_supplierlegalstatus + ' ' + row.pomst.supplier.fc_suppliername1;
                    }
                },
                {
                    data: 'pomst.fn_podetail'
                },
                {
                    data: 'fd_roarivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'fc_rostatus'
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_rono = window.btoa(data.fc_rono);
                $('td:eq(7)', row).html(`<i class="${data.fc_rostatus}"></i>`);
                if (data['fc_rostatus'] == 'P') {
                    $('td:eq(7)', row).html('<span class="badge badge-primary">Terbayar</span>');
                } else {
                    $('td:eq(7)', row).html('<span class="badge badge-success">Diterima</span>');
                }

                $('td:eq(8)', row).html(`
                    <a href="/apps/master-receiving-order/pdf/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                `);
            },
        });

        var tb = $('#tb_terbayar').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-receiving-order/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8]
            }, {
                className: 'text-nowrap',
                targets: [2, 6]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_rono'
                },
                {
                    data: 'fc_sjno'
                },
                {
                    data: 'fc_pono'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return row.pomst.supplier.fc_supplierlegalstatus + ' ' + row.pomst.supplier.fc_suppliername1;
                    }
                },
                {
                    data: 'pomst.fn_podetail'
                },
                {
                    data: 'fd_roarivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'fc_rostatus'
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_rono = window.btoa(data.fc_rono);
                $('td:eq(7)', row).html(`<i class="${data.fc_rostatus}"></i>`);
                if (data['fc_rostatus'] == 'P') {
                    $('td:eq(7)', row).html('<span class="badge badge-primary">Terbayar</span>');
                } else {
                    $(row).hide();
                }

                $('td:eq(8)', row).html(`
                    <a href="/apps/master-receiving-order/pdf/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                `);
            },
        });

        var tb = $('#tb_diterima').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-receiving-order/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8]
            }, {
                className: 'text-nowrap',
                targets: [2, 6]
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_rono'
                },
                {
                    data: 'fc_sjno'
                },
                {
                    data: 'fc_pono'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return row.pomst.supplier.fc_supplierlegalstatus + ' ' + row.pomst.supplier.fc_suppliername1;
                    }
                },
                {
                    data: 'pomst.fn_podetail'
                },
                {
                    data: 'fd_roarivaldate',
                    render: formatTimestamp
                },
                {
                    data: 'fc_rostatus'
                },
                {
                    data: null,
                },
            ],

            rowCallback: function(row, data) {
                var fc_rono = window.btoa(data.fc_rono);
                $('td:eq(7)', row).html(`<i class="${data.fc_rostatus}"></i>`);
                if (data['fc_rostatus'] == 'R') {
                    $('td:eq(7)', row).html('<span class="badge badge-success">Diterima</span>');
                } else {
                    $(row).hide();
                }

                $('td:eq(8)', row).html(`
                    <a href="/apps/master-receiving-order/pdf/${fc_rono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                `);
            },
        });

        // var dropdown = $('<select></select>')
        //     .appendTo('.dataTables_length')
        //     .addClass('form-control select1')
        //     .attr('aria-controls', 'tb')
        //     .on('change', function() {
        //         var value = $(this).val();
        //         $('tb').DataTable().page.len(value).draw();
        //     })
        //     .attr('style', 'margin-left: 20px; width:140px;');

        // dropdown.append($('<option value="" selected disabled>Filter Status...</option>'));
        // dropdown.append($('<option value="Semua">Semua</option>'));
        // dropdown.append($('<option value="Terbayarf">Terbayar</option>'));
        // dropdown.append($('<option value="Diterima">Diterima</option>'));
    </script>
    @endsection