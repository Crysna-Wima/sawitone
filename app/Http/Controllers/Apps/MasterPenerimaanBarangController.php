<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use DB;
use PDF;

use App\Models\GoodReception;
use Yajra\DataTables\DataTables as DataTables;

class MasterPenerimaanBarangController extends Controller
{

    public function index()
    {
        return view('apps.master-penerimaan-barang.index');
    }

    public function datatables()
{
        $data = GoodReception::with('supplier')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    public function pdf(Request $request){
        // dd($request);
        $encode_fc_grno = base64_encode($request->fc_grno);
        $data['gr_mst']= GoodReception::where('fc_grno', $request->fc_grno)->where('fc_branch', auth()->user()->fc_branch)->first();
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }

        //redirect ke /apps/master-receiving-order/pdf dengan mengirimkan $data
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-penerimaan-barang/get_pdf/' . $encode_fc_grno . '/' . $data['nama_pj'],
        ];
        // dd($request);
    }

    public function get_pdf($fc_grno,$nama_pj){
        $decode_fc_grno = base64_decode($fc_grno);
        $data['gr_mst']= GoodReception::with('supplier')->where('fc_grno', $decode_fc_grno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['gr_dtl']= GoodReception::where('fc_grno', $decode_fc_grno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.penerimaan-barang', $data)->setPaper('a4');
        return $pdf->stream();
    }
}
