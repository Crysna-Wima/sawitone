<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\ApiFormatter;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use File;
use DB;

use Yajra\DataTables\DataTables as DataTables;
use App\Models\TempMutasiDetail;
use App\Models\Invstore;

class MutasiBarangDetailController extends Controller
{
    public function datatables_inventory()
    {
        $data = Invstore::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables()
    {
        $data = TempMutasiDetail::with('warehouse')->where('fc_mutationno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}

