<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\PoMaster;
use App\Models\TempRoDetail;
use App\Models\TempRoMaster;
use Illuminate\Http\Request;
use Validator;

class ReceivingDetailOrderController extends Controller
{
    // public function index(){
    //     return view('apps.receiving-order.create-index');
    // }


    
    public function create($fc_pono){
        // $data = PoMaster::with('supplier')->where('fc_pono', auth()->user()->fc_userid)->first();
        $temp_ro_master = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->first();
        $temp_ro_detail = TempRoDetail::where('fc_rono', auth()->user()->fc_userid)->get();

        $count = count($temp_ro_detail);
        $data['data'] = PoMaster::with('supplier')->where('fc_pono', $fc_pono)->first();
        $data['ro_master'] = $temp_ro_master;
        if(!empty($temp_ro_master)){
        return view('apps.receiving-order.create-detail',$data);
        // dd($data);
        }
         return view('apps.receiving-order.create-index',$data);
        // dd($data);
    }

    public function store(Request $request){
        // validasi
        $validator = Validator::make($request->all(),[
            'fc_userid' => 'required',
            'fc_sjno' => 'required',
            'fc_receiver' => 'required',
            'fd_roarivaldate' => 'required'
        ],
        [
            'fc_userid.required' => 'User ID tidak boleh kosong',
            'fc_sjno.required' => 'No Surat Jalan tidak boleh kosong',
            'fc_receiver.required' => 'Penerima tidak boleh kosong',
            'fd_roarivaldate.required' => 'Tanggal diterima tidak boleh kosong'
        ]);

        if ($validator->fails()) {
            // dd($validator->errors()->first());
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_rono' => auth()->user()->fc_userid]);

          $insert_tempromst = TempRoMaster::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_rono' => auth()->user()->fc_userid,
            'fc_pono' => $request->fc_pono,
            'fc_sjno' => $request->fc_sjno,
            'fc_receiver' => $request->fc_receiver,
            'fd_roarivaldate' => $request->fd_roarivaldate,
            'fc_userid' => $request->fc_userid,
            'fc_rostatus' => 'I'
        ], $request->all());

        if($insert_tempromst){
            return [
                'status' => 201,
                'link' => '/apps/receiving-order/create/' . $request->fc_pono,
                'message' => 'Data berhasil disimpan'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal disimpan'
            ];
        }
    }
}
