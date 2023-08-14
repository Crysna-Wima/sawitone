@extends('partial.app')
@section('title', 'Approvement Edit Journal')
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
                    <h4>Data Request Edit Journal</h4>
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
@endsection

@section('js')
<script>
    var tb_applicant = $('#tb_applicant').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/approvement/datatables-applicant",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5]
        }, {
            className: 'text-nowrap',
            targets: []
        }],
        columns: [{
                data: 'fc_approvalno'
            },
            {
                data: 'fd_userinput',
                render: formatTimestamp
            },
            {
                data: 'fc_approvalstatus'
            },
            {
                data: 'fc_approvalused'
            },
            {
                data: 'fc_annotation'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_approvalno = window.btoa(data.fc_approvalno);

            if (data['fc_approvalstatus'] == 'W') {
                $('td:eq(2)', row).html('<span class="badge badge-primary">Menunggu</span>');
            } else if (data['fc_approvalstatus'] == 'R') {
                $('td:eq(2)', row).html('<span class="badge badge-danger">Ditolak</span>');
            } else if (data['fc_approvalstatus'] == 'C') {
                $('td:eq(2)', row).html('<span class="badge badge-danger">Cancel</span>');
            } else {
                $('td:eq(2)', row).html('<span class="badge badge-success">Diterima</span>');
            }

            if (data['fc_approvalused'] == 'F') {
                $('td:eq(3)', row).html('<span class="badge badge-danger">Belum Digunakan</span>');
            } else {
                $('td:eq(3)', row).html('<span class="badge badge-success">Telah Digunakan</span>');
            }

            if (data['fc_approvalstatus'] == 'W') {
                $('td:eq(5)', row).html(`
                    <button class="btn btn-danger btn-sm" onclick="cancel('${data.fc_approvalno}')"><i class="fas fa-ban"></i> Cancel</button>
                `);
            } else {
                $('td:eq(5)', row).html(`
                    <button class="btn btn-primary btn-sm" onclick="detail('${data.fc_approvalno}')"><i class="fas fa-eye"></i> Detail</button>
                `);
            }
        },
    });

    var tb_accessor = $('#tb_accessor').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        pageLength: 5,
        ajax: {
            url: "/apps/approvement/datatables",
            type: 'GET',
        },
        columnDefs: [{
            className: 'text-center',
            targets: [0, 1, 2, 3, 4, 5]
        }, {
            className: 'text-nowrap',
            targets: [6]
        }],
        columns: [{
                data: 'fc_approvalno'
            },
            {
                data: 'fc_applicantid'
            },
            {
                data: 'fd_userinput',
                render: formatTimestamp
            },
            {
                data: 'fc_approvalstatus'
            },
            {
                data: 'fc_approvalused'
            },
            {
                data: 'fc_annotation'
            },
            {
                data: null,
            },
        ],

        rowCallback: function(row, data) {
            var fc_approvalno = window.btoa(data.fc_approvalno);

            if (data['fc_approvalstatus'] == 'W') {
                $('td:eq(3)', row).html('<span class="badge badge-primary">Menunggu</span>');
            } else if (data['fc_approvalstatus'] == 'R') {
                $('td:eq(3)', row).html('<span class="badge badge-danger">Ditolak</span>');
            } else if (data['fc_approvalstatus'] == 'C') {
                $('td:eq(3)', row).html('<span class="badge badge-danger">Cancel</span>');
            } else {
                $('td:eq(3)', row).html('<span class="badge badge-success">Diterima</span>');
            }

            if (data['fc_approvalused'] == 'F') {
                $('td:eq(4)', row).html('<span class="badge badge-danger">Belum Digunakan</span>');
            } else {
                $('td:eq(4)', row).html('<span class="badge badge-success">Telah Digunakan</span>');
            }

            $('td:eq(6)', row).html(`
                    <button class="btn btn-danger btn-sm mr-1" onclick="reject('${data.fc_approvalno}')"><i class="fas fa-x mr-1"></i> Reject</button>
                    <button class="btn btn-success btn-sm" onclick="accept('${data.fc_approvalno}')"><i class="fas fa-check mr-1"></i> Accept</button>
                `);
        },
    });

    function cancel(fc_approvalno) {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin cancel Approval ini?",
            type: "warning",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/approvement/cancel',
                    type: 'PUT',
                    data: {
                        fc_approvalstatus: 'C',
                        fc_approvalno: fc_approvalno
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        if (response.status == 201) {
                            swal(response.message, {
                                icon: 'success',
                            });
                            $("#modal").modal('hide');
                            tb_accessor.ajax.reload();
                            tb_applicant.ajax.reload();
                        } else {
                            swal(response.message, {
                                icon: 'error',
                            });
                            $("#modal").modal('hide');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                            .responseText + ")", {
                                icon: 'error',
                            });
                    }
                });
            }
        });
    }

    function reject(fc_approvalno) {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin reject Approval ini?",
            type: "warning",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/approvement/reject',
                    type: 'PUT',
                    data: {
                        fc_approvalstatus: 'R',
                        fc_approvalno: fc_approvalno
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        if (response.status == 201) {
                            swal(response.message, {
                                icon: 'success',
                            });
                            $("#modal").modal('hide');
                            tb_accessor.ajax.reload();
                            tb_applicant.ajax.reload();
                        } else {
                            swal(response.message, {
                                icon: 'error',
                            });
                            $("#modal").modal('hide');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                            .responseText + ")", {
                                icon: 'error',
                            });
                    }
                });
            }
        });
    }

    function accept(fc_approvalno) {
        swal({
            title: "Konfirmasi",
            text: "Anda yakin ingin accept Approval ini?",
            type: "warning",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((save) => {
            if (save) {
                $("#modal_loading").modal('show');
                $.ajax({
                    url: '/apps/approvement/accept',
                    type: 'PUT',
                    data: {
                        fc_approvalstatus: 'A',
                        fc_approvalno: fc_approvalno
                    },
                    success: function(response) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        if (response.status == 201) {
                            swal(response.message, {
                                icon: 'success',
                            });
                            $("#modal").modal('hide');
                            tb_accessor.ajax.reload();
                            tb_applicant.ajax.reload();
                        } else {
                            swal(response.message, {
                                icon: 'error',
                            });
                            $("#modal").modal('hide');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);
                        swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                            .responseText + ")", {
                                icon: 'error',
                            });
                    }
                });
            }
        });
    }

    $('.modal').css('overflow-y', 'auto');
</script>

@endsection