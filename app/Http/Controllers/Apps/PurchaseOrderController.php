<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use DataTables;
use Carbon\Carbon;
use File;
use DB;

class PurchaseOrderController extends Controller
{
    public function index(){
        return view('apps.purchase-order.index');
    }
}

