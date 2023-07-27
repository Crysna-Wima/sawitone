@extends('partial.app')
@section('title', 'Transaksi Accounting')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Transaksi</h4>
                    <div class="card-header-action">
                        <a href="/apps/transaksi/create-index" type="button" class="btn btn-success"><i class="fa fa-plus mr-1"></i> Tambah Data Transaksi</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. Transaksi</th>
                                    <th scope="col" class="text-center">Nama Transaksi</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Operator</th>
                                    <th scope="col" class="text-center">Referensi Doc</th>
                                    <th scope="col" class="text-center">Balance</th>
                                    <th scope="col" class="text-center">Informasi</th>
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
@endsection

@section('modal')
@endsection

@section('js')
<script>
    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
        }, {
            className: 'text-nowrap',
            targets: [8]
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
                data: 'mapping.fc_mappingname'
            },
            {
                data: 'fd_trxdate_byuser'
            },
            {
                data: 'fc_userid'
            },
            {
                data: 'fc_docreference'
            },
            {
                data: 'fm_balance'
            },
            {
                data: 'transaksitype.fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/transaksi/delete/" + data.fc_mappingcode;
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            $('td:eq(8)', row).html(`
                    <a href="/apps/transaksi/detail/${fc_mappingcode}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_mappingname}')"><i class="fa fa-trash"> </i> Hapus</button>
                `);
        },
    });

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection