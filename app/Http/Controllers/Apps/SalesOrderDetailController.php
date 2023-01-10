<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;

use App\Helpers\Convert;
use DataTables;
use Carbon\Carbon;
use File;

use App\Models\TempSoMaster;
use App\Models\TempSoDetail;
use App\Models\Customer;
use App\Models\Stock;
use App\Models\Warehouse;

class SalesOrderDetailController extends Controller
{
    public function datatables(){
        $data = TempSoDetail::with('branch','warehouse','stock','namepack')->where('fc_sono', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
                ->addColumn('total_harga', function($item) {
                    return $item->fn_so_qty * $item->fm_so_oriprice;
                })
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_barcode' => 'required',
            'fn_so_qty' => 'required|integer|min:1',
        ]);

        if($validator->fails()) {
            // dd($validator->errors()->first());
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $stock = Stock::where(['fc_barcode' => $request->fc_barcode])->first();

        $temp_detail = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->orderBy('fn_sorownum', 'DESC')->first();
        $fn_sorownum = 1;
        if(!empty($temp_detail)){
            $fn_sorownum = $temp_detail->fn_sorownum + 1;
        }

        $stock = Stock::where('fc_barcode', $request->fc_barcode)->first();

        //total harga
        $total_harga = $stock->fm_so_price * $stock->fn_so_qty;

        $request->merge(['fn_so_qty' => Convert::convert_to_double($request->fn_so_qty) ]);
        $request->merge(['fn_so_value' => Convert::convert_to_double($total_harga) ]);
        $request->merge(['fm_so_price' => Convert::convert_to_double($stock->fm_price_default) ]);

        TempSoDetail::create([
            'fc_divisioncode' => $stock->fc_divisioncode,
            'fc_branch' => $stock->fc_branch,
            'fc_sono' => auth()->user()->fc_userid,
            'fn_sorownum' => $fn_sorownum,
            'fc_barcode' => $stock->fc_barcode,
            'fc_namepack' => $stock->fc_namepack,
            'fn_so_qty' => $request->fn_so_qty,
            'fn_so_value' => $request->fn_so_value,
            'fm_so_oriprice' => $request->fm_so_price,
        ]);

        $temp_detail = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->get();

        // $so_discount = 0;
        // $so_total = 0;
        // $so_grand = 0;

        // if(!empty($temp_detail)){
        //     foreach($temp_detail as $item){
        //         $so_discount += $item->fm_so_disc;
        //         $so_total += $item->fm_so_price * $item->fn_so_qty;
        //     }

        //     $so_grand = $so_total - $so_discount;
        // }

        // $data['discount'] = $so_discount;
        // $data['total'] = $so_total;
        // $data['grand'] = $so_grand;

        // $data['discount_view'] = "Rp " . number_format($so_discount,0,',','.');
        // $data['total_view'] = "Rp " . number_format($so_total,0,',','.');
        // $data['grand_view'] = "Rp " . number_format($so_grand,0,',','.');

        return [
            'status' => 200,
            // 'data' => $data,
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function delete($fc_sono, $fn_sorownum){
        TempSoDetail::where(['fc_sono' => $fc_sono, 'fn_sorownum' => $fn_sorownum])->delete();

        return [
            'status' => 200,
            'message' => 'Data berhasil dihapus',
        ];
    }

    public function lock(){

        try {
            TempSoMaster::where(['fc_sono' => auth()->user()->fc_userid, 'fc_sostatus' => 'I'])->update(['fc_sostatus' => 'F']);

            return [
                'status' => 201,
                'message' => 'Data berhasil di lock'
            ];
        } catch (\Illuminate\Database\QueryException $e) {

            return [
                'status' => 300,
                'message' => 'Data gagal di lock silahkan coba lagi'
            ];
        }



    }
}
