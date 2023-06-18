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
            <form id="form_submit" action="/data-master/master-role/create" method="POST" autocomplete="off">
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
                        @foreach ($permission_groups as $group)
                        <div class="row">
                            <div class="col-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                    <label class="form-check-label" for="checkPermission">{{ $group->name }}</label>
                                </div>
                            </div>

                            <div class="col-9 role-{{ $i }}-management-checkbox">
                                @php
                                    $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                    $j = 1;
                                @endphp
                                @foreach ($permissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                        <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                    @php  $j++; @endphp
                                @endforeach
                                <br>
                            </div>
                        </div>
                        @php  $i++; @endphp
                        @endforeach
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

     /**
         * Check all the permissions
         */
         $("#checkPermissionAll").click(function(){
             if($(this).is(':checked')){
                 // check all the checkbox
                 $('input[type=checkbox]').prop('checked', true);
             }else{
                 // un check all the checkbox
                 $('input[type=checkbox]').prop('checked', false);
             }
         });

         function checkPermissionByGroup(className, checkThis){
            const groupIdName = $("#"+checkThis.id);
            const classCheckBox = $('.'+className+' input');

            if(groupIdName.is(':checked')){
                 classCheckBox.prop('checked', true);
             }else{
                 classCheckBox.prop('checked', false);
             }
            implementAllChecked();
         }

         function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
            const classCheckbox = $('.'+groupClassName+ ' input');
            const groupIDCheckBox = $("#"+groupID);

            // if there is any occurance where something is not selected then make selected = false
            if($('.'+groupClassName+ ' input:checked').length == countTotalPermission){
                groupIDCheckBox.prop('checked', true);
            }else{
                groupIDCheckBox.prop('checked', false);
            }
            implementAllChecked();
         }

         function implementAllChecked() {
             const countPermissions = {{ count($all_permissions) }};
             const countPermissionGroups = {{ count($permission_groups) }};

            //  console.log((countPermissions + countPermissionGroups));
            //  console.log($('input[type="checkbox"]:checked').length);

             if($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)){
                $("#checkPermissionAll").prop('checked', true);
            }else{
                $("#checkPermissionAll").prop('checked', false);
            }
         }



         var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/data-master/master-role/datatable',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 1]
                },
                {
                    className: 'text-nowrap',
                    targets: [0]
                },
            ],
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'permissions',
                    render: function(data) {
                        var permissions = data.map(function(permission) {
                            return permission.name;
                        });
                        return permissions.join(', ');
                    }
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(4)', row).html(`
                    <button class="btn btn-info btn-sm mr-1" ><i class="fa fa-edit"></i> Edit</button>
                    <button class="btn btn-danger btn-sm" ><i class="fa fa-trash"> </i> Hapus</button>
                `);
            }
        });
</script>
@endsection
{{-- @section('scripts')
     @include('data-master.master-role.partials.scripts')
@endsection --}}