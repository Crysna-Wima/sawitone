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
                        <h4>Data Receiving Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">RONO</th>
                                        <th scope="col" class="text-center">Surat Jalan</th>
                                        <th scope="col" class="text-center">PONO</th>>
                                        <th scope="col" class="text-center">Supplier</th>
                                        <th scope="col" class="text-center">Item</th>
                                        <th scope="col" class="text-center">Tgl Diterima</th>
                                        <th scope="col" class="text-center">Status</th>
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
            ajax: {
                url: "/apps/master-receiving-order/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8]
            },{
                className: 'text-nowrap',
                targets: []
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },
                {
                    data: null
                },  
                {
                    data: null,
                },
            ], 
            
            rowCallback: function(row, data) {
                $('td:eq(7)', row).html(`<i class="${data.fc_postatus}"></i>`);
                if (data['fc_rostatus'] == 'P') {
                    $('td:eq(7)', row).html('<span class="badge badge-primary">Paid Of</span>');
                } else {
                    $('td:eq(7)', row).html('<span class="badge badge-success">Received</span>');
                }

                $('td:eq(8)', row).html(`
                    <a href="/apps/master-receiving-order/pdf/${data.fc_rono}"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
                `);
            },
        });
    </script>
@endsection
