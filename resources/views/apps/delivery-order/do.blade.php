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
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse show" id="mycard-collapse">
                        <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>SONO : {{ $data->fc_sono }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Order : {{ date('d-m-Y', strtotime($data->fd_sodateinputuser)) }}
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Exp. : {{ date('d-m-Y', strtotime($data->fd_soexpired)) }}
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
                        <div class="card-body" style="height: 215px">
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
                                <table class="table table-striped" id="deliver-item" width="100%">
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
                    <div class="card-body">
                        <form id="form_submit" action="/apps/delivery-order/update_transport/{{ $data->fc_sono }}"
                            method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
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
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Transporter</label>
                                        <div class="input-group">
                                            @if ($data->domst->fm_servpay == 0.0 && empty($data->domst->fc_sotransport))
                                                <input type="text" class="form-control" fdprocessedid="hgh1fp"
                                                    name="fc_transporter">
                                            @else
                                                <input type="text" class="form-control"
                                                    value="{{ $data->domst->fc_transporter }}" fdprocessedid="hgh1fp"
                                                    name="fc_transporter">
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Biaya Penanganan</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control format-rp" name="fm_servpay"
                                                id="fm_servpay" value="{{ $data->domst->fm_servpay }}" required>
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
                                            <input type="hidden" class="form-control" name="fd_dodatesysinput"
                                                id="fd_dodatesysinput" value="{{ date('d-m-Y') }}">
                                            @if ($data->domst->fm_servpay == 0.0 && empty($data->domst->fc_sotransport))
                                                <input type="text" id="fd_dodate" class="form-control datepicker"
                                                    name="fd_dodate" required>
                                            @else
                                                <input type="text" id="fd_dodate" class="form-control datepicker"
                                                    name="fd_dodate" value="{{ $data->domst->fd_dodate }}" required>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Alamat Tujuan</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name=""
                                                id="" value="{{ $data->domst->fc_memberaddress_loading }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    @if (empty($data->domst->fc_sotransport))
                                        <button type="submit" class="btn btn-success">Save</button>
                                    @else
                                        <button type="submit" class="btn btn-success">Edit</button>
                                    @endif
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
                    <div class="card-body" style="height: 180px">
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
            <button type="button" onclick="click_delete()" class="btn btn-danger mr-2">Cancel DO</button>
            <button onclick="submit_do()" type="button" class="btn btn-success mr-2">Submit</button>
        </div>
    </div>
<<<<<<< HEAD
    <div class="button text-right mb-4">
        @if ($data->domst->fc_dostatus == 'D' && $data->domst->fc_sostatus == 'P')
        @else
            <button type="button" onclick="click_delete()" class="btn btn-danger mr-2">Cancel DO</button>
        @endif

        <a href="/apps/delivery-order/create_do/pdf" target="_blank"><button id="preview_do" type="button"
                class="btn btn-primary mr-2">Preview</button></a>
        @if ($data->domst->fc_dostatus == 'D' && $data->domst->fc_sostatus == 'P')
            {{-- <button onclick="submit_do()" type="button" class="btn btn-secondary mr-2" disabled>Submit</button> --}}
        @else
            <button onclick="submit_do()" type="button" class="btn btn-success mr-2">Submit</button>
        @endif

    </div>
    </div>
    </div>
=======
</div>
>>>>>>> bc46b7552f01fb8c77f22794edbc57ae71d24061
@endsection

@section('loading')
    {{-- loading --}}
    {{-- <div class="loading" id="loading_data" style="display:none;">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div> --}}
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_inventory" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Stock Inventory</h5>
                    <div class="card-header-action">
                        <select data-dismiss="modal" class="form-control select2 required-field" name="#" id="#">
                            <option value="Regular">Regular&nbsp;&nbsp;</option>
                            <option value="Bonus">Bonus&nbsp;&nbsp;</option>
                        </select>
                    </div>
                </div>
                <div class="row place_alert_cart_stock">
                </div>
                <form id="form_ttd" autocomplete="off">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="stock_inventory" width="100%">
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
                                        <th scope="col" class="text-center">Quantity</th>
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
        function pilih_inventory(fc_stockcode) {
            console.log(fc_stockcode);
            // tampilkan loading_data
            var stock_inventory_table = $('#stock_inventory');
            if ($.fn.DataTable.isDataTable(stock_inventory_table)) {
                stock_inventory_table.DataTable().destroy();
            }
            stock_inventory_table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": '/apps/delivery-order/datatables-stock-inventory/' + fc_stockcode,
                    "type": "GET",
                    "data": {
                        "fc_stockcode": fc_stockcode
                    }
                },
                "columns": [{
                        "data": 'DT_RowIndex',
                        "sortable": false,
                        "searchable": false
                    },
                    {
                        "data": "fc_barcode"
                    },
                    {
                        "data": "stock.fc_namelong"
                    },
                    {
                        "data": "fn_quantity"
                    },
                    {
                        "data": "fc_rackcode"
                    },
                    {
                        "data": "fc_batch"
                    },
                    {
                        "data": "fc_catnumber"
                    },
                    {
                        "data": "fd_expired", render: formatTimestamp,
                    },
                    {
                        "data": "fm_cogs"
                    },
                    {
                        "data": "fm_purchase"
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            // console.log(data.stock);
                            var qty = data.stock.sodtl[0].fn_so_qty - data.stock.sodtl[0].fn_do_qty;
                            // console.log("qty"+qty);
                            if (qty >= data.fn_quantity) {
                                return `<input type="number" id="quantity_cart_stock_${data.fc_barcode}" min="0" class="form-control" value="${data.fn_quantity}">`;
                            } else {
                                return `<input type="number" id="quantity_cart_stock_${data.fc_barcode}" min="0" class="form-control" value="${qty}">`;
                            }
                        }
                    },
                    {
                        "data": null,
                        "render": function(data, type, full, meta) {
                            return `<button type="button" class="btn btn-primary" onclick="select_stock('${data.fc_barcode}')">Select</button>`;
                        }
                    } // definisi kolom fc_keterangan
                ],
                "columnDefs": [{
                    "className": "text-center",
                    "targets": [0, 3, 4, 5]
                },
                { className: 'text-nowrap', targets: [7] },  
            ],
                "initComplete": function() {
                    // hide loading_data
                    // $('#loading_data').hide();
                    // Tampilkan modal di sini
                    $('#modal_inventory').modal('show');
                    // stock_inventory_table.DataTable().rows().eq(0).each(function(index) {
                    //     var row = stock_inventory_table.DataTable().row(index);
                    //     var data = row.data();
                    //     if (data.fn_quantity == 0) {
                    //         row.remove();
                    //     }
                    //     // console.log(data.fn_quantity );
                    // });
                    // stock_inventory_table.DataTable().draw();
                    // reload
                    stock_inventory_table.DataTable().ajax.reload();
                    var table = stock_inventory_table.DataTable();
                    var rows = table.rows().nodes();
                    for (var i = 0; i < rows.length; i++) {
                        var row = $(rows[i]);
                        var fn_quantity = row.find('td:nth-child(4)').text();
                        if (fn_quantity == 0) {
                            table.row(row).remove().draw(false);
                        }
                    }
                }
            });
        }

        function select_stock(fc_barcode) {
            let stock_name = 'input[name="pname[]'
            console.log($('').val());
            $.ajax({
                url: '/apps/delivery-order/cart_stock',
                type: "POST",
                data: {
                    'fc_barcode': fc_barcode,
                    'quantity': $(`#quantity_cart_stock_${fc_barcode}`).val(),
                },
                dataType: 'JSON',
                success: function(response, textStatus, jQxhr) {
                    $('.place_alert_cart_stock').empty();
                    if (response.status == '200') {
                        $('.place_alert_cart_stock').append(
                            `<span class="badge badge-success">${response.message}</span>`)
                        location.reload();
                    } else {
                        $('.place_alert_cart_stock').append(
                            `<span class="badge badge-danger">${response.message}</span>`)
                    }
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                    console.warn(jqXhr.responseText);
                },
            });
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
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_barcode'
                },
                {
                    data: 'stock.fc_nameshort'
                },
                {
                    data: 'namepack.fv_description'
                },
                {
                    data: 'fn_so_qty'
                },
                {
                    data: 'fn_so_bonusqty'
                },
                {
                    data: 'fn_do_qty'
                },
                {
                    data: 'fn_inv_qty'
                },
                {
                    data: 'fm_so_oriprice',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: 'fm_so_disc'
                },
                {
                    data: 'total_harga',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: null
                },

            ],
            rowCallback: function(row, data) {
                if (data.somst.domst.fc_dostatus == 'D' && data.somst.domst.fc_sostatus == 'P') {
                    // kosong
                    $('td:eq(11)', row).html(``);
                } else {
                    $('td:eq(11)', row).html(`
                    <button class="btn btn-warning btn-sm" data onclick="pilih_inventory('${data.stock.fc_stockcode}')">Pilih Stock</button>
                `);
                } 

                if (data.fn_so_qty > data.fn_do_qty || data.fn_so_bonusqty != 0){
                    $('td:eq(11)', row).html(`
                    <button class="btn btn-warning btn-sm" data onclick="pilih_inventory('${data.stock.fc_stockcode}')">Pilih Stock</button>`);
                } else {
                    $('td:eq(11)', row).html(`
                    <button class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>`);
                }
            },
            footerCallback: function(row, data, start, end, display) {

                // jika data[0].somst.domst.fc_sotransport tidak kosong
                if (data[0].somst.domst.fc_sotransport !== "") {
                    $("#fc_sotransport").val(data[0].somst.domst.fc_sotransport);
                } else {
                    $("#fc_sotransport").val(data[0].somst.fc_sotransport);
                }

                $("#fc_sotransport").trigger("change");
            }
        });

        var deliver_item = $('#deliver-item').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/delivery-order/datatables-do-detail",
                type: 'GET',
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 3, 4, 5, 6, 7, 8, 10, 11]
                },
                {
                    className: 'text-nowrap',
                    targets: [9]
                },  
                {
                    targets: -1,
                    data: null,
                    defaultContent: '<button class="btn btn-danger btn-sm delete-btn">Hapus Item</button>'
                }
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_barcode'
                },
                {
                    data: 'invstore.stock.fc_namelong'
                },
                {
                    data: 'invstore.stock.fc_namepack'
                },
                {
                    data: 'fn_qty_do'
                },
                {
                    data: 'fc_status'
                },
                {
                    data: 'fc_rackcode'
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fc_catnumber',
                },
                {
                    data: 'fd_expired', render: formatTimestamp,
                },
                {
                    data: 'fn_price',
                },
                {
                    data: 'fn_disc',
                },
                {
                    data: 'fn_value'
                },
                {
                    data: null
                }

            ],
            rowCallback: function(row, data) {
                const item_barcode = data.fc_barcode;
                $('td:eq(13)', row).html(`
                <button class="btn btn-danger btn-sm delete-btn" data-id="${item_barcode}">Hapus Item</button>
            `);
            },
            initComplete: function() {
                $('table').on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    var barcode = $(this).data('id');
                    // console.log(barcode);
                    swal({
                            title: "Anda yakin ingin menghapus item ini?",
                            icon: "warning",
                            buttons: ["Batal", "Hapus"],
                            dangerMode: true,
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: '/apps/delivery-order/delete-item/' + barcode,
                                    type: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content')
                                    },
                                    success: function() {
                                        deliver_item.ajax.reload();
                                        swal("Item telah dihapus!", {
                                            icon: "success",
                                        });
                                    },
                                    error: function(xhr) {
                                        swal("Oops!",
                                            "Terjadi kesalahan saat menghapus item.",
                                            "error");
                                    }
                                });
                            }
                        });
                });
            },
            footerCallback: function(row, data, start, end, display) {

            }
        });

        function click_delete() {
            swal({
                    title: 'Apakah anda yakin?',
                    text: 'Apakah anda yakin akan cancel data DO ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: '/apps/delivery-order/cancel_do',
                            type: "DELETE",
                            dataType: "JSON",
                            success: function(response) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                if (response.status === 201) {
                                    $("#modal").modal('hide');
                                    iziToast.success({
                                        title: 'Success!',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                    window.location.href = response.link;
                                } else {
                                    swal(response.message, {
                                        icon: 'error',
                                    });
                                }

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                                    .responseText + ")", {
                                        icon: 'error',
                                    });
                            }
                        });
                    }
                });
        }

        function submit_do() {
            swal({
                    title: 'Apakah anda yakin?',
                    text: 'Apakah anda yakin akan submit data DO ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: '/apps/delivery-order/submit_do',
                            type: "POST",
                            data: {
                                'fc_sostatus': 'P',
                                'fc_dostatus': 'D',
                                // 'fd_dodatesysinput' sekarang format datetime
                                'fd_dodatesysinput': moment().format('YYYY-MM-DD HH:mm:ss'),
                            },
                            success: function(response) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                if (response.status === 201) {
                                    $("#modal").modal('hide');
                                    iziToast.success({
                                        title: 'Success!',
                                        message: response.message,
                                        position: 'topRight'
                                    });
                                    window.location.href = response.link;
                                } else {
                                    swal(response.message, {
                                        icon: 'error',
                                    });
                                }

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                                    .responseText + ")", {
                                        icon: 'error',
                                    });
                            }
                        });
                    }
                });
        }
    </script>
@endsection
