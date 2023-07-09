@extends('partial.app')
@section('title','Invoice CPRR')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
    }

    .d-flex .flex-row-item {
        flex: 1 1 30%;
    }

    .text-secondary{
        color: #969DA4!important;
    }

    .text-success{
        color: #28a745!important;
    }

    .btn-secondary {
            background-color: #A5A5A5 !important;
        }

    @media (min-width: 992px) and (max-width: 1200px){
        .flex-row-item{
            font-size: 12px;
        }

        .grand-text{
            font-size: .9rem;
        }
    }

    .required label:after {
        color: #e32;
        content: ' *';
        display:inline;
    }
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        {{-- Informasi Umum  --}}
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Invoice CPRR</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <form id="form_submit" action="/apps/invoice-cprr/cancel" method="DELETE" autocomplete="off">
                    <div class="collapse" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" id="fc_userid" name="fc_userid" value="{{ $data->fc_userid }}" readonly>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal Terbit</label>
                                        <div class="input-group date">
                                            <input type="text" id="fd_inv_releasedate" name="fd_inv_releasedate" class="form-control"
                                                fdprocessedid="8ovz8a" value="{{ $data->fd_inv_releasedate }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>No. Dokumen RS</label>
                                        <input type="text" class="form-control" id="fc_sono" name="fc_sono" value="{{ $data->fc_suppdocno }}" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Jatuh Tempo</label>
                                        <div class="input-group date">
                                            <input type="text" id="fd_inv_agingdate" name="fd_inv_agingdate" class="form-control"
                                                fdprocessedid="8ovz8a" value="{{ $data->fd_inv_agingdate }}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group required">
                                        <label>Customer</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" value="{{$data->fc_entitycode}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-danger">Batalkan Invoice</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- Detail Customer  --}}
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Customer</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_membernpwp_no }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_typebranch->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_type_business->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_membername1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fc_memberaddress1 }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Piutang</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->fn_memberAgingAP }} Hari" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_legal_status->fv_description }}" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Status PKP</label>
                                    <input type="text" class="form-control" value="{{ $data->customer->member_tax_code->fv_description }} ({{$data->customer->member_tax_code->fc_action}}%)" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Piutang</label>
                                    <input type="text" class="form-control" value="Rp. {{ number_format( $data->customer->fm_memberAP,0,',','.') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Input CPRR Form  --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-body" style="padding-top: 30px!important;">
                    <form id="form_submit_noconfirm" action="/apps/invoice-cprr/detail/store-update" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-5">
                                <div class="form-group">
                                    <label>Kode CPRR</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control required-field" id="fc_detailitem" name="fc_detailitem" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" onclick="click_modal_cprr()"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group required">
                                    <label>Qty</label>
                                    <div class="input-group">
                                        <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) > 0 ? Math.abs(this.value) : null" name="fn_itemqty" id="fn_itemqty" class="form-control" required>    
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group required">
                                    <label>Harga</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" class="form-control format-rp" name="fm_unityprice" id="fm_unityprice" onkeyup="return onkeyupRupiah(this.id);" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" fdprocessedid="hgh1fp" name="fv_description" id="fv_description">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                <button class="btn btn-success ml-1">Add Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Calculation Bill  --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Calculation</h4>
                </div>
                <div class="card-body" style="height: 190px">
                    <div class="d-flex">
                        <div class="flex-row-item" style="margin-right: 30px">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="count_item">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_so_disc">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="total_harga">0,00</p>
                            </div>
                        </div>
                        <div class="flex-row-item">
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                            </div>
                            <div class="d-flex">
                                <p class="flex-row-item"></p>
                                <p class="flex-row-item text-right"></p>
                            </div>
                            <div class="d-flex" style="gap: 5px; white-space: pre">
                                <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="grand_total">Rp. 0,00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Tabel CPRR --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode CPRR</th>
                                        <th scope="col" class="text-center">Nama</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Jumlah</th>
                                        <th scope="col" class="text-center">Harga Satuan</th>
                                        <th scope="col" class="text-center">Catatan</th>
                                        <th scope="col" class="text-center">Total</th>
                                        <th scope="col" class="text-center justify-content-center">Action</th>
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
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_cprr" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih CPRR</h5>
                <div class="card-header-action">
                    <select data-dismiss="modal" onchange="" class="form-control select2 required-field" name="category" id="category">
                        <option value="Semua" selected>Khusus&nbsp;&nbsp;</option>
                        <option value="Khusus">Semua&nbsp;&nbsp;</option>
                    </select>
                </div>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_cprr" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode CPRR</th>
                                    <th scope="col" class="text-center">Nama Pemeriksaan</th>
                                    <th scope="col" class="text-center">Harga</th>
                                    <th scope="col" class="text-center">Catatan</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" id="click_category" class="btn btn-secondary" onclick="clear_category()" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
