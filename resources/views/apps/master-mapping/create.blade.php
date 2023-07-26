@extends('partial.app')
@section('title', 'Buat Mapping')
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
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Divisi</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_divisioncode }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Cabang</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_branch }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Kode Mapping</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_mappingcode }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Nama Mapping</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_mappingname }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group required">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->created_by }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-9">
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{ $data->fv_description ?? '-' }}" readonly>
                                    </div>
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
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_add_debit();"><i class="fa fa-plus mr-1"></i> Tambah Debit</button>
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
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="click_add_kredit();"><i class="fa fa-plus mr-1"></i> Tambah Kredit</button>
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
        <form id="form_submit_edit" action="/apps/master-mapping/submit" method="post">
            <button type="button" onclick="click_cancel()" class="btn btn-danger mr-1">Cancel</button>
            @csrf
            @method('put')
            <button type="submit" class="btn btn-success">Submit Mapping</button>
        </form>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_debit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Debit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_coa_debit" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode COA</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Layer</th>
                                    <th scope="col" class="text-center">COA Induk</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center">Action</th>
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

<div class="modal fade" role="dialog" id="modal_kredit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Kredit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_coa_kredit" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode COA</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Layer</th>
                                    <th scope="col" class="text-center">COA Induk</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center">Action</th>
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
    var mappingcode = "{{ $data->fc_mappingcode }}";
    var encode_mappingcode = window.btoa(mappingcode);

    // console.log(encode_mappingcode)

    function click_add_debit() {
        $('#modal_debit').modal('show');
    }

    function click_add_kredit() {
        $('#modal_kredit').modal('show');
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
                data: 'fc_mappingcode'
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
                    <a href="/apps/master-mapping/detail/${fc_mappingcode}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.mst_coa.fc_coaname}')"><i class="fa fa-trash"> </i> Hapus</button>
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
            var url_delete = "/apps/master-mapping/delete/kredit/" + data.fc_mappingcode;
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            $('td:eq(3)', row).html(`
                    <a href="/apps/master-mapping/detail/${fc_mappingcode}" class="btn btn-primary btn-sm mr-1"><i class="fa fa-eye"></i> Detail</a>
                    <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.mst_coa.fc_coaname}')"><i class="fa fa-trash"> </i> Hapus</button>
                `);
        },
    });

    var tb_coa_debit = $('#tb_coa_debit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/master-coa/datatables",
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
                data: 'fc_coaname'
            },
            {
                data: 'fn_layer'
            },
            {
                data: 'parent.fc_coaname',
                defaultContent: '<span class="badge bg-primary text-light">COA INDUK</span>',
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/master-mapping/delete/" + data.fc_mappingcode;
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            $('td:eq(6)', row).html(`
                    <button class="btn btn-warning btn-sm mr-1" onclick="select_coa_debit('${data.fc_coacode}')"><i class="fas fa-check"></i> Pilih</button>
                `);
        },
    });

    function select_coa_debit(fc_coacode){
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/master-mapping/create/insert-debit',
            type: 'POST',
            data: {
                fc_coacode: fc_coacode,
                fc_mappingcode: mappingcode,
            },
            success: function(response) {
                if (response.status == 200) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal_loading").modal('hide');
                    tb_coa_debit.ajax.reload();
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



    var tb_coa_kredit = $('#tb_coa_kredit').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/master-coa/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5]
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
                data: 'fc_coacode'
            },
            {
                data: 'fc_coaname'
            },
            {
                data: 'fn_layer'
            },
            {
                data: 'parent.fc_coaname',
                defaultContent: '<span class="badge bg-primary text-light">COA INDUK</span>',
            },
            {
                data: 'fv_description',
                defaultContent: '-'
            },
            {
                data: null
            },
        ],

        rowCallback: function(row, data) {
            var url_delete = "/apps/master-mapping/delete/" + data.fc_mappingcode;
            var fc_mappingcode = window.btoa(data.fc_mappingcode);

            $('td:eq(6)', row).html(`
                    <button class="btn btn-warning btn-sm mr-1" onclick="select_coa_kredit('${data.fc_coacode}')"><i class="fas fa-check"></i> Pilih</button>
                `);
        },
    });

    function select_coa_kredit(fc_coacode){
        $("#modal_loading").modal('show');
        $.ajax({
            url: '/apps/master-mapping/create/insert-kredit',
            type: 'POST',
            data: {
                fc_coacode: fc_coacode,
                fc_mappingcode: mappingcode,
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

    function click_cancel(mappingcode) {
        swal({
                title: 'Apakah anda yakin?',
                text: 'Apakah anda yakin akan mengcancel Buat Mapping ini?',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $("#modal_loading").modal('show');
                    $.ajax({
                        url: '/apps/master-mapping/cancel/' + encode_mappingcode,
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
</script>
@endsection