<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\InvMaster;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MasterInvoiceController extends Controller
{
    public function index(){
        return view('apps.master-invoice.index');
    }

    public function datatables(){
        $data = InvMaster::with('domst')->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }
}
