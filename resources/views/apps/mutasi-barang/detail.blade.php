@extends('partial.app')
@section('title', 'Mutasi Barang')
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
        <div class="col-12 col-md-4 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                {{-- <form id="form_submit" action="/apps/mutasi-barang/store-mutasi" method="POST" autocomplete="off"> --}}
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control datepicker" value="{{ \Carbon\Carbon::parse( $data->fd_date_byuser )->isoFormat('D MMMM Y'); }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Jenis Mutasi</label>
                                    <input type="text" class="form-control" value="{{ $data->fc_type_mutation }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Awal</label>
                                    <div class="input-group mb-3">
                                        @if (empty($data->fc_startpoint_code))
                                        <input type="text" class="form-control" id="fc_startpoint" name="fc_startpoint" readonly>
                                        @else
                                        <input type="text" class="form-control" id="fc_startpoint" value="{{ $data->fc_startpoint_code }}" name="fc_startpoint" readonly>
                                        @endif
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" disabled onclick="click_modal_lokasi_awal()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Tujuan</label>
                                    <div class="input-group mb-3">
                                        @if (empty($data->fc_destination_code))
                                        <input type="text" class="form-control" id="fc_destination" name="fc_destination" readonly>
                                        @else
                                        <input type="text" class="form-control" id="fc_destination" value="{{ $data->fc_destination_code }}" name="fc_destination" readonly>
                                        @endif

                                        <div class="input-group-append">
                                            <button class="btn btn-primary" disabled onclick="click_modal_lokasi_tujuan()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                <button class="btn btn-danger" onclick="click_delete()">Cancel Mutasi</button>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Mutasi</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Berangkat</label>
                                    <input type="text" class="form-control" value="{{ $data->warehouse_start->fc_rackname }}" readonly>

                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Tujuan</label>
                                    <input type="text" class="form-control" value="{{ $data->warehouse_start->fc_rackname }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Berangkat</label>
                                    <textarea type="text" class="form-control" data-height="76" value="{{ $data->warehouse_start->fc_warehouseaddress }}" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Tujuan</label>
                                    <textarea type="text" class="form-control" data-height="76" value="{{ $data->warehouse_destination->fc_warehouseaddress }}" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-12">
            <form id="form_submit_noconfirm" method="POST" action="/apps/mutasi-barang/detail/store_mutasi_detail">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-1">
                                <div class="form-group">
                                    <label>Item</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fn_quantity" name="fn_quantity" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Barcode</label>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control" id="fc_stockcode" name="fc_stockcode" readonly>
                                        <input type="text" class="form-control" id="fc_barcode" name="fc_barcode" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="click_modal_inventory()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_namelong" name="fc_namelong" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-2">
                                <div class="form-group required">
                                    <label>Jumlah</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="fn_qty" name="fn_qty" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fv_description" name="fv_description">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                <button type="submit" class="btn btn-success">Tambah Item</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Barang Mutasi</h4>
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
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Expired Date</th>
                                        <th scope="col" class="text-center">Qty</th>
                                        <th scope="col" class="text-center justify-content-center">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Catatan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="fv_description" name="fv_description">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button text-right mb-4">
        <a href="#" class="btn btn-success">Submit Mutasi</a>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_inventory" data-keyboard="false" data-backdrop="static">
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
                        <table class="table table-striped" id="tb_inventory" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Expired Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Actions</th>
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
    function click_modal_inventory() {
        $('#modal_inventory').modal('show');
        table_inventory();
    }

    function table_inventory() {
        var fc_startpoint_code = "{{ $data->fc_startpoint_code }}";
        var tb_inventory = $('#tb_inventory').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "/apps/mutasi-barang/detail/datatables-inventory/" + fc_startpoint_code,
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5]
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
                    data: 'fd_expired'
                },
                {
                    data: 'fc_batch'
                },
                {
                    data: 'fn_quantity'
                },
                {
                    data: null,
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(5)', row).html(`
                    <button type="button" class="btn btn-warning btn-sm" onclick="detail_inventory('${data.fn_quantity}','${data.fc_stockcode}','${data.fc_barcode}','${data.stock.fc_namelong}')"><i class="fa fa-check"></i> Pilih</button>
                `);

            },
        });
    }

    function detail_inventory(fn_quantity, fc_stockcode, fc_barcode, fc_namelong) {
        $('#modal_inventory').modal('hide');
        $('#fc_barcode').val(fc_barcode);
        $('#fc_namelong').val(fc_namelong);
        $('#fn_quantity').val(fn_quantity);
        $('#fc_stockcode').val(fc_stockcode);
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: "/apps/mutasi-barang/detail/datatables",
            type: 'GET'
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
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
                data: 'stock.fc_namelong'
            },
            {
                data: 'fc_batch'
            },
            {
                data: 'fd_expired'
            },
            {
                data: 'fn_qty'
            },
            {
                data: null,
            },
        ],
        rowCallback: function(row, data) {
            var url_delete = "/apps/mutasi-barang/detail/delete/" + data.fc_mutationno + '/' + data.fn_mutationrownum;

            $('td:eq(6)', row).html(`
                    <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','Mutasi Barang Detail')"><i class="fa fa-trash"></i> Hapus Item</button>
                `);
        },
    });

    function click_delete() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan cancel data Mutasi Barang ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/mutasi-barang/cancel_mutasi',
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status === 200) {
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                tb.ajax.reload(null, false);
                            } else if (response.status === 201) {
                                $("#modal").modal('hide');
                                iziToast.success({
                                    title: 'Success!',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                // arahkan ke link
                                location.href = response.link;
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

    $('#form_submit_noconfirm').on('submit', function(e) {
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
            url: $('#form_submit_noconfirm').attr('action'),
            type: $('#form_submit_noconfirm').attr('method'),
            data: $('#form_submit_noconfirm').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal").modal('hide');
                    $("#form_submit_noconfirm")[0].reset();
                    reset_all_select();
                    tb.ajax.reload(null, false);
                    if (response.total < 1) {
                        window.location.href = response.link;
                    }
                } else if (response.status == 201) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                    location.href = location.href;
                } else if (response.status == 203) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
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