<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use DB;
use Yajra\DataTables\DataTables;

class PenerimaanBarangController extends Controller
{
    public function index(){
        return view('apps.penerimaan-barang.index');
    }

    public function get_data_supplier_pb_datatables($fc_branch){
        $data = Supplier::with('branch','supplier_legal_status','supplier_nationality','supplier_type_business','supplier_tax_code','supplier_bank1','supplier_bank2','supplier_bank2','supplier_bank3','supplier_typebranch')->where('fc_branch', $fc_branch)->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }
}
