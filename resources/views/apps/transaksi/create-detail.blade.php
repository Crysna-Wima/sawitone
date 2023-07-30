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
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label>Tgl Transaksi</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <input type="text" id="fd_trxdate_byuser" class="form-control" name="fd_trxdate_byuser" value="{{ \Carbon\Carbon::parse( $data->fd_trxdate_byuser )->isoFormat('D MMMM Y'); }}" readonly>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2">
                                <div class="form-group required">
                                    <label>Tipe Jurnal</label>
                                    <input type="text" class="form-control" id="fc_mappingtrxtype" name="fc_mappingtrxtype" value="{{ $data->transaksitype->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label>Dokumen Referensi</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_docreference" name="fc_docreference" value="{{ $data->fc_docreference }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="form-row">
                            <div class="col-12 col-md-6 col-lg-3 mr-4">
                                <div class="form-group required">
                                    <label>Kode mapping</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_mappingcode" name="fc_mappingcode" value="{{ $data->fc_mappingcode }}" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" disabled onclick="click_modal_mapping()" type="button"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2 mr-4">
                                <div class="form-group">
                                    <label>Nama mapping</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="fc_mappingname" name="fc_mappingname" value="{{ $data->mapping->fc_mappingname }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2 mr-3">
                                <div class="form-group d-flex-row">
                                    <label>Debit</label>
                                    <div class="text mt-2">
                                        <h5 class="text-success" style="font-weight: bold; font-size:large" value=" " id="grand_total" name="grand_total">Rp. 0,00</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2 mr-3">
                                <div class="form-group d-flex-row">
                                    <label id="label_kekurangan">Kredit</label>
                                    <div class="text mt-2">
                                        <h5 class="text-danger" style="font-weight: bold; font-size:large" id="kekurangan">
                                            Rp. 0,00</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="form-group d-flex-row">
                                    <label>Balance</label>
                                    <div class="text mt-2">
                                        <h5 class="text-muted" style="font-weight: bold; font-size:large" id="">Rp.
                                            0,00</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Debit --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Debit</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add_debit();"><i class="fa fa-plus mr-1"></i> Tambah Debit</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
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
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
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
                        <button type="button" class="btn btn-success" onclick="add_kredit();"><i class="fa fa-plus mr-1"></i> Tambah Kredit</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
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
                                        <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <form id="form_submit_edit" action="/apps/transaksi/submit" method="post">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <input type="text" name="fv_description" id="fv_description" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button text-right mb-4">
                    <button type="button" onclick="click_cancel()" class="btn btn-danger mr-1">Cancel</button>
                    <button type="button" onclick="click_pending()" class="btn btn-warning mr-1">Pending</button>
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-success">Submit Transaksi</button>
                </div>
            </form>
        </div>
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

