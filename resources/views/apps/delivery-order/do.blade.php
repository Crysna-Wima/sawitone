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
                        <div class="card-body"  style="height: 215px">
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
                                        <label>Legal Status</label>
                                        <input type="text" class="form-control"
                                        value="{{ $data->customer->member_legal_status->fv_description }}" readonly>
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
                                        <label>Tipe Cabang</label>
                                        <input type="text" class="form-control"
                                        value="{{ $data->customer->member_typebranch->fv_description }}" readonly>
                                    </div>
                                </div>
                                <div class="col-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <input type="text" class="form-control"
                                        value="{{ $data->customer->fc_memberaddress1 }}" readonly>
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
                                            <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DELIVERY ITEM --}}
            <div class="col-12 col-md-12 col-lg-12 place_detail">
                <div class="card">
                    <div class="card-header">
                        <h4>Delivery Item</h4>
                    </div>
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
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Rack</th>
                                            <th scope="col" class="text-center">Batch</th>
                                            <th scope="col" class="text-center">CAT</th>
                                            <th scope="col" class="text-center">Exp.</th>
                                            <th scope="col" class="text-center">Harga</th>
                                            <th scope="col" class="text-center">Disc.</th>
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
            <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-body" style="height: 260px">
                    <form id="form_submit_custom" action="#" method="POST"
                            autocomplete="off">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label>Transport</label>
                                        <select class="form-control select2" name="fc_sotransport" id="fc_sotransport">
                                            <option value="">- Pilih Transport -</option>
                                            <option value="By Dexa">By Dexa</option>
                                            <option value="By Paket">By Paket</option>
                                            <option value="By Customer">By Customer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Transporter</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" fdprocessedid="hgh1fp"
                                                name="" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal DO</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            {{-- input waktu sekarang format timestamp tipe hidden --}}
                                            <input type="hidden" class="form-control" name=""
                                                id="" value="{{ date('d-m-Y') }}">
                                            <input type="text" id="" class="form-control datepicker"
                                                name="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Biaya Penanganan</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control format-rp" name=""
                                                id="" onkeyup="return onkeyupRupiah(this.id);"required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button class="btn btn-success">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-6 place_detail">
                <div class="card">
                    <div class="card-header">
                        <h4>Calculation</h4>
                    </div>
                    <div class="card-body" style="height: 190px">
                        <div class="d-flex">
                            <div class="flex-row-item" style="margin-right: 30px">
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="count_item">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="flex-row-item"></p>
                                    <p class="flex-row-item text-right"></p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_so_disc">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="flex-row-item"></p>
                                    <p class="flex-row-item text-right"></p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="total_harga">0,00</p>
                                </div>
                            </div>
                            <div class="flex-row-item">
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="flex-row-item"></p>
                                    <p class="flex-row-item text-right"></p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre" >
                                    <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                    <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="flex-row-item"></p>
                                    <p class="flex-row-item text-right"></p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                    <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="grand_total">Rp. 0,00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="button text-right mb-4">
            <a href="#"><button type="button" class="btn btn-danger mr-2">Cancel DO</button></a>
            <a href="#"><button type="button" class="btn btn-primary mr-2">Preview</button></a>
            <a href="#"><button type="button" class="btn btn-success mr-2">Submit</button></a>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_inventory" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Stock Inventory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_ttd" autocomplete="off">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Barcode</th>
                                        <th scope="col" class="text-center">Nama</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Rack</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">CAT</th>
                                        <th scope="col" class="text-center">Exp.</th>
                                        <th scope="col" class="text-center">COGS</th>
                                        <th scope="col" class="text-center">Pembelian</th>
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        function pilih_inventory() {
            $('#modal_inventory').modal('show');
        }

        var tb = $('#tb').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/delivery-order/datatables-so-detail",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            },],
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
                { data: null },
                
            ],
            rowCallback : function(row, data){
            $('td:eq(11)', row).html(`
                <button class="btn btn-warning btn-sm" onclick="pilih_inventory()">Pilih Stock</button>
            `);
            },
            footerCallback: function(row, data, start, end, display) {


                $("#fc_sotransport").val(data[0].somst.fc_sotransport);
                $("#fc_sotransport").trigger("change");
            }
        });
    </script>
@endsection
