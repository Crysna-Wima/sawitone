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
        $data = Invstore::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_gudanglain()
    {
        $data = Invstore::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
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
