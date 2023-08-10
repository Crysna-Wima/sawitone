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
                        <table class="table table-striped" id="tb_giro" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center text-nowrap">No. Transaksi</th>
                                    <th scope="col" class="text-center text-nowrap">No. Giro</th>
                                    <th scope="col" class="text-center text-nowrap">Nama COA</th>
                                    <th scope="col" class="text-center">Jatuh Tempo</th>
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
    var tb_giro = $('#tb_giro').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [3, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-giro",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
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
            // encode data.fc_trxno
            var fc_trxno = window.btoa(data.fc_trxno);
            $('td:eq(6)', row).html(`
                    <a href="#" class="btn btn-info btn-sm mr-1"><i class="fa-solid fa-check-to-slot"></i> Tuntaskan</a>
                `);
        },
    });
    $('.modal').css('overflow-y', 'auto');
</script>
@endsection