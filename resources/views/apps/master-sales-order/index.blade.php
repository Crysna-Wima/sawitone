@extends('partial.app')
@section('title','Master Sales Order')
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Sales Order</h4>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
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
@endsection

@section('js')
<script>

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/apps/master-sales-order/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,6,7,9] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_sono' },
         { data: 'fd_sodatesysinput', render: formatTimestamp },
         { data: 'fd_soexpired', render: formatTimestamp },
         { data: 'fc_sotype' },
         { data: 'fc_membercode' },
         { data: 'fn_sodetail' },
         { data: 'fc_sostatus' },
         { data: 'fm_brutto', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp' ) },
         { data: 'fm_brutto' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/master-brand/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;
         var url_delete = "/data-master/master-brand/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_brand + '/' + data.fc_group + '/' + data.fc_subgroup;

         $('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
         if(data['fc_sostatus'] == 'F'){
            $('td:eq(7)', row).html('<span class="badge badge-primary">Waiting</span>');
         }else if(data['fc_sostatus'] == 'C'){
            $('td:eq(7)', row).html('<span class="badge badge-success">Clear</span>');
         }
         else{
            $('td:eq(7)', row).html('<span class="badge badge-warning">Process</span>');
         }

         $('td:eq(9)', row).html(`
            <a href="/apps/master-sales-order/detail/${data.fc_sono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-eye"></i> Detail</button></a>
            <a href="/apps/master-sales-order/pdf/${data.fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
         `);
      }
   });

</script>
@endsection
