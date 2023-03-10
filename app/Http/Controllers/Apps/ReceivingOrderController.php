<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use DataTables;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\Invstore;
use App\Models\DoDetail;
use App\Models\DoMaster;

class ReceivingOrderController extends Controller
{
    public function index(){
        return view('apps.receiving-order.index');
    }
}