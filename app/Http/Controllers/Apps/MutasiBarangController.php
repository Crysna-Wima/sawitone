<?php

namespace App\Http\Controllers\Apps;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\TempMutasiDetail;
use App\Models\TempMutasiMaster;
use Illuminate\Http\Request;
use App\Models\Warehouse;
use Yajra\DataTables\DataTables as DataTables;

use Carbon\Carbon;
use DB;

class MutasiBarangController extends Controller
{
    public function index()
    {
        $temp_mutasi_master = TempMutasiMaster::with('warehouse_start','warehouse_destination')->where('fc_mutationno',auth()->user()->fc_userid)->first();
        $temp_mutasi_detail = TempMutasiDetail::where('fc_mutationno',auth()->user()->fc_userid)->get();
        $total = count($temp_mutasi_detail);
        if(!empty($temp_mutasi_master)){
            $data['data'] = $temp_mutasi_master;
            $data['total'] = $total;
            // return view('apps.purchase-order.detail',$data);
            return view('apps.mutasi-barang.detail',$data);
            // dd($data);
        }
        // dd($temp_po_detail);
        return view('apps.mutasi-barang.index');
    }

    public function datatables_lokasi_awal(){
        $data = Warehouse::with('branch')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function datatables_lokasi_tujuan(){
        $data = Warehouse::with('branch')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_mutasi(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fd_date_byuser' => 'required',
            'fc_type_mutation' => 'required',
            'fc_startpoint' => 'required',
            'fc_destination' => 'required',
         ]
        );
        
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // create ke TempMutasiMaster
       $insert =  TempMutasiMaster::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_mutationno' => auth()->user()->fc_userid,
            'fd_date_byuser' => $request->fd_date_byuser,
            'fc_type_mutation' => $request->fc_type_mutation,
            'fc_startpoint_code' => $request->fc_startpoint,
            'fc_destination_code' => $request->fc_destination,
       ]);

         if($insert){
                return [
                 'status' => 201,
                 'message' => 'Data berhasil disimpan',
                 'link' => '/apps/mutasi-barang'
                ];
        }else{
                return [
                 'status' => 300,
                 'message' => 'Data gagal disimpan'
                ];
        }
    }
}
