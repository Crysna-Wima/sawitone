@extends('partial.app')
@section('title', 'Daftar Penerimaan')
@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data BPB</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. BPB</th>
                                    <th scope="col" class="text-center">No. PO</th>
                                    <th scope="col" class="text-center text-nowrap">Nama Supplier</th>
                                    <th scope="col" class="text-center text-nowrap">Tgl Diterima</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center">Total Belanja</th>
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
@endsection

@section('js')
<script>
    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        order: [
            [4, 'desc']
        ],
        ajax: {
            url: '/apps/invoice-pembelian/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6]
            },
            {
                className: 'text-nowrap',
                targets: [3]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_rono'
            },
            {
                data: 'fc_pono'
            },
            {
                data: 'pomst.supplier.fc_suppliername1'
            },
            {
                data: 'fd_roarivaldate',
                render: formatTimestamp
            },
            {
                data: 'fn_rodetail'
            },
            {
                data: 'invmst.fm_brutto',
                defaultContent: 'Rp 0',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_rono = window.btoa(data.fc_rono);
            $('td:eq(7)', row).html(
                `<a href="/apps/invoice-pembelian/detail/${fc_rono}"><button class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Pilih</button></a>`
            );

        }
    });
</script>
@endsection