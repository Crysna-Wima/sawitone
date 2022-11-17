@extends('partial.app')
@section('title','Master Supplier')
@section('css')
<style>
    #tb_wrapper .row:nth-child(2){
        overflow-x: auto;
    }
</style>
@endsection
@section('content')

<div class="section-body">
   <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
         <div class="card">
            <div class="card-header">
                <h4>Data Master Supplier</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Supplier</button>
                </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table table-striped" id="tb" width="100%">
                     <thead style="white-space: nowrap">
                        <tr>
                           <th scope="col" class="text-center">No</th>
                           <th scope="col" class="text-center">Division</th>
                           <th scope="col" class="text-center">Branch</th>
                           <th scope="col" class="text-center">Supplier Code</th>
                           <th scope="col" class="text-center">Supplier Legal Status</th>
                           <th scope="col" class="text-center">Supplier Name 1</th>
                           <th scope="col" class="text-center">Supplier Name 2</th>
                           <th scope="col" class="text-center">Supplier Phone 1</th>
                           <th scope="col" class="text-center">Supplier Phone 2</th>
                           <th scope="col" class="text-center">Supplier Phone 3</th>
                           <th scope="col" class="text-center">Supplier Email 1</th>
                           <th scope="col" class="text-center">Supplier Email 2</th>
                           <th scope="col" class="text-center">Supplier Nationality</th>
                           <th scope="col" class="text-center">Supplier Forex</th>
                           <th scope="col" class="text-center">Supplier Type Business</th>
                           <th scope="col" class="text-center">Supplier Reseller</th>
                           <th scope="col" class="text-center">Supplier Tax Code</th>
                           <th scope="col" class="text-center">Supplier NPWP</th>
                           <th scope="col" class="text-center">Supplier NPWP Name</th>
                           <th scope="col" class="text-center">Supplier NPWP Address 1</th>
                           <th scope="col" class="text-center">Supplier NPWP Address 2</th>
                           <th scope="col" class="text-center">Supplier AR</th>
                           <th scope="col" class="text-center">Supplier Aging AR</th>
                           <th scope="col" class="text-center">Supplier Lock</th>
                           <th scope="col" class="text-center">Supplier Pic Name</th>
                           <th scope="col" class="text-center">Supplier Pic Phone</th>
                           <th scope="col" class="text-center">Supplier Pic Pos</th>
                           <th scope="col" class="text-center">Supplier Join Date</th>
                           <th scope="col" class="text-center">Supplier Expired</th>
                           <th scope="col" class="text-center">Supplier Bank 1</th>
                           <th scope="col" class="text-center">Supplier Bank 2</th>
                           <th scope="col" class="text-center">Supplier Bank 3</th>
                           <th scope="col" class="text-center">Supplier Virtual Acc</th>
                           <th scope="col" class="text-center">Supplier Norek 1</th>
                           <th scope="col" class="text-center">Supplier Norek 2</th>
                           <th scope="col" class="text-center">Supplier Norek 3</th>
                           <th scope="col" class="text-center">Supplier Description</th>
                           <th scope="col" class="justify-content-center">Actions</th>
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

