<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use App\Models\DoDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\TempReturMaster;
use App\Models\TempReturDetail;
use DB;
use Validator;
use App\Helpers\ApiFormatter;

class ReturBarangDetailController extends Controller
{
    public function datatables()
    {
        $data = TempReturDetail::where('fc_returno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_do_detail($fc_dono)
    {
        $decode_dono = base64_decode($fc_dono);
        $data = DoDetail::with('invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->where('fc_dono', $decode_dono)->get();

        // dd($data);
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
