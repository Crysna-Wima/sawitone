<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Convert;
use App\Models\MutasiMaster;
use App\Models\MutasiDetail;
use Validator;
use PDF;

use Carbon\Carbon;
use DB;
use Yajra\DataTables\DataTables;

class DaftarMutasiBarangController extends Controller
{
    public function index()
    {
        return view('apps.daftar-mutasi-barang.index');
    }

    public function datatables_internal()
    {
        $data = MutasiMaster::with('warehouse')->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_type_mutation', 'INTERNAL')
            ->get();
        // $data = MutasiDetail::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_eksternal()
    {
        $data = MutasiMaster::with('warehouse')->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_type_mutation', 'EKSTERNAL')
            ->get();
        // $data = MutasiDetail::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
