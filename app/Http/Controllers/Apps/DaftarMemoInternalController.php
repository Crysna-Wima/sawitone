<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use Yajra\DataTables\DataTables as DataTables;
use File;
use DB;

use App\Models\SoMaster;
use App\Models\SoDetail;
use App\Models\DoDetail;
use App\Models\TempSoPay;

class DaftarMemoInternalController extends Controller
{

    public function index(){
        return view('apps.daftar-memo-internal.index');
    }

    public function detail($fc_sono){
        // kalau encode pakai base64_encode
        // kalau decode pakai base64_decode
        $encoded_fc_sono = base64_decode($fc_sono);
        session(['fc_sono_global' => $encoded_fc_sono]);
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $encoded_fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.daftar-memo-internal.detail', $data);
        // dd($data);
    }

    public function datatables_so_payment(){
        $data = TempSoPay::where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function datatables_so_detail()
    {
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack','somst')->where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables($fc_sostatus){
        if($fc_sostatus == "ALL") {
            $data = SoMaster::with('domst','customer')->where('fc_sotype', 'Memo Internal')->where('fc_branch', auth()->user()->fc_branch)->get();
        } else {
            $data = SoMaster::with('domst','customer')->where('fc_sotype', 'Memo Internal')->where('fc_branch', auth()->user()->fc_branch)->where('fc_sostatus', $fc_sostatus)->get();
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function cancel_so(Request $request){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $fc_sono = $request->fc_sono;

        // update
        $so_master = SoMaster::where('fc_sono', $fc_sono)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $so_master->update([
            'fc_sostatus' => 'CC',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Data berhasil dicancel',
                'link' => '/apps/daftar-memo-internal'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal dicancel'
        ];
    }
}
