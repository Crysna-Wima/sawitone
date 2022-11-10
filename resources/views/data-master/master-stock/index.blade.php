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
                            <input type="text" class="form-control required-field" name="fc_divisioncode"
                                id="fc_divisioncode">
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

                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Stock Code</label>
                            <input type="text" class="form-control required-field" name="fc_stockcode"
                                id="fc_stockcode">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Barcode</label>
                            <input type="text" class="form-control required-field" name="fc_barcode"
                                id="fc_barcode">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 d-flex justify-content-center align-items-center">
                        <div class="form-group d-flex" style="margin: 0">
                            <div class="selectgroup w-25 mx-1">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value1" value="1" class="selectgroup-input"
                                        checked="">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value1" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
                            <div class="selectgroup w-25 mx-1">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value2" value="1" class="selectgroup-input"
                                        checked="">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value2" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
                            <div class="selectgroup w-25 mx-1">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value3" value="1" class="selectgroup-input"
                                        checked="">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value3" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
                            <div class="selectgroup w-25 mx-1">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value4" value="1" class="selectgroup-input"
                                        checked="">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value5" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Name Short</label>
                            <input type="text" class="form-control required-field" name="fc_nameshort"
                                id="fc_nameshort">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-9">
                        <div class="form-group">
                            <label>Name Long</label>
                            <input type="text" class="form-control required-field" name="fc_namelong"
                                id="fc_namelong">
                        </div>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="col-12 col-md-2 col-lg-2 d-flex align-items-center">
                            <div class="form-group" style="margin: 0">
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="value5" value="1" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="value5" value="0" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="col-12 col-md-2 col-lg-2 d-flex align-items-center">
                            <div class="form-group" style="margin: 0">
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="value6" value="1" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="value6" value="0" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div class="col-12 col-md-2 col-lg-2 d-flex align-items-center">
                            <div class="form-group" style="margin: 0">
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="value7" value="1" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="value7" value="0" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Reorder Level</label>
                            <input type="text" class="form-control required-field" name="fn_reorderlevel"
                                id="fn_reorderlevel">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Max on Hand</label>
                            <input type="text" class="form-control required-field" name="fn_maxonhand"
                                id="fn_maxonhand">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 d-flex align-items-center">
                        <div class="form-group" style="margin: 0">
                            <div class="buttons">
                                <button type="button" style="margin: 0" class="btn btn-sm btn-primary">
                                    Notifications <span class="badge badge-transparent">4</span>
                                </button>
                                <button type="button" style="margin: 0" class="btn btn-sm btn-primary">
                                    Notifications <span class="badge badge-transparent">4</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Type Stock 1</label>
                            <select class="form-control select2 required-field" name="fc_typestock1" id="fc_typestock1">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Type Stock 2</label>
                            <select class="form-control select2 required-field" name="fc_typestock2" id="fc_typestock2">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Brand</label>
                            <select class="form-control select2 required-field" name="fc_brand" id="fc_brand">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Name Pack</label>
                            <input type="text" class="form-control required-field" name="fc_namepack"
                                id="fc_namepack">
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Cogs</label>
                            <input type="text" class="form-control required-field" name="fm_cogs"
                                id="fm_cogs">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Purchase</label>
                            <input type="text" class="form-control required-field" name="fm_purchase"
                                id="fm_purchase">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Sales Price</label>
                            <input type="text" class="form-control required-field" name="fm_salesprice"
                                id="fm_salesprice">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 d-flex justify-content-center align-items-center">
                        <div class="form-group d-flex" style="margin: 0">
                            <div class="selectgroup w-50" style="margin-right: 10px">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value8" value="1" class="selectgroup-input"
                                        checked="">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value8" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
                            <div class="selectgroup w-50">
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value9" value="1" class="selectgroup-input"
                                        checked="">
                                    <span class="selectgroup-button">Yes</span>
                                </label>
                                <label class="selectgroup-item" style="margin: 0!important">
                                    <input type="radio" name="value9" value="0" class="selectgroup-input">
                                    <span class="selectgroup-button">No</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label>Price Default</label>
                            <input type="text" class="form-control required-field" name="fm_price_default"
                                id="fm_price_default">
                        </div>
                    </div>
                    <div class="col-12 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label>Price Distributor</label>
                            <input type="text" class="form-control required-field" name="fm_price_distributor"
                                id="fm_price_distributor">
                        </div>
                    </div>
                    <div class="col-12 col-md-2 col-lg-2">
                        <div class="form-group">
                            <label>Price Project</label>
                            <input type="text" class="form-control required-field" name="fm_price_project"
                                id="fm_price_project">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Price Dealer</label>
                            <input type="text" class="form-control required-field" name="fm_price_dealer"
                                id="fm_price_dealer">
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label>Price End User</label>
                            <input type="text" class="form-control required-field" name="fm_price_enduser"
                                id="fm_price_enduser">
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="fv_description" id="fv_description" style="height: 50px" class="form-control required-field"></textarea>
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
      edit_action(url, 'Edit Data Master Supplier');
      $("#type").val('update');
   }
</script>
@endsection
