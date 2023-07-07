<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Convert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

use PDF;
use App\Models\RoMaster;
use App\Models\RoDetail;
use App\Models\DoMaster;
use App\Models\DoDetail;
use App\Models\InvDetail;
use App\Models\InvMaster;
use App\Models\TransaksiType;
use Validator;

class InvoicePembelianController extends Controller
{
    public function index(){
        return view('apps.invoice-pembelian.index');     
    }
}
