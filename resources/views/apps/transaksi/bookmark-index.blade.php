@extends('partial.app')
@section('title', 'Bookmark Transaksi Accounting')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Daftar Transaksi</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_bookmark" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. Transaksi</th>
                                    <th scope="col" class="text-center">Nama Transaksi</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Operator</th>
                                    <th scope="col" class="text-center">Referensi Doc</th>
                                    <th scope="col" class="text-center">Balance</th>
                                    <th scope="col" class="text-center">Informasi</th>
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
    var tb_bookmark = $('#tb_bookmark').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        order: [
            [1, 'desc']
        ],
        ajax: {
            url: "/apps/transaksi/datatables-bookmark",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5, 6, 7]
        }, {
            className: 'text-nowrap',
            targets: [8]
        }],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_trxno'
            },
            {
                data: 'mapping.fc_mappingname'
            },
            {
                data: 'fd_trxdate_byuser'
            },
            {
                data: 'fc_userid'
            },
            {
                data: 'fc_docreference'
            },
            {
                data: 'fm_balance'
            },
            {
                data: 'transaksitype.fv_description'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            // encode data.fc_trxno
            var fc_trxno = window.btoa(data.fc_trxno);

            $('td:eq(8)', row).html(`
                    <a href="/apps/transaksi/lanjutkan-bookmark" class="btn btn-success btn-sm mr-1 lanjutkan-btn">Lanjutkan</a>
                `);

                $(row).on('click', '.lanjutkan-btn', function(event) {
                event.preventDefault();

                var fc_mappingcode = $(row).attr('id');
                var url_lanjutkan = "/apps/transaksi/lanjutkan-bookmark/" + fc_trxno;

                showConfirmationDialog(url_lanjutkan);
             });
        },
    });

    function showConfirmationDialog(url_lanjutkan) {
            swal({
                title: "Are you sure?",
                text: "Lanjutkan buat transaksi?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willProceed) => {
                if (willProceed) {
                    sendPUTRequest(url_lanjutkan);
                } else {
                    console.log("PUT request canceled.");
                }
            });
        }

        function sendPUTRequest(url_lanjutkan) {
            $('#modal_loading').modal('show');
            $.ajax({
                url: url_lanjutkan,
                type: 'PUT',
                success: function(response) {
                    $('#modal_loading').modal('hide');
                    if(response.status == 201){
                        // arahkan ke response.link
                        window.location.href = response.link;
                    }else{
                        swal("Error", response.message, "error");
                    }
                },
                error: function(error) {
                    $('#modal_loading').modal('hide');
                    swal("Error", error.message, "error");
                }
            });
        }


    $('.modal').css('overflow-y', 'auto');
</script>

@endsection
