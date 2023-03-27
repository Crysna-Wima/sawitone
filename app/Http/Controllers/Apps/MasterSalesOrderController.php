<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use DataTables;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\SoMaster;
use App\Models\SoDetail;
use App\Models\DoDetail;
use App\Models\TempSoPay;

class MasterSalesOrderController extends Controller
{

    public function index(){
        return view('apps.master-sales-order.index');
    }

    public function detail($fc_sono){
        // kalau encode pakai base64_encode
        // kalau decode pakai base64_decode
        $encoded_fc_sono = base64_decode($fc_sono);
        session(['fc_sono_global' => $encoded_fc_sono]);
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $encoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.master-sales-order.detail', $data);
        // dd($data);
    }

    public function datatables_so_payment(){
        $data = TempSoPay::where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function datatables_so_detail()
    {
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack','somst')->where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables(){
        $data = SoMaster::with('domst','customer')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }
    
    public function pdf(Request $request){

        // $decoded_fc_dono = base64_decode($fc_dono);
        // $decoded_fc_sono = base64_decode($fc_sono);
        // session(['fc_sono_global' => $decoded_fc_sono]);
        $data['so_master'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $request->fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['so_detail'] = SoDetail::with('stock')->where('fc_sono', $request->fc_sono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['so_payment'] = TempSoPay::with('transaksitype')->where('fc_sono', $request->fc_sono)->where('fc_branch', auth()->user()->fc_branch)->get();

        $data['do_detail'] = DoDetail::with('invstore.stock')
                                        ->where('fc_dono', $request->fc_dono)
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->get();
        
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        // $pdf = PDF::loadView('pdf.download-pdf', $data)->setPaper('a4');
        // return $pdf->stream();
        // dd($request);
        $encode_fc_sono = base64_encode($request->fc_sono);
        $encode_fc_dono = base64_encode($request->fc_dono);
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-sales-order/get_pdf/' . $encode_fc_dono  . '/' . $encode_fc_sono . '/' . $data['nama_pj'],
        ];

    }

    public function get_pdf($fc_dono, $fc_sono, $name_pj){
        $decoded_fc_dono = base64_decode($fc_dono);
        $decoded_fc_sono = base64_decode($fc_sono);
        session(['fc_sono_global' => $decoded_fc_sono]);
        $data['so_master'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $decoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['so_detail'] = SoDetail::with('stock')->where('fc_sono', $decoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['so_payment'] = TempSoPay::with('transaksitype')->where('fc_sono', $decoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->get();

        $data['do_detail'] = DoDetail::with('invstore.stock')
                                        ->where('fc_dono', $decoded_fc_dono)
                                        ->where('fc_branch', auth()->user()->fc_branch)
                                        ->get();
        
        if($name_pj){
            $data['nama_pj'] = $name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        $pdf = PDF::loadView('pdf.download-pdf', $data)->setPaper('a4');
        return $pdf->stream();
    }
}
