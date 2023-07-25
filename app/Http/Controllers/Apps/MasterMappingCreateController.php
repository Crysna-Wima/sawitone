<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingDetail;
use App\Models\MappingMaster;

use Carbon\Carbon;
use DB;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MasterMappingCreateController extends Controller
{
    public function create($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $data['data'] = MappingMaster::where('fc_branch', auth()->user()->fc_branch)->where('fc_mappingcode', $encoded_fc_mappingcode)->first();

        return view('apps.master-mapping.create', $data);
    }

    public function datatables_debit($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $data = MappingDetail::where('fc_mappingcode', $encoded_fc_mappingcode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_kredit($fc_mappingcode)
    {
        $encoded_fc_mappingcode = base64_decode($fc_mappingcode);
        $data = MappingDetail::where('fc_mappingcode', $encoded_fc_mappingcode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }
}
