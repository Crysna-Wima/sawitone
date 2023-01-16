@extends('partial.app')
@section('title', 'Payment')
@section('css')
    <style>
        #tb_wrapper .row:nth-child(2) {
            overflow-x: auto;
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
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="form-group mr-3">
                                    <label>Date Order</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" fdprocessedid="8ovz8a">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-3 col-lg-3">
                                <div class="form-group mr-3">
                                    <label>Date Expired</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" fdprocessedid="8ovz8a">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-3 col-lg-2">
                                <div class="form-group mr-3 d-flex-row">
                                    <label>Total</label>
                                    <div class="text mt-2">
                                        <h5 class="text-success grand-text" value=" " id="grand_total" name="grand_total">Rp. 0,00</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-3 col-lg-2">
                                <div class="form-group mr-3 d-flex-row">
                                    <label>Kekurangan</label>
                                    <div class="text mt-2">
                                        <h5 class="text-danger grand-text" id="">Rp. 0,00</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 col-md-3 col-lg-2">
                                <div class="form-group mr-3 d-flex-row">
                                    <label>Hutang</label>
                                    <div class="text mt-2">
                                        <h5 class="text-muted grand-text" id="" value="{{ $data->customer->fm_memberAP }}">Rp. 0,00</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-4">
                <div class="card">
                    <div class="card-body" style="padding-top: 30px!important;">
                        <form id="form_submit" action="/apps/sales-order/detail/payment/store-update/{{ $data->fc_sono }}"
                            method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')
                            <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                                <div class="form-group">
                                    <label>Transport</label>
                                    <select class="form-control select2" name="fc_sotransport" id="fc_sotransport">
                                        <option value="By Dexa">By Dexa</option>
                                        <option value="By Paket">By Paket</option>
                                        <option value="By Customer">By Customer</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                                <div class="form-group">
                                    <label>Servpay</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        @if ($data->fm_servpay == 0)
                                        <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" 
                                            class="form-control" name="fm_servpay" id="fm_servpay" fdprocessedid="hgh1fp">
                                        @else
                                        <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" 
                                            class="form-control" name="fm_servpay" id="fm_servpay" value="{{ $data->fm_servpay }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 pr-0 pl-0">
                                <div class="form-group">
                                    <label>Alamat Muat</label>
                                    <textarea type="text" name="fc_memberaddress_loading1" class="form-control"
                                        id="fc_memberaddress_loading1" data-height="100" readonly><?php echo $data->customer->fc_memberaddress_loading1; ?></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 text-right">
                                @if ($data->fm_servpay == 0 && empty($data->fc_sotransport))
                                    <button type="submit" class="btn btn-success">Save</button>
                                        @else
                                    <button type="submit" class="btn btn-success">Edit</button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Metode Pembayaran</h4>
                        <div class="card-header-action">
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#modal_payment"><i class="fa fa-plus mr-1"></i>Tambah Metode</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tb" width="100%">
                                    <thead style="white-space: nowrap">
                                        <tr>
                                            <th scope="col" class="text-center">Kode Metode Pembayaran</th>
                                            <th scope="col" class="text-center">Deskripsi Metode</th>
                                            <th scope="col" class="text-center">Nominal</th>
                                            <th scope="col" class="text-center">Tanggal</th>
                                            <th scope="col" class="text-center">Keterangan</th>
                                            <th scope="col" class="text-center" style="width: 10%">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="button text-right">
                    <a href="#" class="btn btn-success">Submit</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_payment" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-m" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Pilih Metode</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="" method="POST" autocomplete="off">
                    <input type="text" name="type" id="type" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Kode Metode Pembayaran</label>
                                    <select class="form-control select2 " name="fc_kode" id="fc_kode">
                                        <option value="">-- Pilih Kode Bayar --</option>
                                        @foreach ($kode_bayar as $kode)
                                            <option value="{{ $kode->fc_kode }}">{{ $kode->fc_kode }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div id="fv_description" class="form-group">
                                    <label>Deskripsi Bayar</label>
                                    <input type="text" class="form-control " name="fv_description" readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="number" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null" 
                                            class="form-control" fdprocessedid="hgh1fp">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="text" class="form-control datepicker" name="" id=""
                                        readonly>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="" id="" style="height: 70px" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success">Konfirmasi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        // ajax tanpa datatable untuk get data dari apps/sales-order/detail/datatables
        $.ajax({
            url: "{{ url('apps/sales-order/detail/datatables') }}",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                let count_quantity = 0;
                let total_harga = 0;
                let grand_total = 0;

                for (var i = 0; i < data.data.length; i++) {
                    count_quantity += data.data[i].fn_so_qty;
                    total_harga += data.data[i].total_harga;
                    grand_total += (data.data[i].total_harga);
                }
                $('#grand_total').html("Rp. " + fungsiRupiah(grand_total + data.data[0].tempsomst.fm_servpay));
                // console.log(grand_total + data.data[0].tempsomst.fm_servpay);

            }
        });

        $(document).ready(function() {
        $('#fc_kode').on('change', function() {
            var option_id = $(this).val();
            $('#fv_description').empty();
            if(option_id != "") {
                $.ajax({
                    url: "{{ url('/apps/sales-order/detail/payment/getdata') }}/"+option_id,
                    type: "GET",
                    dataType: "json",
                    success:function(fc_kode) {
                        $.each(fc_kode, function(key, value) {
                            // console.log(value['fv_description']);
                            // $('#fv_description').append('<option value="'+ value['fv_description'] +'">'+ value['fv_description'] +'</option>');
                                
                                    $('#fv_description').append('<label>Deskripsi Bayar</label><input type="text" value="'+ value['fv_description'] +'" class="form-control " name="fv_description" id="fv_description" readonly>');
                                
                                
                        
                            // console.log(value['fv_description'] == '')
                        });
                    }
                });
            }else{
                $('#fv_description').empty().append(
                '<label>Deskripsi Bayar</label><input type="text" class="form-control " name="fv_description" id="fv_description" readonly>'
            );
            }
        });
    });

    </script>
@endsection

{{-- @php
    var_dump($data->fc_sono)
@endphp --}}
