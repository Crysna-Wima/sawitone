@extends('partial.app')
@section('title', 'Delivery Order')
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
                    <div class="collapse show" id="mycard-collapse">
                        <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Order : {{ date('d-m-Y', strtotime ($data->fd_sodateinputuser)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Expired : {{ date('d-m-Y', strtotime($data->fd_soexpired)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Sales</label>
                                        <input type="text" class="form-control" value="{{ $data->sales->fc_salesname1 }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Tipe Order</label>
                                        <input type="text" class="form-control" value="{{ $data->fc_sotype }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Customer</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse2">
                        <div class="card-body"  style="height: 303px">
                            <div class="row">
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->customer->fc_membernpwp_no }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Cabang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->customer->member_typebranch->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Tipe Bisnis</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->customer->member_type_business->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->customer->fc_membername1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->customer->fc_memberaddress1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Masa Hutang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->customer->fn_memberAgingAP }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Legal Status</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->customer->member_legal_status->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Alamat Muat</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->fc_memberaddress_loading1 }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Hutang</label>
                                        <input type="text" class="form-control"
                                            value="{{ $data->customer->fm_memberAP }}" readonly>
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
                                <table class="table table-striped" id="tb" width="100%">
                                    <thead style="white-space: nowrap">
                                        <tr>
                                            <th scope="col" class="text-center">No</th>
                                            <th scope="col" class="text-center">Barcode</th>
                                            <th scope="col" class="text-center">Nama Produk</th>
                                            <th scope="col" class="text-center">Unity</th>
                                            <th scope="col" class="text-center">Qty</th>
                                            <th scope="col" class="text-center">Bonus</th>
                                            <th scope="col" class="text-center">DO</th>
                                            <th scope="col" class="text-center">INV</th>
                                            <th scope="col" class="text-center">Harga</th>
                                            <th scope="col" class="text-center">Disc.(Rp)</th>
                                            <th scope="col" class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="button text-right mb-4">
            <a href="#"><button type="button" class="btn btn-info mr-2">Cancel DO</button></a>
            <a href="#"><button type="button" class="btn btn-primary mr-2">Preview</button></a>
            <a href="#"><button type="button" class="btn btn-success mr-2">Submit</button></a>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var tb = $('#tb').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-sales-order/datatables-so-detail",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7, 8, 9, 10]
            }, ],
            columns: [
                { data: 'DT_RowIndex', searchable: false, orderable: false },
                { data: 'fc_barcode' },
                { data: 'stock.fc_nameshort' },
                { data: 'namepack.fv_description' },
                { data: 'fn_so_qty' },
                { data: 'fn_so_bonusqty' },
                { data: 'fn_do_qty' },
                { data: 'fn_inv_qty' },
                { data: 'fm_so_oriprice',render: $.fn.dataTable.render.number(',', '.', 0, 'Rp') },
                { data: 'fm_so_disc' },
                { data: 'total_harga',render: $.fn.dataTable.render.number(',', '.', 0, 'Rp') },
            ],
            footerCallback: function(row, data, start, end, display) {

                let count_quantity = 0;
                let total_harga = 0;
                let grand_total = 0;

                for (var i = 0; i < data.length; i++) {
                    count_quantity += data[i].fn_so_qty;
                    total_harga += data[i].total_harga;
                    grand_total += data[i].total_harga;
                }

                $('#count_quantity').html(count_quantity);
                // $('#total_harga').html(fungsiRupiah(grand_total));
                // $('#grand_total').html("Rp. " + fungsiRupiah(total_harga));
                // servpay
                if(data.length != 0){
                    $('#fm_servpay').html("Rp. " + fungsiRupiah(data[0].somst.fm_servpay));
                    $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].somst.fm_tax));
                    $('#grand_total').html("Rp. " + fungsiRupiah(data[0].somst.fm_brutto));
                    $('#total_harga').html("Rp. " + fungsiRupiah(data[0].somst.fm_netto));
                    $('#fm_so_disc').html("Rp. " + fungsiRupiah(data[0].somst.fn_disctotal));
                    $('#count_item').html(data[0].somst.fn_sodetail);
                }
            }
        });

        var tb_sopay = $('#tb_sopay').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/master-sales-order/datatables-so-payment",
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
                        data: 'fc_sopaymentcode',
                        name: 'Kode Metode Pembayaran'
                    },
                    {
                        data: 'fc_description',
                        name: 'Deskripsi Metode'
                    },
                    {
                        data: 'fm_valuepayment',
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp'),
                        name: 'Nominal'
                    },
                    {
                        data: "fd_paymentdate",
                        render: formatTimestamp
                    },
                    {
                        data: 'fv_keterangan',
                        name: 'Keterangan'
                    },
                ],
        });
    </script>
@endsection
