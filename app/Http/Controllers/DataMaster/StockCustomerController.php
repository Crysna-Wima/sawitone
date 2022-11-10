<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\StockCustomer;

class StockCustomerController extends Controller
{
    public function index(){
        return view('data-master.stock-customer.index');
    }

    public function detail($fc_stockcode){
        return StockCustomer::where('fc_stockcode', $fc_stockcode)->first();
    }

    public function datatables(){
        $data = StockCustomer::orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_stockcode' => 'required',
            'fc_barcode' => 'required',
            'fc_membercode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        Sales::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_stockcode' => $request->fc_stockcode,
            'fc_barcode' => $request->fc_barcode,
            'fc_membercode' => $request->fc_membercode,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_stockcode){
        StockCustomer::where('fc_stockcode', $fc_stockcode)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
