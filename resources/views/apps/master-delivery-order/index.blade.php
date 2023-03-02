@extends('partial.app')
@section('title', 'Master Delivery Order')
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
    </style>
@endsection

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
                                        <th scope="col" class="text-center" style="width: 22%">Actions</th>
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
    <div class="modal fade" role="dialog" id="modal_invoice" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Penerbitan Invoice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_submit" action="/apps/master-delivery-order/inv/publish" method="POST" autocomplete="off">
                    @csrf
                    <input type="text" name="type" id="type" hidden>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Informasi Umum</h4>
                                    </div>
                                    <input type="text" id="" value="" hidden>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label>DONO :</label>
                                                    <span id="fc_dono"></span>
                                                    <input type="text" name="fc_dono" id="fc_dono_input" hidden>
                                                    <input type="text" name="fc_divisioncode" id="fc_divisioncode_input"
                                                        hidden>
                                                    <input type="text" name="fc_sono" id="fc_sono_input"
                                                        hidden>
                                                    <input type="text" name="fc_branch" id="fc_branch_input"
                                                        hidden>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-12">
                                                <div class="form-group">
                                                    <label>Tanggal :</label>
                                                    <span id="fd_dodateinputuser"></span>
                                                </div>
                                                {{-- input --}}
                                                <input type="text" id="fd_dodateinputuser_input"
                                                    name="fd_dodateinputuser" hidden>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-6">
                                                <div class="form-group">
                                                    <label>NPWP</label>
                                                    <input type="text" class="form-control" id="fc_membernpwp_no"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" id="fc_membername1" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 place_detail">
                              <div class="card">
                                 <div class="card-header">
                                       <h4>Calculation</h4>
                                 </div>
                                 <div class="card-body" style="height: 217px">
                                       <div class="d-flex">
                                          <div class="flex-row-item" style="margin-right: 30px">
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Item</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fn_dodetail">0,00</p>
                                             </div>
                                             <input type="text" name="fn_dodetail" id="fn_dodetail_input" hidden>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Disc. Total</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_disctotal">0,00</p>
                                             </div>
                                             <input type="text" name="fm_disctotal" id="fm_disctotal_input" hidden>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Total</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_netto">0,00</p>
                                             </div>
                                          </div>
                                          <input type="text" name="fm_netto" id="fm_netto_input" hidden>
                                          <div class="flex-row-item">
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Pelayanan</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_servpay">0,00</p>
                                             </div>
                                             <input type="text" name="fm_servpay" id="fm_servpay_input" hidden>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex" style="gap: 5px; white-space: pre" >
                                                   <p class="text-secondary flex-row-item" style="font-size: medium">Pajak</p>
                                                   <p class="text-success flex-row-item text-right" style="font-size: medium" id="fm_tax">0,00</p>
                                             </div>
                                             <input type="text" name="fm_tax" id="fm_tax_input" hidden>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex">
                                                   <p class="flex-row-item"></p>
                                                   <p class="flex-row-item text-right"></p>
                                             </div>
                                             <div class="d-flex" style="gap: 5px; white-space: pre">
                                                   <p class="text-secondary flex-row-item" style="font-weight: bold; font-size: medium">GRAND</p>
                                                   <p class="text-success flex-row-item text-right" style="font-weight: bold; font-size:medium" id="fm_brutto">Rp. 0,00</p>
                                             </div>
                                             <input type="text" name="fm_brutto" id="fm_brutto_input" hidden>
                                          </div>
                                       </div>
                                 </div>
                              </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Terbit</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>

                                        <input type="text" id="fd_inv_releasedate" class="form-control datepicker"
                                            name="fd_inv_releasedate" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Masa</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <input type="number" id="fn_inv_agingday" class="form-control" name="fn_inv_agingday"
                                            required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Hari
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-4">
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <div class="input-group" data-date-format="dd-mm-yyyy">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>

                                        <input type="text" id="fn_inv_agingdate" class="form-control datepicker"
                                            name="fn_inv_agingdate" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success">Terbitkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
         $('#modal_invoice').css('overflow-y', 'auto');
      
        function click_modal_invoice(fc_dono) {
            // tambahkan text pada label dengan id fc_dono
            $('#fc_dono').text(fc_dono);

            // tambahkan modal loading
            $('#modal_loading').modal('show');

            $.ajax({
                url: '/apps/master-delivery-order/datatables/detail',
                type: 'GET',
                data: {
                    'fc_dono': fc_dono
                },
                success: function(data) {

                    // hilangkan modal loading
                    $('#modal_loading').modal('hide');

                    // set fc_dono
                    $('#fc_dono').text(data.fc_dono);
                    // set fc_dono input
                    $('#fc_dono_input').val(data.fc_dono);

                    // set fc_divisioncode input
                    $('#fc_divisioncode_input').val(data.fc_divisioncode);

                    // set fc_sono input
                    $('#fc_sono_input').val(data.fc_sono);

                    // set fc_branch input
                    $('#fc_branch_input').val(data.fc_branch);

                    // set fd_dodateinputuser
                    $('#fd_dodateinputuser').text(
                        moment(data.fd_dodateinputuser).format('D MMMM Y')
                    );
                    // set fd_dodateinputuser input
                    $('#fd_dodateinputuser_input').val(
                        moment(data.fd_dodateinputuser).format('D MMMM Y')
                    );
                    //set fc_membernpwp_no input value
                    $('#fc_membernpwp_no').val(data.somst.customer.fc_membernpwp_no);

                    // set fc_membername1 input value
                    $('#fc_membername1').val(data.somst.customer.fc_membername1);
                    
                    // autofill fn_agingdate
                    $('#fn_inv_agingday').on('input', function() {
                        var fd_inv_releasedate = $('#fd_inv_releasedate').val();
                        var fn_inv_agingday = $('#fn_inv_agingday').val();
                        var fn_inv_agingdate = moment(fd_inv_releasedate, 'YYYY-MM-DD').add(fn_inv_agingday, 'days').format('YYYY-MM-DD');
                        $('#fn_inv_agingdate').val(fn_inv_agingdate);
                    });

                    // set fn_dodetail
                    $('#fn_dodetail').html(data.fn_dodetail);
                    $("#fn_dodetail").trigger("change");
                    // set fn_dodetail_input
                    $('#fn_dodetail_input').val(data.fn_dodetail);

                    // set fm_disctotal
                    $('#fm_disctotal').html(data.fm_disctotal);
                    $("#fm_disctotal").trigger("change");
                    // set fm_disctotal_input
                    $('#fm_disctotal_input').val(data.fm_disctotal);

                    // set fm_servpay
                    $('#fm_servpay').html(data.fm_servpay);
                    $("#fm_servpay").trigger("change");
                    // set fm_servpay_input
                    $('#fm_servpay_input').val(data.fm_servpay);

                    // set fm_netto
                    $('#fm_netto').html(data.fm_netto);
                    $("#fm_netto").trigger("change");
                    // set fm_netto_input
                    $('#fm_netto_input').val(data.fm_netto);

                    // set fm_tax
                    $('#fm_tax').html(data.fm_tax)
                    $("#fm_tax").trigger("change");
                    // set fm_tax_input
                    $('#fm_tax_input').val(data.fm_tax);

                    // set fm_brutto
                    $('#fm_brutto').html(
                        // concat dengan RP
                        $.fn.dataTable.render.number(',', '.', 0, 'Rp ').display(data.fm_brutto)
                    )
                    $("#fm_brutto").trigger("change");
                    // set fm_brutto_input
                    $('#fm_brutto_input').val(data.fm_brutto);


                    // tampilkan modal_invoice
                    $('#modal_invoice').modal('show');
                },
                error: function() {
                    // hilangkan modal loading
                    $('#modal_loading').modal('hide');

                    console.log('Error retrieving fd_dodateinputuser');
                }
            });
        }


        var tb = $('#tb').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/apps/master-delivery-order/datatables',
                type: 'GET'
            },
            columnDefs: [{
                    className: 'text-center',
                    targets: [0, 7, 8]
                },
                {
                    className: 'text-nowrap',
                    targets: [3, 6, 8]
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
                    data: 'fc_dono'
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
                    data: 'fm_brutto',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                },
                {
                    data: 'fc_dostatus'
                },
                {
                    data: null
                },
            ],
            rowCallback: function(row, data) {
                $('td:eq(7)', row).html(`<i class="${data.fc_sostatus}"></i>`);
                if (data['fc_dostatus'] == 'I') {
                    $(row).hide();
                } else if (data['fc_dostatus'] == 'D') {
                    $('td:eq(7)', row).html('<span class="badge badge-primary">Delivery</span>');
                } else {
                    $('td:eq(7)', row).html('<span class="badge badge-success">Received</span>');
                }

                if (data['fc_dostatus'] == 'I') {
                    $(row).hide();
                } else if (data['fc_dostatus'] == 'D') {
                    $('td:eq(8)', row).html(
                        `
               <a href="/apps/master-delivery-order/pdf/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
               <a href="/apps/master-delivery-order/pdf_sj/${data.fc_dono}" target="_blank"><button class="btn btn-primary btn-sm mr-1"><i class="fa fa-truck"></i> Surat Jalan</button></a>`
                    );
                } else {
                    if (data['fc_invstatus'] == 'N') {
                        $('td:eq(8)', row).html(
                            `
                     <a href="/apps/master-delivery-order/pdf/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                     <button class="btn btn-info btn-sm" onclick="click_modal_invoice('${data.fc_dono}')">Terbitkan Invoice</button>`
                        );
                    } else {
                        $('td:eq(8)', row).html(
                            `
                     <a href="/apps/master-delivery-order/pdf/${data.fc_dono}" target="_blank"><button class="btn btn-warning btn-sm mr-1"><i class="fa fa-file"></i> PDF</button></a>
                     <a href="/apps/master-delivery-order/inv/${data.fc_dono}" target="_blank"><button class="btn btn-success btn-sm mr-1"><i class="fa fa-credit-card"></i> Invoice</button></a>`
                        );
                    }
                }
                //<a href="/apps/master-delivery-order/inv/${data.fc_dono}" target="_blank"><button class="btn btn-success btn-sm mr-1"><i class="fa fa-credit-card"></i> Invoice</button></a>`
            }
        });
    </script>
@endsection
