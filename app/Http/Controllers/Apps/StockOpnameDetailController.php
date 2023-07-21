<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

use App\Models\StockOpname;
use App\Models\TempStockOpnameDetail;
use App\Models\Warehouse;

use Carbon\Carbon;
use DateTime;
use DB;
use Validator;
use App\Helpers\ApiFormatter;
use App\Models\Invstore;

class StockOpnameDetailController extends Controller
{
    public function datatables()
    {
        $data = TempStockOpnameDetail::with('invstore.stock')->where('fc_stockopname_no', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatable_inventory($fc_warehousecode){
        // decode fc_warehousecode
        $fc_warehousecode = base64_decode($fc_warehousecode);
        $data = Invstore::with('stock')->where('fc_warehousecode',$fc_warehousecode)->where('fc_branch', auth()->user()->fc_branch)->get();
        
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function lock_update(Request $request){
            // dd($request);
            if($request->tipe == 'lock'){
                   $data = TempStockOpnameDetail::where('fn_rownum', $request->fn_rownum)
                ->where('fc_stockopname_no', auth()->user()->fc_userid)->update([
                    'fc_status' => 'L',
                    'fn_quantity' => $request->fn_quantity,
                ]);

                if($data){
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diupdate'
                    ];
                }else{
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diupdate'
                    ];
                }
            }else{
               $data = TempStockOpnameDetail::where('fn_rownum', $request->fn_rownum)
                ->where('fc_stockopname_no', auth()->user()->fc_userid)->update([
                    'fc_status' => 'U',
                    // 'fn_quantity' => $request->fn_quantity,
                ]); 

                if($data){
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diupdate'
                    ];
                }else{
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diupdate'
                    ];
                }
            }
        
        // 
    }


    public function datatables_satuan()
    {
        $data = TempStockOpnameDetail::with('invstore.stock')->where('fc_stockopname_no', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

}