<div class="modal fade" role="dialog" id="modal_debit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Tambah Debit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_debit" action="/apps/transaksi/detail/store-debit" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Kode COA</label>
                                <select name="fc_coacode" id="fc_coacode" onchange="get_data_coa()" class="select2" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label id="label-select">Direct Payment</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment" id="fc_directpayment" value="T" class="selectgroup-input" disabled>
                                        <span class="selectgroup-button">YA</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment" id="fc_directpayment" value="F" class="selectgroup-input" checked="" disabled>
                                        <span class="selectgroup-button">TIDAK</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label id="label-select">Status Neraca</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus" id="fc_balancestatus" value="C" class="selectgroup-input" disabled>
                                        <span class="selectgroup-button">KREDIT</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus" id="fc_balancestatus" value="D" class="selectgroup-input" checked="" disabled>
                                        <span class="selectgroup-button">DEBIT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group ">
                                <label>Group</label>
                                <select name="fc_group" id="fc_group" class="select2" disabled></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Metode Pembayaran</label>
                                <select name="fc_paymentmethod" id="fc_paymentmethod" class="select2" required></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_kredit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Tambah Kredit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_kredit" action="/apps/transaksi/detail/store-kredit" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Kode COA</label>
                                <select name="fc_coacode_kredit" id="fc_coacode_kredit" onchange="get_data_coa_kredit()" class="select2 -field" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label id="label-select">Direct Payment</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment_kredit" id="fc_directpayment_kredit" value="T" class="selectgroup-input" disabled>
                                        <span class="selectgroup-button">YA</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_directpayment_kredit" id="fc_directpayment_kredit" value="F" class="selectgroup-input" checked="" disabled>
                                        <span class="selectgroup-button">TIDAK</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label id="label-select">Status Neraca</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus_kredit" id="fc_balancestatus_kredit" value="C" class="selectgroup-input" disabled>
                                        <span class="selectgroup-button">KREDIT</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fc_balancestatus_kredit" id="fc_balancestatus_kredit" value="D" class="selectgroup-input" checked="" disabled>
                                        <span class="selectgroup-button">DEBIT</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group ">
                                <label>Group</label>
                                <select name="fc_group_kredit" id="fc_group_kredit" class="select2" disabled></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Metode Pembayaran</label>
                                <select name="fc_paymentmethod_kredit" id="fc_paymentmethod_kredit" class="select2 " required></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        get_data_payment();
        get_coa();
        get_coa_kredit();
    })

    function add_debit() {
        $('#modal_debit').modal('show');
    }

    function add_kredit() {
        $('#modal_kredit').modal('show');
    }

    function get_data_payment() {
        $.ajax({
            url: "/master/get-data-where-field-id-get/TransaksiType/fc_trx/PAYMENTACC",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_paymentmethod").empty();
                    $("#fc_paymentmethod").append(`<option value="" selected disabled> - Pilih - </option>`);
                    $("#fc_paymentmethod_kredit").empty();
                    $("#fc_paymentmethod_kredit").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_paymentmethod").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        $("#fc_paymentmethod_kredit").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_coa() {
        $('#modal_loading').modal('show');
        var fc_coacode = window.btoa($('#fc_coacode').val());
        // console.log(fc_coacode);
        $.ajax({
            url: "/apps/transaksi/detail/" + fc_coacode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    console.log(data);
                    var value = data[0].mst_coa.fc_directpayment;
                    $("input[name=fc_directpayment][value=" + value + "]").prop('checked', true);
                    var value2 = data[0].mst_coa.fc_balancestatus;
                    $("input[name=fc_balancestatus][value=" + value2 + "]").prop('checked', true);
                    if (data[0].mst_coa.transaksitype == null) {
                        $('#fc_group').append(`<option value="" selected>-</option>`);
                    }
                    $('#fc_group').append(`<option value="${data[0].mst_coa.fc_group}" selected>${data[0].mst_coa.transaksitype.fv_description}</option>`);

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

    function get_data_coa_kredit() {
        $('#modal_loading').modal('show');
        var fc_coacode = window.btoa($('#fc_coacode_kredit').val());
        // console.log(fc_coacode);
        $.ajax({
            url: "/apps/transaksi/detail/kredit/" + fc_coacode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    console.log(data);
                    var value = data[0].mst_coa.fc_directpayment;
                    $("input[name=fc_directpayment_kredit][value=" + value + "]").prop('checked', true);
                    var value2 = data[0].mst_coa.fc_balancestatus;
                    $("input[name=fc_balancestatus_kredit][value=" + value2 + "]").prop('checked', true);
                    if (data[0].mst_coa.transaksitype == null) {
                        $('#fc_group_kredit').append(`<option value="" selected>-</option>`);
                    } else {
                        $('#fc_group_kredit').append(`<option value="${data[0].mst_coa.fc_group}" selected disabled>${data[0].mst_coa.transaksitype.fv_description}</option>`);
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

    function get_coa() {
        $('#modal_loading').modal('show');
        $.ajax({
            url: "/apps/transaksi/detail/get-coa",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_coacode").empty();
                    $("#fc_coacode").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_coacode").append(`<option value="${data[i].fc_coacode}">${data[i].mst_coa.fc_coaname}</option>`);
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

    function get_coa_kredit() {
        $('#modal_loading').modal('show');
        $.ajax({
            url: "/apps/transaksi/detail/get-coa-kredit",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    $("#fc_coacode_kredit").empty();
                    $("#fc_coacode_kredit").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_coacode_kredit").append(`<option value="${data[i].fc_coacode}">${data[i].mst_coa.fc_coaname}</option>`);
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
            url: "/apps/transaksi/detail/datatables-debit",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
        }, {
            className: 'text-nowrap',
            targets: []
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_coacode'
            },
            {
                data: 'coamst.fc_coaname'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="number" id="fm_nominal_${data.fn_rownum}" min="0" class="form-control" value="${data.fm_nominal}">`;
                }
            },
            {
                data: 'payment.fv_description',
                defaultContent: '-'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="text" id="fv_description_${data.fn_rownum}" class="form-control">`;
                }
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/transaksi/detail/delete/" + data.fc_coacode + "/" + data.fn_rownum;
            var fc_coacode = window.btoa(data.fc_coacode);

            $('td:eq(6)', row).html(`
                <button class="btn btn-warning btn-sm mr-1" onclick="#"><i class="fas fa-edit"> </i></button>
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.coamst.fc_coaname}')"><i class="fa fa-trash"> </i></button>
                `);
        },
    });

    var tb_kredit = $('#tb_kredit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/detail/datatables-kredit",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6]
        }, {
            className: 'text-nowrap',
            targets: []
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_coacode'
            },
            {
                data: 'coamst.fc_coaname'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="number" id="fm_nominal_${data.fn_rownum}" min="0" class="form-control" value="${data.fm_nominal}">`;
                }
            },
            {
                data: 'payment.fv_description',
                defaultContent: '-'
            },
            {
                data: null,
                render: function(data, type, full, meta) {
                    return `<input type="text" id="fv_description_${data.fn_rownum}" class="form-control">`;
                }
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/transaksi/detail/delete/" + data.fc_coacode + "/" + data.fn_rownum;
            var fc_coacode = window.btoa(data.fc_coacode);

            $('td:eq(6)', row).html(`
            <button class="btn btn-warning btn-sm mr-1" onclick="#"><i class="fas fa-edit"> </i></button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.coamst.fc_coaname}')"><i class="fa fa-trash"> </i></button>
                `);
        },
    });

    $('#form_submit_debit').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        swal({
                title: 'Yakin?',
                text: 'Apakah anda yakin akan menyimpan data ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: $('#form_submit_debit').attr('action'),
                        type: $('#form_submit_debit').attr('method'),
                        data: $('#form_submit_debit').serialize(),
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal_debit").modal('hide');
                                $("#form_submit_debit")[0].reset();
                                reset_all_select();
                                tb_debit.ajax.reload(null, false);

                            } else if (response.status == 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                location.href = response.link;
                            } else if (response.status == 203) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_debit.ajax.reload(null, false);
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
                }
            });
    });

    $('#form_submit_kredit').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        swal({
                title: 'Yakin?',
                text: 'Apakah anda yakin akan menyimpan data ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((save) => {
                if (save) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: $('#form_submit_kredit').attr('action'),
                        type: $('#form_submit_kredit').attr('method'),
                        data: $('#form_submit_kredit').serialize(),
                        success: function(response) {
                            setTimeout(function() {
                                $('#modal_loading').modal('hide');
                            }, 500);
                            if (response.status == 200) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal_kredit").modal('hide');
                                $("#form_submit_kredit")[0].reset();
                                reset_all_select();
                                tb_kredit.ajax.reload(null, false);

                            } else if (response.status == 201) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                location.href = response.link;
                            } else if (response.status == 203) {
                                swal(response.message, {
                                    icon: 'success',
                                });
                                $("#modal").modal('hide');
                                tb_debit.ajax.reload(null, false);
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
                }
            });
    });

    function click_cancel() {
        swal({
                title: 'Konfirmasi',
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

    function click_pending() {
        swal({
            title: 'Konfirmasi',
            text: 'Apakah anda yakin akan Pending Transaksi Accounting ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/transaksi/pending',
                    type: 'PUT',
                    data: {
                        fc_status: 'P',
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        if (response.status == 200) {
                            iziToast.success({
                                title: 'Success!',
                                message: response.message,
                                position: 'topRight'
                            });
                            $("#modal").modal('hide');
                            location.href = response.link;
                        } else {
                            iziToast.error({
                                title: 'Gagal!',
                                message: response.message,
                                position: 'topRight'
                            });
                            $("#modal").modal('hide');
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