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
use App\Models\InvMaster;
use App\Models\TransaksiType;

class MasterInvoiceController extends Controller
{
    public function index(){
        $do_mst= DoMaster::with('somst.customer')->first();
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
    
    public function inv_ro($fc_rono)
    {
        session(['fc_rono_global' => $fc_rono]);
        $data['ro_mst']= RoMaster::with('pomst.sales')->where('fc_rono', $fc_rono)->first();
        $data['ro_dtl']= RoDetail::with('invstore.stock')->where('fc_rono', $fc_rono)->get();
        // get data invmaster
        $data['inv_mst'] = InvMaster::with('romst')->where('fc_rono', $fc_rono)->first();
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
        $data = InvMaster::with('domst')->where('fc_invtype', 'INC')->get();

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
    
}
