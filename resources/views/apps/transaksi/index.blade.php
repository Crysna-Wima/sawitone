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
                        <a href="/apps/transaksi/giro" type="button" class="btn btn-info mr-1"><i class="fas fa-money-check mr-1"></i> Cek Giro</a>
                        <a href="/apps/transaksi/bookmark-index" type="button" class="btn btn-warning mr-1"><i class="fas fa-bookmark mr-1"></i> Bookmark</a>
                        <a href="/apps/transaksi/create-index" type="button" class="btn btn-success"><i class="fa fa-plus mr-1"></i> Tambah Data Transaksi</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">Nama Transaksi</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Operator</th>
                                    <th scope="col" class="text-center text-nowrap">Tipe Referensi</th>
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
            targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
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
                data: 'mapping.fc_mappingname'
            },
            {
                data: 'fd_trxdate_byuser',
                render: formatTimestamp
            },
            {
                data: 'fc_userid'
            },
            {
                data: 'fc_docreference'
            },
            {
                data: 'fm_balance',
                render: function(data, type, row) {
                    return row.fm_balance.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'transaksitype.fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_trxno = window.btoa(data.fc_trxno);

            $('td:eq(8)', row).html(`
                    <a href="/apps/transaksi/get-data/${fc_trxno}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                `);
        },
    });

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection