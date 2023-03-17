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
            <a href="/apps/master-sales-order/pdf/${fc_sono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
         `);
      }
   });

   var dropdown = $('<select></select>')
      .appendTo('.dataTables_length')
      .addClass('form-control select1')
      .attr('aria-controls', 'tb')
      .on('change', function() {
         var value = $(this).val();
         $('tb').DataTable().page.len(value).draw();
      })
      .attr('style', 'margin-left: 20px; width:140px;');

   dropdown.append($('<option value="" selected disabled>Filter Status...</option>'));
   dropdown.append($('<option value="Semua">Semua</option>'));
   dropdown.append($('<option value="Menunggu">Menunggu</option>'));
   dropdown.append($('<option value="Pending">Pending</option>'));
   dropdown.append($('<option value="DO Tuntas">DO Tuntas</option>'));
   dropdown.append($('<option value="Selesai">Selesai</option>'));

</script>
@endsection