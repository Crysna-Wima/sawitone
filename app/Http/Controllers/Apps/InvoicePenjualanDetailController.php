<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\SoMaster;
use App\Models\DoMaster;
use App\Models\DoDetail;
use App\Models\InvoiceDtl;
use App\Models\InvoiceMst;
use App\Models\TempInvoiceDtl;
use App\Models\TransaksiType;
use Validator;

class InvoicePenjualanDetailController extends Controller
{
    public function create($fc_dono)
    {
        $encoded_fc_dono = base64_decode($fc_dono);
        $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        // $data['ro_mst'] = RoMaster::with('pomst','rodtl','invmst')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();

        return view('apps.invoice-penjualan.create', $data);       
        // dd($data);
    }

    public function datatables_do_detail($fc_dono){
        $decode_dono = base64_decode($fc_dono);
        $data = DoDetail::with('invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->where('fc_dono', $decode_dono)->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
        // dd($fc_dono);
    }

    public function datatables_biaya_lain(){
        $data = TempInvoiceDtl::with('tempinvmst', 'nameunity')->where('fc_invno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }
}
