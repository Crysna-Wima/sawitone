@extends('partial.app')
@section('title','Master Warehouse')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Warehouse</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Warehouse</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Divisi</th>
                           <th scope="col" class="text-center">Branch</th>
                           <th scope="col" class="text-center">Warehouse</th>
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
          <form id="form_submit" action="/data-master/master-warehouse/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type">
             <div class="modal-body">
                <div class="row">
                     <div class="col-12 col-md-6 col-lg-6">
                         <div class="form-group">
                             <label>Division Code</label>
                             <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode">
                         </div>
                     </div>
                     <div class="col-12 col-md-6 col-lg-6">
                         <div class="form-group">
                             <label>Branch</label>
                             <select type="text" class="form-control select2 required-field" name="fc_branch" id="fc_branch"></select>
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
                                 <option value="INTERNAL">Internal</option>
                                 <option value="EXTERNAL">External</option>
                             </select>
                         </div>
                     </div>
                     <div class="col-12 col-md-3 col-lg-3">
                         <div class="form-group">
                             <label>Status</label>
                             <select class="form-control select2 required-field" name="fl_status" id="fl_status">
                                <option value="G">Gudang</option>
                                <option value="D">Display</option>
                             </select>
                         </div>
                     </div>

                     <div class="col-12 col-md-9 col-lg-9">
                         <div class="form-group">
                             <label>Rackname</label>
                             <input type="text" class="form-control required-field" name="fc_rackname" id="fc_rackname">
                         </div>
                     </div>
                     <div class="col-12 col-md-3 col-lg-3">
                         <div class="form-group">
                             <label>Capacity</label>
                             <input type="number" class="form-control required-field" name="fn_capacity" id="fn_capacity">
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

$(document).ready(function(){
        get_data_branch();
    });

    function get_data_branch(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_branch").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function add(){
      $("#modal").modal('show');
      $(".modal-title").text('Tambah Master Warehouse');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/master-warehouse/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,1,2] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_divisioncode' },
         { data: 'transaksi_type.fv_description' },
         { data: 'fc_warehousecode' },
         { data: 'fc_warehousecode' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/master-warehouse/detail/" + data.fc_warehousecode;
         var url_delete = "/data-master/master-warehouse/delete/" + data.fc_warehousecode;

         $('td:eq(4)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_warehousecode}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Data Master Warehouse');
      $("#type").val('update');
   }
</script>
@endsection