<script>    
    function click_modal_cprr(){
        $('#modal_cprr').modal('show');
        table_cprr();
    }
    

    var tb = $("#tb").DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        ajax:{
            url: '/apps/invoice-cprr/datatables',
            type: 'GET'
        },
        columnDefs: [
            {
                className: 'text-center',
                targets: [0, 1, 2, 3, 4, 5, 6, 7, 8]
            },
        ],
        columns: [
            {
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false,
            },
            {
                data: 'fc_detailitem',
            },
            {
                data: 'cospertes.fc_cprrname',
            },
            
            {
                data: 'nameunity.fv_description',
            },
            {
                data: 'fn_itemqty',
            },
            {
                data: 'fm_unityprice',
                render: function(data, type, row){
                    return row.fm_unityprice.toLocaleString('id-ID',{
                        style:  'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: 'fv_description',
            },
            {
                data: 'fm_value',
                render: function(data, type, row){
                    return row.fm_value.toLocaleString('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    })
                }
            },
            {
                data: null
            }
        ],
        rowCallback: function(row, data){
            var url_delete = "/apps/invoice-cprr/detail/delete/" + data.fc_invno + '/' + data.fn_invrownum;

            $('td:eq(8)', row).html(`
                <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','CPRR Detail')"><i class="fa fa-trash"> </i> Hapus Item</button>
            `);
        }
    })


    function table_cprr(){
        var fc_membercode = window.btoa($('#fc_membercode').val());

        var tb_cptt = $('#tb_cprr').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '/data-master/cprr-customer/datatables/'+fc_membercode,
                type: 'GET',
                data: function(dData){
                    dData.category = $("#categori").val();
                },
            },
            columnDefs: [{
                className: 'text-center',
                targets: []
            }],
            columns: [
                {
                    data: 'DT_RowIndex',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'fc_cprrcode',
                },
                {
                    data: 'cospertes.fc_cprrname'
                },
                {
                    data: 'fm_price',
                    render: function(data, type, row){
                        return row.fm_price.toLocaleString('id-ID',{
                            style:  'currency',
                            currency: 'IDR'
                        })
                    }
                }, 
                {
                    data: 'fv_description'
                },
                {
                    data: null,
                }
            ],
            rowCallback: function(row, data){
                $("td:eq(5)", row).html(`
                    <button type="button" onclick="choosen('${data.id}')" class="btn btn-warning btn-sm mr-1"><i class="fa fa-check"></i> Pilih</butoon>
                `);
            }
        })
    }
    
    function choosen(id) { 
        $("modal_loading").modal('show');
        var fc_id = window.btoa(id);
        $.ajax({
            url: "/data-master/cprr-customer/" + fc_id,
            type: "GET",
            dataType: "JSON",
            success: function(response){
                var data = response.data;

                $("#modal_cprr").modal('hide');
                $("#fc_detailitem").val(data.fc_cprrcode);
                $("#fm_unityprice").val(data.fm_price);
                $("#fv_description").val(data.fv_description);
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {
                    icon: 'error',
                });
            }
        });
    }
    $('#form_submit_noconfirm').on('submit', function(e) {
        e.preventDefault();

        var form_id = $(this).attr("id");
        if (check_required(form_id) === false) {
            swal("Oops! Mohon isi field yang kosong", {
                icon: 'warning',
            });
            return;
        }

        $("#modal_loading").modal('show');
        $.ajax({
            url: $('#form_submit_noconfirm').attr('action'),
            type: $('#form_submit_noconfirm').attr('method'),
            data: $('#form_submit_noconfirm').serialize(),
            success: function(response) {

                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                if (response.status == 200) {
                    // swal(response.message, { icon: 'success', });
                    $("#modal").modal('hide');
                    $("#form_submit_noconfirm")[0].reset();
                    reset_all_select();
                    tb.ajax.reload(null, false);
                    if (response.total < 1) {
                        window.location.href = response.link;
                    }
                } else if (response.status == 201) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                    location.href = location.href;
                } else if (response.status == 203) {
                    swal(response.message, {
                        icon: 'success',
                    });
                    $("#modal").modal('hide');
                    tb.ajax.reload(null, false);
                } else if (response.status == 300) {
                    swal(response.message, {
                        icon: 'error',
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                setTimeout(function() {
                    $('#modal_loading').modal('hide');
                }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                    icon: 'error',
                });
            }
        });
    });
</script>
@endsection
