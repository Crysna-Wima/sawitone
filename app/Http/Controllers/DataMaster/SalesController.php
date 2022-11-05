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
        return view('data-master.sales.index');
    }

    public function detail($fc_kode){
        return Sales::where('fc_kode', $fc_kode)->first();
    }

    public function datatables(){
        $data = Sales::orderBy('fc_trx', 'ASC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'fc_trx' => 'required',
            'fc_kode' => 'required',
            'fv_description' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        Sales::updateOrCreate(['fc_trx' => $request->fc_trx, 'fc_kode' => $request->fc_kode],[
            'fc_trx' => $request->fc_trx,
            'fc_kode' => $request->fc_kode,
            'fv_description' => $request->fv_description,
        ] );

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_kode){
        Sales::where('fc_kode', $fc_kode)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
