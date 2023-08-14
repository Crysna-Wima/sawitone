<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Yajra\DataTables\DataTables as DataTables;
use File;
use DB;

use App\Models\Approvement;

class ApprovementController extends Controller
{

    public function index(){
        return view('apps.approvement.index');
    }

    public function datatables(){
        $data = Approvement::with('branch')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_applicant(){
        $data = Approvement::with('branch')
        ->where('fc_applicantid', auth()->user()->fc_userid)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function cancel(Request $request){
        $fc_approvalno = $request->fc_approvalno;

        // update
        $data = Approvement::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_approvalstatus' => 'C',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil dicancel',
                'link' => '/apps/approvement'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Approval gagal dicancel'
        ];
    }

    public function reject(Request $request){
        $fc_approvalno = $request->fc_approvalno;

        // update
        $data = Approvement::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_approvalstatus' => 'R',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil direject',
                'link' => '/apps/approvement'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Approval gagal direject'
        ];
    }

    public function accept(Request $request){
        $fc_approvalno = $request->fc_approvalno;

        // update
        $data = Approvement::where('fc_approvalno', $fc_approvalno)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $data->update([
            'fc_approvalstatus' => 'A',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Approval berhasil direject',
                'link' => '/apps/approvement'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Approval gagal direject'
        ];
    }
}
