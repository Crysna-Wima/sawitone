<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Stock;

class MasterStockController extends Controller
{
    public function index(){
        return view('data-master.master-stock.index');
    }

    public function detail($fc_stockcode){
        return Stock::where('fc_stockcode', $fc_stockcode)->first();
    }

    public function datatables(){
        $data = Stock::with(
            'branch',
            'namepack',
            'type_stock1',
            'type_stock2',
        )->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'fc_stockcode' => 'required',
            'fc_barcode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if(empty($request->type)){
            $cek_data = Stock::where([
                'fc_stockcode' => $request->fc_stockcode,
                'fc_barcode' => $request->fc_barcode,
            ])->withTrashed()->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        $request->merge(['fm_cogs' => Convert::convert_to_double($request->fm_cogs) ]);
        $request->merge(['fm_purchase' => Convert::convert_to_double($request->fm_purchase) ]);
        $request->merge(['fm_salesprice' => Convert::convert_to_double($request->fm_salesprice) ]);
        $request->merge(['fm_disc_rp' => Convert::convert_to_double($request->fm_disc_rp) ]);
        $request->merge(['fm_time_disc_rp' => Convert::convert_to_double($request->fm_time_disc_rp) ]);
        $request->merge(['fm_price_distributor' => Convert::convert_to_double($request->fm_price_distributor) ]);
        $request->merge(['fm_price_project' => Convert::convert_to_double($request->fm_price_project) ]);
        $request->merge(['fm_price_dealer' => Convert::convert_to_double($request->fm_price_dealer) ]);
        $request->merge(['fm_price_enduser' => Convert::convert_to_double($request->fm_price_enduser) ]);
        $request->merge(['fm_price_default' => Convert::convert_to_double($request->fm_price_default) ]);

        Stock::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_stockcode' => $request->fc_stockcode,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_stockcode){
        Stock::where('fc_stockcode', $fc_stockcode)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
