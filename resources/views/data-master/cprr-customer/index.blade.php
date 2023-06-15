@extends('partial.app')
@section('title','CPRR Customer')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2) {
        overflow-x: auto;
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
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah CPRR Customer</h4>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                    <form id="form_submit" action="/data-master/cprr-customer/store-update" method="POST" autocomplete="off">
                        <input type="text" name="type" id="type" hidden>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6" hidden>
                                    <div class="form-group">
                                        <label>Division Code</label>
                                        <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group required">
                                        <label>Cabang</label>
                                        <select class="form-control select2 required-field" name="fc_branch" id="fc_branch" required></select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group required">
                                        <label>Member Code</label>
                                        <select class="form-control select2 required-field" name="fc_membercode" id="fc_membercode" required></select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>-</label>
                                        <button type="button" class="btn btn-info btn-block" onclick="click_cprr()">Pilih CPRR</button>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Kode CPRR</label>
                                        <input type="text" class="form-control" name="fc_cprrcode" id="fc_cprrcode" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label>Nama CPRR</label>
                                        <input type="text" class="form-control" name="fc_cprrname" id="fc_cprrname" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-lg-4">
                                    <div class="form-group required">
                                        <label>Price</label>
                                        <input type="text" class="form-control format-rp" name="fm_price" id="fm_price" onkeyup="return onkeyupRupiah(this.id);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" onclick="click_reset()" hidden id="button_reset" class="btn btn-danger">Reset Data</button>
                            <button type="submit" class="btn btn-success">Simpan Data CPRR Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data CPRR Customer</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead style="white-space: nowrap">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Divisi</th>
                                    <th scope="col" class="text-center">Cabang</th>
                                    <th scope="col" class="text-center">Nama Customer</th>
                                    <th scope="col" class="text-center">Kode CPRR</th>
                                    <th scope="col" class="text-center">Nama CPRR</th>
                                    <th scope="col" class="text-center">Price</th>
                                    <th scope="col" class="text-center">Actions</th>
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
<div class="modal fade" role="dialog" id="modal_cprr" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih CPRR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" id="counting" hidden>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_cprr" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Divisi</th>
                                <th scope="col" class="text-center">Cabang</th>
                                <th scope="col" class="text-center">Kode CPRR</th>
                                <th scope="col" class="text-center">Nama Pemeriksaan</th>
                                <th scope="col" class="text-center" style="width: 20%">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function() {
        get_data_branch();
        get_data_customer_code();
    })

    function click_cprr() {
        $('#modal_cprr').modal('show');
        table_cprr();
    }

    function table_cprr() {
        var tb = $('#tb_cprr').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '/data-master/master-cprr/datatables',
                type: 'GET'
            },
            columnDefs: [{
                className: 'text-center',
                targets: [0, 2, 3, 4, 5]
            }, ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'fc_divisioncode'
                },
                {
                    data: 'branch.fv_description'
                },
                {
                    data: 'fc_cprrcode'
                },
                {
                    data: 'fc_cprrname'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(5)', row).html(`
                    <button class="btn btn-warning btn-sm mr-1" onclick="pilih('${data.fc_cprrcode}')"><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });

    }

    function pilih($fc_cprrcode) {
        // console.log($fc_cprrcode)
        $.ajax({
            url: "/data-master/cprr-customer/detail/" + $fc_cprrcode,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                $("#modal_cprr").modal('hide');
                $('#fc_cprrcode').val(response.fc_cprrcode);
                $('#fc_cprrname').val(response.fc_cprrname);
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

    function get_data_customer_code() {
        $("#modal_loading").modal('show');
        $.ajax({
            url: "/master/get-data-all/Customer",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status === 200) {
                    var data = response.data;
                    console.log(data)
                    $("#fc_membercode").empty();
                    $("#fc_membercode").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membercode").append(`<option value="${data[i].fc_membercode}">${data[i].fc_membername1}</option>`);
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

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax: {
            url: '/data-master/cprr-customer/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 1, 2, 3]
            },
            {
                className: 'text-nowrap',
                targets: [7]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_divisioncode'
            },
            {
                data: 'branch.fv_description'
            },
            {
                data: 'customer.fc_membername1',
                defaultContent: '-',
            },
            {
                data: 'fc_cprrcode'
            },
            {
                data: 'cospertes.fc_cprrname',
            },
            {
                data: 'fm_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var url_edit = "/data-master/cprr-customer/detail/" + data.fc_cprrcode;
            var url_delete = "/data-master/cprr-customer/delete/" + data.id + '/' + data.fc_cprrcode;

            $('td:eq(7)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}','${data.fc_cprrcode}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_cprrcode}')"><i class="fa fa-trash"> </i> Hapus</button>
                `);
        }

    });

    function edit(url, cprrcode) {
        edit_action_custom(url, cprrcode);
        $("#type").val('update');
    }

    function edit_action_custom(url, cprrcode) {
        save_method = 'edit';
        $("#modal_loading").modal('show');
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                Object.keys(response).forEach(function(key) {
                    var elem_name = $('[name=' + key + ']');
                    if (elem_name.hasClass('selectric')) {
                        elem_name.val(response[key]).change().selectric('refresh');
                    } else if (elem_name.hasClass('select2')) {
                        elem_name.select2("trigger", "select", {
                            data: {
                                id: response[key]
                            }
                        });
                    } else if (elem_name.hasClass('selectgroup-input')) {
                        $("input[name=" + key + "][value=" + response[key] + "]").prop('checked', true);
                    } else if (elem_name.hasClass('my-ckeditor')) {
                        CKEDITOR.instances[key].setData(response[key]);
                    } else if (elem_name.hasClass('summernote')) {
                        elem_name.summernote('code', response[key]);
                    } else if (elem_name.hasClass('custom-control-input')) {
                        $("input[name=" + key + "][value=" + response[key] + "]").prop('checked', true);
                    } else if (elem_name.hasClass('time-format')) {
                        elem_name.val(response[key].substr(0, 5));
                    } else if (elem_name.hasClass('format-rp')) {
                        var nominal = response[key].toString();
                        elem_name.val(nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
                    } else {
                        elem_name.val(response[key]);
                    }
                });

                $('#fc_cprrcode').val(cprrcode);
                $('#fc_membercode').val(response.fc_membercode);
                $('#fm_price').val(response.fm_price);
                $('#button_reset').attr('hidden', false);
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
</script>
@endsection