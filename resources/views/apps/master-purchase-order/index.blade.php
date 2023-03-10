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

        @media (min-width: 992px) and (max-width: 1200px) {
            .flex-row-item {
                font-size: 12px;
            }

            .grand-text {
                font-size: .9rem;
            }
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
                        <div class="table-responsive">
                            <table class="table table-striped" id="po_master" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">PONO</th>
                                        <th scope="col" class="text-center">Tgl</th>
                                        <th scope="col" class="text-center">Expired</th>
                                        <th scope="col" class="text-center">Tipe</th>
                                        <th scope="col" class="text-center">Supplier</th>
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
@endsection

@section('modal')

@endsection

@section('js')
    <script>
        var tb = $('#po_master').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-purchase-order/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8, 9]
            },{
                className: 'text-nowrap',
                targets: [2, 3, 5, 9]
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
                    data: null,
                    render: function ( data, type, row ) {
                        return row.supplier.fc_supplierlegalstatus+' '+row.supplier.fc_suppliername1;
                    }
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
                $('td:eq(7)', row).html(`<i class="${data.fc_postatus}"></i>`);
                if (data['fc_postatus'] == 'F') {
                    $('td:eq(7)', row).html('<span class="badge badge-primary">Ordered</span>');
                } else if (data['fc_postatus'] == 'P') {
                    $('td:eq(7)', row).html('<span class="badge badge-warning">Process</span>');
                } else if (data['fc_postatus'] == 'L') {
                    $('td:eq(7)', row).html('<span class="badge badge-danger">Lock</span>');
                } else if (data['fc_postatus'] == 'S') {
                    $('td:eq(7)', row).html('<span class="badge badge-info">Sent</span>');
                } else {
                    $('td:eq(7)', row).html('<span class="badge badge-success">Complete</span>');
                }

                $('td:eq(9)', row).html(`
                    <a href="/apps/master-purchase-order/detail/${data.fc_pono}"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                    <a href="/apps/master-purchase-order/pdf/${data.fc_pono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                `);
            },
        });
    </script>
@endsection
