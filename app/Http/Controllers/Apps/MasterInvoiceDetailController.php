<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\RoDetail;
use App\Models\RoMaster;

use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class MasterInvoiceDetailController extends Controller
{
    public function create($fc_rono)
    {
        $data['ro_mst'] = RoMaster::with('pomst.supplier.supplier_tax_code')->where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['tipe_cabang'] = RoMaster::with('pomst.supplier.supplier_typebranch')->where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['tipe_bisnis'] = RoMaster::with('pomst.supplier.supplier_type_business')->where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['legal_status'] = RoMaster::with('pomst.supplier.supplier_legal_status')->where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.master-invoice.create-index', $data);
        // dd($data);
    }

    public function datatables_ro()
    {

        $data = RoDetail::with('invstore.stock', 'romst')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
