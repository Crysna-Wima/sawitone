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

    public function datatables_satuan()
    {
        $data = TempStockOpnameDetail::with('invstore.stock')->where('fc_stockopname_no', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
