<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\TempPoDetail;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class PurchaseOrderDetailController extends Controller
{
    public function datatables(){
        $data = TempPoDetail::with('branch', 'warehouse', 'stock', 'namepack','temppomst')->where('fc_pono', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store_update(Request $request){
        //  validasi request
        $validator = Validator::make($request->all(),[
            // 'fc_barcode' => 'required',
            'fc_stockcode' => 'required',
            'fn_po_qty' => 'required|integer|min:1',
            'fm_po_price' => 'required|integer',
        ], [
            // 'fc_barcode.required' => 'Barcode harus diisi',
            'fc_stockcode.required' => 'Stockcode harus diisi',
            'fn_so_qty.required' => 'Quantity harus diisi',
            'fm_po_price' => 'Harga harus diisi'
        ]);


        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $count_po_dtl = TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->get();
        $total = count($count_po_dtl);

        $stock = Stock::where('fc_barcode', $request->fc_barcode)->first();
        $temp_detail = TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->orderBy('fn_porownum', 'DESC')->first();

        // jika ada TempSoDetail yang fc_barcode == $request->fc_barcode
        $count_barcode = TempPoDetail::where('fc_pono', auth()->user()->fc_userid)->where('fc_stockcode', $request->fc_stockcode)->get();
         
        
        // jika ada fc_barcode yang sama di $temppodtl
        if (!empty($temp_detail)) {
            // jika ditemukan $count_barcode error produk yang sama telah diinputkan
            if (count($count_barcode) > 0) {
                return [
                    'status' => 300,
                    'total' => $total,
                    'message' => 'Produk yang sama telah diinputkan'
                ];
            }
        }


        $fn_porownum = 1;
        if (!empty($temp_detail)) {
            $fn_porownum = $temp_detail->fn_porownum + 1;
        }

        $stock = Stock::where('fc_barcode', $request->fc_barcode)->first();

        //total harga
        $total_harga = $request->fn_po_value * $request->fm_po_price;

        $request->merge(['fn_po_qty' => Convert::convert_to_double($request->fn_po_qty)]);
        $request->merge(['fn_po_value' => Convert::convert_to_double($total_harga)]);
        $request->merge(['fm_po_price' => Convert::convert_to_double($stock->fm_price_default)]);

        $insert_po_detail = TempPoDetail::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_pono' => auth()->user()->fc_userid,
            'fn_porownum' => $fn_porownum,
            // 'fc_barcode' => $stock->fc_barcode,
            'fc_stockcode' => $request->fc_stockcode,
            'fc_namepack' => $stock->fc_namepack,
            'fn_po_qty' => $request->fn_po_qty,
            'fn_po_value' => $request->fn_po_qty * $request->fm_po_price_edit,
            'fm_po_price' => $request-> fm_po_price,
            'fv_description' => $request-> fv_description
        ]);
            
        if($insert_po_detail){
            return response()->json([
               'status' => 200,
               'total' => $total,
               'link' => '/apps/purchase-order',
               'message' => 'Data berhasil disimpan'
           ]);
           }
            return [
               'status' => 300,
               'link' => '/apps/purchase-order',
               'message' => 'Error'
               ];
     }

     public function delete($fc_pono, $fn_porownum){
        $delete = TempPoDetail::where('fc_pono', $fc_pono)->where('fn_porownum', $fn_porownum)->delete();
        if($delete){
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
