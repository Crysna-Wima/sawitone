@extends('partial.app')
@section('title', 'Detail Mapping')
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

    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    .cbox {
        margin-top: 25px;
    }

    .ks-cboxtags {
        list-style: none;
    }

    .ks-cboxtags {
        display: inline;
    }

    .ks-cboxtags label {
        display: inline-block;
        background-color: rgba(255, 255, 255, .9);
        border: 2px solid rgba(139, 139, 139, .3);
        color: #adadad;
        border-radius: 25px;
        white-space: nowrap;
        margin: 3px 0px;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        -webkit-tap-highlight-color: transparent;
        transition: all .2s;
    }

    .ks-cboxtags label {
        padding: 8px 12px;
        cursor: pointer;
    }

    .ks-cboxtags label::before {
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        font-size: 12px;
        padding: 2px 6px 2px 2px;
        content: "\f067";
        transition: transform .3s ease-in-out;
    }

    .ks-cboxtags input[type="checkbox"]:checked+label::before {
        content: "\f00c";
        transform: rotate(-360deg);
        transition: transform .3s ease-in-out;
    }

    .ks-cboxtags input[type="checkbox"]:checked+label {
        border: 2px solid #b6d7a8;
        background-color: #0A9447;
        color: #fff;
        transition: all .2s;
    }

    .ks-cboxtags input[type="checkbox"] {
        display: absolute;
    }

    .ks-cboxtags input[type="checkbox"] {
        position: absolute;
        opacity: 0;
    }

    .ks-cboxtags input[type="checkbox"]:focus+label {
        border: 2px solid #97d508;
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
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse show" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Cabang</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->branch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Kode Mapping</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_mappingcode }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label>Nama Mapping</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_mappingname }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->created_by }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label id="label-select">Hold</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item" style="margin: 0!important">
                                            <input type="radio" name="fc_hold" id="fc_hold" value="{{ $data->fc_hold }}" class="selectgroup-input" checked>
                                            @if($data->fc_hold == 'T')
                                            <span class="selectgroup-button">YA</span>
                                            @else
                                            <span class="selectgroup-button">TIDAK</span>
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Tipe</label>
                                    <input type="text" class="form-control" name="fc_mappingcashtype" id="fc_mappingcashtype" value="{{ $data->tipe->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Transaksi</label>
                                    <input type="text" class="form-control" name="fc_mappingtrxtype" id="fc_mappingtrxtype" value="{{ $data->transaksi->fv_description }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Hak Istimewa Debit</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkAllDebit" name="trxaccmethod[]" value="DEFAULT" {{ in_array('DEFAULT', json_decode(json_encode($fc_debit_previledge), true)) ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="checkAllDebit">General</label>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-9" id="checkbox">
                                <div class="ks-cboxtags">
                                    @if($trxaccmethod)
                                    @foreach($trxaccmethod as $index => $accmethod)
                                    @php
                                    $isDebitPreviledge = in_array($accmethod->fc_kode, $fc_debit_previledge);
                                    @endphp
                                    @if($accmethod->fc_kode !== 'DEFAULT')
                                    <input type="checkbox" id="{{ 'checkbox_debit' . $index }}" name="trxaccmethod[]" value="{{ $accmethod->fc_kode }}" {{ $isDebitPreviledge ? 'checked' : '' }} disabled>
                                    <label for="{{ 'checkbox_debit' . $index }}">{{ $accmethod->fv_description }}</label>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Hak Istimewa Kredit</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkAllKredit" name="trxaccmethod[]" value="DEFAULT" {{ in_array('DEFAULT', $fc_credit_previledge) ? 'checked' : '' }} disabled>
                            <label class="form-check-label" for="checkAllKredit">General</label>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-9" id="checkbox">
                                <div class="ks-cboxtags">
                                    @if($trxaccmethod)
                                    @foreach($trxaccmethod as $index => $accmethod)
                                    @php
                                    $isCreditPreviledge = in_array($accmethod->fc_kode, $fc_credit_previledge);
                                    @endphp
                                    @if($accmethod->fc_kode !== 'DEFAULT')
                                    <input type="checkbox" id="{{ 'checkbox_kredit' . $index }}" name="trxaccmethod[]" value="{{ $accmethod->fc_kode }}" {{ $isCreditPreviledge ? 'checked' : '' }} disabled>
                                    <label for="{{ 'checkbox_kredit' . $index }}">{{ $accmethod->fv_description }}</label>
                                    @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Debit --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Mapping Debit</h4>
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
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Mapping Kredit</h4>
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
        <a href="/apps/master-mapping"><button type="button" class="btn btn-info">Back</button></a>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-3 col-lg-3" hidden>
                        <div class="form-group">
                            <label>Divisi</label>
                            <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required">
                            <label>Cabang</label>
                            <input type="text" class="form-control" name="fc_branch1" id="fc_branch1">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required">
                            <label>Layer</label>
                            <input type="number" min="0" class="form-control required-field" onchange="get_parent()" name="fn_layer" id="fn_layer">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required">
                            <label>COA Induk</label>
                            <select name="fc_parentcode" id="fc_parentcode" class="select2 required-field"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <div class="form-group required">
                            <label>Kode COA</label>
                            <input type="text" class="form-control required-field" name="fc_coacode" id="fc_coacode">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-9">
                        <div class="form-group required">
                            <label>Nama COA</label>
                            <input type="text" class="form-control required-field" name="fc_coaname" id="fc_coaname">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required-select">
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
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required-select">
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
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group required">
                            <label>Group</label>
                            <select name="fc_group" id="fc_group" class="select2 required-field"></select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            <input type="text" class="form-control" name="fv_description" id="fv_description">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var mappingcode = "{{ $data->fc_mappingcode }}";
    var encode_mappingcode = window.btoa(mappingcode);

    function detail(fc_coacode) {
        $("#modal").modal('show');
        $(".modal-title").text('Detail COA');
        get_detail(fc_coacode);
    }

    function get_detail(fc_coacode) {
        $('#modal_loading').modal('show');
        var coacode = window.btoa(fc_coacode);

        $.ajax({
            url: "/apps/master-coa/detail/" + coacode,
            type: 'GET',
            dataType: 'JSON',
            success: function(response) {
                var data = response.data;
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);

                if (response.status == 200) {
                    console.log(data);
                    var value = data.fc_directpayment;
                    $("input[name=fc_directpayment][value=" + value + "]").prop('checked', true);
                    var value2 = data.fc_balancestatus;
                    $("input[name= fc_balancestatus][value=" + value2 + "]").prop('checked', true);
                    $('#fc_branch1').val(data.branch.fv_description);
                    $('#fc_branch1').prop('readonly', true);
                    $('#fc_coacode').val(data.fc_coacode);
                    $('#fc_coacode').prop('readonly', true);
                    $('#fc_coaname').val(data.fc_coaname);
                    $('#fc_coaname').prop('readonly', true);
                    $('#fn_layer').val(data.fn_layer);
                    $('#fn_layer').prop('readonly', true);
                    // $('#fc_directpayment').val(data.fc_directpayment).prop('checked', true);

                    if (data.fc_parentcode == 0) {
                        $('#fc_parentcode').append(`<option value="0" selected>COA INDUK</option>`)
                        $('#fc_parentcode').prop('disabled', true);
                        $('#fc_parentcode_hidden').val(0);
                    } else {
                        $('#fc_parentcode').append(`<option value="${data.parent.fc_coacode}" selected>${data.parent.fc_coaname}</option>`);
                        $('#fc_parentcode').prop('disabled', true);
                        $('#fc_parentcode_hidden').val(data.parent.fc_coacode);
                    }
                    if (data.transaksitype != null) {
                        $('#fc_group').append(`<option value="${data.fc_group}" selected>${data.transaksitype.fv_description}</option>`);
                        $('#fc_group').prop('disabled', true);
                    } else {
                        $('#fc_group').append(`<option value="-" selected>-</option>`);
                        $('#fc_group').prop('disabled', true);
                    }
                    $('#fv_description').val(data.fv_description);
                    $('#fv_description').prop('readonly', true);
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
        })
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
            url: "/apps/master-mapping/create/datatables-debit/" + encode_mappingcode,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2]
        }, {
            className: 'text-nowrap',
            targets: [3]
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
                data: 'mst_coa.fc_coaname'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_mappingcode = window.btoa(data.fc_mappingcode);
            var fc_coacode = window.btoa(data.fc_coacode);
            var url_delete = "/apps/master-mapping/delete/debit/" + fc_coacode;


            $('td:eq(3)', row).html(`
                    <button type="button" class="btn btn-primary btn-sm mr-1" onclick="detail('${data.fc_coacode}')"><i class="fa fa-eye"> </i> Detail</button>
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
            url: "/apps/master-mapping/create/datatables-kredit/" + encode_mappingcode,
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2]
        }, {
            className: 'text-nowrap',
            targets: [3]
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
                data: 'mst_coa.fc_coaname'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var fc_mappingcode = window.btoa(data.fc_mappingcode);
            var fc_coacode = window.btoa(data.fc_coacode);
            var url_delete = "/apps/master-mapping/delete/kredit/" + fc_coacode;


            $('td:eq(3)', row).html(`
            <button type="button" class="btn btn-primary btn-sm mr-1" onclick="detail('${data.fc_coacode}')"><i class="fa fa-eye"> </i> Detail</button>
                `);
        },
    });
</script>
@endsection