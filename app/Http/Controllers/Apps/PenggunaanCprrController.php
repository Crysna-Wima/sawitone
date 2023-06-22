<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\Invstore;
use App\Models\Warehouse;
use App\Models\Stock;
use Yajra\DataTables\DataTables;

class PenggunaanCprrController extends Controller
{

    public function index(){
        return view('apps.penggunaan-cprr.index');
        // dd($do_master);
    }
}
