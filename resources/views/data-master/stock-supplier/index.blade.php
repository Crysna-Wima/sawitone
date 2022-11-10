@extends('partial.app')
@section('title','Master Stock Supplier')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Stock Supplier</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Stock Supplier</button>
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
                                <input type="text" class="form-control required-field" name="fc_divisioncode"
                                    id="fc_divisioncode">
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
                                <label>Supplier Code</label>
                                <select class="form-control select2 required-field" name="fc_suppliercode" id="fc_suppliercode">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Input Date</label>
                                <input type="text" class="form-control required-field" name="fd_inputdate" id="fd_inputdate">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12 col-md-6 col-lg-6" style="padding: 0!important">
                                <div class="form-group">
                                    <label>Price Customer</label>
                                    <input type="text" class="form-control required-field" name="fm_price_customer" id="fm_price_customer">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12 col-md-6 col-lg-6" style="padding: 0!important">
                                <div class="form-group">
                                    <label>Price Detail</label>
                                    <input type="text" class="form-control required-field" name="fm_price_detail" id="fm_price_detail">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12 col-md-6 col-lg-6" style="padding: 0!important">
                                <div class="form-group">
                                    <label>Price Distributor</label>
                                    <input type="text" class="form-control required-field" name="fm_price_distributor" id="fm_price_distributor">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12 col-md-6 col-lg-6" style="padding: 0!important">
                                <div class="form-group">
                                    <label>Price Project</label>
                                    <input type="text" class="form-control required-field" name="fm_price_project" id="fm_price_project">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12 col-md-6 col-lg-6" style="padding: 0!important">
                                <div class="form-group">
                                    <label>Price Dealer</label>
                                    <input type="text" class="form-control required-field" name="fm_price_dealer" id="fm_price_dealer">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="col-12 col-md-6 col-lg-6" style="padding: 0!important">
                                <div class="form-group">
                                    <label>Price Enduser</label>
                                    <input type="text" class="form-control required-field" name="fm_price_enduser" id="fm_price_enduser">
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
