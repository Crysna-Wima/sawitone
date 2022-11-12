<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Customer;

class CustomerController extends Controller
{
    public function index(){
        return view('data-master.master-customer.index');
    }

    public function detail($fc_membercode){
        return Customer::where('fc_membercode', $fc_membercode)->first();
    }

    public function datatables(){
        $data = Customer::with(
            'branch',
            'member_type_business',
            'member_typebranch',
            'member_legal_status',
            'member_tax_code',
            'member_nationality',
            'member_bank1',
            'member_bank2',
            'member_bank3',
            )->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_membercode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        Customer::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_membercode' => $request->fc_membercode,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_membercode){
        Customer::where('fc_membercode', $fc_membercode)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
