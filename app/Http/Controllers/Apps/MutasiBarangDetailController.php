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
use App\Models\Stock;

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
        $data = TempMutasiDetail::with('warehouse', 'stock')->where('fc_mutationno', auth()->user()->fc_userid)->get();

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

        $count_po_dtl = TempMutasiDetail::where('fc_mutationno', auth()->user()->fc_userid)->get();
        $total = count($count_po_dtl);

        $stock = Stock::where('fc_stockcode', $request->fc_stockcode)->first();
        $temp_detail = TempMutasiDetail::where('fc_mutationno', auth()->user()->fc_userid)->orderBy('fn_mutationrownum', 'DESC')->first();

        // jika ada TempSoDetail yang fc_stockcode == $request->fc_stockcode
        $count_stockcode = TempMutasiDetail::where('fc_mutationno', auth()->user()->fc_userid)->where('fc_stockcode', $request->fc_stockcode)->get();


        // jika ada fc_stockcode yang sama di $temppodtl
        if (!empty($temp_detail)) {
            // jika ditemukan $count_barcode error produk yang sama telah diinputkan
            if (count($count_stockcode) > 0) {
                return [
                    'status' => 300,
                    'total' => $total,
                    'message' => 'Produk yang sama telah diinputkan'
                ];
            }
        }


        $fn_mutationrownum = 1;
        if (!empty($temp_detail)) {
            $fn_mutationrownum = $temp_detail->fn_mutationrownum + 1;
        }

        // create ke TempMutasiMaster
        $insert =  TempMutasiDetail::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_mutationno' => auth()->user()->fc_userid,
            'fc_stockcode' => $request->fc_stockcode,
            'fn_mutationrownum' => $fn_mutationrownum,
            'fc_barcode' => $request->fc_barcode,
            'fn_qty' => $request->fn_qty,
       ]);

         if($insert){
                return [
                 'status' => 200,
                 'link' => '/apps/mutasi-barang',
                 'message' => 'Data berhasil disimpan',
                ];
        }else{
                return [
                 'status' => 300,
                 'link' => '/apps/mutasi-barang',
                 'message' => 'Data gagal disimpan'
                ];
        }
    }

    public function delete($fc_mutationno, $fn_mutationrownum)
    {
        // hitung jumlah data di TempMutasiDetail
        $count_mutasi_dtl = TempMutasiDetail::where('fc_mutationno', $fc_mutationno)->where('fc_branch', auth()->user()->fc_branch)->count();
        $delete = TempMutasiDetail::where('fc_mutationno', $fc_mutationno)->where('fn_mutationrownum', $fn_mutationrownum)->delete();
        if ($delete) {
            if($count_mutasi_dtl < 2){
                return response()->json([
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                    'link' => '/apps/mutasi-barang'
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return [
            'status' => 300,
            'message' => 'Error'
        ];
    }

}

