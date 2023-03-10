<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use DataTables;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\PoMaster;

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