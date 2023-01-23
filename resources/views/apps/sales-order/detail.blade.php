@extends('partial.app')
@section('title', 'Sales Order')
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
                        <h4>Master Sales Order</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse" id="mycard-collapse">
                        <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Tanggal :
                                            {{ \Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</label>
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
                                        <label>SO Type</label>
                                        <input type="text" class="form-control" value="{{ $data->fc_sotype }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Customer Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_membercode"
                                                name="fc_membercode" value="{{ $data->fc_membercode }}" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" disabled onclick="click_modal_customer()"
                                                    type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Status PKP</label>
                                        <input type="text" class="form-control" value="" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button class="btn btn-danger" onclick="click_delete()">Delete SO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Customer Sales Order</h4>
                        <div class="card-header-action">
                            <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i
                                    class="fas fa-minus"></i></a>
                        </div>
                    </div>
                    <div class="collapse" id="mycard-collapse2">
                        <div class="card-body">
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

            <div class="col-12 col-md-12 col-lg-6 place_detail">
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <form id="form_submit" action="/apps/sales-order/detail/store-update" method="POST"
                            autocomplete="off">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Barcode</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_barcode" name="fc_barcode"
                                                readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button"
                                                    onclick="click_modal_stock()"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Qty</label>
                                    <div class="form-group">
                                        <input type="number" min="0"
                                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                            class="form-control" name="fn_so_qty" id="fn_so_qty">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Qty Bonus</label>
                                    <div class="form-group">
                                        <input type="number" min="0"
                                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                            class="form-control" name="fn_so_bonusqty" id="fn_so_bonusqty">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button class="btn btn-success">Add Item</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-6 place_detail">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-row-item" style="margin-right: 30px">
                                <div class="d-flex">
                                    <p class="text-secondary flex-row-item">Item</p>
                                    <p class="text-success flex-row-item text-right" id="count_item">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-secondary flex-row-item">Disc. Total</p>
                                    <p class="text-success flex-row-item text-right" id="fm_so_disc">0,00</p>
                                </div>
                                <div class="d-flex">
                                    <p class="text-secondary flex-row-item">Total</p>
                                    <p class="text-success flex-row-item text-right" id="total_harga">0,00</p>
                                </div>
                            </div>
                            <div class="flex-row-item">
                                <div class="d-flex" style="gap: 5px">
                                    <p class="text-secondary flex-row-item">Service Pay</p>
                                    <p class="text-success flex-row-item text-right" id="fm_servpay">0,00</p>
                                </div>
                                <div class="d-flex" style="gap: 5px">
                                    <p class="text-secondary flex-row-item">Pajak(+11%)</p>
                                    <p class="text-success flex-row-item text-right" id="fc_membertaxcode">0,00</p>
                                </div>
                                <div class="d-flex" style="gap: 5px; white-space: pre">
                                    <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                    <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:large" id="grand_total">Rp. 0,00</p>
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
                                            <th scope="col" class="text-center">Qty Bonus</th>
                                            <th scope="col" class="text-center">Harga</th>
                                            <th scope="col" class="text-center">Disc.(%)</th>
                                            <th scope="col" class="text-center">Disc.(Rp)</th>
                                            <th scope="col" class="text-center">Total</th>
                                            <th scope="col" class="text-center justify-content-center">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($data->fc_sostatus === 'F')
                    <div class="button text-right mb-4">
                        <a href="#" class="btn btn-success">Save SO</a>
                    </div>
                @else
                    <div class="button text-right mb-4">
                        <a href="/apps/sales-order/detail/payment" class="btn btn-success">Pembayaran</a>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_customer" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_ttd" autocomplete="off">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_customer" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">Kode</th>
                                        <th scope="col" class="text-center">Nama</th>
                                        <th scope="col" class="text-center">Alamat</th>
                                        <th scope="col" class="text-center">Tipe Bisnis</th>
                                        <th scope="col" class="text-center">Tipe Cabang</th>
                                        <th scope="col" class="text-center">Status Legal</th>
                                        <th scope="col" class="text-center">NPWP</th>
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

    <div class="modal fade" role="dialog" id="modal_stock" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_ttd" autocomplete="off">
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_stock" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Produk</th>
                                        <th scope="col" class="text-center">Nama Produk</th>
                                        <th scope="col" class="text-center">Unity</th>
                                        <th scope="col" class="text-center">Harga</th>
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
        $(document).ready(function() {
            $('.place_detail').attr('hidden', false);
        })

        function click_modal_customer() {
            $('#modal_customer').modal('show');
            table_customer();
        }

        function click_modal_stock() {
            $('#modal_stock').modal('show');
            table_stock();
        }

        function onchange_member_code(fc_membercode) {
            $.ajax({
                url: "/master/data-customer-first/" + fc_membercode,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    if (response.status === 200) {
                        var data = response.data;
                        $('#fc_membertaxcode').val(data.member_tax_code.fc_kode);
                        $('#fc_membertaxcode_view').val(data.member_tax_code.fv_description);
                        $('#fc_memberaddress_loading1').val(data.fc_memberaddress_loading1);
                        $('#fc_memberaddress_loading2').val(data.fc_memberaddress_loading2);
                    } else {
                        iziToast.error({
                            title: 'Error!',
                            message: response.message,
                            position: 'topRight'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                        icon: 'error',
                    });
                }
            });
        }

        function table_customer() {
            var tb_customer = $('#tb_customer').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "/master/get-data-customer-so-datatables/" + $('#fc_branch').val(),
                    type: 'GET'
                },
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7]
                }, ],
                columns: [{
                        data: 'fc_membercode'
                    },
                    {
                        data: 'fc_membername1'
                    },
                    {
                        data: 'fc_memberaddress1'
                    },
                    {
                        data: 'member_type_business.fv_description'
                    },
                    {
                        data: 'member_typebranch.fv_description'
                    },
                    {
                        data: 'member_legal_status.fv_description'
                    },
                    {
                        data: 'fc_membernpwp_no'
                    },
                    {
                        data: 'fc_membernpwp_no'
                    },
                ],
                rowCallback: function(row, data) {
                    $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="detail_customer('${data.fc_membercode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
                }
            });
        }

        function table_stock() {
            var tb_stock = $('#tb_stock').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "/master/get-data-stock-so-datatables",
                    type: 'GET'
                },
                columnDefs: [{
                    className: 'text-center',
                    targets: [0, 5]
                }, ],
                columns: [{
                        data: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'fc_stockcode'
                    },
                    {
                        data: 'fc_nameshort'
                    },
                    {
                        data: 'namepack.fv_description'
                    },
                    {
                        data: 'fm_price_default',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp. ')
                    },
                    {
                        data: 'fc_stockcode'
                    },
                ],
                rowCallback: function(row, data) {
                    $('td:eq(5)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick="detail_stock('${data.fc_stockcode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
                }
            });
        }

        function detail_stock($id) {
            $.ajax({
                url: "/master/get-data-where-field-id-first/Stock/fc_stockcode/" + $id,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    var data = response.data;

                    $('#fc_barcode').val(data.fc_barcode);

                    $("#modal_stock").modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                        icon: 'error',
                    });
                }
            });
        }

        function detail_customer($id) {
            $("#modal_loading").modal('show');
            $.ajax({
                url: "/master/data-customer-first/" + $id,
                type: "GET",
                dataType: "JSON",
                success: function(response) {
                    var data = response.data;
                    $('#modal_loading').modal('hide');
                    $("#modal_customer").modal('hide');
                    Object.keys(data).forEach(function(key) {
                        var elem_name = $('[name=' + key + ']');
                        elem_name.val(data[key]);
                    });

                    $('#fc_member_branchtype_desc').val(data.member_typebranch.fv_description);
                    $('#fc_membertypebusiness_desc').val(data.member_type_business.fv_description);
                    $('#fc_memberlegalstatus_desc').val(data.member_legal_status.fv_description);


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                        icon: 'error',
                    });
                }
            });
        }

        var tb = $('#tb').DataTable({
            // apabila data kosong
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/sales-order/detail/datatables",
                type: 'GET',
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6, 7, 8, 9]
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
                    data: 'fm_so_oriprice',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: 'fm_so_disc'
                },
                {
                    data: 'fm_so_disc'
                },
                {
                    data: 'total_harga',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },
                {
                    data: 'fn_so_value',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
                },


            ],
            rowCallback: function(row, data) {
                var url_delete = "/apps/sales-order/detail/delete/" + data.fc_sono + '/' + data.fn_sorownum;

                $('td:eq(10)', row).html(`
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','SO Detail')"><i class="fa fa-trash"> </i> Hapus Item</button>
            `);
            },
            footerCallback: function(row, data, start, end, display) {

                let count_quantity = 0;
                let total_harga = 0;
                let grand_total = 0;

                for (var i = 0; i < data.length; i++) {
                    count_quantity += data[i].fn_so_qty;
                    total_harga += data[i].total_harga;
                    grand_total += data[i].total_harga;
                }

                $('#count_item').html(data.length);
                $('#count_quantity').html(count_quantity);
                $('#total_harga').html(fungsiRupiah(grand_total));
                $('#grand_total').html("Rp. " + fungsiRupiah(total_harga));
                // servpay
                if(data.length != 0){
                    $('#fm_servpay').html(data[0].tempsomst.fm_servpay);
                }

                
            }
        });

        function click_delete() {
            swal({
                    title: 'Apakah anda yakin?',
                    text: 'Apakah anda yakin akan menghapus data SO ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: '/apps/sales-order/delete',
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

        // sementara
        function save_so() {
            swal({
                    title: 'Apakah anda yakin?',
                    text: 'Apakah anda yakin akan menyimpan data SO ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: '/apps/sales-order/detail/lock',
                            type: "GET",
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
    </script>
@endsection
