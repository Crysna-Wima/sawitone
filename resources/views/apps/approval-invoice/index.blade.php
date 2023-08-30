@extends('partial.app')
@section('title', 'Approval Invoice')
@section('css')
<style>
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
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Request Approval Invoice</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if (auth()->user()->fc_groupuser == 'IN_MNGACT' && auth()->user()->fl_level == 3)
                        <table class="table table-striped" id="tb_accessor" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center text-nowrap">No. Approval</th>
                                    <th scope="col" class="text-center">Pemohon</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Penggunaan</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                        @else
                        <table class="table table-striped" id="tb_applicant" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center text-nowrap">No. Approval</th>
                                    <th scope="col" class="text-center">Tanggal</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Penggunaan</th>
                                    <th scope="col" class="text-center">Keterangan</th>
                                    <th scope="col" class="text-center" style="width: 20%">Actions</th>
                                </tr>
                            </thead>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" role="dialog" id="modal_cancel" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Cancel Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit" action="/apps/approvement/cancel-approval" method="PUT" autocomplete="off">
                <input type="text" class="form-control" name="fc_branch" id="fc_branch" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8">
                            <div class="form-group">
                                <label>No. Approval</label>
                                <input name="fc_approvalno_cancel" id="fc_approvalno_cancel" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Pemohon</label>
                                <input name="fc_applicantid" id="fc_applicantid" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Alasan</label>
                                <input name="fv_description" id="fv_description" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_detail" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Detail Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="form-group">
                            <label>No. Approval</label>
                            <input name="fc_approvalno_detail" id="fc_approvalno_detail" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>Pemohon</label>
                            <input name="fc_applicantid_detail" id="fc_applicantid_detail" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Alasan</label>
                            <input name="fv_description_detail" id="fv_description_detail" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_reject" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Reject Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_reject" action="/apps/approvement/reject" method="POST" autocomplete="off">
                <input type="text" class="form-control" name="fc_branch" id="fc_branch" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8">
                            <div class="form-group">
                                <label>No. Approval</label>
                                <input name="fc_approvalno_reject" id="fc_approvalno_reject" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Pemohon</label>
                                <input name="fc_applicantid_reject" id="fc_applicantid_reject" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Keterangan</label>
                                <input name="fd_accessorrespon_reject" id="fd_accessorrespon_reject" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_accept" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Accept Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_submit_accept" action="/apps/approvement/accept" method="POST" autocomplete="off">
                <input type="text" class="form-control" name="fc_branch" id="fc_branch" value="{{ auth()->user()->fc_branch}}" readonly hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-8">
                            <div class="form-group">
                                <label>No. Approval</label>
                                <input name="fc_approvalno_accept" id="fc_approvalno_accept" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="form-group">
                                <label>Pemohon</label>
                                <input name="fc_applicantid_accept" id="fc_applicantid_accept" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-12">
                            <div class="form-group required">
                                <label>Keterangan</label>
                                <input name="fd_accessorrespon_accept" id="fd_accessorrespon_accept" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" role="dialog" id="modal_approvdetail" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header br">
                <h5 class="modal-title">Detail Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-8">
                        <div class="form-group">
                            <label>No. Approval</label>
                            <input name="fc_approvalno" id="fc_approvalno_dtl" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="form-group">
                            <label>Pemberi Akses</label>
                            <input name="fc_accessorid" id="fc_accessorid_dtl" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Tanggal Approval</label>
                            <div class="input-group date">
                                <input name="fd_approvaldate" id="fd_approvaldate_dtl" class="form-control" readonly>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-group">
                            <label>Catatan</label>
                            <input name="fd_accessorrespon" id="fd_accessorrespon_dtl" class="form-control" readonly>
                        </div>
                    </div>
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
    $('.modal').css('overflow-y', 'auto');
</script>

@endsection