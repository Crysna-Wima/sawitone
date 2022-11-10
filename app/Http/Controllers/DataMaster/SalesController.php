<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Sales;

class SalesController extends Controller
{
    public function index(){
        return view('data-master.master-sales.index');
    }

    public function detail($fc_salescode){
        return Sales::where('fc_salescode', $fc_salescode)->first();
    }

    public function datatables(){
        $data = Sales::orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_salescode' => 'required',
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
            'fc_salescode' => $request->fc_salescode,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_salescode){
        Sales::where('fc_salescode', $fc_salescode)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
