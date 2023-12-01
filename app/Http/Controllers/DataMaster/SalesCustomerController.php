<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;
use App\Models\User;
use App\Models\SalesCustomer;

class SalesCustomerController extends Controller
{
    public function index(){
        return view('data-master.sales-customer.index');
    }

    public function detail($fc_divisioncode, $fc_branch, $fc_salescode, $fc_membercode){
        return SalesCustomer::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_salescode' => $fc_salescode,
            'fc_membercode' => $fc_membercode
        ])->first();
    }

    public function datatables(){
        $data = SalesCustomer::with('branch', 'sales', 'customer')->orderBy('created_at', 'DESC')->groupBy('fc_salescode')->get();
        $dataArray = array();
    
        foreach($data as $item){
            $filter = SalesCustomer::where('fc_salescode', $item->fc_salescode)->get()->count();
            array_push($dataArray, $filter);
        }
    
        return DataTables::of($data)
        ->addColumn('sum_membercode', function($row) use ($data, $dataArray) {
            $index = array_search($row->fc_salescode, array_column($data->toArray(), 'fc_salescode'));
            $filterCount = $dataArray[$index];
            return $filterCount;
        })
        ->addIndexColumn()
        ->make(true);
    }

    public function detailSalesCustomer($fc_salescode){
        $data = SalesCustomer::where('fc_salescode', $fc_salescode)->with('branch', 'sales', 'customer')->first();
        $nama = $data->sales->fc_salesname1;
        return view('apps.detail-sales-customer.index', compact('fc_salescode', 'nama', 'data'));
    }

    public function detaillDatatables($fc_salescode){
        $decode_fc_salescode = base64_decode($fc_salescode);
        $data = SalesCustomer::with('branch', 'sales', 'customer')->where('fc_salescode', $decode_fc_salescode)->orderBy('created_at', 'DESC')->get();
        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function createCustomer(Request $request, $fc_salescode){
        SalesCustomer::create([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_salescode' => $request->fc_salescode,
            'fc_membercode' => $request->fc_membercode,
            'fd_memberjoindate' => $request->fd_memberjoindate,
            'fl_active' => $request->fl_active,
            'fv_salescustomerdescription' => $request->fv_salescustomerdescription
        ]);
        
        return [
            'status' => 200,
            'link' => '/data-master/sales-customer/detail/customer/' . $fc_salescode,
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function deleteCustomer($fc_membercode, $fc_salescode)
    {
        $getOneData = SalesCustomer::where('fc_membercode', $fc_membercode)->where('fc_salescode', $fc_salescode);
        $getOneData->delete();
        return [
            'status' => 200,
            'link' => '/data-master/sales-customer/detail/customer/' . $fc_salescode,
            'message' => 'Data berhasil dihapus'
        ];
    }
    public function store_update(request $request){
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_salescode' => 'required',
            'fc_membercode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if(empty($request->type)){
            $cek_data = SalesCustomer::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_salescode' => $request->fc_salescode,
                'fc_membercode' => $request->fc_membercode,
            ])->withTrashed()->count();

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

    public function delete($fc_divisioncode, $fc_branch, $fc_salescode, $fc_membercode){
        SalesCustomer::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_salescode' => $fc_salescode,
            'fc_membercode' => $fc_membercode
        ])->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
