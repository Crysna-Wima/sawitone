<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Yajra\DataTables\DataTables as DataTables;

use Carbon\Carbon;
use DB;

class MutasiBarangController extends Controller
{
    public function index()
    {
        // $temp_po_master = TempPoMaster::with('branch','supplier.supplier_tax_code', 'supplier.supplier_type_business', 'supplier.supplier_typebranch', 'supplier.supplier_legal_status')->where('fc_pono',auth()->user()->fc_userid)->first();
        // $temp_po_detail = TempPoDetail::where('fc_pono',auth()->user()->fc_userid)->get();
        // $total = count($temp_po_detail);
        // if(!empty($temp_po_master)){
        //     $data['data'] = $temp_po_master;
        //     $data['total'] = $total;
        //     // return view('apps.purchase-order.detail',$data);
        //     return view('apps.purchase-order.detail',$data);
        //     // dd($data);
        // }
        // dd($temp_po_detail);
        return view('apps.mutasi-barang.index');
    }

    public function datatables_lokasi_awal(){
        $data = Warehouse::with('branch')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function datatables_lokasi_tujuan(){
        $data = Warehouse::with('branch')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }
}
