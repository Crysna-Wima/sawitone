<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\RoDetail;
use App\Models\RoMaster;

use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class MasterInvoiceDetailController extends Controller
{
    public function create()
    {
        $data['data'] = RoMaster::with('pomst.supplier')->where('fc_branch', auth()->user()->fc_branch)->get();
        return view('apps.master-invoice.create-index', $data);
    }
}
