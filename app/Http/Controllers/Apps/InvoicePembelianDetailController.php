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
use App\Models\InvoiceDtl;
use App\Models\InvoiceMst;
use App\Models\TempInvoiceDtl;
use App\Models\TempInvoiceMst;
use App\Models\TransaksiType;
use DB;
use Validator;

class InvoicePenjualanDetailController extends Controller
{
    public function create($fc_rono)
    {
        $encoded_fc_rono = base64_decode($fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $encoded_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock')->where('fc_rono', $encoded_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        // $data['ro_mst'] = RoMaster::with('pomst','rodtl','invmst')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        
        return view('apps.invoice-pembelian.create', $data);       
        // dd($data);
    }

    public function insert_item(Request $request){
        $fn_invrownum = 1;
        $tempInvDtl = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)
                    ->orderBy('fn_invrownum', 'DESC')        
                    ->first();

        $total = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)  
                ->count();

        // validator data yang dibutuhkan (mandatory) 
        if(!empty($request->fc_status)){
            $validator = Validator::make($request->all(), [
                'fc_detailitem' => 'required',
                'fc_unityname' => 'required',
                'fn_itemqty' => 'required',
                'fm_unityprice' => 'required',
                'fc_status' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'fc_detailitem' => 'required',
                'fn_itemqty' => 'required',
                'fm_unityprice' => 'required',
            ]);
        }  

        if($validator->fails()){
            return [
                'status' => 300,
                'total' => $total,
                'message' => $validator->errors()->first()
            ];
        }

        // Mencari apakah sudah pernah memasukkan CPRR yang sama 
        if(!empty($request->fc_status)){
            $item = TempInvoiceDtl::where([
                'fc_invno' => auth()->user()->fc_userid,
                'fc_detailitem' => $request->fc_detailitem
            ])->first();
        } else {
            $item = TempInvoiceDtl::where([
                'fc_invno' => auth()->user()->fc_userid,
                'fc_detailitem' => $request->fc_detailitem
            ])->first();
        }
        
        // Kondisi ketika ada CPRR yang sama 
        if(!empty($item)){
            return [
                'status' => 300,
                'total' => $total,
                'message' => 'Produk yang sama telah diinputkan'
            ];
        }

        if(!empty($tempInvDtl)){
            $fn_invrownum = $tempInvDtl->fn_invrownum + 1;
        }

        if(!empty($request->fc_status)){
            $request->merge(['fm_unityprice' => Convert::convert_to_double($request->fm_unityprice)]);
            
            $insert_invdtl = TempInvoiceDtl::create([
                'fn_invrownum' => $fn_invrownum, 
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_invno' => auth()->user()->fc_userid,
                'fc_status' => $request->fc_status,
                'fc_detailitem' => $request->fc_detailitem,
                'fc_unityname' => $request->fc_unityname,
                'fm_unityprice' => $request->fm_unityprice,
                'fc_invtype' => 'SALES',
                'fn_itemqty' =>  $request->fn_itemqty,
                'fv_description' => $request->fv_description,
            ]);
        } else {
            $request->merge(['fm_unityprice' => Convert::convert_to_double($request->fm_unityprice)]);

            $insert_invdtl = TempInvoiceDtl::create([
                'fn_invrownum' => $fn_invrownum, 
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_invno' => auth()->user()->fc_userid,
                'fc_detailitem' => $request->fc_detailitem,
                'fc_unityname' => "CPRR",
                'fm_unityprice' => $request->fm_unityprice,
                'fn_itemqty' =>  $request->fn_itemqty,
                'fv_description' => $request->fv_description
            ]);
        }

        if($insert_invdtl){
            return response()->json([
                'status' => 200,
                'total' => $total,
                'link' => '/apps/invoice-cprr',
                'message' => 'Data berhasil disimpan'
            ]);
        } else{
             return [
                 'status' => 300,
                 'link' => '/apps/invoice-cprr',
                 'message' => 'Error'
             ];
        }
    }

    public function datatables_ro_detail($fc_rono){
        // $decode_dono = base64_decode($fc_dono);
        $data = TempInvoiceDtl::with('invstore.stock','tempinvmst.domst')
        ->where('fc_invno',auth()->user()->fc_userid)
        ->where('fc_status','DEFAULT')
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
        // dd($data);
    }

    public function datatables_biaya_lain(){
        $data = TempInvoiceDtl::with('tempinvmst', 'nameunity')
        ->where('fc_invno', auth()->user()->fc_userid)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_status', 'ADDON')
        ->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function delete($fc_invno, $fn_invrownum){
        $count_invdtl = TempInvoiceDtl::where('fc_invno', $fc_invno)->count();

        $deleteInvDtl = TempInvoiceDtl::where([
            'fc_invno' => $fc_invno,
            'fn_invrownum' => $fn_invrownum,
        ])->delete();

        if($deleteInvDtl){
            if($count_invdtl < 2){
                return [
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                    'link' => '/apps/invoice-penjualan'
                ];
            }
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus',
            ]; 
        }

        return [
            'status' => 300,
            'message' => 'Error',
        ];
    }

    public function update_unityprice(Request $request){
        $validator = Validator::make($request->all(), [
            'fm_unityprice' => 'required',
            'fn_invrownum' => 'required',
        ]);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $update_unityprice = TempInvoiceDtl::where([
            'fn_invrownum' => $request->fn_invrownum,
        ])->update([
            'fm_unityprice' => Convert::convert_to_double($request->fm_unityprice)
        ]);

        if($update_unityprice){
            return [
                'status' => 200,
                'message' => 'Data berhasil diupdate'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Error'
        ];
    }

    public function cancel_invoice(){
        DB::beginTransaction();

		try{
            TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)->delete();
            TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)->delete();

			DB::commit();

			return [
				'status' => 201, // SUCCESS
                'link' => '/apps/invoice-pembelian',
				'message' => 'Data berhasil dihapus'
			];
		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }

    public function submit_invoice(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_invtype' => 'required',
        ]);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        $check_invdtl = TempInvoiceDtl::where('fc_status', 'DEFAULT')->where('fc_branch',auth()->user()->fc_branch)->count();
        if($check_invdtl < 1){
            return [
                'status' => 300,
                'message' => 'Barang terkirim kosong'
            ];
        }
        try {
            DB::beginTransaction();
            TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)
            ->where('fc_invtype', $request->fc_invtype)
            ->where('fc_branch', auth()->user()->fc_branch)
                ->update([
                    'fc_status' => 'R'
                    ]);
            DB::commit();

            return [
				'status' => 201, // SUCCESS
                'link' => '/apps/invoice-pembelian',
				'message' => 'Data berhasil dihapus'
			];
        }catch(\Exception $e){
            return [
                'status' => 300,
                'message' => $e->getMessage()
            ];
        }
        // dd($request);

    }
}
