@extends('partial.app')
@section('title', 'Mutasi Barang')
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
        <div class="col-12 col-md-4 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <form id="form_submit" action="" method="POST" autocomplete="off">
                    <div class="collapse show" id="mycard-collapse">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <div class="input-group" data-date-format="dd-mm-yyyy">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" id="fd_date_byuser" class="form-control datepicker"
                                                name="fd_date_byuser" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Jenis Mutasi</label>
                                        @if (empty($data->fc_type_mutation))
                                            <select class="form-control select2" name="fc_type_mutation" id="fc_type_mutation" required>
                                                <option value="" selected disabled>- Pilih -</option>
                                                <option value="INTERNAL">INTERNAL</option>
                                                <option value="EKSTERNAL">EKSTERNAL</option>
                                            </select>
                                        @else
                                            <select class="form-control select2" name="fc_type_mutation" id="fc_type_mutation" required>
                                                <option value="{{ $data->fc_type_mutation }}" selected>
                                                -- {{ $data->fc_type_mutation }} --
                                                </option>
                                                <option value="INTERNAL">INTERNAL</option>
                                                <option value="EKSTERNAL">EKSTERNAL</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Lokasi Awal</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_startpoint" name="fc_startpoint" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="click_modal_lokasi_awal()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <label>Lokasi Tujuan</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="fc_destination" name="fc_destination" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" onclick="click_modal_lokasi_tujuan()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12 text-right">
                                    <button type="submit" class="btn btn-success">Buat Mutasi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4>Detail Mutasi</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse2" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <div class="collapse show" id="mycard-collapse2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Berangkat</label>
                                    <input type="text" class="form-control" name="fc_rackname" id="fc_rackname" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Lokasi Tujuan</label>
                                    <input type="text" class="form-control" name="fc_rackname" id="fc_rackname" readonly>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Berangkat</label>
                                    <textarea type="text" name="fc_warehouseaddress" class="form-control" id="fc_warehouseaddress"
                                        data-height="76" readonly></textarea>
                                </div>
                            </div>
                            <div class="col-4 col-md-4 col-lg-6">
                                <div class="form-group">
                                    <label>Alamat Lokasi Tujuan</label>
                                    <textarea type="text" name="fc_warehouseaddress" class="form-control" id="fc_warehouseaddress"
                                        data-height="76" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_lokasi_awal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Lokasi Awal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_warehouse_awal" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Division</th>
                                    <th scope="col" class="text-center">Cabang</th>
                                    <th scope="col" class="text-center">Kode Gudang</th>
                                    <th scope="col" class="text-center">Posisi Gudang</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Rackname</th>
                                    <th scope="col" class="text-center">Kapasitas</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_lokasi_tujuan" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Lokasi Tujuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_warehouse_tujuan" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Division</th>
                                    <th scope="col" class="text-center">Cabang</th>
                                    <th scope="col" class="text-center">Kode Gudang</th>
                                    <th scope="col" class="text-center">Posisi Gudang</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Rackname</th>
                                    <th scope="col" class="text-center">Kapasitas</th>
                                    <th scope="col" class="text-center">Deskripsi</th>
                                    <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    function click_modal_lokasi_awal() {
        $('#modal_lokasi_awal').modal('show');
        table_warehouse_awal();
    }

    function click_modal_lokasi_tujuan() {
        $('#modal_lokasi_tujuan').modal('show');
        table_warehouse_tujuan();
    }

    function table_warehouse_awal() {
        var tb = $('#tb_warehouse_awal').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/apps/mutasi-barang/datatables-lokasi-awal',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0]
            },
            {
                className: 'text-nowrap',
                targets: [9]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_divisioncode'
            },
            {
                data: 'branch.fv_description'
            },
            {
                data: 'fc_warehousecode'
            },
            {
                data: 'fc_warehousepos'
            },
            {
                data: 'fl_status'
            },
            {
                data: 'fc_rackname'
            },
            {
                data: 'fn_capacity'
            },
            {
                data: 'fv_description'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {

            $('td:eq(5)', row).html(`<i class="${data.fc_dostatus}"></i>`);
            if (data['fl_status'] == 'G') {
                $('td:eq(5)', row).html('<span class="badge badge-success">Gudang</span>');
            } else {
                $('td:eq(5)', row).html('<span class="badge badge-primary">Display</span>');
            }

            $('td:eq(9)', row).html(`
            <button class="btn btn-warning btn-sm mr-1" onclick=""><i class="fa fa-check"></i> Pilih</button>
         `);
        }
    });
    }

    function table_warehouse_tujuan() {
        var tb = $('#tb_warehouse_tujuan').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/apps/mutasi-barang/datatables-lokasi-tujuan',
            type: 'GET'
        },
        columnDefs: [{
                className: 'text-center',
                targets: [0]
            },
            {
                className: 'text-nowrap',
                targets: [9]
            },
        ],
        columns: [{
                data: 'DT_RowIndex',
                searchable: false,
                orderable: false
            },
            {
                data: 'fc_divisioncode'
            },
            {
                data: 'branch.fv_description'
            },
            {
                data: 'fc_warehousecode'
            },
            {
                data: 'fc_warehousepos'
            },
            {
                data: 'fl_status'
            },
            {
                data: 'fc_rackname'
            },
            {
                data: 'fn_capacity'
            },
            {
                data: 'fv_description'
            },
            {
                data: null
            },
        ],
        rowCallback: function(row, data) {

            $('td:eq(5)', row).html(`<i class="${data.fc_dostatus}"></i>`);
            if (data['fl_status'] == 'G') {
                $('td:eq(5)', row).html('<span class="badge badge-success">Gudang</span>');
            } else {
                $('td:eq(5)', row).html('<span class="badge badge-primary">Display</span>');
            }

            $('td:eq(9)', row).html(`
            <button class="btn btn-warning btn-sm mr-1" onclick=""><i class="fa fa-check"></i> Pilih</button>
         `);
        }
    });
    }

</script>
@endsection