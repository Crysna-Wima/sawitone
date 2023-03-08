@extends('partial.app')
@section('title','Purchase Order')
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
</style>
@endsection
@section('content')

<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <form id="form_submit" action="/apps/sales-order/store-update" method="POST" autocomplete="off">
                    <div class="collapse show" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label>Tanggal : {{ \Carbon\Carbon::now()->format('d/m/Y') }}</label>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Operator</label>
                                        <input type="text" class="form-control" name="" id="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>PO Type</label>
                                        <select class="form-control select2 required-field" name="" id="">
                                            <option value="" selected disabled>- Pilih -</option>
                                            <option value="Consignment">Consignment</option>
                                            <option value="Regular SO">Grochery</option>
                                            <option value="Retailer">Retailer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Supplier Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_membercode" name="fc_membercode" readonly>
                                            <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="click_modal_supplier()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                    <label>Status PKP</label>
                                    {{-- <select class="form-control select2 select2-hidden-accessible" name="" id="" tabindex="-1" aria-hidden="true">
                                        <option value="T">YES</option>
                                        <option selected="" value="F">NO</option>
                                    </select> --}}
                                    <input type="text" class="form-control" id="status_pkp" name="fc_pkp" readonly>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success">Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Supplier</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>NPWP</label>
                                    <input type="text" class="form-control" name="fc_membernpwp_no" id="fc_membernpwp_no" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Cabang</label>
                                    <input type="text" class="form-control" name="fc_member_branchtype" id="fc_member_branchtype" readonly hidden>
                                    <input type="text" class="form-control" name="fc_member_branchtype_desc" id="fc_member_branchtype_desc" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Tipe Bisnis</label>
                                    <input type="text" class="form-control" name="fc_membertypebusiness" id="fc_membertypebusiness" readonly hidden>
                                    <input type="text" class="form-control" name="fc_membertypebusiness_desc" id="fc_membertypebusiness_desc" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="fc_membername1" id="fc_membername1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" class="form-control" name="fc_memberaddress1" id="fc_memberaddress1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Masa Hutang</label>
                                    <input type="text" class="form-control" name="fc_stockcode" id="fc_stockcode" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Legal Status</label>
                                    <input type="text" class="form-control" name="fc_memberlegalstatus" id="fc_memberlegalstatus" readonly hidden>
                                    <input type="text" class="form-control" name="fc_memberlegalstatus_desc" id="fc_memberlegalstatus_desc" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <input type="text" class="form-control" name="fc_memberaddress_loading1" id="fc_memberaddress_loading1" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label>Hutang</label>
                                    <input type="text" class="form-control" name="fc_stockcode" id="fc_stockcode" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-8 place_detail">
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <form id="form_submit_custom" action="/apps/sales-order/detail/store-update" method="POST"
                            autocomplete="off">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Kode Barang</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_barcode" name="fc_barcode"
                                                readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button"
                                                    onclick=""><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Qty</label>
                                    <div class="form-group">
                                        <input type="number" min="0"
                                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                            class="form-control" name="" id="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <label>Bonus</label>
                                    <div class="form-group">
                                        <input type="number" min="0"
                                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                            class="form-control" name="" id="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    Rp.
                                                </div>
                                            </div>
                                            <input type="text" class="form-control format-rp" name=""
                                                id="" onkeyup="return onkeyupRupiah(this.id);"required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-7">
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" fdprocessedid="hgh1fp"
                                                name="" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button class="btn btn-success">Add Item</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4 place_detail">
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important; height: 260px">
                        <form id="form_submit" action="#"
                            method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="d-flex">
                                <div class="flex-row-item">
                                    <div class="d-flex" style="gap: 5px; white-space: pre">
                                        <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                        <p class="text-success flex-row-item text-right" style="font-size: medium" id="count_item">0,00</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Transport</label>
                                        @if (empty($data->fc_sotransport))
                                            <select class="form-control select2" name="" id="">
                                                <option value="" selected disabled>- Pilih Transport -</option>
                                                <option value="By Dexa">By Dexa</option>
                                                <option value="By Paket">By Paket</option>
                                                <option value="By Customer">By Customer</option>
                                            </select>
                                        @else
                                            <select class="form-control select2" name="" id="">
                                                <option value="#" selected disabled></option>
                                                <option value="By Dexa">By Dexa</option>
                                                <option value="By Paket">By Paket</option>
                                                <option value="By Customer">By Customer</option>
                                            </select>
                                        @endif
                                    </div>
                                    <div class="d-flex">
                                        <p class="flex-row-item"></p>
                                        <p class="flex-row-item text-right"></p>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-success">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        {{-- TABLE --}}
        <div class="col-12 col-md-12 col-lg-12 place_detail">
             <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Nama Produk</th>
                                    <th scope="col" class="text-center">Quantity</th>
                                    <th scope="col" class="text-center">Unity</th>
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
    <div class="modal fade" role="dialog" id="modal_supplier" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="tb_supplier" width="100%">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center">Kode</th>
                            <th scope="col" class="text-center">Nama</th>
                            <th scope="col" class="text-center">Alamat</th>
                            <th scope="col" class="text-center">Tipe Bisnis</th>
                            <th scope="col" class="text-center">Tipe Cabang</th>
                            <th scope="col" class="text-center">Legalitas</th>
                            <th scope="col" class="text-center">NPWP</th>
                            <th scope="col" class="text-center" style="width: 10%">Actions</th>
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

    $(document).ready(function(){
        get_data_sales();
        $('.place_detail').attr('hidden', true);
    })

    function click_modal_supplier(){
        $('#modal_supplier').modal('show');
        table_supplier();
    }

    function table_supplier(){
        var tb = $('#tb_supplier').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: "#",
                type: 'GET'
            },
            columnDefs: [
                { className: 'text-center', targets: [0,7] },
            ],
            columns: [
                { data: 'fc_suppliercode' },
                { data: 'fc_suppliername1' },
                { data: 'fc_supplier_npwpaddress1' },
                { data: 'fc_suplliertypiebusiness' },
                { data: 'fc_branchtype' },
                { data: 'fc_supplierlegalstatus' },
                { data: 'fc_suppliernpwp' },
                { data: null },
            ],
            rowCallback : function(row, data){
                $('td:eq(7)', row).html(`
                    <button type="button" class="btn btn-success btn-sm mr-1" onclick=""><i class="fa fa-check"></i> Pilih</button>
                `);
            }
        });
    }
</script>
@endsection
