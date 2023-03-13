<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\RoMaster;
use App\Models\RoDetail;
use Yajra\DataTables\DataTables as DataTables;

class MasterReceivingOrderController extends Controller
{

    public function index()
    {
        return view('apps.master-receiving-order.index');
    }

    public function datatables()
    {

        $data = RoMaster::with('pomst.supplier')->where('fc_pono', session('fc_pono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf($fc_rono)
    {
        session(['fc_pono_global' => $fc_rono]);
        $data['ro_mst'] = RoMaster::with('supplier')->where('fc_rono', $fc_rono)->first();
        $data['ro_dtl'] = RoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_rono', $fc_rono)->get();
        $pdf = PDF::loadView('pdf.receiving-order', $data)->setPaper('a4');
        return $pdf->stream();
    }
}
