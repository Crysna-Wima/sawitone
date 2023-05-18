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

class MutasiBarangController extends Controller
{
    public function index()
    {
        return view('apps.mutasi-barang.index');
    }
}
