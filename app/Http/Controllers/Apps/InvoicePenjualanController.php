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
use App\Models\InvDetail;
use App\Models\InvMaster;
use App\Models\TransaksiType;
use Validator;

class InvoicePenjualanController extends Controller
{
    public function index(){
        return view('apps.invoice-penjualan.index');     
    }

    public function detail($fc_dono){
        $decoded_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $decoded_fc_dono ]);
        $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $decoded_fc_dono )->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $decoded_fc_dono )->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_dono'] = $decoded_fc_dono;
        return view('apps.invoice-penjualan.detail', $data);
    }

    public function datatables_do_detail($fc_dono){
        $decode_dono = base64_decode($fc_dono);
        $data = DoDetail::with('invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->where('fc_dono', $decode_dono)->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
        // dd($fc_dono);
    }
}
