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
use DB;

use App\Models\TempSoMaster;
use App\Models\TempSoDetail;
use App\Models\Customer;

class SalesOrderController extends Controller
{
    public function index(){
        $temp_so_master = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)->first();
        if(!empty($temp_so_master)){
            return redirect()->route('so.detail');
        }

        return view('apps.sales-order.index');
    }

    public function detail($fc_divisioncode, $fc_branch, $fc_sono){
        return TempSoMaster::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_sono' => $fc_sono,
        ])->first();
    }

    public function datatables(){
        $data = TempSoMaster::with('branch')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->merge(['fm_servpay' => Convert::convert_to_double($request->fm_servpay) ]);
        $request->request->add(['fc_sono' => auth()->user()->fc_userid]);

        TempSoMaster::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_sono' => $request->fc_sono,
        ], $request->all());

        return [
            'status' => 201,
            'link' => '/apps/sales-order/detail',
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function delete($fc_divisioncode, $fc_branch, $fc_sono){
        DB::beginTransaction();

        TempSoDetail::where('fc_sono', $fc_sono)->delete();
        TempSoMaster::where(['fc_divisioncode' => $fc_divisioncode, 'fc_branch' => $fc_branch, 'fc_sono' => $fc_sono])->delete();

        return [
            'status' => 200,
            'message' => 'Data berhasil dihapus'
        ];

		try{

			//query

			DB::commit();

			return [
				'status' => 200, // SUCCESS
				'message' => 'Data berhasil dihapus'
			];


		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }
}
