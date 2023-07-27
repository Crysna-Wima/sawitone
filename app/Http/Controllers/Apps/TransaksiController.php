<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingMaster;
use Carbon\Carbon;
use DB;
use App\Models\NotificationDetail;
use App\Models\TrxAccountingMaster;
use App\Models\TrxAccountingDetail;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{

    public function index()
    {
        return view('apps.transaksi.index');
    }

    public function create()
    {
        $trxaccounting_mst = TrxAccountingMaster::with('transaksitype', 'mapping')->where('fc_trxno', auth()->user()->fc_userid)->first();
        $trxaccounting_dtl = TrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->get();

        $total = count($trxaccounting_dtl);
        if (!empty($trxaccounting_mst)) {
            $data['data'] = $trxaccounting_mst;
            $data['total'] = $total;

            return view('apps.transaksi.create-detail', $data);
        }
        return view('apps.transaksi.create-index');
    }
    
    public function select_mapping($fc_mappingcode)
    {
        $fc_mappingcode = base64_decode($fc_mappingcode);
        $data = MappingMaster::where('fc_branch', auth()->user()->fc_branch)->where('fc_mappingcode', $fc_mappingcode)->first();
        // retur json
        return response()->json(
            [
                'data' => $data,
                'status' => 'success'
            ]
        );
    }

    public function datatables(){
        $data = TrxAccountingMaster::with('transaksitype', 'mapping')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }
}
