<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use DB;

use Yajra\DataTables\DataTables as DataTables;
use App\Models\TempMutasiDetail;
use App\Models\Invstore;
use App\Models\TempMutasiMaster;

class MutasiBarangDetailController extends Controller
{
    public function datatables_inventory($fc_startpoint_code)
    {
        $data = Invstore::with('stock')
        // ->where('fc_warehousecode', $fc_startpoint_code)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables()
    {
        $data = TempMutasiDetail::with('warehouse')->where('fc_mutationno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store_mutasi_detail(Request $request){
         // validator
         $validator = Validator::make($request->all(), [
            'fc_stockcode' => 'required',
            'fc_barcode' => 'required',
            'fc_namelong' => 'required',
            'fn_qty' => 'required',
         ]
        );
        
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // create ke TempMutasiMaster
       $insert =  TempMutasiDetail::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_mutationno' => auth()->user()->fc_userid,
            'fc_stockcode' => $request->fc_stockcode,
            'fc_barcode' => $request->fc_barcode,
            'fn_qty' => $request->fn_qty,
       ]);

         if($insert){
                return [
                 'status' => 200,
                 'message' => 'Data berhasil disimpan',
                ];
        }else{
                return [
                 'status' => 300,
                 'message' => 'Data gagal disimpan'
                ];
        }
    }

}

