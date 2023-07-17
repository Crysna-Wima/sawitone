<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\TempReturMaster;
use App\Models\TempReturDetail;
use DB;
use Validator;

class ReturBarangDetailController extends Controller
{
    public function datatables()
    {
        $data = TempReturDetail::where('fc_returno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
