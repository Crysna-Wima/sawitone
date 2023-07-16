<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

use App\Models\DoMaster;
use App\Models\DoDetail;
use App\Models\ReturMaster;
use App\Models\ReturDetail;
use Carbon\Carbon;
use DateTime;
use DB;
use Validator;

class ReturBarangController extends Controller
{
    public function index()
    {
        return view('apps.retur-barang.index');
    }

    public function detail($fc_dono)
    {
        $decoded_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $decoded_fc_dono]);
        $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $decoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $decoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['fc_dono'] = $decoded_fc_dono;

        return view('apps.retur-barang.detail', $data);
    }

    public function store_retur(Request $request)
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

        $retur_mst = ReturMaster::where('fc_returno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();

        if (empty($retur_mst)) {
            // create TempInvoiceMst
            $create = ReturMaster::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_returno' => auth()->user()->fc_userid,
                'fc_dono' => $request->fc_dono,
                'fc_status' => 'I',
                'fd_returdate' => date('Y-m-d H:i:s', strtotime($request->fd_returdate)),
                'fc_userid' => auth()->user()->fc_userid,
            ]);

            if ($create) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/retur-barang/create/' . base64_encode($request->fc_dono)
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
}
