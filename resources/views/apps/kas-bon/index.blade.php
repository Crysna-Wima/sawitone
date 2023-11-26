@extends('partial.app')
@section('title', 'Kas Bon')
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
    {{-- @dd($data) --}}
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Daftar Kas Bon</h4>
                        <div class="card-header-action">
                            <button type="button" class="btn btn-success" onclick="add();">
                                <i class="fa fa-plus mr-1"></i> Tambah Kas Bon
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Nama Pengguna</th>
                                        <th scope="col" class="text-center">Tanggal</th>
                                        <th scope="col" class="text-center">Keterangan</th>
                                        <th scope="col" class="text-center">Nominal</th>
                                        <th scope="col" class="text-center">Status</th>
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
    <div class="modal fade" role="dialog" id="modal_create" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="/apps/kas-bon/store" method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group required">
                                    <label>Nama</label>
                                    <input type="text" class="form-control required-field" name="fc_userapplicant"
                                        required />
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control required-field" name="fd_kasbondate"
                                        required />
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group required">
                                    <label>Nominal</label>
                                    <input type="number" class="form-control required-field" name="fm_nominal" required />
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group required">
                                    <label>Keterangan</label>
                                    <textarea class="form-control required-filed" name="fv_description" style="height: 90px"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function add() {
            $("#modal_create").modal('show');
            $(".modal-title").text('Tambah Kas Bon');
            $("#form_submit")[0].reset();
        }

        // var tb = $('#tb').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     pageLength: 5,
        //     ajax: {
        //         url: '/apps/kas-bon/datatables',
        //         type: 'GET'
        //     },
        //     columnDefs: [{
        //         className: 'text-center',
        //         targets: [0, 2, 3, 4, 6]
        //     }, ],
        //     columns: [{
        //             data: 'DT_RowIndex',
        //             searchable: false,
        //             orderable: false
        //         },
        //         //add data for datatables here
        //         {
        //             'Nama'
        //         },
        //         {
        //             'xx/xx/xxxx'
        //         },
        //         {
        //             'Id sit pariatur esse occaecat excepteur aliqua mollit amet. Ad laboris proident pariatur eu officia aliqua officia excepteur aute amet. Nisi eu do aliqua voluptate cillum anim laborum occaecat officia.'
        //         },
        //         {
        //             'Rp. xxxxxxx'
        //         },
        //         {
        //             data: 'DT_RowIndex'
        //         },
        //     ],
        //     rowCallback: function(row, data) {
        //         if (data['status'] == 'J') {
        //             $('td:eq(#)', row).html('<span class="badge badge-success">Journal</span>');
        //         } else if (data['status' == 'CC']) {
        //             $('td:eq(#)', row).html('<span class="badge badge-danger">Cancel</span>');
        //         } else {
        //             $('td:eq(#)', row).html('<span class="badge badge-primary">Process</span>');
        //         }

        //         var url_cencel = "/" + data.id;
        //         var url_delete = "/" + data.id;

        //         $('td:eq(#)', row).html(
        //             `
    //     <button class="btn btn-info btn-sm mr-1" onclick="cancel('#')"><i class="fa fa-edit"></i> Cancel</button>
    //     <button class="btn btn-danger btn-sm" onclick="submit('#')"><i class="fa fa-trash"> </i> Submit</button>`
        //         );
        //     }
        // });
    </script>
@endsection
