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
        $temp_so_master = TempSoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', auth()->user()->fc_userid)->first();
        if(!empty($temp_so_master)){
            $data['data'] = $temp_so_master;
            return view('apps.sales-order.detail', $data);
            
        }
        return view('apps.sales-order.index');
        
    }

    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_salescode' => 'required',
            'fc_membercode' => 'required',
            'fc_sotype' => 'required',
            
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_sono' => auth()->user()->fc_userid]);

        $customer = Customer::where('fc_membercode', $request->fc_membercode)->first();

        TempSoMaster::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_sono' => $request->fc_sono,
            'fc_sotype' => $request->fc_sotype,
            'fc_membercode' => $request->fc_membercode,
            'fc_membertaxcode' => $customer->fc_membertaxcode,
            'fc_memberaddress_loading1' => $customer->fc_memberaddress_loading1,
            'fc_memberaddress_loading2' => $customer->fc_memberaddress_loading2,
            'fd_sodatesysinput' => Carbon::now(),
            'fd_sodatesysinput' => Carbon::now(),
            'fc_salescode' => $request->fc_salescode,
            'fc_userid' => auth()->user()->fc_userid,
        ], $request->all());

        return [
            'status' => 201,
            'link' => '/apps/sales-order',
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function delete(){
        DB::beginTransaction();

		try{
            TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->delete();
            TempSoMaster::where(['fc_sono' => auth()->user()->fc_userid])->delete();

			DB::commit();

			return [
				'status' => 201, // SUCCESS
                'link' => '/apps/sales-order',
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
