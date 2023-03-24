@extends('partial.app')
@section('title','Master Sales Order')
@section('css')
<style>
   .text-secondary {
      color: #969DA4 !important;
   }

   .text-success {
      color: #28a745 !important;
   }

   .btn-secondary {
      background-color: #A5A5A5 !important;
   }

   .nav-tabs .nav-item .nav-link {
      color: #A5A5A5;
   }

   .nav-tabs .nav-item .nav-link.active {
      font-weight: bold;
      color: #0A9447;
   }
</style>
@endsection

@section('content')
<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
               <h4>Data Master Sales Order</h4>
            </div>
            <div class="card-body">
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active show" id="semua-tab" data-toggle="tab" href="#semua" role="tab" aria-controls="semua" aria-selected="true">Semua</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="menunggu-tab" data-toggle="tab" href="#menunggu" role="tab" aria-controls="menunggu" aria-selected="false">Menunggu</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending" aria-selected="false">Pending</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="selesai-tab" data-toggle="tab" href="#selesai" role="tab" aria-controls="selesai" aria-selected="false">Selesai</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="do-tuntas-tab" data-toggle="tab" href="#do-tuntas" role="tab" aria-controls="do-tuntas" aria-selected="false">DO Tuntas</a>
                  </li>
               </ul>
               <div class="tab-content" id="myTabContent">
                  <div class="tab-pane fade active show" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                     <div class="table-responsive">
                        <table class="table table-striped" id="tb_semua" width="100%">
                           <thead>
                              <tr>
                                 <th scope="col" class="text-center">No</th>
                                 <th scope="col" class="text-center">Sono</th>
                                 <th scope="col" class="text-center">Tanggal</th>
                                 <th scope="col" class="text-center">Expired</th>
                                 <th scope="col" class="text-center">Tipe</th>
                                 <th scope="col" class="text-center">Customer</th>
                                 <th scope="col" class="text-center">Item</th>
                                 <th scope="col" class="text-center">Status</th>
                                 <th scope="col" class="text-center">Total</th>
                                 <th scope="col" class="text-center" style="width: 20%">Actions</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="menunggu" role="tabpanel" aria-labelledby="menunggu-tab">
                     <div class="table-responsive">
                        <table class="table table-striped" id="tb_menunggu" width="100%">
                           <thead>
                              <tr>
                                 <th scope="col" class="text-center">No</th>
                                 <th scope="col" class="text-center">Sono</th>
                                 <th scope="col" class="text-center">Tanggal</th>
                                 <th scope="col" class="text-center">Expired</th>
                                 <th scope="col" class="text-center">Tipe</th>
                                 <th scope="col" class="text-center">Customer</th>
                                 <th scope="col" class="text-center">Item</th>
                                 <th scope="col" class="text-center">Status</th>
                                 <th scope="col" class="text-center">Total</th>
                                 <th scope="col" class="text-center" style="width: 20%">Actions</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                     <div class="table-responsive">
                        <table class="table table-striped" id="tb_pending" width="100%">
                           <thead>
                              <tr>
                                 <th scope="col" class="text-center">No</th>
                                 <th scope="col" class="text-center">Sono</th>
                                 <th scope="col" class="text-center">Tanggal</th>
                                 <th scope="col" class="text-center">Expired</th>
                                 <th scope="col" class="text-center">Tipe</th>
                                 <th scope="col" class="text-center">Customer</th>
                                 <th scope="col" class="text-center">Item</th>
                                 <th scope="col" class="text-center">Status</th>
                                 <th scope="col" class="text-center">Total</th>
                                 <th scope="col" class="text-center" style="width: 20%">Actions</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                     <div class="table-responsive">
                        <table class="table table-striped" id="tb_selesai" width="100%">
                           <thead>
                              <tr>
                                 <th scope="col" class="text-center">No</th>
                                 <th scope="col" class="text-center">Sono</th>
                                 <th scope="col" class="text-center">Tanggal</th>
                                 <th scope="col" class="text-center">Expired</th>
                                 <th scope="col" class="text-center">Tipe</th>
                                 <th scope="col" class="text-center">Customer</th>
                                 <th scope="col" class="text-center">Item</th>
                                 <th scope="col" class="text-center">Status</th>
                                 <th scope="col" class="text-center">Total</th>
                                 <th scope="col" class="text-center" style="width: 20%">Actions</th>
                              </tr>
                           </thead>
                        </table>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="do-tuntas" role="tabpanel" aria-labelledby="do-tuntas-tab">
                     <div class="table-responsive">
                        <table class="table table-striped" id="tb_do_done" width="100%">
                           <thead>
                              <tr>
                                 <th scope="col" class="text-center">No</th>
                                 <th scope="col" class="text-center">Sono</th>
                                 <th scope="col" class="text-center">Tanggal</th>
                                 <th scope="col" class="text-center">Expired</th>
                                 <th scope="col" class="text-center">Tipe</th>
                                 <th scope="col" class="text-center">Customer</th>
                                 <th scope="col" class="text-center">Item</th>
                                 <th scope="col" class="text-center">Status</th>
                                 <th scope="col" class="text-center">Total</th>
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
   </div>
</div>
@endsection

@section('js')
<script>
   var tb = $('#tb_semua').DataTable({
      processing: true,
      serverSide: true,
      order: [[2, 'desc']],
      ajax: {
         url: '/apps/master-sales-order/datatables',
         type: 'GET'
      },
      columnDefs: [{
            className: 'text-center',
            targets: [0, 6, 7]
         },
         {
            className: 'text-nowrap',
            targets: [3, 9]
         },
      ],
      columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            orderable: false
         },
         {
            data: 'fc_sono'
         },
         {
            data: 'fd_sodatesysinput',
            render: formatTimestamp
         },
         {
            data: 'fd_soexpired',
            render: formatTimestamp
         },
         {
            data: 'fc_sotype'
         },
         {
            data: 'customer.fc_membername1'
         },
         {
            data: 'fn_sodetail'
         },
         {
            data: 'fc_sostatus'
         },
         {
            data: 'fm_brutto',
            render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
         },
         {
            data: null
         },
      ],

      rowCallback: function(row, data) {
         var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
         var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

         var fc_sono = window.btoa(data.fc_sono);
         // console.log(data);

         // jika data.domst tidak kosong
         if (data.domst) {
           var fc_dono = window.btoa(data.domst.fc_dono);
         } else {
             var fc_dono = window.btoa(undefined);
         }

         $('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
         if (data['fc_sostatus'] == 'F') {
            $('td:eq(7)', row).html('<span class="badge badge-primary">Menunggu</span>');
         } else if (data['fc_sostatus'] == 'C') {
            $('td:eq(7)', row).html('<span class="badge badge-success">Selesai</span>');
         } else if (data['fc_sostatus'] == 'DD') {
            $('td:eq(7)', row).html('<span class="badge badge-info">DO Tuntas</span>');
         } else if (data['fc_sostatus'] == 'P') {
            $('td:eq(7)', row).html('<span class="badge badge-warning">Pending</span>');
         } else {
            $('td:eq(7)', row).html('<span class="badge badge-danger">Lock</span>');
         }

         $('td:eq(9)', row).html(`
            <a href="/apps/master-sales-order/detail/${fc_sono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <a href="/apps/master-sales-order/pdf/${fc_dono}/${fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
            <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close SO</button>
         `);
      }
   });

   var tb = $('#tb_menunggu').DataTable({
      processing: true,
      serverSide: true,
      order: [[2, 'desc']],
      ajax: {
         url: '/apps/master-sales-order/datatables',
         type: 'GET'
      },
      columnDefs: [{
            className: 'text-center',
            targets: [0, 6, 7]
         },
         {
            className: 'text-nowrap',
            targets: [3, 9]
         },
      ],
      columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            orderable: false
         },
         {
            data: 'fc_sono'
         },
         {
            data: 'fd_sodatesysinput',
            render: formatTimestamp
         },
         {
            data: 'fd_soexpired',
            render: formatTimestamp
         },
         {
            data: 'fc_sotype'
         },
         {
            data: 'customer.fc_membername1'
         },
         {
            data: 'fn_sodetail'
         },
         {
            data: 'fc_sostatus'
         },
         {
            data: 'fm_brutto',
            render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
         },
         {
            data: null
         },
      ],

      rowCallback: function(row, data) {
         var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
         var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

         var fc_sono = window.btoa(data.fc_sono);
         // console.log(fc_sono);

         $('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
         if (data['fc_sostatus'] == 'F') {
            $('td:eq(7)', row).html('<span class="badge badge-primary">Menunggu</span>');
         } else {
            $(row).hide();
         }

         $('td:eq(9)', row).html(`
            <a href="/apps/master-sales-order/detail/${fc_sono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <a href="/apps/master-sales-order/pdf/${fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
            <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close SO</button>
         `);
      }
   });

   var tb = $('#tb_pending').DataTable({
      processing: true,
      serverSide: true,
      order: [[2, 'desc']],
      ajax: {
         url: '/apps/master-sales-order/datatables',
         type: 'GET'
      },
      columnDefs: [{
            className: 'text-center',
            targets: [0, 6, 7]
         },
         {
            className: 'text-nowrap',
            targets: [3, 9]
         },
      ],
      columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            orderable: false
         },
         {
            data: 'fc_sono'
         },
         {
            data: 'fd_sodatesysinput',
            render: formatTimestamp
         },
         {
            data: 'fd_soexpired',
            render: formatTimestamp
         },
         {
            data: 'fc_sotype'
         },
         {
            data: 'customer.fc_membername1'
         },
         {
            data: 'fn_sodetail'
         },
         {
            data: 'fc_sostatus'
         },
         {
            data: 'fm_brutto',
            render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
         },
         {
            data: null
         },
      ],

      rowCallback: function(row, data) {
         var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
         var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

         var fc_sono = window.btoa(data.fc_sono);
         // console.log(fc_sono);

         $('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
         if (data['fc_sostatus'] == 'P') {
            $('td:eq(7)', row).html('<span class="badge badge-warning">Pending</span>');
         } else {
            $(row).hide();
         }

         $('td:eq(9)', row).html(`
            <a href="/apps/master-sales-order/detail/${fc_sono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <a href="/apps/master-sales-order/pdf/${fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
            <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close SO</button>
         `);
      }
   });

   var tb = $('#tb_selesai').DataTable({
      processing: true,
      serverSide: true,
      order: [[2, 'desc']],
      ajax: {
         url: '/apps/master-sales-order/datatables',
         type: 'GET'
      },
      columnDefs: [{
            className: 'text-center',
            targets: [0, 6, 7]
         },
         {
            className: 'text-nowrap',
            targets: [3, 9]
         },
      ],
      columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            orderable: false
         },
         {
            data: 'fc_sono'
         },
         {
            data: 'fd_sodatesysinput',
            render: formatTimestamp
         },
         {
            data: 'fd_soexpired',
            render: formatTimestamp
         },
         {
            data: 'fc_sotype'
         },
         {
            data: 'customer.fc_membername1'
         },
         {
            data: 'fn_sodetail'
         },
         {
            data: 'fc_sostatus'
         },
         {
            data: 'fm_brutto',
            render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
         },
         {
            data: null
         },
      ],

      rowCallback: function(row, data) {
         var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
         var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

         var fc_sono = window.btoa(data.fc_sono);
         // console.log(fc_sono);

         $('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
         if (data['fc_sostatus'] == 'C') {
            $('td:eq(7)', row).html('<span class="badge badge-success">Selesai</span>');
         } else {
            $(row).hide();
         }

         $('td:eq(9)', row).html(`
            <a href="/apps/master-sales-order/detail/${fc_sono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <a href="/apps/master-sales-order/pdf/${fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
            <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close SO</button>
         `);
      }
   });

   var tb = $('#tb_do_done').DataTable({
      processing: true,
      serverSide: true,
      order: [[2, 'desc']],
      ajax: {
         url: '/apps/master-sales-order/datatables',
         type: 'GET'
      },
      columnDefs: [{
            className: 'text-center',
            targets: [0, 6, 7]
         },
         {
            className: 'text-nowrap',
            targets: [3, 9]
         },
      ],
      columns: [{
            data: 'DT_RowIndex',
            searchable: false,
            orderable: false
         },
         {
            data: 'fc_sono'
         },
         {
            data: 'fd_sodatesysinput',
            render: formatTimestamp
         },
         {
            data: 'fd_soexpired',
            render: formatTimestamp
         },
         {
            data: 'fc_sotype'
         },
         {
            data: 'customer.fc_membername1'
         },
         {
            data: 'fn_sodetail'
         },
         {
            data: 'fc_sostatus'
         },
         {
            data: 'fm_brutto',
            render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
         },
         {
            data: null
         },
      ],

      rowCallback: function(row, data) {
         var url_edit = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
         var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

         var fc_sono = window.btoa(data.fc_sono);
         // console.log(fc_sono);

         $('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
         if (data['fc_sostatus'] == 'DD') {
            $('td:eq(7)', row).html('<span class="badge badge-info">DO Tuntas</span>');
         } else {
            $(row).hide();
         }

         $('td:eq(9)', row).html(`
            <a href="/apps/master-sales-order/detail/${fc_sono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <a href="/apps/master-sales-order/pdf/${fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
            <button class="btn btn-danger btn-sm" onclick=""><i class="fa fa-times"></i> Close SO</button>
         `);
      }
   });
   
</script>
@endsection