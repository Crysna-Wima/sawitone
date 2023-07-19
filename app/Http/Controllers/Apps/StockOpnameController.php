<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

use App\Models\StockInquiri;
use App\Models\TempReturMaster;
use App\Models\TempReturDetail;
use App\Models\Warehouse;

use Carbon\Carbon;
use DateTime;
use DB;
use Validator;
use App\Helpers\ApiFormatter;

class StockOpnameController extends Controller
{
    public function index()
    {
        return view('apps.stock-opname.index');
    }

    public function detail_gudang($fc_warehousecode){

        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data = Warehouse::where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        // retur json
        return response()->json(
            [
                'data' => $data,
                'status' => 'success'
            ]
        );
    }

    public function store_update(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fc_dono' => 'required',
            'fd_returdate' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $retur_mst = TempReturMaster::where('fc_returno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();

        if (empty($retur_mst)) {
            // create TempInvoiceMst
            $insert = TempReturMaster::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_returno' => auth()->user()->fc_userid,
                'fc_dono' => $request->fc_dono,
                'fc_status' => 'I',
                'fd_returdate' => date('Y-m-d H:i:s', strtotime($request->fd_returdate)),
                'fc_userid' => auth()->user()->fc_userid,
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/retur-barang'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } else {
            return [
                'status' => 300,
                'message' => 'Data sudah ada'
            ];
        }
    }
    
    public function cancel(){
        DB::beginTransaction();

		try{
            TempReturMaster::where('fc_returno', auth()->user()->fc_userid)->delete();
            TempReturDetail::where('fc_returno', auth()->user()->fc_userid)->delete();

			DB::commit();

			return [
				'status' => 201, // SUCCESS
                'link' => '/apps/retur-barang',
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