<!-- Modal -->
<div class="modal fade" role="dialog" id="modal" data-keyboard="false" data-backdrop="static" style="overflow-y: auto">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="text" class="form-control required-field" name="fc_branch_view" id="fc_branch_view" value="{{ auth()->user()->fc_branch}}" readonly hidden>
            <form id="form_submit" action="/data-master/master-supplier/store-update" method="POST" autocomplete="off">
                <input type="text" name="type" id="type" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6" hidden>
                            <div class="form-group">
                                <label>Division Code</label>
                                <input type="text" class="form-control required-field" name="fc_divisioncode" id="fc_divisioncode" value="{{ auth()->user()->fc_divisioncode }}" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Branch</label>
                                <select class="form-control select2 required-field" name="fc_branch" id="fc_branch"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Code</label>
                                <input type="text" class="form-control required-field" name="fc_suppliercode" id="fc_suppliercode" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Name 1</label>
                                <input type="text" class="form-control required-field" name="fc_suppliername1" id="fc_suppliername1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Name 2</label>
                                <input type="text" class="form-control" name="fc_suppliername2" id="fc_suppliername2">
                            </div>
                        </div>

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Pic Name</label>
                                <input type="text" class="form-control" name="fc_supplierpicname" id="fc_supplierpicname">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Pic Phone</label>
                                <input type="text" class="form-control" name="fc_supplierpicphone" id="fc_supplierpicphone">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Pic Pos</label>
                                <input type="text" class="form-control" name="fc_supplierpicpos" id="fc_supplierpicpos">
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Legal Status</label>
                                <select class="select2" name="fc_supplierlegalstatus" id="fc_supplierlegalstatus"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Nationality</label>
                                <select class="select2" name="fc_suppliernationality" id="fc_suppliernationality" onchange="change_nationality()"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Forex</label>
                                <input type="text" readonly class="form-control" name="fc_supplierforex" id="fc_supplierforex">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Type Business</label>
                                <select class="select2 required-field" name="fc_suppliertypebusiness" id="fc_suppliertypebusiness"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Join Date</label>
                                <input type="text"   class="form-control datepicker" name="fd_supplierjoindate" id="fd_supplierjoindate">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Expired</label>
                                <input type="text" class="form-control datepicker" name="fd_supplierexpired" id="fd_supplierexpired">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Reseller</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_supplierreseller" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_supplierreseller" value="F" class="selectgroup-input" checked="">
                                        <span class="selectgroup-button">Non Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Tax Code</label>
                                <select class="select2" name="fc_suppliertaxcode" id="fc_suppliertaxcode"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier NPWP</label>
                                <input type="text" class="form-control" name="fc_supplierNPWP" id="fc_supplierNPWP">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier NPWP Name</label>
                                <input type="text" class="form-control" name="fc_suppliernpwp_name" id="fc_suppliernpwp_name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier NPWP Address 1</label>
                                <textarea type="text" class="form-control" name="fc_supplier_npwpaddress1" id="fc_supplier_npwpaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier NPWP Address 2</label>
                                <textarea type="text" class="form-control" name="fc_supplier_npwpaddress2" id="fc_supplier_npwpaddress2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Email 1</label>
                                <input type="text" class="form-control" name="fc_supplieremail1" id="fc_supplieremail1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Supplier Email 2</label>
                                <input type="text" class="form-control" name="fc_supplieremail2" id="fc_supplieremail2">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Phone 1</label>
                                <input type="text" class="form-control" name="fc_supplierphone1" id="fc_supplierphone1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Phone 2</label>
                                <input type="text" class="form-control" name="fc_supplierphone2" id="fc_supplierphone2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Phone 3</label>
                                <input type="text" class="form-control" name="fc_supplierphone3" id="fc_supplierphone3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Bank 1</label>
                                <select class="form-control select2" name="fc_supplierbank1" id="fc_supplierbank1"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Bank 2</label>
                                <select class="form-control select2" name="fc_supplierbank2" id="fc_supplierbank2"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Bank 3</label>
                                <select class="form-control select2" name="fc_supplierbank3" id="fc_supplierbank3"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier No Rekening 1</label>
                                <input type="text" class="form-control" name="fc_suppliernorek1" id="fc_suppliernorek1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier No Rekening 2</label>
                                <input type="text" class="form-control" name="fc_suppliernorek2" id="fc_suppliernorek2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier No Rekening 3</label>
                                <input type="text" class="form-control" name="fc_suppliernorek3" id="fc_suppliernorek3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Supplier Virtual AC</label>
                                <input type="text" class="form-control" name="fc_suppliervirtualac" id="fc_suppliervirtualac">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Supplier Hutang</label>
                                <input type="text" class="form-control" readonly name="fm_supplierAR" id="fm_supplierAR" value="0">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Supplier Aging AP</label>
                                <input type="number" class="form-control" name="fn_supplierAgingAR" id="fn_supplierAgingAR">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Lock Transaksi</label>
                                <select class="form-control select2" name="fn_supplierlockTrans" id="fn_supplierlockTrans"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="fv_supplierdescription" id="fv_supplierdescription" style="height: 90px" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>
       $(document).ready(function(){
        get_data_branch();
        get_data_legal_status();
        get_data_nationality();
        get_data_type_business();
        get_data_tax_code();
        get_data_lock_code();
        get_data_supplier_bank();
    })

    function generate_no_document(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/generate-no-document",
            type: "GET",
            data: {
                'fv_document': 'SUPPLIER',
                'fc_branch': null,
                'fv_part': null,
            },
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    $('#fc_suppliercode').val(response.data);
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function change_nationality(){
        $('#fc_supplierforex').val($('#fc_suppliernationality').val());
    }

    function get_data_branch(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/BRANCH",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_branch").empty();
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_kode == $('#fc_branch_view').val()){
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}" selected>${data[i].fv_description}</option>`);
                            $("#fc_branch").prop("disabled", true);
                        }else{
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                        }
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function get_data_legal_status(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/CUST_LEGAL",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_supplierlegalstatus").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_supplierlegalstatus").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function get_data_nationality(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/NATIONALITY",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_suppliernationality").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliernationality").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function get_data_type_business(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/MEMBER_BUSI_TYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_suppliertypebusiness").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliertypebusiness").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function get_data_tax_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/CUST_TAXTYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_suppliertaxcode").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_suppliertaxcode").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function get_data_lock_code(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/CUST_LOCKTYPE",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fn_supplierlockTrans").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fn_supplierlockTrans").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function get_data_supplier_bank(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/BankAcc",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_supplierbank1").empty();
                    $("#fc_supplierbank2").empty();
                    $("#fc_supplierbank3").empty();
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_supplierbank1").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
                        $("#fc_supplierbank2").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
                        $("#fc_supplierbank3").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
                    }
                }else{
                    iziToast.error({
                        title: 'Error!',
                        message: response.message,
                        position: 'topRight'
                    });
                }
            },error: function (jqXHR, textStatus, errorThrown){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + errorThrown + ")", {  icon: 'error', });
            }
        });
    }

    function add(){
      $("#modal").modal('show');
      $(".modal-title").text('Tambah Master Supplier');
      $("#form_submit")[0].reset();
      change_nationality();
      generate_no_document();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/master-supplier/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0,5] },
         { className: 'd-flex', targets: [37] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_divisioncode' },
         { data: 'branch.fv_description' },
         { data: 'fc_suppliercode' },
         { data: 'supplier_legal_status.fv_description' },
         { data: 'fc_suppliername1' },
         { data: 'fc_suppliername2' },
         { data: 'fc_supplierphone1' },
         { data: 'fc_supplierphone2' },
         { data: 'fc_supplierphone3' },
         { data: 'fc_supplieremail1' },
         { data: 'fc_supplieremail2' },
         { data: 'supplier_nationality.fv_description' },
         { data: 'fc_supplierforex' },
         { data: 'supplier_type_business.fv_description' },
         { data: 'fl_supplierreseller' },
         { data: 'supplier_tax_code.fv_description' },
         { data: 'fc_supplierNPWP' },
         { data: 'fc_suppliernpwp_name' },
         { data: 'fc_supplier_npwpaddress1' },
         { data: 'fc_supplier_npwpaddress2' },
         { data: 'fm_supplierAR' },
         { data: 'fn_supplierAgingAR' },
         { data: 'fn_supplierlockTrans' },
         { data: 'fc_supplierpicname' },
         { data: 'fc_supplierpicphone' },
         { data: 'fc_supplierpicpos' },
         { data: 'fd_supplierjoindate' },
         { data: 'fd_supplierexpired' },
         { data: 'supplier_bank1.fv_bankname' },
         { data: 'supplier_bank2.fv_bankname' },
         { data: 'supplier_bank3.fv_bankname' },
         { data: 'fc_suppliervirtualac' },
         { data: 'fc_suppliernorek1' },
         { data: 'fc_suppliernorek2' },
         { data: 'fc_suppliernorek3' },
         { data: 'fv_supplierdescription' },
         { data: 'fc_suppliercode' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/master-supplier/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_suppliercode;
         var url_delete = "/data-master/master-supplier/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_suppliercode;

         $('td:eq(37)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_suppliername1}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Data Master Supplier');
      $("#type").val('update');
   }
</script>
@endsection
