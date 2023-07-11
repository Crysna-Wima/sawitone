@extends('partial.app')
@section('title', 'Invoice Penjualan')
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
        <div class="col-12 col-md-4 col-lg-6">
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
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. BPB : {{ $ro_mst->fc_rono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. PO : {{ $ro_mst->fc_pono }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. SJ : {{ $ro_mst->fc_sjno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>No. GR : {{ $ro_mst->fc_grno }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl PO : {{ date('d-m-Y', strtotime($ro_mst->pomst->fd_podateinputuser)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tgl Diterima : {{ date('d-m-Y', strtotime($ro_mst->fd_roarivaldate)) }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Basis Gudang</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->warehouse->fc_rackname }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->supplier_tax_code->fv_description }} ({{ $ro_mst->pomst->supplier->supplier_tax_code->fc_action }}%)" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Supplier</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_supplierNPWP }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->supplier_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->supplier_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_suppliername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fc_supplier_npwpaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Hutang</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->fn_supplierAgingAR }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $ro_mst->pomst->supplier->supplier_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Hutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ $ro_mst->pomst->supplier->fm_supplierAR }}" readonly>
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
                <div class="card-header">
                    <h4>Barang Diterima</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Exp. Date</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Total</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Biaya Lainnya</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_modal_biaya();"><i class="fa fa-plus mr-1"></i> Tambah Biaya Lain</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_lain" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <th scope="col" class="text-center">Action</th>
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
                <div class="card-header">
                    <h4>Transportasi</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transport</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_potransport" id="fc_potransport" value="{{ $ro_mst->pomst->fc_potransport }}" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Transporter</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_transporter" id="fc_transporter" value="{{ $ro_mst->fc_transporter }}" readonly>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Penerima</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_receiver" id="fc_receiver" value="{{ $ro_mst->fc_receiver }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Biaya Transport</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $ro_mst->fm_servpay }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label>Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fv_description" id="fv_description" value="{{ $ro_mst->fv_description ?? '-' }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Alamat Penerimaan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="fc_address_loading" id="fc_address_loading" value="{{ $ro_mst->fc_address_loading }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TOTAL HARGA --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Kalkulasi</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_dodetail">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_calculate">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button text-right mb-4">
        <button type="button" onclick="click_delete()" class="btn btn-danger mr-1">Cancel</button>
        <form id="form_submit_edit" action="/apps/invoice-penjualan/create/submit-invoice" method="post">
            @csrf
            @method('put')
            <input type="hidden" name="fc_invtype" value="{{ utf8_encode('PURCHASE') }}">
            <input type="hidden" name="fc_status" value="{{ utf8_encode('R') }}">
            <button type="submit" class="btn btn-success">Terbitkan Invoice</button>
        </form>


    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_biaya" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Biaya Lainnya</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_item2" action="/apps/invoice-pembelian/create/store-detail" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <input type="text" value="ADDON" id="fc_status" name="fc_status" hidden>
                                <label>Keterangan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fc_detailitem" name="fc_detailitem">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group">
                                <label>Satuan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fc_unityname" name="fc_unityname">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Harga Satuan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            Rp.
                                        </div>
                                    </div>
                                    <input type="text" class="form-control" id="fm_unityprice" name="fm_unityprice" onkeyup="return onkeyupRupiah(this.id);">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-4">
                            <div class="form-group">
                                <label>Qty</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="fn_itemqty" name="fn_itemqty">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Catatan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fv_description" name="fv_description">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-success btn-submit">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function click_modal_biaya() {
        $("#modal_biaya").modal('show');
    }

    var rono = "{{ $ro_mst->fc_rono }}";
    var encode_rono = window.btoa(rono);
    // console.log(encode_rono)
    var tb = $('#tb').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/invoice-pembelian/create/datatables-ro-detail/" + encode_rono,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3]
        }, ],
        columns: [
            {
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'invstore.stock.fc_stockcode'
            },
            {
                data: 'invstore.stock.fc_namelong'
            },
            {
                data: 'invstore.stock.fc_namepack'
            },
            {
                data: 'invstore.fc_batch'
            },
            {
                data: 'invstore.fd_expired',
                render: formatTimestamp
            },
            {
                data: 'fn_itemqty'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="number" id="fm_unityprice_${data.fn_invrownum}" min="0" class="form-control" value="${data.fm_unityprice}">`;
                }
            },
            {
                data: 'fm_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            if (data.fn_price == 0) {
                $('td:eq(9)', row).html(`
                    <button type="submit" class="btn btn-primary">Save</button>`);
            } else if (data.fc_invstatus === 'R') {
                $('td:eq(9)', row).html(`
                    <button type="submit" class="btn btn-secondary" disabled>Edit</button>`);
            } else {
                $('td:eq(9)', row).html(`
                <button type="submit" class="btn btn-warning" data-id="${data.fn_invrownum}" data-price="${data.fm_unityprice}" onclick="editUnityPrice(this)">Edit</button>`);
            }
        },
        footerCallback: function(row, data, start, end, display) {

        }
    });

    function editUnityPrice(button) {
        var id = $(button).data('id');
        var currentPrice = $(button).data('price');
        var newPrice = parseFloat($(`#fm_unityprice_${id}`).val());

        if (newPrice === currentPrice) {
            swal("No changes made.", {
                icon: 'info'
            });
            return;
        }

        swal({
            title: "Konfirmasi",
            text: "Apakah kamu yakin ingin update harga tersebut?",
            icon: "warning",
            buttons: ["Cancel", "Update"],
            dangerMode: true,
        }).then(function(confirm) {
            if (confirm) {
                updateFmUnityPrice(id, newPrice);
            }
        });
    }

    function updateFmUnityPrice(id, fmUnityPrice) {
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/invoice-pembelian/update-fm-unityprice',
            type: 'PUT',
            data: {
                fn_invrownum: id,
                fm_unityprice: fmUnityPrice
            },
            success: function(response) {
                if (response.status == 200) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal_loading").modal('hide');
                    tb.ajax.reload();
                } else {
                    swal(response.message, {
                        icon: 'error',
                    });
                    $("#modal_loading").modal('hide');
                }
            },
            error: function(xhr, status, error) {
                $("#modal_loading").modal('hide');
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function click_delete() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan membatalkan invoice ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/invoice-pembelian/cancel-invoice',
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

    var tb_lain = $('#tb_lain').DataTable({
        // apabila data kosong
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/invoice-pembelian/datatables-biaya-lain",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 3, 4, 5, 6, 7]
        }, ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_detailitem'
            },
            {
                data: 'fc_unityname'
            },
            {
                data: 'fm_unityprice',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
            },
            {
                data: 'fn_itemqty'
            },
            {
                data: 'fm_value',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
            },
            {
                data: 'fv_description'
            },
            {
                data: null,
            },
        ],
        rowCallback: function(row, data) {
            var url_delete = "/apps/invoice-penjualan/detail/delete/" + data.fc_invno + '/' + data.fn_invrownum;

            $('td:eq(7)', row).html(`
                <button class="btn btn-danger" onclick="delete_action('${url_delete}','Biaya Lainnya')"><i class="fa fa-trash"></i> Hapus</button>`);
        },
        footerCallback: function(row, data, start, end, display) {
            if (data.length != 0) {
                $('#fm_servpay_calculate').html("Rp. " + fungsiRupiah(data[0].tempinvmst.fm_servpay));
                $("#fm_servpay_calculate").trigger("change");
                $('#fm_tax').html("Rp. " + fungsiRupiah(data[0].tempinvmst.fm_tax));
                $("#fm_tax").trigger("change");
                $('#grand_total').html("Rp. " + fungsiRupiah(data[0].tempinvmst.fm_brutto));
                $("#grand_total").trigger("change");
                $('#total_harga').html("Rp. " + fungsiRupiah(data[0].tempinvmst.fm_netto));
                $("#total_harga").trigger("change");
                $('#fm_disctotal').html("Rp. " + fungsiRupiah(data[0].tempinvmst.fm_disctotal));
                $("#fm_disctotal").trigger("change");
                $('#count_item').html(data[0].tempinvmst.fn_invdetail);
                $("#count_item").trigger("change");
            }
        }
    });

    $('#form_submit_item2').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        $("#modal_loading").modal('show');
        $.ajax({
            url: $('#form_submit_item2').attr('action'),
            type: $('#form_submit_item2').attr('method'),
            data: $('#form_submit_item2').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal_biaya").modal('hide');
                    $("#form_submit_item2")[0].reset();
                    reset_all_select();
                    tb_lain.ajax.reload(null, false);
                    if (response.total < 1) {
                        window.location.href = response.link;
                    }
                } else if (response.status == 300) {
                    swal(response.message, {
                        icon: 'error',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    });
</script>
@endsection