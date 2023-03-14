<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;
use App\Models\PoDetail;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\PoMaster;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\TempRoDetail;
use App\Models\TempRoMaster;
use Yajra\DataTables\DataTables;

class ReceivingOrderController extends Controller
{
    public function index()
    {
        $data = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->first();

        $count = TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->count();
        if ($count === 0) {
            return view('apps.receiving-order.index');
        } else {
            return redirect('/apps/receiving-order/create/' . $data->fc_pono);
        }
    }

    public function detail($fc_pono)
    {
        session(['fc_pono_global' => $fc_pono]);
        $data['data'] = PoMaster::with('supplier')->where('fc_pono', $fc_pono)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.receiving-order.detail', $data);
        // dd($data);
    }

    public function datatables_po_detail()
    {
        //  jika session fc_sono_global tidak sama dengan null
        if (session('fc_pono_global') != null) {
            $fc_pono = session('fc_pono_global');
        } else {
            $pomst = PoMaster::where('fc_userid', auth()->user()->fc_userid)->first();
            $fc_pono_pomst = $pomst->fc_pono;
            $fc_pono = $fc_pono_pomst;
        }

        $data = PoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_pono', $fc_pono)->where('fc_branch', auth()->user()->fc_branch)->where('fc_divisioncode', auth()->user()->fc_divisioncode)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf_ro($fc_rono)
    {
        session(['fc_rono_global' => $fc_rono]);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $fc_rono)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $fc_rono)->get();
        $pdf = PDF::loadView('pdf.receiving-order-podetail', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function datatables_receiving_order()
    {

        $data = RoMaster::with('pomst.supplier')->where('fc_pono', session('fc_pono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables()
    {
        $data = PoMaster::with('supplier')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function cancel_ro($fc_pono)
    {
        DB::beginTransaction();

        try {
            TempRoDetail::where('fc_rono', auth()->user()->fc_userid)->delete();
            TempRoMaster::where('fc_rono', auth()->user()->fc_userid)->delete();

            DB::commit();

            return [
                'status' => 201, // SUCCESS
                'link' => '/apps/receiving-order',
                'message' => 'Receiving Order dibatalkan'
            ];
        } catch (\Exception $e) {

            DB::rollback();

            return [
                'status'     => 300, // GAGAL
                'message'       => (env('APP_DEBUG', 'true') == 'true') ? $e->getMessage() : 'Operation error'
            ];
        }
    }
}
