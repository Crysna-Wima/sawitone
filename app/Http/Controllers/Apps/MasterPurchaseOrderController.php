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
use App\Models\RoMaster;
use Yajra\DataTables\DataTables as DataTables;

class MasterPurchaseOrderController extends Controller
{

    public function index()
    {
        return view('apps.master-purchase-order.index');
    }

    public function detail($fc_pono)
    {
        session(['fc_pono_global' => $fc_pono]);
        $data['po_master'] = PoMaster::with('supplier')->where('fc_pono', $fc_pono)->first();
        $data['po_detail'] = PoDetail::where('fc_pono', $fc_pono)->get();

        return view('apps.master-purchase-order.detail', $data);
        // dd($data);
    }

    public function datatables()
    {
        $data = PoMaster::with('supplier')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }


    public function datatables_po_detail(){

        //  jika session fc_sono_global tidak sama dengan null
        if (session('fc_pono_global') != null) {
            $fc_pono = session('fc_pono_global');
        } else {
            $pomst = PoMaster::where('fc_userid', auth()->user()->fc_userid)->first();
            $fc_pono_pomst = $pomst->fc_pono;
            $fc_pono = $fc_pono_pomst;
        }

        $data = PoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_pono', $fc_pono)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_receiving_order()
    {

        $data = RoMaster::with('supplier')->where('fc_pono', session('fc_pono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf($fc_pono)
    {
        session(['fc_pono_global' => $fc_pono]);
        $data['po_mst'] = PoMaster::with('supplier')->where('fc_pono', $fc_pono)->first();
        $data['po_dtl'] = PoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_pono', $fc_pono)->get();
        $pdf = PDF::loadView('pdf.purchase-order', $data)->setPaper('a4');
        return $pdf->stream();
    }
}
