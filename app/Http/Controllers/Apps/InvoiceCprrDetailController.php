<?php

namespace App\Http\Controllers\apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\TempInvoiceDtl;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class InvoiceCprrDetailController extends Controller
{
    public function index($fc_status){
        $typeInvDtl = base64_decode($fc_status);
        $invoiceCprrDtl = TempInvoiceDtl::with('tempinvmst','cospertes','nameunity')->where('fc_invno', auth()->user()->fc_userid)->where('fc_status',$typeInvDtl)->get();
        
        return DataTables::of($invoiceCprrDtl)->addIndexColumn()->make(true);
    }

    public function create(request $request){
        $fn_invrownum = 1;
        $tempInvDtl = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)
                    ->orderBy('fn_invrownum', 'DESC')        
                    ->first();

        $total = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)  
                ->count();

        // validator data yang dibutuhkan (mandatory) 
        if(!empty($request->fc_status)){
            $validator = Validator::make($request->all(), [
                'fc_detailitem2' => 'required',
                'fc_unityname2' => 'required',
                'fn_itemqty2' => 'required',
                'fm_unityprice2' => 'required',
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
                'fc_detailitem' => $request->fc_detailitem2
            ])->first();
        } else {
            $item = TempInvoiceDtl::where([
                'fc_invno' => auth()->user()->fc_userid,
                'fc_detailitem' => $request->fc_detailitem2
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
            $request->merge(['fm_unityprice2' => Convert::convert_to_double($request->fm_unityprice2)]);
            
            $insert_invdtl = TempInvoiceDtl::create([
                'fn_invrownum' => $fn_invrownum, 
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_invno' => auth()->user()->fc_userid,
                'fc_status' => $request->fc_status,
                'fc_detailitem' => $request->fc_detailitem2,
                'fc_unityname' => $request->fc_unityname2,
                'fm_unityprice' => $request->fm_unityprice2,
                'fn_itemqty' =>  $request->fn_itemqty2,
                'fv_description' => $request->fv_description2,
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
                    'link' => '/apps/invoice-cprr'
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
}
