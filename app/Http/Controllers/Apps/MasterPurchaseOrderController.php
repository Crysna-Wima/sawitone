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
use App\Models\PoDetail;
use Yajra\DataTables\DataTables as DataTables;

class MasterPurchaseOrderController extends Controller
{

    public function index(){
        return view('apps.master-purchase-order.index');
    }

    public function detail($fc_pono){
        session(['fc_pono_global' => $fc_pono]);
        $data['data'] = PoMaster::with('supplier')->where('fc_pono', $fc_pono)->first();
        return view('apps.master-purchase-order.detail', $data);
        // dd($data);
    }
    
    public function datatables(){
        $data = PoMaster::with('supplier');

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function datatables_po_detail()
    {
        $data = PoDetail::where('fc_pono', session('fc_pono_global'))->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function datatables_ro()
    {
        $data = RoMaster::with('supplier')->where('fc_pono', session('fc_pono_global'))->first();
        // $data = PoDetail::where('fc_pono', session('fc_pono_global'))->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function pdf($fc_pono)
    {
        session(['fc_pono_global' => $fc_pono]);
        $data['po_mst']= PoMaster::with('supplier')->where('fc_pono', $fc_pono)->first();
        // $data['po_dtl']= PoDetail::where('fc_pono', $fc_pono)->get();
        $pdf = PDF::loadView('pdf.purchase-order', $data)->setPaper('a4');
        return $pdf->stream();
    }
}
