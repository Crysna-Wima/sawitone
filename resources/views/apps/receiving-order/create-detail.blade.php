@extends('partial.app')
@section('title', 'New Receiving Order')
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
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Informasi Umum</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse" id="mycard-collapse">
                        <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                        <form id="form_submit" action="/apps/purchase-order/store-update" method="POST" autocomplete="off">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Order :
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>PO No :
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6" style="white-space: nowrap;">
                                    <div class="form-group">
                                        <label>Tipe :
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" value="{{ auth()->user()->fc_username }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>No. Surat Jalan</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Penerima</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Diterima</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="" class="form-control datepicker"
                                                name="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success">Buat RO</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Supplier</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse" id="mycard-collapse2">
                        <div class="card-body"  style="height: 303px">
                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control"
                                            value="" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Cabang</label>
                                        <input type="text" class="form-control"
                                            value="" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Bisnis</label>
                                        <input type="text" class="form-control"
                                            value="" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control"
                                            value="" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Telepon</label>
                                        <input type="text" class="form-control"
                                            value="" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Legal Status</label>
                                        <input type="text" class="form-control"
                                            value="" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-12">
                                    <div class="form-group">
                                        <label>Alamat Muat</label>
                                        <input type="text" class="form-control"
                                            value="" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped" id="po_detail" width="100%">
                                    <thead style="white-space: nowrap">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Stockcode</th>
                                            <th scope="col" class="text-center">Nama Produk</th>
                                            <th scope="col" class="text-center">Unity</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center">Qty RO</th>
                                            <th scope="col" class="text-center">Bonus</th>
                                            <th scope="col" class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE SO PAY --}}
            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    <div class="card-header">
                        <h4>Item Receiving</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb_ro" width="100%">
                                    <thead style="white-space: nowrap">
                                        <tr>
                                            <th scope="col" class="text-center">No.</th>
                                            <th scope="col" class="text-center">RONO</th>
                                            <th scope="col" class="text-center">Tgl RO</th>
                                            <th scope="col" class="text-center">Item</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb-4">
            <a href="#"><button type="button" class="btn btn-success mr-2">Submit</button></a>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var tb = $('#po_detail').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-purchase-order/datatables-po-detail",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7]
            }, ],
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'fc_stockcode' },
                { data: 'fc_nameshort' },
                { data: 'namepack.fv_description' },
                { data: 'fn_po_qty' },
                { data: 'fn_ro_qty' },
                { data: 'fn_po_bonusqty' },
                { data: 'fc_postatus' },
            ],
        });

        var tb_sopay = $('#tb_ro').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-purchase-order/datatables-ro",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5,]
            }, ],
            columns: [
                    {   data: 'DT_RowIndex', 
                        searchable: false, 
                        orderable: false },
                    {
                        data: null,
                    },
                    {
                        data: null,
                    },
                    {
                        data: null,
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
                    },
                    {
                        data: null,
                        render: formatTimestamp
                    },
                    {
                        data: null,
                    },
                ],
        });
    </script>
@endsection
