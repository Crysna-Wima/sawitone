<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;

use Carbon\Carbon;
use DB;
use App\Models\NotificationDetail;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{

    public function index()
    {
        return view('apps.pembayaran-pelunasan.index');
    }
}
