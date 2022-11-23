<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\TempSoMaster;
use App\Models\TempSoDetail;
use App\Models\Customer;

class SalesOrderController extends Controller
{
    public function index(){
        return view('apps.sales-order.index');
    }

    public function add_detail($fc_sono){
        $data = TempSoMaster::with('branch', 'member_tax_code', 'sales')->where('fc_sono', $fc_sono)->first();
        return view('views.apps.sales-order.detail', $data);
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

        $request->request->add(['fc_sono' => auth()->user()->fc_user]);

        TempSoMaster::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_sono' => $request->fc_sono,
        ], $request->all());
    }
}
