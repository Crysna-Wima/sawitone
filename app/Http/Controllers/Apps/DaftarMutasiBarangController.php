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

    public function detail($fc_mutationno){
        // kalau encode pakai base64_encode
        // kalau decode pakai base64_decode
        $encoded_fc_mutationno = base64_decode($fc_mutationno);
        session(['fc_mutationno_global' => $encoded_fc_mutationno]);
        $data['mutasi_mst'] = MutasiMaster::with('warehouse_start', 'warehouse_destination')->where('fc_mutationno', $encoded_fc_mutationno)->where('fc_branch', auth()->user()->fc_branch)->first();
        return view('apps.daftar-mutasi-barang.detail', $data);
        // dd($data);
    }
    
    public function datatables()
    {
        $data = MutasiDetail::with('invstore', 'stock')->where('fc_mutationno', session('fc_mutationno_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
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

    public function datatables_belum_terlaksana()
    {
        $data = MutasiMaster::with('warehouse')->where('fc_branch', auth()->user()->fc_branch)->get();
        // $data = MutasiDetail::with('stock')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
