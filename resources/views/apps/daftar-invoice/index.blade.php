@extends('partial.app')
@section('title', 'Daftar Invoice')
@section('css')
<style>
    .text-secondary {
        color: #969DA4 !important;
    }

    .text-success {
        color: #28a745 !important;
    }

    .btn-secondary {
        background-color: #A5A5A5 !important;
    }

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background-color: #0A9447;
        border-color: transparent;
    }

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #FFFF;
    }

    .nav-tabs .nav-item .nav-link {
        color: #A5A5A5;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Invoice</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active show" id="penjualan-tab" data-toggle="tab" href="#penjualan" role="tab" aria-controls="penjualan" aria-selected="true">Penjualan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pembelian-tab" data-toggle="tab" href="#pembelian" role="tab" aria-controls="pembelian" aria-selected="false">Pembelian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cprr-tab" data-toggle="tab" href="#cprr" role="tab" aria-controls="cprr" aria-selected="false">CPRR</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="penjualan" role="tabpanel" aria-labelledby="penjualan-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_penjualan" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. Invoice</th>
                                            <th scope="col" class="text-center">No. SJ</th>
                                            <th scope="col" class="text-center">Tgl Terbit</th>
                                            <th scope="col" class="text-center">Jatuh Tempo</th>
                                            <th scope="col" class="text-center">Customer</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Tagihan</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pembelian" role="tabpanel" aria-labelledby="pembelian-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_pembelian" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. Invoice</th>
                                            <th scope="col" class="text-center">No. BPB</th>
                                            <th scope="col" class="text-center">Tgl Terbit</th>
                                            <th scope="col" class="text-center">Jatuh Tempo</th>
                                            <th scope="col" class="text-center">Supplier</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Tagihan</th>
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cprr" role="tabpanel" aria-labelledby="cprr-tab">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_cprr" width="100%">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">No. Invoice</th>
                                            <th scope="col" class="text-center">Tgl Terbit</th>
                                            <th scope="col" class="text-center">Jatuh Tempo</th>
                                            <th scope="col" class="text-center">Customer</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Tagihan</th>
                                            <th scope="col" class="text-center">Catatan</th>
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
            <form id="form_submit_pdf" action="/apps/daftar-invoice/pdf" method="POST" autocomplete="off">
                @csrf
                <input type="text" name="fc_invno" id="fc_invno_input" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label class="d-block">Nama</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="name_user" id="name_user" checked="">
                                    <label class="form-check-label" for="name_user">
                                        {{ auth()->user()->fc_username }}
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="name_user_lainnya" id="name_user_lainnya">
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
    function click_modal_nama(fc_invno) {
        // #fc_pono_input value
        $('#fc_invno_input').val(fc_invno);
        $('#modal_nama').modal('show');
    };

    var tb_penjualan = $('#tb_penjualan').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        order: [
            [3, 'desc']
        ],
        ajax: {
            url: '/apps/daftar-invoice/datatables/SALES',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 6, 7]
            },
            {
                className: 'text-nowrap',
                targets: [3, 8]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_invno'
            },
            {
                data: 'domst.fc_dono'
            },
            {
                data: 'fd_inv_releasedate',
                render: formatTimestamp
            },
            {
                data: 'fd_inv_agingdate',
                render: formatTimestamp
            },
            {
                data: 'customer.fc_membername1'
            },
            {
                data: 'fc_status'
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_invno = window.btoa(data.fc_invno);
            // console.log(fc_sono);

            $('td:eq(6)', row).html(`<i class="${data.fc_status}"></i>`);
            if (data['fc_status'] == 'R') {
                $('td:eq(6)', row).html('<span class="badge badge-primary">Terbit</span>');
            } else if (data['fc_status'] == 'I') {
                $('td:eq(6)', row).html('<span class="badge badge-warning">Pending</span>');
            } else if (data['fc_status'] == 'L') {
                $('td:eq(6)', row).html('<span class="badge badge-danger">Lock</span>');
            } else {
                $('td:eq(6)', row).html('<span class="badge badge-success">Lunas</span>');
            }

            $('td:eq(8)', row).html(`
            <a href="/apps/daftar-invoice/detail/${fc_invno}/SALES"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_invno}')"><i class="fa fa-file"></i> PDF</button>
         `);
        }
    });

    var tb_pembelian = $('#tb_pembelian').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        order: [
            [3, 'desc']
        ],
        ajax: {
            url: '/apps/daftar-invoice/datatables/PURCHASE',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 6, 7]
            },
            {
                className: 'text-nowrap',
                targets: [3, 8]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_invno'
            },
            {
                data: 'romst.fc_rono'
            },
            {
                data: 'fd_inv_releasedate',
                render: formatTimestamp
            },
            {
                data: 'fd_inv_agingdate',
                render: formatTimestamp
            },
            {
                data: 'supplier.fc_suppliername1'
            },
            {
                data: 'fc_status'
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_invno = window.btoa(data.fc_invno);
            // console.log(fc_sono);

            $('td:eq(6)', row).html(`<i class="${data.fc_status}"></i>`);
            if (data['fc_status'] == 'R') {
                $('td:eq(6)', row).html('<span class="badge badge-primary">Terbit</span>');
            } else if (data['fc_status'] == 'I') {
                $('td:eq(6)', row).html('<span class="badge badge-warning">Pending</span>');
            } else if (data['fc_status'] == 'L') {
                $('td:eq(6)', row).html('<span class="badge badge-danger">Lock</span>');
            } else {
                $('td:eq(6)', row).html('<span class="badge badge-success">Lunas</span>');
            }

            $('td:eq(8)', row).html(`
            <a href="/apps/daftar-invoice/detail/${fc_invno}/PURCHASE"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_invno}')"><i class="fa fa-file"></i> PDF</button>
         `);
        }
    });

    var tb_cprr = $('#tb_cprr').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 5,
        order: [
            [2, 'desc']
        ],
        ajax: {
            url: '/apps/daftar-invoice/datatables/CPRR',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 6, 7]
            },
            {
                className: 'text-nowrap',
                targets: [2, 3, 8]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_invno'
            },
            {
                data: 'fd_inv_releasedate',
                render: formatTimestamp
            },
            {
                data: 'fd_inv_agingdate',
                render: formatTimestamp
            },
            {
                data: 'customer.fc_membername1'
            },
            {
                data: 'fc_status'
            },
            {
                data: 'fm_brutto',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_invno = window.btoa(data.fc_invno);
            // console.log(fc_sono);

            $('td:eq(5)', row).html(`<i class="${data.fc_status}"></i>`);
            if (data['fc_status'] == 'R') {
                $('td:eq(5)', row).html('<span class="badge badge-primary">Terbit</span>');
            } else if (data['fc_status'] == 'I') {
                $('td:eq(5)', row).html('<span class="badge badge-warning">Pending</span>');
            } else if (data['fc_status'] == 'L') {
                $('td:eq(5)', row).html('<span class="badge badge-danger">Lock</span>');
            } else {
                $('td:eq(5)', row).html('<span class="badge badge-success">Lunas</span>');
            }

            $('td:eq(8)', row).html(`
            <a href="/apps/daftar-invoice/detail/${fc_invno}/CPRR"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <button class="btn btn-warning btn-sm" onclick="click_modal_nama('${data.fc_invno}')"><i class="fa fa-file"></i> PDF</button>
         `);
        }
    });
</script>
@endsection