@extends('partial.app')
@section('title','Master Stock')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Stock</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Stock</button>
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
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/data-master/master-stock/store-update" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Branch</label>
                                <select type="text" class="form-control select2 required-field" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Stock Code</label>
                                <input type="text" class="form-control required-field" name="fc_stockcode" id="fc_stockcode">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Barcode</label>
                                <input type="text" class="form-control required-field" name="fc_barcode" id="fc_barcode">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Name Short</label>
                                <input type="text" class="form-control required-field" name="fc_nameshort" id="fc_nameshort">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Name Long</label>
                                <input type="text" class="form-control required-field" name="fc_namelong" id="fc_namelong">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Name Pack</label>
                                <input type="text" class="form-control required-field" name="fc_namepack" id="fc_namepack">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Brand</label>
                                <input type="text" class="form-control required-field" name="fc_brand" id="fc_brand">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Group</label>
                                <input type="text" class="form-control" name="fc_group" id="fc_group" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Sub Group</label>
                                <input type="text" class="form-control" name="fc_subgroup" id="fc_subgroup" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3"></div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Batch</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_batch" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_batch" value="0" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Expired Date</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_expired" value="F" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_expired" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Serial Number</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_serialnumber" value="F" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_serialnumber" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Cat Number</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_catnumber" value="F" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_catnumber" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Blacklist</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_blacklist" value="F" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_blacklist" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Tax Type</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_taxtype" value="F" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_taxtype" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Rep Supplier</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_repsupplier" value="F" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_repsupplier" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3"></div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Type Stock 1</label>
                                <select class="form-control select2 required-field" name="fc_typestock1" id="fc_typestock1"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Type Stock 2</label>
                                <select class="form-control select2 required-field" name="fc_typestock2" id="fc_typestock2"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Reorder Level</label>
                                <input type="text" class="form-control required-field" name="fn_reorderlevel" id="fn_reorderlevel">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Max on Hand</label>
                                <input type="text" class="form-control required-field" name="fn_maxonhand" id="fn_maxonhand">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Cogs</label>
                                <input type="text" class="form-control required-field" name="fm_cogs" id="fm_cogs">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Purchase</label>
                                <input type="text" class="form-control required-field" name="fm_purchase" id="fm_purchase">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Sales Price</label>
                                <input type="text" class="form-control required-field" name="fm_salesprice" id="fm_salesprice">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3"></div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Diskon Tanggal</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_disc_date" value="T" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_disc_date" value="F" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 place_diskon_tanggal">
                            <div class="form-group">
                                <label>Tanggal Start</label>
                                <input type="text" class="form-control required-field datepicker" name="fd_disc_begin" id="fd_disc_begin">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 place_diskon_tanggal">
                            <div class="form-group">
                                <label>Tanggal End</label>
                                <input type="text" class="form-control required-field datepicker" name="fd_disc_end" id="fd_disc_end">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2 place_diskon_tanggal">
                            <div class="form-group">
                                <label>Rupiah</label>
                                <input type="text" class="form-control required-field" name="fm_disc_rp" id="fm_disc_rp">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2 place_diskon_tanggal">
                            <div class="form-group">
                                <label>Persentase</label>
                                <input type="text" class="form-control required-field" name="fm_disc_pr" id="fm_disc_pr">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Diskon Waktu</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_disc_time" value="F" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_disc_time" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 place_diskon_waktu">
                            <div class="form-group">
                                <label>Tanggal Start</label>
                                <input type="text" class="form-control required-field datepicker" name="ft_disc_begin" id="ft_disc_begin">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3 place_diskon_waktu">
                            <div class="form-group">
                                <label>Tanggal End</label>
                                <input type="text" class="form-control required-field datepicker" name="ft_disc_end" id="ft_disc_end">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2 place_diskon_waktu">
                            <div class="form-group">
                                <label>Rupiah</label>
                                <input type="text" class="form-control required-field" name="fm_time_disc_rp" id="fm_time_disc_rp">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2 place_diskon_waktu">
                            <div class="form-group">
                                <label>Persentase</label>
                                <input type="text" class="form-control required-field" name="fm_time_disc_pr" id="fm_time_disc_pr">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" class="form-control required-field" name="fm_price_default" id="fm_price_default">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Price Distributor</label>
                                <input type="text" class="form-control required-field" name="fm_price_distributor" id="fm_price_distributor">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Price Project</label>
                                <input type="text" class="form-control required-field" name="fm_price_project" id="fm_price_project">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Price Dealer</label>
                                <input type="text" class="form-control required-field" name="fm_price_dealer" id="fm_price_dealer">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Price End User</label>
                                <input type="text" class="form-control required-field" name="fm_price_enduser" id="fm_price_enduser">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="fv_stockdescription" id="fv_stockdescription" style="height: 50px" class="form-control required-field"></textarea>
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
        get_data_type_stock1();
        get_data_type_stock2();
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

    function get_data_type_stock1(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_typestock1").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_typestock1").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_type_stock2(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_typestock2").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_typestock2").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
      $(".modal-title").text('Tambah Master Stock');
      $("#form_submit")[0].reset();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/master-stock/datatables',
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
         var url_edit   = "/data-master/master-stock/detail/" + data.fc_stockcode;
         var url_delete = "/data-master/master-stock/delete/" + data.fc_stockcode;

         $('td:eq(4)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_nameshort}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Data Master Stock');
      $("#type").val('update');
   }
</script>
@endsection
