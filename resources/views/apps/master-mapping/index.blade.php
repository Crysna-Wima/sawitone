@extends('partial.app')
@section('title', 'Master Mapping')
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
                    <h4>Data Mapping</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_modal_add();"><i class="fa fa-plus mr-1"></i> Tambah Data Mapping</button>
                    </div>
                </div>
                <div class="card-body">
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
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_add" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Tambah Data Mapping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/apps/master-mapping/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Division Code</label>
                                <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-6">
                            <div class="form-group required">
                                <label>Kode Mapping</label>
                                <input type="text" class="form-control required-field" name="fc_mappingcode" id="fc_mappingcode">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Operator</label>
                                <input type="text" class="form-control required-field" name="" id="" value="{{ auth()->user()->fc_username }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-9">
                            <div class="form-group required">
                                <label>Nama Mapping</label>
                                <input type="text" class="form-control required-field" name="fc_mappingname" id="fc_mappingname">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="fv_description" id="fv_description" style="height: 50px" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" role="dialog" id="modal_edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Edit Data Mapping</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view_edit" id="fc_branch_view_edit" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit_cprr" action="/apps/master-mapping/update" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Division Code</label>
                                <input type="text" class="form-control" name="fc_divisioncode_edit" id="fc_divisioncode_edit" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2" name="fc_branch_edit" id="fc_branch_edit"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-6">
                            <div class="form-group required">
                                <label>Kode Mapping</label>
                                <input type="text" class="form-control required-field" name="fc_mappingcode_edit" id="fc_mappingcode_edit">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Operator</label>
                                <input type="text" class="form-control required-field" name="" id="" value="{{ auth()->user()->fc_username }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-9">
                            <div class="form-group required">
                                <label>Nama Mapping</label>
                                <input type="text" class="form-control required-field" name="fc_mappingname_edit" id="fc_mappingname_edit">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="fv_description_edit" id="fv_description_edit" style="height: 50px" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        get_data_branch();
        get_data_branch_edit();
    })

    function click_modal_add() {
        $('#modal_add').modal('show');
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

    function get_data_branch_edit() {
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
                    $("#fc_branch_edit").empty();
                    for (var i = 0; i < data.length; i++) {
                        if (data[i].fc_kode == $('#fc_branch_view_edit').val()) {
                            $("#fc_branch_edit").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch_edit").prop("disabled", true);
                        } else {
                            $("#fc_branch_edit").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function edit(fc_mappingcode) {
        $('#modal_loading').modal('show');

        $.ajax({
            url: '/apps/master-mapping/get-data/edit',
            type: 'GET',
            data: {
                fc_mappingcode: fc_mappingcode
            },
            success: function(response) {
                var data = response.data;

                if (response.status == 200) {
                    // modal_loading hide
                    setTimeout(function() {
                        $('#modal_loading').modal('hide');
                    }, 500);
                    $('#modal_edit').modal('show');
                }
            },
            error: function() {
                alert('Terjadi kesalahan pada server');
                $('#modal_loading').modal('hide');
            }
        });
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/master-mapping/datatables",
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
                data: null
            },
            {
                data: null
            },
            {
                data: 'fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var url_edit = "/apps/master-mapping/edit/" + data.fc_mappingcode;
            var url_delete = "/apps/master-mapping/delete/" + data.fc_mappingcode;
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            $('td:eq(6)', row).html(`
                    <a href="/apps/master-mapping/detail/${fc_mappingcode}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}','${data.fc_mappingcode}')"><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_mappingname}')"><i class="fa fa-trash"> </i> Hapus</button>
                `);
        },
    });

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection