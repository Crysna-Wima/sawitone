@extends('partial.app')
@section('title','Master Delivery Order')
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

@section('js')
<script>

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/apps/master-delivery-order/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,7] },
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
            // $('td:eq(7)', row).html('<span class="badge badge-warning">Input</span>');
            $(row).hide(); 
         }else if(data['fc_dostatus'] == 'D'){
            $('td:eq(7)', row).html('<span class="badge badge-primary">Delivery</span>');
         }
         else{
            $('td:eq(7)', row).html('<span class="badge badge-success">Received</span>');
         }

         $('td:eq(8)', row).html(`
            <a href="/apps/master-delivery-order/pdf/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
            <a href="/apps/master-delivery-order/pdf_sj/${data.fc_dono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-truck"></i> Surat Jalan</button></a>
         `);
      }
   });

</script>
@endsection
