@extends('partial.app')
@section('title', 'Daftar Pengiriman')
@section('css')
<style>
    .required label:after {
        color: #e32;
        content: ' *';
        display: inline;
    }

    table.dataTable tbody tr td {
        word-wrap: break-word;
        word-break: break-all;
    }
</style>
@endsection
@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Surat Jalan</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-success" onclick="add_multi();"><i class="fa fa-plus"></i> Multi SJ</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">No. Surat Jalan</th>
                                    <th scope="col" class="text-center">No. SO</th>
                                    <th scope="col" class="text-center">Tgl SJ</th>
                                    <th scope="col" class="text-center">Customer</th>
                                    <th scope="col" class="text-center">Item</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
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
<div class="modal fade" role="dialog" id="modal_multi" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Multi SJ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="#" method="POST" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Customer</label>
                                <select name="fc_membercode" id="fc_membercode" class="form-control select2" required></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Sales Order</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="fc_sono" name="fc_sono" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" onclick="click_modal_so()" type="button"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_so" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Sales Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_so" width="100%">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">No. SO</th>
                                <th scope="col" class="text-center">Tanggal</th>
                                <th scope="col" class="text-center">Expired</th>
                                <th scope="col" class="text-center">Tipe</th>
                                <th scope="col" class="text-center">Operator</th>
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
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        get_data_customer();
        $('#fc_membercode').select2({
            closeOnSelect: true
        });
    })

    function add_multi() {
        $('#modal_multi').modal('show');
    }

    function click_modal_so() {
        $('#modal_so').modal('show');
    }

    function get_data_customer() {
        $.ajax({
            url: "/apps/invoice-penjualan/data-customer",
            type: "GET",
            dataType: "JSON",
            success: function(response) {
                if (response.status === 200) {
                    var data = response.data;
                    // console.log(data);
                    $("#fc_membercode").empty();
                    $("#fc_membercode").append(`<option value="" selected disabled> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membercode").append(`<option value="${data[i].fc_membercode}">${data[i].fc_membername1}</option>`);
                    }
                } else {
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }

    var tb = $('#tb').DataTable({
        processing: true,
        serverSide: true,
        order: [
            [3, 'desc']
        ],
        ajax: {
            url: '/apps/invoice-penjualan/datatables',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0, 4, 5, 6]
            },
            {
                className: 'text-nowrap',
                targets: [3]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_dono'
            },
            {
                data: 'fc_sono'
            },
            {
                data: 'fd_dodate',
                render: formatTimestamp
            },
            {
                data: 'somst.customer.fc_membername1'
            },
            {
                data: 'fn_dodetail'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {
            var fc_dono = window.btoa(data.fc_dono);
            $('td:eq(6)', row).html(
                `<a href="/apps/invoice-penjualan/detail/${fc_dono}"><button class="btn btn-warning btn-sm"><i class="fa fa-check"></i> Pilih</button></a>`
            );

        }
    });

    var defaultCustomer = 'all';
    var encodedDefaultCustomer = btoa(defaultCustomer);
        var tb_so = $('#tb_so').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            order: [
                [2, 'desc']
            ],
            ajax: {
                url: '/apps/invoice-penjualan/datatables-so/' + encodedDefaultCustomer,
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 5, 6, 7]
                },
                {
                    className: 'text-nowrap',
                    targets: [3, 10]
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
                    data: 'fc_userid'
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
                var fc_sono = window.btoa(data.fc_sono);
                // console.log(fc_sono);

                $('td:eq(8)', row).html(`<i class="${data.fc_sostatus}"></i>`);
                if (data['fc_sostatus'] == 'F') {
                    $('td:eq(8)', row).html('<span class="badge badge-primary">Menunggu</span>');
                } else {
                    $(row).hide();
                }

                $('td:eq(10)', row).html(`
            <a href="#"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-check"></i> Pilih</button></a>
         `);
            }
        });

        $('#fc_membercode').on('change', function() {
            var selectedCustomer = $(this).val();
            var encodedSelectedCustomer = btoa(selectedCustomer); 
            updateDataTable(encodedSelectedCustomer);
        });

        function updateDataTable(encodedSelectedCustomer) {
            tb_so.ajax.url('/apps/invoice-penjualan/datatables-so/' + encodedSelectedCustomer).load();
        }
   
</script>
@endsection