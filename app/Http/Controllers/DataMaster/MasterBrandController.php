<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\Brand;

class MasterBrandController extends Controller
{
    public function index(){
        return view('data-master.master-brand.index');
    }

    public function detail($fc_subgroup){
        return Brand::where('fc_subgroup', $fc_subgroup)->first();
    }

    public function datatables(){
        $data = Brand::orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_brand' => 'required',
            'fc_group' => 'required',
            'fc_subgroup' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        Brand::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_brand' => $request->fc_brand,
            'fc_group' => $request->fc_group,
            'fc_subgroup' => $request->fc_subgroup,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_subgroup){
        Brand::where('fc_subgroup', $fc_subgroup)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
