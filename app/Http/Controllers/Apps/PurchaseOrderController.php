<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;
use App\Models\Supplier;
use App\Models\TempPoDetail;
use App\Models\TempPoMaster;
use DataTables;
use Carbon\Carbon;
use File;
use DB;

class PurchaseOrderController extends Controller
{
    public function index(){
        $temp_po_master = TempPoMaster::with('branch','supplier.supplier_tax_code', 'supplier.supplier_type_business', 'supplier.supplier_typebranch', 'supplier.supplier_legal_status')->where('fc_pono',auth()->user()->fc_userid)->first();
        $temp_po_detail = TempPoDetail::where('fc_pono',auth()->user()->fc_userid)->get();
        $total = count($temp_po_detail);
        if(!empty($temp_po_master)){
            $data['data'] = $temp_po_master;
            $data['total'] = $total;
            // return view('apps.purchase-order.detail',$data);
            return view('apps.purchase-order.index');
            // dd($data);
        }
        // dd($temp_po_detail);
        return view('apps.purchase-order.index');
    }

    public function get_data_supplier_po_datatables($fc_branch){
        $data = Supplier::with('branch','supplier_legal_status','supplier_nationality','supplier_type_business','supplier_tax_code','supplier_bank1','supplier_bank2','supplier_bank2','supplier_bank3','supplier_typebranch')->where('fc_branch', $fc_branch)->get();
        dd($data);
    }
}

