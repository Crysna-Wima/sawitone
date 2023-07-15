<?php

namespace App\Http\Controllers\Apps;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DoMaster;
use App\Models\DoDetail;
use Carbon\Carbon;
use DateTime;
use DB;
use Validator;

class ReturBarangDetailController extends Controller
{
    public function index(){
        return view('apps.retur-barang.index');     
    }
}
