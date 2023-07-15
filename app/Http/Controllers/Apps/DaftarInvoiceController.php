<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoDetail;
use App\Models\DoDetail;
use App\Models\InvoiceDtl;
use App\Models\InvoiceMst;
use App\Models\TransaksiType;
use Validator;

class DaftarInvoiceController extends Controller
{
    public function index(){
        return view('apps.daftar-invoice.index');     
    }

    public function detail($fc_invno, $fc_invtype)
    {
        $decode_fc_invno = base64_decode($fc_invno);
        session(['fc_invno_global' => $decode_fc_invno]);
        if($fc_invtype == "SALES") {
            $data['inv_mst'] = InvoiceMst::with('domst', 'somst', 'customer')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'SALES')->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'SALES')->where('fc_branch', auth()->user()->fc_branch)->get();
        } else if ($fc_invtype == "PURCHASE"){
            $data['inv_mst'] = InvoiceMst::with('pomst', 'romst', 'supplier')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->get();
        } else {
            $data['inv_mst'] = InvoiceMst::with('domst', 'somst', 'customer')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'CPRR')->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity', 'cospertes')->where('fc_invno', $decode_fc_invno)->where('fc_invtype', 'CPRR')->where('fc_branch', auth()->user()->fc_branch)->get();
        }
        $data['fc_invno'] = $decode_fc_invno;
        return view('apps.daftar-invoice.detail', $data);
        // dd($data);
    }

    public function datatables($fc_invtype){
        
        $data = InvoiceMst::with('domst','pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_branch', auth()->user()->fc_branch)->where('fc_invtype', $fc_invtype)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_inv_detail($fc_invno){
        $decode_fc_invno = base64_decode($fc_invno);
        $data = InvoiceDtl::with('invmst', 'cospertes', 'nameunity')
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_invno', $decode_fc_invno)
        ->where('fc_status', 'ADDON')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_do_detail($fc_invno){
        $decode_fc_invno = base64_decode($fc_invno);
        $data = InvoiceDtl::with('invstore.stock', 'invmst')
        ->where('fc_invno', $decode_fc_invno)
        ->where('fc_status','DEFAULT')
        ->where('fc_invtype' , "SALES")
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
        // dd($fc_dono);
    }

    public function datatables_ro_detail($fc_invno){
        $decode_fc_invno = base64_decode($fc_invno);
        $data = InvoiceDtl::with('invstore.stock', 'invmst')
        ->where('fc_invno', $decode_fc_invno)
        ->where('fc_status','DEFAULT')
        ->where('fc_invtype' , "PURCHASE")
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function datatables_cprr($fc_invno){
        $decode_fc_invno = base64_decode($fc_invno);
        $data = InvoiceDtl::with('invstore.stock', 'invmst', 'nameunity', 'cospertes')
        ->where('fc_invno', $decode_fc_invno)
        ->where('fc_status','DEFAULT')
        ->where('fc_invtype' , "CPRR")
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();
        
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function pdf(Request $request){
        // dd($request);
        $encode_fc_invno = base64_encode($request->fc_invno);
        $data['inv_mst'] = InvoiceMst::with('domst','pomst', 'somst', 'romst', 'supplier', 'customer', 'bank')->where('fc_invno', $request->fc_invno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['inv_dtl'] = InvoiceDtl::with('invmst', 'nameunity', 'cospertes')->where('fc_invno', $request->fc_invno)->where('fc_branch', auth()->user()->fc_branch)->get();
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/daftar-invoice/get_pdf/' . $encode_fc_invno . '/' . $data['nama_pj'],
        ];
    }

    public function get_pdf($fc_invno, $nama_pj){
        $decode_fc_invno = base64_decode($fc_invno);
        $data['inv_mst'] = InvoiceMst::with('domst','pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_invno', $decode_fc_invno)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['inv_dtl'] = InvoiceDtl::with('invstore.stock', 'invmst', 'nameunity', 'cospertes')->where('fc_invno', $decode_fc_invno)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.invoice', $data)->setPaper('a4');
        return $pdf->stream();
    }

}
