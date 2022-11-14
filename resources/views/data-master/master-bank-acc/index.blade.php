@extends('partial.app')
@section('title','Master Bank Acc')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
    }
</style>
@endsection
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Bank Acc</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Bank Acc</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive" style="overflow-x: unset">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead style="white-space: nowrap">
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Division</th>
                           <th scope="col" class="text-center">Branch</th>
                           <th scope="col" class="text-center">Bank Name</th>
                           <th scope="col" class="text-center">Bank Type</th>
                           <th scope="col" class="text-center">Bank Code</th>
                           <th scope="col" class="text-center">Bank Branch</th>
                           <th scope="col" class="text-center">Bank Username</th>
                           <th scope="col" class="text-center">Bank Hold</th>
                           <th scope="col" class="text-center">Bank Address 1</th>
                           <th scope="col" class="text-center">Bank Address 2</th>
                           <th scope="col" class="text-center justify-content-center">Actions</th>
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
            <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/data-master/master-bank-acc/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control select2 required-field" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" class="form-control required-field" name="fv_bankname" id="fv_bankname">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Bank Type</label>
                                <select class="form-control select2" name="fc_banktype" id="fc_banktype">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bank Code</label>
                                <input type="text" class="form-control" name="fc_bankcode" id="fc_bankcode">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Bank Username</label>
                                <input type="text" class="form-control" name="fv_bankusername" id="fv_bankusername">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Bank Hold</label>
                                <select class="form-control select2" name="fl_bankhold" id="fl_bankhold">
                                    <option value="T">YES</option>
                                    <option selected value="F">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Bank Branch</label>
                                <input type="text" class="form-control" name="fv_bankbranch" id="fv_bankbranch">
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Bank Address 1</label>
                                <textarea class="form-control" name="fv_bankaddress1" id="fv_bankaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Bank Address 2</label>
                                <textarea class="form-control" name="fv_bankaddress2" id="fv_bankaddress2" style="height: 100px"></textarea>
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
    })

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
                        if(data[i].fc_kode == $('#fc_branch_view').val()){
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch").prop("disabled", true);
                        }else{
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
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
      $(".modal-title").text('Tambah Master Bank Acc');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/master-bank-acc/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,11] },
         { className: 'd-flex', targets: [11] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_divisioncode' },
         { data: 'branch.fv_description' },
         { data: 'fv_bankname' },
         { data: 'fc_banktype' },
         { data: 'fc_bankcode' },
         { data: 'fv_bankbranch' },
         { data: 'fv_bankusername' },
         { data: 'fl_bankhold' },
         { data: 'fv_bankaddress1' },
         { data: 'fv_bankaddress2' },
         { data: 'fv_bankaddress2' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/master-bank-acc/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_bankcode;
         var url_delete = "/data-master/master-bank-acc/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_bankcode;

         $('td:eq(11)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fv_bankname}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Data Master Bank Acc');
      $("#type").val('update');
   }
</script>
@endsection
