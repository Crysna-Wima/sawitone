<?php

namespace App\Http\Controllers\DataMaster;

use App\Helpers\ApiFormatter;
use App\Http\Controllers\Controller;
use App\Models\Cospertes;
use App\Models\MasterCoa;
use Illuminate\Http\Request;
use Validator;
use DataTables;

class MasterCoaController extends Controller
{
    public function index(){
        return view('data-master.master-coa.index');
    }

    public function detail($fc_coacode){
        $coacode = base64_decode($fc_coacode);

        $data = MasterCoa::with('parent')
        ->where([
            'fc_coacode' =>  $coacode,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
        ])
        ->first();

        return ApiFormatter::getResponse($data);
    }

    public function datatables(){
        $data = MasterCoa::with('branch', 'parent')->where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
        ])->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function getParent($layer){
        $fn_layer = base64_decode($layer);

        $data = MasterCoa::where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fn_layer' => $fn_layer - 1,
        ])
        ->get();
        
        if(empty($data)){
            return [
                'status' => 200,
                'data'=> ['INDUK COA']
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function storeUpdate(request $request){
        $validator = Validator::make($request->all(), [
            'fc_coacode' => 'required',
            'fn_layer' => 'required',
            'fc_parentcode' => 'required',
            'fc_coaname' => 'required',
        ]);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' => $validator->errors()->first(),
            ];
        }
        // dd($request);
        $request->request->add(['fc_branch' => auth()->user()->fc_branch, 'fc_divisioncode' => auth()->user()->fc_divisioncode]);

        // jika type form adalah update 
        if(!empty($request->type) && $request->type == 'update'){
            $updateRecord = MasterCoa::updateOrCreate([
                'fc_coacode' => $request->fc_coacode,
            ], $request->all());

            if($updateRecord){
                return [
                        'status' => 200, // SUCCESS
                        'message' => 'Data berhasil diupdate'
                    ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Oops! Terjadi kesalahan saat mengupdate data'
                ];
            }    

        }else {
            $countRecord = MasterCoa::where([
                'fc_coacode' => $request->fc_coacode,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_parentcode' => $request->fc_parentcode,
                'deleted_at' => null
            ])->count();

            if($countRecord > 0){
                return [
                    'status' => 300,
                    'message' => "Mohon maaf, kode COA sudah tersedia",
                ];
            }

            $insertRecord = MasterCoa::create([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_coacode' => $request->fc_coacode,
                'fn_layer' => $request->fn_layer,
                'fc_directpayment' => $request->fc_directpayment,
                'fc_parentcode' => $request->fc_parentcode,
                'fc_coaname' => $request->fc_coaname,
                'fv_description' => $request->fv_description,
            ], $request->all());

            if($insertRecord){
                return [
                    'status' => 200,
                    'message' => "Data COA berhasil ditambahkan",
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Oops! Terjadi kesalahan saat menambahkan data',
                ];
            }
        }
    }

    public function delete($id){
        $idDecode = base64_decode($id);

        $deleteRecord = MasterCoa::where('id', $idDecode)->delete();

        if($deleteRecord){
            return [
                'status' => 200,
                'message' => "Data Berhasil Dihapus",
            ];
        } else {
            return [
                'status' => 300,
                'message' => "Ooops!! Data Gagal Dihapus ...",
            ];
        }

    }
}
