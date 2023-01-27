@extends('partial.app')
@section('title','Master Customer')
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
                <h4>Data Master Customer</h4>
                <div class="card-header-action">
                    <button type="button" class="btn btn-success" onclick="add();"><i class="fa fa-plus mr-1"></i> Tambah Master Customer</button>
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
                           <th scope="col" class="text-center">Member Code</th>
                           <th scope="col" class="text-center">Member Name 1</th>
                           <th scope="col" class="text-center">Member Name 2</th>
                           <th scope="col" class="text-center">Member Address 1</th>
                           <th scope="col" class="text-center">Member Address 2</th>
                           <th scope="col" class="text-center">Member Address Loading 1</th>
                           <th scope="col" class="text-center">Member Address Loading 2</th>
                           <th scope="col" class="text-center">Member Phone 1</th>
                           <th scope="col" class="text-center">Member Phone 2</th>
                           <th scope="col" class="text-center">Member Phone 3</th>
                           <th scope="col" class="text-center">Member Web</th>
                           <th scope="col" class="text-center">Member Email 1</th>
                           <th scope="col" class="text-center">Member Email 2</th>
                           <th scope="col" class="text-center">Member Type Buisness</th>
                           <th scope="col" class="text-center">Member Branch Type</th>
                           <th scope="col" class="text-center">Member Reseller</th>
                           <th scope="col" class="text-center">Member Legal Status</th>
                           <th scope="col" class="text-center">Member Tax Code</th>
                           <th scope="col" class="text-center">Member NPWP No</th>
                           <th scope="col" class="text-center">Member NPWP Name</th>
                           <th scope="col" class="text-center">Member NPWP Address 1</th>
                           <th scope="col" class="text-center">Member NPWP Address 2</th>
                           <th scope="col" class="text-center">Member Nationality</th>
                           <th scope="col" class="text-center">Member Forex</th>
                           <th scope="col" class="text-center">Member AP</th>
                           <th scope="col" class="text-center">Member Aging AP</th>
                           <th scope="col" class="text-center">Member Lock Trans Type</th>
                           <th scope="col" class="text-center">Contact Person 1</th>
                           <th scope="col" class="text-center">Contact Person 2</th>
                           <th scope="col" class="text-center">Contact Person 3</th>
                           <th scope="col" class="text-center">Contact Person 4</th>
                           <th scope="col" class="text-center">Contact Person 5</th>
                           <th scope="col" class="text-center">Member Pic Phone</th>
                           <th scope="col" class="text-center">Member Pic Pos</th>
                           <th scope="col" class="text-center">Member Join Date</th>
                           <th scope="col" class="text-center">Member Contract</th>
                           <th scope="col" class="text-center">Member Bank 1</th>
                           <th scope="col" class="text-center">Member Bank 2</th>
                           <th scope="col" class="text-center">Member Bank 3</th>
                           <th scope="col" class="text-center">Member Virtual Acc</th>
                           <th scope="col" class="text-center">Member Norek 1</th>
                           <th scope="col" class="text-center">Member Norek 2</th>
                           <th scope="col" class="text-center">Member Norek 3</th>
                           <th scope="col" class="text-center">Member Desciption</th>
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
            <form id="form_submit" action="/data-master/master-customer/store-update" method="POST" autocomplete="off">
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
                                <label>Customer Code</label>
                                <input type="text" class="form-control required-field" readonly name="fc_membercode" id="fc_membercode">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer Name 1</label>
                                <input type="text" class="form-control required-field" name="fc_membername1" id="fc_membername1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer Name 2</label>
                                <input type="text" class="form-control" name="fc_membername2" id="fc_membername2">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer Address 1</label>
                                <textarea type="text" class="form-control" name="fc_memberaddress1" id="fc_memberaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer Address 2</label>
                                <textarea type="text" class="form-control" name="fc_memberaddress2" id="fc_memberaddress2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer Address Loading 1</label>
                                <textarea type="text" class="form-control" name="fc_memberaddress_loading1" id="fc_memberaddress_loading1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer Address Loading 2</label>
                                <textarea type="text" class="form-control" name="fc_memberaddress_loading2" id="fc_memberaddress_loading2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Contact Person Name 1</label>
                                <input type="text" class="form-control" name="fc_memberpicname" id="fc_memberpicname">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Contact Person Name 2</label>
                                <input type="text" class="form-control" name="fc_memberpicname2" id="fc_memberpicname2">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Contact Person Name 3</label>
                                <input type="text" class="form-control" name="fc_memberpicname3" id="fc_memberpicname3">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Contact Person Name 4</label>
                                <input type="text" class="form-control" name="fc_memberpicname4" id="fc_memberpicname4">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Contact Person Name 5</label>
                                <input type="text" class="form-control" name="fc_memberpicname5" id="fc_memberpicname5">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Pic Phone</label>
                                <input type="text" class="form-control" name="fc_memberpicphone" id="fc_memberpicphone">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Pic Pos</label>
                                <input type="text" class="form-control" name="fc_memberpicpos" id="fc_memberpicpos">
                            </div>
                        </div>

                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Legal Status</label>
                                <select class="select2 required-field" name="fc_memberlegalstatus" id="fc_memberlegalstatus"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Nationality</label>
                                <select class="select2" name="fc_membernationality" id="fc_membernationality" onchange="change_nationality()"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Forex</label>
                                <input type="text" readonly class="form-control" name="fc_memberforex" id="fc_memberforex">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Type Business</label>
                                <select class="select2 required-field" name="fc_membertypebusiness" id="fc_membertypebusiness"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Join Date</label>
                                <input type="text"   class="form-control datepicker" name="fd_memberjoindate" id="fd_memberjoindate">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Contract</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_membercontract" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">YES</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_membercontract" value="F" class="selectgroup-input"  checked="">
                                        <span class="selectgroup-button">NO</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Reseller</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_memberreseller" value="T" class="selectgroup-input">
                                        <span class="selectgroup-button">Active</span>
                                    </label>
                                    <label class="selectgroup-item" style="margin: 0!important">
                                        <input type="radio" name="fl_memberreseller" value="F" class="selectgroup-input"  checked="">
                                        <span class="selectgroup-button">Non Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Tax Code</label>
                                <select class="select2" name="fc_membertaxcode" id="fc_membertaxcode"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Branch Type</label>
                                <select class="select2" class="form-control required-field" name="fc_member_branchtype" id="fc_member_branchtype"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-6">
                            <div class="form-group">
                                <label>Customer NPWP</label>
                                <input type="text" class="form-control" name="fc_membernpwp_no" id="fc_membernpwp_no">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer NPWP Name</label>
                                <input type="text" class="form-control" name="fc_membernpwp_name" id="fc_membernpwp_name">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer NPWP Address 1</label>
                                <textarea type="text" class="form-control" name="fc_member_npwpaddress1" id="fc_member_npwpaddress1" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer NPWP Address 2</label>
                                <textarea type="text" class="form-control" name="fc_member_npwpaddress2" id="fc_member_npwpaddress2" style="height: 100px"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer Email 1</label>
                                <input type="text" class="form-control" name="fc_memberemail1" id="fc_memberemail1">
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label>Customer Email 2</label>
                                <input type="text" class="form-control" name="fc_memberemail2" id="fc_memberemail2">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer Phone 1</label>
                                <input type="text" class="form-control" name="fc_memberphone1" id="fc_memberphone1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer Phone 2</label>
                                <input type="text" class="form-control" name="fc_memberphone2" id="fc_memberphone2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer Phone 3</label>
                                <input type="text" class="form-control" name="fc_memberphone3" id="fc_memberphone3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer Bank 1</label>
                                <select class="form-control select2" name="fc_memberbank1" id="fc_memberbank1"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer Bank 2</label>
                                <select class="form-control select2" name="fc_memberbank2" id="fc_memberbank2"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer Bank 3</label>
                                <select class="form-control select2" name="fc_memberbank3" id="fc_memberbank3"></select>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer No Rekening 1</label>
                                <input type="text" class="form-control" name="fc_membernorek1" id="fc_membernorek1">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer No Rekening 2</label>
                                <input type="text" class="form-control" name="fc_membernorek2" id="fc_membernorek2">
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer No Rekening 3</label>
                                <input type="text" class="form-control" name="fc_membernorek3" id="fc_membernorek3">
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Customer Virtual AC</label>
                                <input type="text" class="form-control" name="fc_membervirtualac" id="fc_membervirtualac">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Customer Hutang</label>
                                <input type="text" class="form-control" readonly name="fm_memberAP" id="fm_memberAP" value="0">
                            </div>
                        </div>
                        <div class="col-12 col-md-2 col-lg-2">
                            <div class="form-group">
                                <label>Customer Aging AP</label>
                                <input type="number" class="form-control" name="fn_memberAgingAP" id="fn_memberAgingAP">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="form-group">
                                <label>Lock Transaksi</label>
                                <select class="form-control select2" name="fc_memberlockTransType" id="fc_memberlockTransType"></select>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="fv_memberdescription" id="fv_memberdescription" style="height: 90px" class="form-control"></textarea>
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
        get_data_member_bank();
        get_data_branch_type();
    })

    function generate_no_document(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/generate-no-document",
            type: "GET",
            data: {
                'fv_document': 'CUSTOMER',
                'fc_branch': null,
                'fv_part': null,
            },
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    $('#fc_membercode').val(response.data);
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
        $('#fc_memberforex').val($('#fc_membernationality').val());
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
                    $("#fc_branch").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        if(data[i].fc_kode == $('#fc_branch_view').val()){
                            $("#fc_branch").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_memberlegalstatus").empty();
                    $("#fc_memberlegalstatus").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_memberlegalstatus").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_membernationality").empty();
                    $("#fc_membernationality").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membernationality").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_membertypebusiness").empty();
                    $("#fc_membertypebusiness").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membertypebusiness").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_membertaxcode").empty();
                    $("#fc_membertaxcode").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_membertaxcode").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
                    $("#fc_memberlockTransType").empty();
                    $("##fc_memberlockTransType").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_memberlockTransType").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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

    function get_data_member_bank(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-all/BankAcc",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_memberbank1").empty();
                    $("#fc_memberbank1").append(`<option value="" selected readonly> - Pilih - </option>`);
                    $("#fc_memberbank2").empty();
                    $("#fc_memberbank2").append(`<option value="" selected readonly> - Pilih - </option>`);
                    $("#fc_memberbank3").empty();
                    $("#fc_memberbank3").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_memberbank1").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
                        $("#fc_memberbank2").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
                        $("#fc_memberbank3").append(`<option value="${data[i].fc_bankcode}">${data[i].fv_bankname}</option>`);
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

    function get_data_branch_type(){
        $("#modal_loading").modal('show');
        $.ajax({
            url : "/master/get-data-where-field-id-get/TransaksiType/fc_trx/CUST_TYPEOFFICE",
            type: "GET",
            dataType: "JSON",
            success: function(response){
                setTimeout(function () {  $('#modal_loading').modal('hide'); }, 500);
                if(response.status === 200){
                    var data = response.data;
                    $("#fc_member_branchtype").empty();
                    $("#fc_member_branchtype").append(`<option value="" selected readonly> - Pilih - </option>`);
                    for (var i = 0; i < data.length; i++) {
                        $("#fc_member_branchtype").append(`<option value="${data[i].fc_kode}">${data[i].fv_description}</option>`);
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
      $(".modal-title").text('Tambah Master Customer');
      $("#form_submit")[0].reset();
      change_nationality();
      generate_no_document();
    }

   var tb = $('#tb').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
         url: '/data-master/master-customer/datatables',
         type: 'GET'
      },
      columnDefs: [
         { className: 'text-center', targets: [0] },
         { className: 'd-flex', targets: [43] },
      ],
      columns: [
         { data: 'DT_RowIndex',searchable: false, orderable: false},
         { data: 'fc_divisioncode' },
         { data: 'branch.fv_description' },
         { data: 'fc_membercode' },
         { data: 'fc_membername1' },
         { data: 'fc_membername2' },
         { data: 'fc_memberaddress1' },
         { data: 'fc_memberaddress2' },
         { data: 'fc_memberaddress_loading1' },
         { data: 'fc_memberaddress_loading2' },
         { data: 'fc_memberphone1' },
         { data: 'fc_memberphone2' },
         { data: 'fc_memberphone3' },
         { data: 'fc_memberweb' },
         { data: 'fc_memberemail1' },
         { data: 'fc_memberemail2' },
         { data: 'member_type_business.fv_description' },
         { data: 'member_typebranch.fv_description' },
         { data: 'fl_memberreseller' },
         { data: 'member_legal_status.fv_description' },
         { data: 'member_tax_code.fv_description' },
         { data: 'fc_membernpwp_no' },
         { data: 'fc_membernpwp_name' },
         { data: 'fc_member_npwpaddress1' },
         { data: 'fc_member_npwpaddress2' },
         { data: 'member_nationality.fv_description' },
         { data: 'fc_memberforex' },
         { data: 'fm_memberAP' },
         { data: 'fn_memberAgingAP' },
         { data: 'fc_memberlockTransType' },
         { data: 'fc_memberpicname' },
         { data: 'fc_memberpicname2' },
         { data: 'fc_memberpicname3' },
         { data: 'fc_memberpicname4' },
         { data: 'fc_memberpicname5' },
         { data: 'fc_memberpicphone' },
         { data: 'fc_memberpicpos' },
         { data: 'fd_memberjoindate' },
         { data: 'fl_membercontract' },
         { data: 'member_bank1.fv_bankname' },
         { data: 'member_bank2.fv_bankname' },
         { data: 'member_bank3.fv_bankname' },
         { data: 'fc_membervirtualac' },
         { data: 'fc_membernorek1' },
         { data: 'fc_membernorek2' },
         { data: 'fc_membernorek3' },
         { data: 'fv_memberdescription' },
         { data: 'fc_memberpicpos' },
      ],
      rowCallback : function(row, data){
         var url_edit   = "/data-master/master-customer/detail/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_membercode;
         var url_delete = "/data-master/master-customer/delete/" + data.fc_divisioncode + '/' + data.fc_branch + '/' + data.fc_membercode;

         $('td:eq(47)', row).html(`
            <button class="btn btn-info btn-sm mr-1" onclick="edit('${url_edit}')"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-danger btn-sm" onclick="delete_action('${url_delete}','${data.fc_membername1}')"><i class="fa fa-trash"> </i> Hapus</button>
         `);
      }
   });

   function edit(url){
      edit_action(url, 'Edit Data Master Customer');
      $("#type").val('update');
      $('#fc_branch').attr("disabled", true);
   }
</script>
@endsection
