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

use App\Models\Warehouse;
use App\Models\Invstore;
use App\Models\ScanQr;

class PenggunaanCprrController extends Controller
{

    public function index(){
        return view('apps.penggunaan-cprr.index');
    }

    public function detail($fc_warehousecode)
    {
        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data['gudang_mst'] = Warehouse::where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.penggunaan-cprr.detail', $data);
        // dd($data);
    }

    public function datatables(){
        $data = Warehouse::where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->where('fc_warehousepos', 'EXTERNAL')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $groupedScanner = ScanQr::where('fc_warehousecode', $row->fc_warehousecode)
                    ->selectRaw("SUBSTRING(fc_barcode, 1, 40) as grouped_barcode, COUNT(*) as count")
                    ->groupBy('grouped_barcode')
                    ->get();

                $sumQuantity = $groupedScanner->count();

                return $sumQuantity;
            })
            ->make(true);
    }

    public function datatables_detail($fc_warehousecode)
    {
        $data = ScanQr::with('invstore.stock')
            ->where('fc_warehousecode', $fc_warehousecode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
