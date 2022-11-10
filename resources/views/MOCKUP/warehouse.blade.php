@extends('partial.app')
@section('title','Master Sales')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Sales</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Sales</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Type</th>
                           <th scope="col" class="text-center">Kode</th>
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
         <form id="form_submit" action="/data-master/meta-data/store-update" method="POST" autocomplete="off">
            <div class="modal-body">
               <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Division Code</label>
                            <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode">
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="form-group">
                            <label>Branch</label>
                            <input type="text" class="form-control required-field" name="fc_branch" id="fc_branch">
                        </div>
                    </div>
                    <div class="col-12 col-md-2 col-lg-2 d-flex justify-content-center align-items-center">
                        <div class="form-group" style="margin: 1px">
                            <button type="button" class="btn btn-primary">Modal TRXTYPE</button>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label>Warehouse Code</label>
                            <input type="text" class="form-control required-field" name="fc_warehousecode" id="fc_warehousecode">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Warehouse Pos</label>
                            <select class="form-control select2 required-field" name="fc_warehousepos" id="fc_warehousepos">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control select2 required-field" name="fl_status" id="fl_status">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-md-9 col-lg-9">
                        <div class="form-group">
                            <label>Racname</label>
                            <input type="text" class="form-control required-field" name="fc_racname" id="fc_racname">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Capacity</label>
                            <input type="text" class="form-control required-field" name="fn_capacity" id="fn_capacity">
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control required-field" name="fv_description" id="fv_description" style="height: 150px"></textarea>
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

    function add(){
      $("#modal").modal('show');
      $(".modal-title").text('Tambah User');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/meta-data/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,4] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_trx' },
         { data: 'fc_kode' },
         { data: 'fv_description' },
         { data: 'fc_kode' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/meta-data/detail/" + data.fc_kode;
         var url_delete = "/data-master/meta-data/delete/" + data.fc_kode;

         $('td:eq(4)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fv_description}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Data Master Sales');
      $("#type").val('update');
   }
</script>
@endsection
