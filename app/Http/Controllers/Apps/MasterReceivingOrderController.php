<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\RoMaster;
use App\Models\RoDetail;
use Yajra\DataTables\DataTables as DataTables;

class MasterReceivingOrderController extends Controller
{

    public function index()
    {
        return view('apps.master-receiving-order.index');
    }

    public function datatables()
    {

        $data = RoMaster::with('pomst.supplier')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf(Request $request){
        // dd($request);
        $decode_fc_rono = base64_encode($request->fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        // $pdf = PDF::loadView('pdf.purchase-order', $data)->setPaper('a4');
        // return $pdf->stream();
        // dd($data);

        //redirect ke /apps/master-receiving-order/pdf dengan mengirimkan $data
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-receiving-order/get_pdf/' . $decode_fc_rono . '/' . $data['nama_pj'],
        ];
    }

    public function get_pdf($fc_rono,$nama_pj){
        $decode_fc_rono = base64_decode($fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.receiving-order', $data)->setPaper('a4');
        return $pdf->stream();
    }
}
