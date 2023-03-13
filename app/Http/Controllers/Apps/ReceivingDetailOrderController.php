<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\PoDetail;
use App\Models\PoMaster;
use App\Models\TempRoDetail;
use App\Models\TempRoMaster;
use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class ReceivingDetailOrderController extends Controller
{
    // public function index(){
    //     return view('apps.receiving-order.create-index');
    // }



    public function create($fc_pono)
    {
        // $data = PoMaster::with('supplier')->where('fc_pono', auth()->user()->fc_userid)->first();
        $temp_ro_master = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->first();
        $temp_ro_detail = TempRoDetail::where('fc_rono', auth()->user()->fc_userid)->get();

        $count = count($temp_ro_detail);
        $data['data'] = PoMaster::with('supplier')->where('fc_pono', $fc_pono)->first();
        $data['ro_master'] = $temp_ro_master;
        if (!empty($temp_ro_master)) {
            return view('apps.receiving-order.create-detail', $data);
            // dd($data);
        }
        return view('apps.receiving-order.create-index', $data);
        // dd($data);
    }

    public function store(Request $request)
    {
        // validasi
        $validator = Validator::make(
            $request->all(),
            [
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
            ]
        );

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

        if ($insert_tempromst) {
            return [
                'status' => 201,
                'link' => '/apps/receiving-order/create/' . $request->fc_pono,
                'message' => 'Data berhasil disimpan'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal disimpan'
            ];
        }
    }

    public function detail_item($fc_stockcode, $fc_pono)
    {
        $data = PoDetail::with('stock')->where('fc_stockcode', $fc_stockcode)
            ->where('fc_pono', $fc_pono)
            ->first();
        // kirim dalam bentuk json
        return response()->json($data);
    }

    public function insert_item(Request $request)
    {
        // validasi
        $validator = Validator::make(
            $request->all(),
            [
                'fc_stockcode' => 'required',
                'fc_nameshort' => 'required',
                'fn_qty_ro' => 'required',
                'fd_expired_date' => 'required',
                'fc_batch' => 'required',
            ],
            [
                'fc_stockcode.required' => 'Kode Barang tidak boleh kosong',
                'fc_nameshort.required' => 'Nama Barang tidak boleh kosong',
                'fn_qty_ro.required' => 'Qty tidak boleh kosong',
                'fd_expired_date.required' => 'Expired Date tidak boleh kosong',
                'fc_batch.required' => 'Batch tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            // dd($validator->errors()->first());
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_rono' => auth()->user()->fc_userid]);

        $insert_temprodtl = TempRoDetail::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_rono' => auth()->user()->fc_userid,
            'fc_stockcode' => $request->fc_stockcode,
            'fc_namepack' => $request->fc_namepack,
            'fn_qty_ro' => $request->fn_qty_ro,
            'fd_expired_date' => $request->fd_expired_date,
            'fc_batch' => $request->fc_batch,
            'fc_catnumber' => $request->fc_catnumber,
        ], $request->all());

        if ($insert_temprodtl) {
            return [
                'status' => 200,
                'message' => 'Data berhasil disimpan',
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal disimpan'
            ];
        }
    }

    public function datatables_temp_ro_detail($fc_pono)
    {
       
         $data = TempRoDetail::with('stock')->where('fc_rono', auth()->user()->fc_userid)->whereHas('tempromst', function ($query) use ($fc_pono) {
             $query->where('fc_pono', $fc_pono);
         })->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function submit_ro(Request $request)
    {
        // validasi
        $validator = Validator::make(
            $request->all(),
            [
                'fc_potransport' => 'required',
                'fd_rosjdate' => 'required',
                'fc_address_loading' => 'required'
            ],
            [
                'fc_potransport.required' => 'Transport tidak boleh kosong',
                'fd_rosjdate.required' => 'Tanggal Surat Jalan tidak boleh kosong',
                'fc_address_loading.required' => 'Alamat Loading tidak boleh kosong'
            ]
        );

        if ($validator->fails()) {
            // dd($validator->errors()->first());
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }


        // jika ada tidak ada data di temp_ro_detail yang fc_rono sama dengan yang login
        if (TempRoDetail::where('fc_rono', auth()->user()->fc_userid)->count() == 0) {
            return [
                'status' => 300,
                'message' => 'Item Receiving Kosong'
            ];
        }

        // update
        DB::beginTransaction();
        try {
            $update_tempromst = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)
                ->update([
                    'fc_potransport' => $request->fc_potransport,
                    'fd_rosjdate' => $request->fd_rosjdate,
                    'fc_address_loading' => $request->fc_address_loading,
                    'fc_rostatus' => 'R'
                ]);
            TempRoDetail::where('fc_rono', auth()->user()->fc_userid)->delete();
            TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->delete();

            DB::commit();
            if ($update_tempromst) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/receiving-order'
                ];
            }
        } catch (\Exception $e) {

            DB::rollBack();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal disimpan'
        ];
    }

    public function delete_item($fn_rownum)
    {
        $delete = TempRoDetail::where('fc_rono', auth()->user()->fc_userid)
            ->where('fn_rownum', $fn_rownum)
            ->delete();

        if ($delete) {
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal dihapus'
            ];
        }
        // dd($fn_rownum);
    }
}
