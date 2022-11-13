<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\BankAcc;

class MasterBankAccController extends Controller
{
    public function index(){
        return view('data-master.master-bank-acc.index');
    }

    public function detail($fc_bankcode){
        return BankAcc::where('fc_bankcode', $fc_bankcode)->first();
    }

    public function datatables(){
        $data = BankAcc::with('branch')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_bankcode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if(empty($request->type)){
            $cek_data = BankAcc::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_bankcode' => $request->fc_bankcode,
            ])->withTrashed()->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        BankAcc::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_bankcode' => $request->fc_bankcode,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_bankcode){
        BankAcc::where('fc_bankcode', $fc_bankcode)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
