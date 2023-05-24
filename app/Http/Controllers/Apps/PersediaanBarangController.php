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
use App\Models\Warehouse;
use App\Models\MutasiMaster;
use App\Models\Stock;

class PersediaanBarangController extends Controller
{
    public function index()
    {
        return view('apps.persediaan-barang.index');
    }

    public function detail($fc_warehousecode){
        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data['gudang_mst'] = Warehouse::where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.persediaan-barang.detail', $data);
        // dd($data);
    }

    public function datatables_detail($fc_warehousecode)
    {
        $data = Invstore::with('stock')
        ->select('fc_stockcode', DB::raw('SUM(fn_quantity) as fn_quantity'))
        ->where('fc_warehousecode', $fc_warehousecode)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->groupBy('fc_stockcode')
        ->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_detail_inventory($fc_stockcode, $fc_warehousecode)
    {
        $data = Invstore::with('stock')->where('fc_stockcode', $fc_stockcode)->where('fc_warehousecode', $fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_mutasi($fc_warehousecode)
    {
        $data = MutasiMaster::with('warehouse')
        ->where('fc_branch', auth()->user()->fc_branch)
        ->where(function ($query) use ($fc_warehousecode) {
            $query->where('fc_startpoint_code', $fc_warehousecode)
                ->orWhere('fc_destination_code', $fc_warehousecode);
        })
        ->get();
        // $data = MutasiDetail::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_dexa()
    {
        // $data = Invstore::with(['stock', 'warehouse' => function($query) {
        //     $query->where('fc_warehousepos', 'INTERNAL');
        // }])
        //     ->where('fc_branch', auth()->user()->fc_branch)
        //     ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        //     // ->where('fc_warehousecode', Warehouse::where('fc_warehousepos', 'INTERNAL')->first()->fc_warehousecode) 
        //     ->groupBy('fc_stockcode')
        //     ->get();

        // return DataTables::of($data)
        //     ->addIndexColumn()
        //     ->addColumn('sum_quantity', function ($row) {
        //         if ($row->warehouse === null) {
        //             return null; // Jika warehouse null, kembalikan nilai null
        //         }
                
        //         $sumQuantity = Invstore::where('fc_stockcode', $row->fc_stockcode)
        //             ->whereHas('warehouse', function ($query) {
        //                 $query->where('fc_warehousepos', 'INTERNAL');
        //             })
        //             ->sum('fn_quantity');
                
        //         return $sumQuantity;
        //     })
        //     ->make(true);

        $data = Stock::with(['invstore' => function ($query) {
            $query->whereHas('warehouse', function ($query) {
                $query->where('fc_warehousepos', 'INTERNAL');
            });
        }, 'invstore.warehouse'])
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->where('fc_branch', auth()->user()->fc_branch)
            ->get();
    
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $sumQuantity = $row->invstore->sum('fn_quantity');
                return $sumQuantity;
            })
            ->make(true);
    }

    public function datatables_gudanglain()
    {
        $data = Warehouse::where('fc_branch', auth()->user()->fc_branch)
        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
        ->where('fc_warehousepos', 'EXTERNAL')
        ->get();

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('sum_quantity', function ($row) {
            $groupedInvstore = Invstore::where('fc_warehousecode', $row->fc_warehousecode)
                ->selectRaw("SUBSTRING(fc_barcode, 1, 40) as grouped_barcode, COUNT(*) as count")
                ->groupBy('grouped_barcode')
                ->get();

            $sumQuantity = $groupedInvstore->count();
            
            return $sumQuantity;
        })
        ->make(true);
    }

    public function datatables_semua()
    {
        $data = Invstore::with('stock', 'warehouse')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->groupBy('fc_stockcode')
            ->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_quantity', function ($row) {
                $sumQuantity = Invstore::where('fc_stockcode', $row->fc_stockcode)
                    ->sum('fn_quantity');

                return $sumQuantity;
            })
            ->make(true);
    }

    public function datatables_inventory_dexa($fc_stockcode)
    {
        $data = Invstore::with(['stock', 'warehouse' => function($query) {
            $query->where('fc_warehousepos', 'INTERNAL');
        }])
        ->where('fc_stockcode', $fc_stockcode)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->get();
    
        $filteredData = $data->filter(function ($item) {
            return $item->warehouse !== null;
        });
    
        return DataTables::of($filteredData)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_inventory_gudanglain($fc_stockcode)
    {
        $data = Invstore::with('stock')->where('fc_stockcode', $fc_stockcode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf($fc_warehousecode)
    {
        $decode_fc_warehousecode = base64_decode($fc_warehousecode);
        session(['fc_warehousecode_global' => $decode_fc_warehousecode]);
        $data['gudang_mst']= Warehouse::where('fc_warehousecode', $decode_fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['gudang_dtl']= Invstore::with('stock')->where('fc_warehousecode', $decode_fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->get();

        $pdf = PDF::loadView('pdf.gudang', $data)->setPaper('a4');
        return $pdf->stream();
    }
}
