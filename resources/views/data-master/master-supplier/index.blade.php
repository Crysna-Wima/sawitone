@extends('partial.app')
@section('title','Master Supplier')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Supplier</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Supplier</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Kode</th>
                           <th scope="col" class="text-center">Legal Status</th>
                           <th scope="col" class="text-center">Nama</th>
                           <th scope="col" class="text-center">Phone    </th>
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
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static" style="overflow-y: auto">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/data-master/master-supplier/store-update" method="POST" autocomplete="off">
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
                                <label>Supplier Code</label>
                                <input type="text" class="form-control required-field" name="fc_suppliercode" id="fc_suppliercode">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Name 1</label>
                                <input type="text" class="form-control required-field" name="fc_suppliername1" id="fc_suppliername1">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Name 2</label>
                                <input type="text" class="form-control required-field" name="fc_suppliername2" id="fc_suppliername2">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Pic Name</label>
                                <input type="text" class="form-control required-field" name="fc_supplierpicname" id="fc_supplierpicname">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Pic Phone</label>
                                <input type="text" class="form-control required-field" name="fc_supplierpicphone" id="fc_supplierpicphone">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Pic Pos</label>
                                <input type="text" class="form-control required-field" name="fc_supplierpicpos" id="fc_supplierpicpos">
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Legal Status</label>
                                <select class="select2" name="fc_supplierlegalstatus" id="fc_supplierlegalstatus"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Nationality</label>
                                <select class="select2" name="fc_suppliernationality" id="fc_suppliernationality"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Forex</label>
                                <input type="text" readonly class="form-control" name="fc_supplierforex" id="fc_supplierforex" value="s">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Type Business</label>
                                <select class="select2" name="fc_suppliertypebusiness" id="fc_suppliertypebusiness"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Join Date</label>
                                <input type="text"   class="form-control datepicker" name="fd_supplierjoindate" id="fd_supplierjoindate">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Expired</label>
                                <input type="text" class="form-control datepicker" name="fd_supplierexpired" id="fd_supplierexpired">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Reseller</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_supplierreseller" value="T" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_supplierreseller" value="F" class="selectgroup-input">
                                        <span class="selectgroup-button">Non Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Tax Code</label>
                                <select class="select2" name="fc_suppliertaxcode" id="fc_suppliertaxcode"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier NPWP</label>
                                <input type="text" class="form-control" name="fc_supplierNPWP" id="fc_supplierNPWP">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier NPWP Name</label>
                                <input type="text" class="form-control" name="fc_suppliernpwp_name" id="fc_suppliernpwp_name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier NPWP Address 1</label>
                                <textarea type="text" class="form-control" name="fc_supplier_npwpaddress1" id="fc_supplier_npwpaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier NPWP Address 2</label>
                                <textarea type="text" class="form-control" name="fc_supplier_npwpaddress2" id="fc_supplier_npwpaddress2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Email 1</label>
                                <input type="text" class="form-control" name="fc_supplieremail1" id="fc_supplieremail1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Email 2</label>
                                <input type="text" class="form-control" name="fc_supplieremail2" id="fc_supplieremail2">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Phone 1</label>
                                <input type="text" class="form-control" name="fc_supplierphone1" id="fc_supplierphone1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Phone 2</label>
                                <input type="text" class="form-control" name="fc_supplierphone2" id="fc_supplierphone2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Phone 3</label>
                                <input type="text" class="form-control" name="fc_supplierphone3" id="fc_supplierphone3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Bank 1</label>
                                <select type="text" class="form-control select2" name="fc_supplierbank1" id="fc_supplierbank1"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Bank 2</label>
                                <select type="text" class="form-control select2" name="fc_supplierbank2" id="fc_supplierbank2"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Bank 3</label>
                                <select type="text" class="form-control select2" name="fc_supplierbank3" id="fc_supplierbank3"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier No Rekening 1</label>
                                <input type="text" class="form-control" name="fc_suppliernorek1" id="fc_suppliernorek1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier No Rekening 2</label>
                                <input type="text" class="form-control" name="fc_suppliernorek2" id="fc_suppliernorek2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier No Rekening 3</label>
                                <input type="text" class="form-control" name="fc_suppliernorek3" id="fc_suppliernorek3">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Virtual AC</label>
                                <input type="text" class="form-control" name="fc_suppliervirtualac" id="fc_suppliervirtualac">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Aging AR</label>
                                <input type="text" class="form-control" name="fn_supplierAgingAR" id="fn_supplierAgingAR">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Lock Transaksi</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fn_supplierlockTrans" value="T" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">LOCK</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fn_supplierlockTrans" value="F" class="selectgroup-input">
                                        <span class="selectgroup-button">NOT LOCK</span>
                                    </label>
                                </div>
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
        get_data_legal_status();
        get_data_nationality();
        get_data_type_business();
        get_data_tax_code();
        get_data_supplier_bank();
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

    function get_data_legal_status(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_supplierlegalstatus").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_supplierlegalstatus").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_nationality(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_suppliernationality").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliernationality").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_type_business(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_suppliertypebusiness").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliertypebusiness").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_tax_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_suppliertaxcode").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliertaxcode").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_supplier_bank(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/BankAcc",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_supplierbank1").empty();
                    $("#fc_supplierbank2").empty();
                    $("#fc_supplierbank3").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_supplierbank1").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
                        $("#fc_supplierbank2").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
                        $("#fc_supplierbank3").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
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
      $(".modal-title").text('Tambah Master Supplier');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/master-supplier/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,5] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_suppliercode' },
         { data: 'fc_supplierlegalstatus' },
         { data: 'fc_suppliername1' },
         { data: 'fc_supplierphone1' },
         { data: 'fc_supplierphone1' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/master-supplier/detail/" + data.fc_suppliercode;
         var url_delete = "/data-master/master-supplier/delete/" + data.fc_suppliercode;

         $('td:eq(5)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_suppliername1}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Data Master Supplier');
      $("#type").val('update');
   }
</script>
@endsection
