@extends('partial.app')
@section('title', 'Transaksi Accounting')
@section('css')
<style>
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
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-2">
                                <div class="form-group required">
                                    <label>Cabang</label>
                                    <input type="text" class="form-control" id="fc_userid" value="{{ $data->fc_branch }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <div class="form-group required">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" id="fc_userid" value="{{ $data->fc_userid }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Tgl Transaksi</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <input type="text" id="fd_trxdate_byuser" class="form-control" name="fd_trxdate_byuser" value="{{ $data->fd_trxdate_byuser }}" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Kode mapping</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_mappingcode" name="fc_mappingcode" value="{{ $data->fc_mappingcode }}" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" disabled onclick="click_modal_mapping()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label>Nama mapping</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_mappingname" name="fc_mappingname" value="{{ $data->mapping->fc_mappingname }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label>Tipe Jurnal</label>
                                    <input type="text" class="form-control" id="fc_informtrx" name="fc_informtrx" value="{{ $data->transaksitype->fv_description }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Dokumen Referensi</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_docreference" name="fc_docreference" value="{{ $data->fc_docreference }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Debit --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Debit</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_add_debit();"><i class="fa fa-plus mr-1"></i> Tambah Debit</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <h3>Total : Rp. 0</h3>
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_debit" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode COA</th>
                                        <th scope="col" class="text-center">Nama COA</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Metode Pembayaran</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Kredit --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Kredit</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_add_kredit();"><i class="fa fa-plus mr-1"></i> Tambah Kredit</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <h3>Total : Rp. 0</h3>
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb_kredit" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode COA</th>
                                        <th scope="col" class="text-center">Nama COA</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Metode Pembayaran</th>
                                        <th scope="col" class="text-center">Keterangan</th>
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
    <div class="button text-right mb-4">
        <form id="form_submit_edit" action="/apps/transaksi/submit" method="post">
            <button type="button" onclick="click_cancel()" class="btn btn-danger mr-1">Cancel</button>
            <button type="button" onclick="click_pending()" class="btn btn-warning mr-1">Pending</button>
            @csrf
            @method('put')
            <button type="submit" class="btn btn-success">Submit Transaksi</button>
        </form>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_mapping" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Mapping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Mapping</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Jumlah Debit</th>
                                    <th scope="col" class="text-center">Jumlah Kredit</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
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
    $(".datepicker").datepicker({
        changeMonth: true,
        changeYear: true,
    });

    $(document).ready(function() {
        get_data_branch();
        get_data_jurnal();
    })

    function click_modal_mapping() {
        $('#modal_mapping').modal('show');
    }


    function select_mapping(fc_mappingcode) {
        // encode
        var mappingcode = window.btoa(fc_mappingcode);
        $.ajax({
            url: "/apps/transaksi/select-mapping/" + mappingcode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $("#modal_do").modal('hide');
                var data = response.data;

                $('#fc_mappingcode').val(data.fc_mappingcode);
                $('#fc_mappingname').val(data.fc_mappingname);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    function get_data_branch() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_branch").empty();
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].fc_kode == $('#fc_branch_view').val()) {
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch").prop("disabled", true);
                        } else {
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
                    }
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

    function get_data_jurnal() {
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/JURNALTYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_informtrx").empty();
                    $("#fc_informtrx").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_informtrx").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    var tb_debit = $('#tb_debit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/detail/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, ]
        }, {
            className: 'text-nowrap',
            targets: [6]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_mappingcode'
            },
            {
                data: 'fc_mappingname'
            },
            {
                data: 'sum_debit'
            },
            {
                data: 'sum_credit'
            },
            {
                data: 'fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            $('td:eq(6)', row).html(`
                    <button class="btn btn-warning btn-sm" onclick="select_mapping('${data.fc_mappingcode}')"><i class="fas fa-check"></i> Pilih</button>
                `);
        },
    });

    function click_cancel() {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan cancel Transaksi Accounting?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/transaksi/cancel_transaksi',
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
</script>

@endsection