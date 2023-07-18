<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\DoDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\TempReturMaster;
use App\Models\TempReturDetail;
use DB;
use Validator;
use App\Helpers\ApiFormatter;

class ReturBarangDetailController extends Controller
{
    public function datatables()
    {
        $data = TempReturDetail::where('fc_returno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_do_detail($fc_dono){
        $decode_dono = base64_decode($fc_dono);
        $data = DoDetail::with('invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->where('fc_dono', $decode_dono)->get();

        // dd($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store_update(Request $request){
        // validasi
        $validator = Validator::make($request->all(), [
            'fc_barcode' => 'required',
            'fc_stockcode' => 'required',
            'fn_returqty' => 'required',
            'fn_price_edit' => 'required',
        ]);
        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // insert ke ReturnDetail
        $insert_data = TempReturDetail::create([
             'fc_divisioncode' => auth()->user()->fc_divisioncode,
             'fc_branch' => auth()->user()->fc_branch,
             'fc_returno' => auth()->user()->fc_userid,
             'fc_barcode' => $request->fc_barcode,
             'fc_batch' => $request->fc_batch,
             'fc_namepack' => $request->fc_namepack,
             'fc_catnumber' => $request->fc_catnumber,
             'fd_expired' => $request->fd_expired,
             'fn_price' => $request->fn_price_edit,
             'fn_disc' => $request->fn_disc,
             'fn_value' => $request->fn_value,
             'fc_status' => $request->fc_status,
             'fn_returqty' => $request->fn_returqty,
             'fv_description' => $request->fv_description
        ]);

        // jika insert berhasil
        if($insert_data){
            return response()->json([
               'status' => 200,
               'message' => 'Data berhasil disimpan'
           ]);
        } else{
            return [
                'status' => 300,
                'link' => '/apps/retur-barang',
                'message' => 'Error'
            ];
        }
        // dd($request);
        
    }

    
}
