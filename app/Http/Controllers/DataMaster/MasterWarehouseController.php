<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Warehouse;

class MasterWarehouseController extends Controller
{
    public function index(){
        return view('data-master.master-warehouse.index');
    }

    public function detail($fc_warehousecode){
        return Warehouse::where('fc_warehousecode', $fc_warehousecode)->first();
    }

    public function datatables(){
        $data = Warehouse::with('transaksi_type')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_warehousecode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        Warehouse::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_warehousecode' => $request->fc_warehousecode,
        ], $request->except(['type']));

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_warehousecode){
        Warehouse::where('fc_warehousecode', $fc_warehousecode)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
