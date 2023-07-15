<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\DoMaster;
use App\Models\DoDetail;
use App\Models\TempInvoiceDtl;
use App\Models\TempInvoiceMst;
use DB;
use Validator;

class ReturBarangDetailController extends Controller
{
    public function create($fc_dono)
    {
        $encoded_fc_dono = base64_decode($fc_dono);
        $data['temp'] = TempInvoiceMst::with('domst', 'somst', 'bank')->where('fc_invno',auth()->user()->fc_userid)->first();
        $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        // $data['ro_mst'] = RoMaster::with('pomst','rodtl','invmst')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();

        return view('apps.retur-barang.create', $data);
        // dd($data);
    }

    public function datatables_do_detail($fc_dono)
    {
        // $decode_dono = base64_decode($fc_dono);
        $data = TempInvoiceDtl::with('invstore.stock', 'tempinvmst')
            ->where([
                'fc_invno' =>  auth()->user()->fc_userid,
                'fc_invtype' => "SALES",
                'fc_status' => "DEFAULT",
                'fc_branch' =>  auth()->user()->fc_branch,
            ])
            ->get();


        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }
}
