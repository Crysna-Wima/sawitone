@extends('partial.app')
@section('title', 'Giro Berjalan')
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
                    <h4>Daftar Giro</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_bookmark" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">Nama Transaksi</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Operator</th>
                                    <th scope="col" class="text-center text-nowrap">Referensi Doc</th>
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

@section('js')
<script>
    var tb_bookmark = $('#tb_bookmark').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-bookmark",
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
            // encode data.fc_trxno
            var fc_trxno = window.btoa(data.fc_trxno);

            if (data.fc_docreference == "") {
                $('td:eq(5)', row).html(`<i><b>No Reference</b></i>`);
            }

            $('td:eq(8)', row).html(`
                    <a href="/apps/transaksi/lanjutkan-bookmark" class="btn btn-warning btn-sm mr-1 lanjutkan-btn"><i class="fas fa-forward mr-1"></i> Lanjutkan</a>
                `);
        },
    });


    $('.modal').css('overflow-y', 'auto');
</script>

@endsection