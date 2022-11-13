<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\SalesCustomer;

class SalesCustomerController extends Controller
{
    public function index(){
        return view('data-master.sales-customer.index');
    }

    public function detail($fc_salescode, $fc_membercode){
        return SalesCustomer::where(['fc_salescode' => $fc_salescode,'fc_membercode' => $fc_membercode])->first();
    }

    public function datatables(){
        $data = SalesCustomer::with('branch', 'sales', 'customer')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_salescode' => 'required',
            'fc_membercode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        if(empty($request->type)){
            $cek_data = SalesCustomer::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_salescode' => $request->fc_salescode,
                'fc_membercode' => $request->fc_membercode,
            ])->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        SalesCustomer::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_salescode' => $request->fc_salescode,
            'fc_membercode' => $request->fc_membercode,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_salescode, $fc_membercode){
        SalesCustomer::where(['fc_salescode' => $fc_salescode,'fc_membercode' => $fc_membercode])->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
