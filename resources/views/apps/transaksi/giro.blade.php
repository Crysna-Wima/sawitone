@extends('partial.app')
@section('title', 'Giro Berjalan')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    .select2-selection__rendered {
        margin-right: 15px;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Giro</h4>
                    <div class="card-header-action">
                        <select data-dismiss="modal" name="category" class="form-control select2" id="category">
                            <option value="C" selected>Giro Diterima</option>
                            <option value="D">Giro Keluar</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" id="giro-masuk">
                        <table class="table table-striped" id="tb_giro_masuk" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">No. Giro</th>
                                    <th scope="col" class="text-center text-nowrap">Nama COA</th>
                                    <th scope="col" class="text-center text-nowrap">Jatuh Tempo</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="table-responsive" id="giro-keluar" hidden>
                        <table class="table table-striped" id="tb_giro_keluar" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">No. Giro</th>
                                    <th scope="col" class="text-center text-nowrap">Nama COA</th>
                                    <th scope="col" class="text-center text-nowrap">Jatuh Tempo</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12 text-right">
            <a href="/apps/transaksi" type="button" class="btn btn-info mr-1">Back</a>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $("#category").change(function() {
        if ($('#category').val() === 'D') {
            $('#giro-masuk').attr('hidden', false);
            $('#giro-keluar').attr('hidden', true);
        } else {
            $('#giro-masuk').attr('hidden', true);
            $('#giro-keluar').attr('hidden', false);
        }
    });

    var tb_giro_masuk = $('#tb_giro_masuk').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [4, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-giro/D",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
        }, {
            className: 'text-nowrap',
            targets: []
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_trxno'
            },
            {
                data: 'fc_refno'
            },
            {
                data: 'coa.fc_coaname'
            },
            {
                data: 'fd_agingref',
                render: formatTimestamp
            },
            {
                data: 'fc_girostatus'
            },
            {
                data: 'fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            $('td:eq(7)', row).html(`
                    <a href="#" class="btn btn-info btn-sm mr-1"><i class="fa-solid fa-check-to-slot"></i> Tuntaskan</a>
                `);
        },
    });

    var tb_giro_keluar = $('#tb_giro_keluar').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [4, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-giro/C",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
        }, {
            className: 'text-nowrap',
            targets: []
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_trxno'
            },
            {
                data: 'fc_refno'
            },
            {
                data: 'coa.fc_coaname'
            },
            {
                data: 'fd_agingref',
                render: formatTimestamp
            },
            {
                data: 'fc_girostatus'
            },
            {
                data: 'fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            $('td:eq(7)', row).html(`
                    <a href="#" class="btn btn-info btn-sm mr-1"><i class="fa-solid fa-check-to-slot"></i> Tuntaskan</a>
                `);
        },
    });
    $('.modal').css('overflow-y', 'auto');
</script>
@endsection