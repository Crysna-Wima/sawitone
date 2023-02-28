@extends('partial.app')
@section('title','Master Delivery Order')
@section('css')
    <style>
         #tb_wrapper .row:nth-child(2) {
            overflow-x: auto;
        }

        .d-flex .flex-row-item {
            flex: 1 1 30%;
        }

        .text-secondary {
            color: #969DA4 !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .btn-secondary {
            background-color: #A5A5A5 !important;
        }

        @media (min-width: 992px) and (max-width: 1200px) {
            .flex-row-item {
                font-size: 12px;
            }

            .grand-text {
                font-size: .9rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Delivery Order</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead>
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Sono</th>
                           <th scope="col" class="text-center">Dono</th>
                           <th scope="col" class="text-center">Tgl DO</th>
                           <th scope="col" class="text-center">Customer</th>
                           <th scope="col" class="text-center">Item</th>
                           <th scope="col" class="text-center">Total</th>
                           <th scope="col" class="text-center">Status</th>
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
<div class="modal fade" role="dialog" id="modal_invoice" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Penerbitan Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="/apps/sales-order/detail/payment/create" method="POST"
                    autocomplete="off">
                    @csrf
                    <input type="text" name="type" id="type" hidden>
                    <div class="modal-body">
                        <div class="row">
                           <div class="col-12 col-md-4 col-lg-6">
                              <div class="card">
                                 <div class="card-header">
                                       <h4>Informasi Umum</h4>
                                 </div>
                                 <input type="text" id="" value="" hidden>
                                 <div class="card-body">
                                    <div class="row">
                                       <div class="col-12 col-md-12 col-lg-12">
                                             <div class="form-group">
                                                <label>DONO : {{ $do_mst->fc_dono }}
                                                </label>
                                             </div>
                                       </div>
                                       <div class="col-12 col-md-12 col-lg-12">
                                             <div class="form-group">
                                                <label>Tanggal : {{ \Carbon\Carbon::parse( $do_mst->fd_dodateinputuser )->isoFormat('D MMMM Y'); }}
                                                </label>
                                             </div>
                                       </div>
                                       <div class="col-12 col-md-12 col-lg-6">
                                             <div class="form-group">
                                                <label>NPWP</label>
                                                <input type="text" class="form-control" value="{{ $do_mst->somst->customer->fc_membernpwp_no ?? '-' }}"
                                                   readonly>
                                             </div>
                                       </div>
                                       <div class="col-12 col-md-6 col-lg-6">
                                             <div class="form-group">
                                                <label>Nama</label>
                                                <input type="text" class="form-control" value="{{ $do_mst->somst->customer->fc_membername1 }}" readonly>
                                             </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-md-12 col-lg-6 place_detail">
                              <div class="card">
                                 <div class="card-header">
                                       <h4>Calculation</h4>
                                 </div>
                                 <div class="card-body" style="height: 217px">
                                       <div class="d-flex">
                                          <div class="flex-row-item" style="margin-right: 30px">
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_dodetail">0,00</p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto">0,00</p>
                                             </div>
                                          </div>
                                          <div class="flex-row-item">
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay_calculate">0,00</p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex" style="gap: 5px; white-space: pre" >
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                                   <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                                             </div>
                                          </div>
                                       </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Terbit</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        {{-- input waktu sekarang format timestamp tipe hidden --}}
                                        <input type="hidden" class="form-control" name=""
                                            id="" value="{{ date('d-m-Y') }}">

                                        <input type="text" id="" class="form-control datepicker"
                                            name="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Masa</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        {{-- input waktu sekarang format timestamp tipe hidden --}}
                                        <input type="hidden" class="form-control" name=""
                                            id="">

                                        <input type="text" id="" class="form-control"
                                            name="" required>
                                       <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Hari
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        {{-- input waktu sekarang format timestamp tipe hidden --}}
                                        <input type="hidden" class="form-control" name=""
                                            id="" value="{{ date('d-m-Y') }}">

                                        <input type="text" id="" class="form-control datepicker"
                                            name="" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success">Terbitkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>

   function click_modal_invoice(){
      $('#modal_invoice').modal('show');
   }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/apps/master-delivery-order/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,7,8] },
         { className: 'text-nowrap', targets: [3,6,8] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_sono' },
         { data: 'fc_dono'},
         { data: 'fd_dodate', render: formatTimestamp },
         { data: 'somst.customer.fc_membername1' },
         { data: 'fn_dodetail' },
         { data: 'fm_brutto', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },
         { data: 'fc_dostatus' },
         { data: null },
      ],
      rowCallback : function(row, data){
         $('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
         if(data['fc_dostatus'] == 'I'){
            $(row).hide(); 
         }else if(data['fc_dostatus'] == 'D'){
            $('td:eq(7)', row).html('<span class="badge badge-primary">Delivery</span>');
         }
         else{
            $('td:eq(7)', row).html('<span class="badge badge-success">Received</span>');
         }

         if(data['fc_dostatus'] == 'I'){
            $(row).hide();
         } else if (data['fc_dostatus'] == 'D'){
            $('td:eq(8)', row).html(`
               <a href="/apps/master-delivery-order/pdf/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
               <a href="/apps/master-delivery-order/pdf_sj/${data.fc_dono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-truck"></i> Surat Jalan</button></a>`
            );
         } else {
               if(data['fc_invstatus'] == 'N'){
                  $('td:eq(8)', row).html(`
                     <a href="/apps/master-delivery-order/pdf/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                     <button class="btn btn-info btn-sm" data onclick="click_modal_invoice()">Terbitkan Invoice</button>`
                  );
               } else {
                  $('td:eq(8)', row).html(`
                     <a href="/apps/master-delivery-order/pdf/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                     <a href="/apps/master-delivery-order/inv/${data.fc_dono}" target="_blank"><button class="btn btn-success btn-sm mr-1"><i class="fa fa-credit-card"></i> Invoice</button></a>`
               );
            }
         }
         //<a href="/apps/master-delivery-order/inv/${data.fc_dono}" target="_blank"><button class="btn btn-success btn-sm mr-1"><i class="fa fa-credit-card"></i> Invoice</button></a>`
      }
   });

</script>
@endsection
