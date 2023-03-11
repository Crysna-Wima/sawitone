<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;
use App\Models\PoDetail;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\PoMaster;
use App\Models\RoMaster;
use Yajra\DataTables\DataTables;

class ReceivingOrderController extends Controller
{
    public function index(){
        return view('apps.receiving-order.index');
    }

    public function detail($fc_pono){
        session(['fc_pono_global' => $fc_pono]);
        $data['data'] = PoMaster::with('supplier')->where('fc_pono', $fc_pono)->first();
        return view('apps.receiving-order.detail', $data);
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

    public function datatables_receiving_order(){
        
        $data = RoMaster::with('supplier')->where('fc_pono', session('fc_pono_global'))->get();
         
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function create(){
        // $data = PoMaster::with('supplier')->where('fc_pono', auth()->user()->fc_userid)->first();
        return view('apps.receiving-order.create');
        // $romst = RoMaster::where('fc_dono', auth()->user()->fc_userid)->first();
        // $data['romst'] = $romst;
        // dd($data);
    }

    public function datatables(){
        $data = PoMaster::with('supplier');

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }
}