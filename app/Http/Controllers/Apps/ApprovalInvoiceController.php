<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiFormatter;
use Carbon\Carbon;
use Yajra\DataTables\DataTables as DataTables;
use File;
use DB;

use App\Models\Approvement;
use App\Models\TrxAccountingMaster;
use App\Models\TrxAccountingDetail;

class ApprovalInvoiceController extends Controller
{

    public function index(){
        return view('apps.approval-invoice.index');
    }
}
