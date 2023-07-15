<?php

namespace App\Http\Controllers\Apps;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

use App\Models\DoMaster;
use App\Models\DoDetail;
use Carbon\Carbon;
use DateTime;
use DB;
use Validator;

class ReturBarangController extends Controller
{
    public function index(){
        return view('apps.retur-barang.index');     
    }

    public function detail($fc_dono){
        $decoded_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $decoded_fc_dono ]);
        $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $decoded_fc_dono )->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $decoded_fc_dono )->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_dono'] = $decoded_fc_dono;

        return view('apps.retur-barang.detail', $data);
    }

    // public function retur($fc_dono){
    //     $decoded_fc_dono = base64_decode($fc_dono);
    //     session(['fc_dono_global' => $decoded_fc_dono ]);
    //     $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $decoded_fc_dono )->where('fc_branch', auth()->user()->fc_branch)->first();
    //     $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $decoded_fc_dono )->where('fc_branch', auth()->user()->fc_branch)->get();
    //     $data['fc_dono'] = $decoded_fc_dono;

    //     return view('apps.retur-barang.retur', $data);
    //     // dd($data);
    // }
}
