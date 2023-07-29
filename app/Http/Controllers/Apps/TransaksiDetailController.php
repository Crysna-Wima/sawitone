<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingMaster;
use App\Models\MappingDetail;
use Carbon\Carbon;
use DB;
use App\Models\NotificationDetail;
use App\Models\TempTrxAccountingMaster;
use App\Models\TempTrxAccountingDetail;
use Validator;
use Auth;
use App\Helpers\ApiFormatter;
use App\Models\InvoiceMst;
use App\Models\MappingUser;
use App\Models\MasterCoa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiDetailController extends Controller
{
    public function datatables_debit(){
        $data = TempTrxAccountingDetail::where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_kredit(){
        $data = TempTrxAccountingDetail::where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_coa($coacode)
    {
        $fc_coacode = base64_decode($coacode);

        $data = MappingDetail::with('mst_coa', 'grup')->where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_coacode' => $fc_coacode,
        ])
            ->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_coa()
    {
        $data = MappingDetail::with('mst_coa', 'grup')->where('fc_branch', auth()->user()->fc_branch)->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }
}
