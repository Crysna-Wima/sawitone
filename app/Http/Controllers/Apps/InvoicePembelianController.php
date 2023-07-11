<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\DoDetail;
use App\Models\DoMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\InvDetail;
use App\Models\InvMaster;
use App\Models\InvoiceMst;
use App\Models\TempInvoiceDtl;
use App\Models\TempInvoiceMst;
use App\Models\TransaksiType;
use Carbon\Carbon;
use Validator;

class InvoicePembelianController extends Controller
{
    public function index(){
        $temp_inv_master = TempInvoiceMst::with('customer')->where('fc_invno', auth()->user()->fc_userid)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->first();
        $temp_detail = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)->get();
        $total = count($temp_detail);
        if(!empty($temp_inv_master)){
            $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['ro_dtl'] = RoDetail::with('invstore.stock')->where('fc_rono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->get();
            return view('apps.invoice-pembelian.create',$data);
            // dd($data);
        }
        return view('apps.invoice-pembelian.index');     
    }

    public function detail($fc_rono)
    {
        $decode_fc_rono = base64_decode($fc_rono);
        session(['fc_rono_global' => $decode_fc_rono]);
        $data['ro_mst'] = RoMaster::with('pomst.supplier', 'warehouse')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_rono'] = $decode_fc_rono;

        $temp_inv_master = TempInvoiceMst::with('supplier')->where([
            'fc_invno' =>  auth()->user()->fc_userid,
            'fc_branch' =>  auth()->user()->fc_branch,
            'fc_invtype' => "PURCHASE"
        ])->first();
        if(!empty($temp_inv_master)){
            $data['ro_mst'] = RoMaster::with('pomst.supplier')->where('fc_rono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->first();
            $data['ro_dtl'] = RoDetail::with('invstore.stock')->where('fc_rono', $temp_inv_master->fc_child_suppdocno)->where('fc_branch', auth()->user()->fc_branch)->get();
            return view('apps.invoice-pembelian.create',$data);
            // dd($temp_inv_master->fc_child_suppdocno);
        }
        $data['ro_mst'] = DoMaster::with('pomst.supplier')->where('fc_rono', $decode_fc_rono )->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = DoDetail::with('invstore.stock')->where('fc_rono', $decode_fc_rono )->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_rono'] = $decode_fc_rono;
        
        return view('apps.invoice-pembelian.detail', $data);
    }

    public function datatables()
    {
        $data = RoMaster::with('pomst.supplier')->where('fc_rostatus', 'R')->where('fc_branch', auth()->user()->fc_branch)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_ro_detail()
    {
        $data = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', session('fc_rono_global'))->where('fc_branch', auth()->user()->fc_branch)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function create_invoice(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fc_suppdocno' => 'required',
            'fc_entitycode' => 'required'
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        
        $temp_inv_master = TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)->where('fc_invtype', 'PURCHASE')->where('fc_branch', auth()->user()->fc_branch)->first();

        if(empty($temp_inv_master)){
             // create TempInvoiceMst
         $create = TempInvoiceMst::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_invno' => auth()->user()->fc_userid,
            'fc_suppdocno' => $request->fc_suppdocno,
            'fc_child_suppdocno' => $request->fc_child_suppdocno,
            'fc_entitycode' => $request->fc_entitycode,
            'fc_status' => 'I',
            'fc_invtype' => 'PURCHASE',
            'fd_inv_releasedate' => date('Y-m-d H:i:s', strtotime($request->fd_inv_releasedate)),
            'fn_inv_agingday' => $request->fn_inv_agingday,
            'fd_inv_agingdate' => date('Y-m-d H:i:s', strtotime($request->fd_inv_agingdate)),
            'fc_userid' => auth()->user()->fc_userid,
            'fn_invdetail' => $request->fn_dodetail
         ]);

            if($create){
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/invoice-pembelian/create/' . base64_encode( $request->fc_child_suppdocno)
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        }else{
            return [
                'status' => 300,
                'message' => 'Data sudah ada'
            ];
        }
       
    }
}
