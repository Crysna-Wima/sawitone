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

use App\Models\PoMaster;
use Yajra\DataTables\DataTables as DataTables;

class MasterPurchaseOrderController extends Controller
{

    public function index(){
        return view('apps.master-purchase-order.index');
    }
    
    public function datatables(){
        $data = PoMaster::all();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }
    // public function pdf($fc_dono)
    // {
        // session(['fc_dono_global' => $fc_dono]);
        // $data['do_mst']= DoMaster::with('somst')->where('fc_dono', $fc_dono)->first();
        // $data['do_dtl']= DoDetail::with('invstore.stock')->where('fc_dono', $fc_dono)->get();
        // $pdf = PDF::loadView('pdf.report-do', $data)->setPaper('a4');
        // return $pdf->stream();
    // }
}
