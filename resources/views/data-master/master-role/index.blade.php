@extends('partial.app')
@section('title','Master Role')
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

    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Role</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Role</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead style="white-space: nowrap">
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center" width="10%">Role ID</th>
                                    <th class="text-center" width="10%">Nama Role</th>
                                    <th class="text-center" width="50%">Hak Akses</th>
                                    <th class="text-center" width="15%">Actions</th>
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
<!-- Modal -->
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/data-master/master-cprr/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nama Role</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama role">
                    </div>

                    <div class="form-group">
                        <label for="name">Hak Akses</label>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                            <label class="form-check-label" for="checkPermissionAll">All</label>
                        </div>
                        <hr>
                        @php $i = 1; @endphp
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                    <label class="form-check-label" for="checkPermission">Tes</label>
                                </div>
                            </div>

                            <div class="col-9 role-{{ $i }}-management-checkbox">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="permissions[]" id="" value="">
                                    <label class="form-check-label" for="checkPermission"></label>
                                </div>
                                <br>
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

<!-- Modal Update -->
<!-- <div class="modal fade" role="dialog" id="modal_edit" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Edit Data Master CPRR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control" name="fc_branch_view_edit" id="fc_branch_view_edit" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit_cprr" action="/data-master/master-cprr/update" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="text" class="form-control" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group required">
                                <label>Cabang</label>
                                <select class="form-control select2" name="fc_branch_edit" id="fc_branch_edit"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-9">
                            <div class="form-group required">
                                <label>Kode CPRR</label>
                                <input type="text" class="form-control required-field" name="fc_cprrcode" id="fc_cprrcode_edit" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-12">
                            <div class="form-group required">
                                <label>Nama Pemeriksaan</label>
                                <input type="text" class="form-control required-field" name="fc_cprrname" id="fc_cprrname_edit">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="fv_description" id="fv_description_edit" style="height: 50px" class="form-control"></textarea>
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
</div> -->

@endsection

@section('js')
<script>
    function add() {
        $("#modal").modal('show');
        $(".modal-title").text('Tambah Role');
        $("#form_submit")[0].reset();
    }

    $('.modal').css('overflow-y', 'auto');
</script>
@endsection
