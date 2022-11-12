@extends('partial.app')
@section('title','Master Stock Customer')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Stock Customer</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Stock Customer</button>
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
                           <th scope="col" class="text-center">Stock Code</th>
                           <th scope="col" class="text-center">Member Code</th>
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
            <form id="form_submit" action="/data-master/stock-customer/store-update" method="POST" autocomplete="off">
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
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Stock Code</label>
                                <select class="form-control select2 required-field" name="fc_stockcode" id="fc_stockcode"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Member Code</label>
                                <select class="form-control select2 required-field" name="fc_membercode" id="fc_membercode"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Barcode</label>
                                <input type="text" class="form-control required-field" name="fc_barcode" id="fc_barcode">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Price Customer</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_customer" id="fm_price_customer" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_default" id="fm_price_default" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Price Distributor</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_distributor" id="fm_price_distributor" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Price Project</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_project" id="fm_price_project" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Price Dealer</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_dealer" id="fm_price_dealer" onkeyup="return onkeyupRupiah(this.id);">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Price End User</label>
                                <input type="text" class="form-control required-field format-rp" name="fm_price_enduser" id="fm_price_enduser" onkeyup="return onkeyupRupiah(this.id);">
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
        get_data_stock_code();
        get_data_customer_code();
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

    function get_data_stock_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/Stock",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_stockcode").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_stockcode").append(`<option value="${data[i].fc_stockcode}">${data[i].fc_nameshort}</option>`);
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

    function get_data_customer_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/Customer",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    console.log(data)
                    $("#fc_membercode").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membercode").append(`<option value="${data[i].fc_membercode}">${data[i].fc_membername1}</option>`);
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
      $(".modal-title").text('Tambah Stock Customer');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/stock-customer/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,5] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_divisioncode' },
         { data: 'fc_branch' },
         { data: 'fc_stockcode' },
         { data: 'fc_membercode' },
         { data: 'fc_membercode' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/stock-customer/detail/" + data.fc_stockcode + '/' + data.fc_membercode;
         var url_delete = "/data-master/stock-customer/delete/" + data.fc_stockcode + '/' + data.fc_membercode;

         $('td:eq(5)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fv_description}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Data Stock Customer');
      $("#type").val('update');
   }
</script>
@endsection
