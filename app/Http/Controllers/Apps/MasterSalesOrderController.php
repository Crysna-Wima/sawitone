<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use DataTables;
use Carbon\Carbon;
use File;
use DB;

use App\Models\SoMaster;
use App\Models\SoDetail;
use App\Models\TempSoPay;

class MasterSalesOrderController extends Controller
{

    public function index(){
        return view('apps.master-sales-order.index');
    }

    public function detail($fc_sono){
        session(['fc_sono_global' => $fc_sono]);
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $fc_sono)->first();
        return view('apps.master-sales-order.detail', $data);
    }

    public function datatables_so_payment(){
        $data = TempSoPay::where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function datatables_so_detail()
    {
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack','somst')->where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables(){
        $data = SoMaster::all();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }
}
