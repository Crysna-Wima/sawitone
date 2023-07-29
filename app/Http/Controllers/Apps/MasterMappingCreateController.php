<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingDetail;
use App\Models\MappingMaster;

use Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterMappingCreateController extends Controller
{
    public function create($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $data['data'] = MappingMaster::with('transaksi', 'tipe', 'branch')->where('fc_branch', auth()->user()->fc_branch)->where('fc_mappingcode', $encoded_fc_mappingcode)->first();

        return view('apps.master-mapping.create', $data);
    }

    public function datatables_debit($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $data = MappingDetail::with('mst_coa')->where('fc_mappingcode', $encoded_fc_mappingcode)
                                ->where('fc_mappingpos', "D")
                                ->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_kredit($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $data = MappingDetail::with('mst_coa')->where('fc_mappingcode', $encoded_fc_mappingcode)
                                ->where('fc_mappingpos', "C")
                                ->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }


    public function insert_debit(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_mappingcode' => 'required',
            'fc_coacode' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $count_coa = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
        ->where('fc_coacode', $request->fc_coacode)
        ->where('fc_mappingpos', "D")
        ->where('fc_branch', auth()->user()->fc_branch)->count();

        if($count_coa > 0){
            return [
                'status' => 300,
                'message' => 'Kode COA sudah ada'
            ];
        }else{
            $data = MappingDetail::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_coacode' => $request->fc_coacode,
                'fc_mappingpos' => "D",
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($data){
                return [
                    'status' => 200,
                    'message' => 'Debit berhasil diinsert',
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Debit gagal diinsert',
                ];
            } 
        }

        
    }

    public function insert_kredit(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_mappingcode' => 'required',
            'fc_coacode' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $count_coa = MappingDetail::where('fc_mappingcode', $request->fc_mappingcode)
        ->where('fc_coacode', $request->fc_coacode)
        ->where('fc_mappingpos', "C")
        ->where('fc_branch', auth()->user()->fc_branch)->count();

        if($count_coa > 0){
            return [
                'status' => 300,
                'message' => 'Kode COA sudah ada'
            ];
        }else{
            $data = MappingDetail::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_coacode' => $request->fc_coacode,
                'fc_mappingpos' => "C",
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($data){
                return [
                    'status' => 200,
                    'message' => 'Kredit berhasil diinsert',
                ];
            }else{
                return [
                    'status' => 300,
                    'message' => 'Kredit gagal diinsert',
                ];
            } 
        }

       
    }

    public function delete_debit($fc_coacode){

        // decode fc_mappingcode
        $decode_fc_coacode = base64_decode($fc_coacode);

       // jika fc_mappingcode samadengan null
         if($fc_coacode == null){
            return [
                'status' => 300,
                'message' => 'Mapping Code tidak boleh kosong',
            ];
        }
        $data = MappingDetail::where('fc_coacode', $decode_fc_coacode)
                                ->where('fc_mappingpos','D')->delete();

        if($data){
            return [
                'status' => 200,
                'message' => 'Debit berhasil dihapus',
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Debit gagal dihapus',
            ];
        } 
    }

    public function delete_kredit($fc_coacode){

        // decode fc_mappingcode
        $decode_fc_coacode = base64_decode($fc_coacode);

       // jika fc_mappingcode samadengan null
         if($fc_coacode == null){
            return [
                'status' => 300,
                'message' => 'Mapping Code tidak boleh kosong',
            ];
        }
        $data = MappingDetail::where('fc_coacode', $decode_fc_coacode)
                                ->where('fc_mappingpos','C')->delete();

        if($data){
            return [
                'status' => 200,
                'message' => 'Debit berhasil dihapus',
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Debit gagal dihapus',
            ];
        } 
    }
}
