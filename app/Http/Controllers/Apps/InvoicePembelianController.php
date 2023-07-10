<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\DoDetail;
use App\Models\DoMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\InvDetail;
use App\Models\InvMaster;
use App\Models\InvoiceMst;
use App\Models\TempInvoiceDtl;
use App\Models\TempInvoiceMst;
use App\Models\TransaksiType;
use Carbon\Carbon;
use Validator;

class InvoicePembelianController extends Controller
{
    public function index(){
        $temp_inv_master = TempInvoiceMst::with('customer')->where('fc_invno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();
        $temp_detail = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)->get();
        $total = count($temp_detail);
        if(!empty($temp_inv_master)){
            $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['ro_dtl'] = RoDetail::with('invstore.stock')->where('fc_rono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->get();
            // return view('apps.invoice-pembelian.create',$data);
            dd($data);
        }
        return view('apps.invoice-pembelian.index');     
    }

    public function detail($fc_rono)
    {
        $decode_fc_rono = base64_decode($fc_rono);
        session(['fc_rono_global' => $decode_fc_rono]);
        $data['ro_mst'] = RoMaster::with('pomst.supplier', 'warehouse')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_rono'] = $decode_fc_rono;
        return view('apps.invoice-pembelian.detail', $data);
        // dd($data);
    }

    public function datatables()
    {
        $data = RoMaster::with('pomst.supplier')->where('fc_rostatus', 'R')->where('fc_branch', auth()->user()->fc_branch)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_ro_detail()
    {
        $data = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', session('fc_rono_global'))->where('fc_branch', auth()->user()->fc_branch)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
