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

    public function index(){
        $data['warehouse'] = Warehouse::all();
        $data['data'] = TempSoMaster::where(['fc_sono' => auth()->user()->fc_userid])->with('branch','member_tax_code','sales')->first();

        $temp_detail = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->get();

        $so_discount = 0;
        $so_total = 0;
        $so_grand = 0;

        if(!empty($temp_detail)){
            foreach($temp_detail as $item){
                $so_discount += $item->fm_so_disc;
                $so_total += $item->fm_so_price * $item->fn_so_qty;
            }

            $so_grand = $so_total - $so_discount;
        }

        $data['discount'] = $so_discount;
        $data['total'] = $so_total;
        $data['grand'] = $so_grand;

        return view('apps.sales-order.detail', $data);
    }

    public function detail($fc_divisioncode, $fc_branch, $fc_sono, $fn_sorownum){
        return TempSoDetail::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_sono' => $fc_sono,
            'fn_sorownum' => $fn_sorownum,
        ])->first();
    }

    public function datatables(){
        $data = TempSoDetail::with('branch', 'warehouse')->where('fc_sono', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_stockcode' => 'required',
            'fc_barcode' => 'required',
            'fc_name' => 'required',
            'fn_so_qty' => 'required',
            'fn_so_bonusqty' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $stock = Stock::where(['fc_stockcode' => $request->fc_stockcode, 'fc_barcode' => $request->fc_barcode])->first();

        $temp_detail = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->orderBy('fn_sorownum', 'DESC')->first();
        $fn_sorownum = 1;
        if(!empty($temp_detail)){
            $fn_sorownum = $temp_detail->fn_sorownum + 1;
        }

        if($request->fc_warehousecode == 'NO GUDANG'){
            $request->request->remove('fc_warehouse');
        }

        $request->merge(['fn_so_qty' => Convert::convert_to_double($request->fn_so_qty) ]);
        $request->merge(['fm_so_price' => Convert::convert_to_double($request->fm_so_price) ]);
        $request->merge(['fm_so_disc' => Convert::convert_to_double($request->fm_so_disc) ]);
        $request->merge(['fn_so_value' => Convert::convert_to_double($request->fn_so_value) ]);
        $request->merge(['fn_so_bonusqty' => Convert::convert_to_double($request->fn_so_bonusqty) ]);

        TempSoDetail::create([
            'fc_divisioncode' => $stock->fc_divisioncode,
            'fc_branch' => $stock->fc_branch,
            'fc_sono' => auth()->user()->fc_userid,
            'fn_sorownum' => $fn_sorownum,
            'fc_barcode' => $stock->fc_barcode,
            'fc_namepack' => $stock->fc_namepack,
            'fn_so_qty' => $request->fn_so_qty,
            'fm_so_price' => $request->fm_so_price,
            'fm_so_disc' => $request->fm_so_disc,
            'fn_so_value' => $request->fn_so_value,
            'fn_so_bonusqty' => $request->fn_so_bonusqty,
            'fc_warehousecode' => $request->fc_warehousecode,
            'fv_description' => $request->fv_description,
        ]);

        $temp_detail = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->get();

        $so_discount = 0;
        $so_total = 0;
        $so_grand = 0;

        if(!empty($temp_detail)){
            foreach($temp_detail as $item){
                $so_discount += $item->fm_so_disc;
                $so_total += $item->fm_so_price * $item->fn_so_qty;
            }

            $so_grand = $so_total - $so_discount;
        }

        $data['discount'] = $so_discount;
        $data['total'] = $so_total;
        $data['grand'] = $so_grand;

        $data['discount_view'] = "Rp " . number_format($so_discount,0,',','.');
        $data['total_view'] = "Rp " . number_format($so_total,0,',','.');
        $data['grand_view'] = "Rp " . number_format($so_grand,0,',','.');

        return [
            'status' => 200,
            'data' => $data,
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
