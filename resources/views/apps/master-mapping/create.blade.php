@extends('partial.app')
@section('title', 'Retur Barang')
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
        <div class="col-12 col-md-4 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Informasi Umum</h4>
                    <div class="card-header-action">
                        <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
                    </div>
                </div>
                <input type="text" id="fc_branch" value="{{ auth()->user()->fc_branch }}" hidden>
                <div class="collapse" id="mycard-collapse">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Divisi</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_divisioncode }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Cabang</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_branch }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Kode Mapping</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_mappingcode }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Nama Mapping</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->fc_mappingname }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-3">
                                <div class="form-group">
                                    <label>Operator</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $data->created_by }}" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-9">
                                <div class="form-group required">
                                    <label>Deskripsi</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" value="{{ $data->fv_description ?? '-' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RETUR ITEM --}}
        <div class="col-12 col-md-12 col-lg-6 place_detail">
            <div class="card">
                <div class="card-header">
                    <h4>Item yang Diretur</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped" id="tb" width="100%">
                                <thead style="white-space: nowrap">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Kode Barang</th>
                                        <th scope="col" class="text-center">Nama Barang</th>
                                        <th scope="col" class="text-center">Satuan</th>
                                        <th scope="col" class="text-center">Batch</th>
                                        <th scope="col" class="text-center">Exp.</th>
                                        <th scope="col" class="text-center">CAT.</th>
                                        <th scope="col" class="text-center">Qty Retur</th>
                                        <th scope="col" class="text-center">Harga</th>
                                        <th scope="col" class="text-center">Catatan</th>
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
    <div class="button text-right mb-4">
        <form id="form_submit_edit" action="/apps/retur-barang/detail/submit" method="post">
            <button type="button" onclick="click_cancel()" class="btn btn-danger mr-1">Cancel</button>
            @csrf
            @method('put')
            <button type="submit" class="btn btn-success">Submit Retur</button>
        </form>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_do_dtl" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Pilih Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="tb_do_dtl" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Kode Barang</th>
                                    <th scope="col" class="text-center">Nama Barang</th>
                                    <th scope="col" class="text-center">Satuan</th>
                                    <th scope="col" class="text-center">Qty</th>
                                    <th scope="col" class="text-center">Qty Retur</th>
                                    <th scope="col" class="text-center">Exp. Date</th>
                                    <th scope="col" class="text-center">Batch</th>
                                    <th scope="col" class="text-center">Action</th>
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
</script>
@endsection