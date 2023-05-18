<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Convert;

use Validator;
use PDF;

use Carbon\Carbon;
use DB;
use Yajra\DataTables\DataTables;
use App\Models\Invstore;

class PersediaanBarangController extends Controller
{
    public function index()
    {
        return view('apps.persediaan-barang.index');
    }

    public function datatables_dexa()
    {
        $data = Invstore::with('stock')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $sumQuantity = Invstore::where('fc_stockcode', $row->fc_stockcode)
                    ->where('fc_warehousecode', $row->fc_warehousecode)
                    ->sum('fn_quantity');

                return $sumQuantity;
            })
            ->make(true);
    }


    public function datatables_gudanglain()
    {
        $data = Invstore::with('stock')
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->where('fl_status', 'EXTERNAL')
        ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $sumQuantity = Invstore::where('fc_stockcode', $row->fc_stockcode)
                    ->where('fc_warehousecode', $row->fc_warehousecode)
                    ->sum('fn_quantity');

                return $sumQuantity;
            })
            ->make(true);
    }

    public function datatables_inventory_dexa()
    {
        $data = Invstore::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_inventory_gudanglain()
    {
        $data = Invstore::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
