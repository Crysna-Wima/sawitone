<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DB;

use App\Models\GoodReception;
use Yajra\DataTables\DataTables as DataTables;

class MasterPenerimaanBarangController extends Controller
{

    public function index()
    {
        return view('apps.master-penerimaan-barang.index');
    }

    public function datatables()
{
        $data = GoodReception::where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
