@extends('partial.app')
@section('title', 'Penggunaan CPRR')
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

    .nav-tabs .nav-item.show .nav-link,
    .nav-tabs .nav-link.active {
        background-color: #0A9447;
        border-color: transparent;
    }

    .nav-tabs .nav-item .nav-link.active {
        font-weight: bold;
        color: #FFFF;
    }

    .nav-tabs .nav-item .nav-link {
        color: #A5A5A5;
    }

    #html5-qrcode-button-camera-start {
        background-color: #0A9447;
        /* Green */
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 12px;
        border-radius: 4px;
    }

    #html5-qrcode-button-camera-stop {
        background-color: #FF0000;
        /* Green */
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 12px;
        border-radius: 4px;
    }

    #html5-qrcode-button-file-selection {
        background-color: #0A9447;
        /* Green */
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 12px;
        border-radius: 4px;
    }

    #html5-qrcode-button-camera-permission {
        background-color: #0A9447;
        /* Green */
        border: none;
        color: white;
        text-align: center;
        text-decoration: none;
        padding-top: 5px;
        padding-bottom: 5px;
        font-size: 12px;
        border-radius: 4px;
    }
</style>
@endsection

@section('content')
<div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div id="reader" width="600px"></div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 mt-2">
                            <div class="form-group required">
                                <label>Hasil Scan</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="result" name="result" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" onclick="click_modal_barcode()" type="button" id="detail"><i class="fa fa-eye"></i> Detail</button>
                                    </div>
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
<div class="modal fade" role="dialog" id="modal_barcode" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Detail Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_ttd" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group required">
                                <label>Katalog</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="fc_stockcode" name="fc_stockcode" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group required">
                                <label>Batch</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="fc_batch" name="fc_batch" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6">
                            <div class="form-group required">
                                <label>Expired Date</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="fd_expired" name="fd_expired" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    var audio = new Audio('/assets/audio/scan.mp3');

    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        // console.log(`Code matched = ${decodedText}`, decodedResult);
        audio.play();
        $('#result').val(decodedText);
        html5QrcodeScanner.clear();
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        // console.warn(`Code scan error = ${error}`);
    }
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            },
            supportedScanTypes: [
                Html5QrcodeScanType.SCAN_TYPE_CAMERA
            ],
        }, false);
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    function click_modal_barcode() {
        $('#modal_barcode').modal('show');
    }
</script>
@endsection