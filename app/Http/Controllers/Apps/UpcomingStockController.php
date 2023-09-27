<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\PoDetail;
use Carbon\Carbon;
use DB;
use Validator;
use Auth;
use App\Helpers\ApiFormatter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UpcomingStockController extends Controller
{

    public function index()
    {
        return view('apps.upcoming-stock.index');
    }

    public function datatables()
    {
        // $data = PoDetail::with('pomst', 'stock')
        // ->where('fc_branch', auth()->user()->fc_branch)
        // ->groupBy('fc_stockcode')
        // ->orderBy('fc_stockcode')
        // ->get();
        $data = DB::select("SELECT a.fc_stockcode, COUNT(a.fc_stockcode), c.fc_namelong, c.fc_namepack 
        FROM db_dexa.t_podtl a
        LEFT OUTER JOIN db_dexa.t_pomst b ON a.fc_pono = b.fc_pono
        LEFT OUTER JOIN db_dexa.t_stock c ON a.fc_stockcode = c.fc_stockcode
        WHERE b.fd_poexpired >= SYSDATE()
        AND (a.fn_po_qty - a.fn_ro_qty) > 0
        GROUP BY a.fc_stockcode
        ORDER BY a.fc_stockcode;");

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_detail($fc_stockcode)
    {
        $decode_fc_stockcode = base64_decode($fc_stockcode);
        $data = DB::select("SELECT a.fc_stockcode, d.fc_namelong, d.fc_namepack, (a.fn_po_qty - a.fn_ro_qty) AS QTY, 
            a.fc_pono, e.fc_suppliername1, b.fd_poexpired AS Kedatangan  FROM db_dexa.t_podtl a
            LEFT OUTER JOIN db_dexa.t_pomst  b ON a.fc_pono = b.fc_pono
            LEFT OUTER JOIN db_dexa.t_supplier c ON b.fc_suppliercode = c.fc_suppliercode
            LEFT OUTER JOIN db_dexa.t_stock d ON d.fc_stockcode = a.fc_stockcode
            LEFT OUTER JOIN db_dexa.t_supplier e ON b.fc_suppliercode = e.fc_suppliercode
            WHERE a.fc_stockcode = $decode_fc_stockcode
            AND b.fd_poexpired >= SYSDATE()
            AND ((a.fn_po_qty - a.fn_ro_qty) > 0);
        ");

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }
}
