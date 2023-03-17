<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\DoMaster;
use App\Models\DoDetail;
use App\Models\InvDetail;
use App\Models\InvMaster;
use App\Models\TransaksiType;
use Validator;

class MasterInvoiceController extends Controller
{
    public function index(){
        $do_mst= DoMaster::with('somst.customer')->where('fc_branch', auth()->user()->fc_branch)->first();
        $inv_mst = InvMaster::where('fc_branch', auth()->user()->fc_branch)->get();

        $temp_so_pay = TransaksiType::where('fc_trx', "PAYMENTCODE")->get();

        // jika $inv_mst kosong arahkan kehalaman lain
        if(empty($inv_mst)){
            return view('apps.master-invoice.empty', [
                'kode_bayar' => $temp_so_pay,
                'inv_mst'  => $inv_mst,
                'do_mst' => $do_mst 
            ]);
        }else{
            return view('apps.master-invoice.index', [
                'kode_bayar' => $temp_so_pay,
                'inv_mst'  => $inv_mst,
                'do_mst' => $do_mst 
            ]);
            // dd($inv_mst);
        }
        

        
        // dd($inv_mst);
    }

    public function inv_do($fc_dono)
    {
        session(['fc_dono_global' => $fc_dono]);
        $data['do_mst']= DoMaster::with('somst')->where('fc_dono', $fc_dono)->first();
        $data['do_dtl']= DoDetail::with('invstore.stock')->where('fc_dono', $fc_dono)->get();
        // get data invmaster
        $data['inv_mst'] = InvMaster::with('domst')->where('fc_dono', $fc_dono)->first();
        $pdf = PDF::loadView('pdf.invoice-do', $data)->setPaper('a4');
        return $pdf->stream();
    }
    
    public function inv_ro($fc_rono){
        $decode_fc_rono = base64_decode($fc_rono);
        session(['fc_rono_global' => $decode_fc_rono]);
        // $data['ro_mst']= RoMaster::with('pomst.sales')->where('fc_rono', $fc_rono)->first();
        // $data['ro_dtl']= RoDetail::with('invstore.stock')->where('fc_rono', $fc_rono)->get();

        $data['ro_mst']= RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl']= RoDetail::with('invstore.stock')->where('fc_rono',  $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        // get data invmaster
        $data['inv_mst'] = InvMaster::with('romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $pdf = PDF::loadView('pdf.invoice-ro', $data)->setPaper('a4');
        return $pdf->stream();
    }
    
    public function add_invoice(){
        $data = RoMaster::with('pomst.supplier')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_incoming(){
        $data = InvMaster::with('domst')->where('fc_invtype', 'INC')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function datatables_outgoing(){
        $data = InvMaster::with('domst')->where('fc_invtype', 'OTG')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    // update_inv
    public function get_update_incoming(Request $request){
        // dd($request->fc_invno);
        $data = InvMaster::with('romst.pomst.supplier')->where('fc_invno', $request->fc_invno)
        ->where('fc_branch', auth()->user()->fc_branch)->first();

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil diupdate',
            'data' => $data
        ]);
        // dd($data);
    }

    public function update_invoice_incoming(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fc_invno_incoming' => 'required',
            'fd_inv_agingdate' => 'required',
            'fd_datepayment' => 'required',
            'fc_kode_incoming' => 'required',
            'fc_payername' => 'required',
            'fm_valuepayment' => 'required',
        ],[
            'fc_invno_incoming.required' => 'Nomor Invoice tidak boleh kosong',
            'fd_inv_agingdate.required' => 'Tanggal Berakhir tidak boleh kosong',
            'fd_datepayment.required' => 'Tanggal Pembayaran tidak boleh kosong',
            'fc_kode_incoming.required' => 'Kode Pembayaran tidak boleh kosong',
            'fc_payername.required' => 'Nama Pembayar tidak boleh kosong',
            'fm_valuepayment.required' => 'Nilai Pembayaran tidak boleh kosong',
        ]);

        // jika validator tidak terpenuhi
        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // insert data ke InvDetail
        $insert_inv_dtl = InvDetail::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_invno' => $request->fc_invno_incoming,
            'fc_paymentcode' => $request->fc_kode_incoming,
            'fc_payername' => $request->fc_payername,
            'fd_datepayment' => $request->fd_datepayment,
            'fm_valuepayment' => $request->fm_valuepayment,
            'fc_bankaccount' => $request->fc_bankaccount_incoming,
            // 'fc_keterangan' => $request->fc_keterangan,
        ]);


        // jika insert inv detail berhasil berikan respon 200
        if ($insert_inv_dtl) {
            return response()->json([
                'status' => 201,
                'message' => 'Update Invoice Berhasil',
                'link' => '/apps/master-invoice'
            ]);
        }

        // jika insert inv detail gagal berikan respon 300
        return response()->json([
            'status' => 300,
            'message' => 'Update Invoice Gagal',
        ]);


        // dd($request);
    }
    
}
