<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingMaster;
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
        return view('apps.transaksi.index');
    }

    public function create()
    {
        return view('apps.transaksi.create-index');
    }

    public function select_mapping($fc_mappingcode)
    {
        $fc_mappingcode = base64_decode($fc_mappingcode);
        $data = MappingMaster::where('fc_branch', auth()->user()->fc_branch)->where('fc_mappingcode', $fc_mappingcode)->first();
        // retur json
        return response()->json(
            [
                'data' => $data,
                'status' => 'success'
            ]
        );
    }
}
