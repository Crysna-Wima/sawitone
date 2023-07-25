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

class MasterMappingController extends Controller
{

    public function index()
    {
        return view('apps.master-mapping.index');
    }

    public function datatables()
    {
        $data = MappingMaster::where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('sum_debit', function ($row) {
                $sum_debit = MappingDetail::where('fc_mappingpos', "D")
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_mappingcode', $row->fc_mappingcode)
                    ->count();
    
                return $sum_debit;
            })
            ->addColumn('sum_credit', function ($row) {
                $sum_credit = MappingDetail::where('fc_mappingpos', "C")
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_mappingcode', $row->fc_mappingcode)
                    ->count();
    
                return $sum_credit;
            })
            ->make(true);
        // dd($data);
    }

    public function store_update(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fc_mappingcode' => 'required|unique:t_mappingmst,fc_mappingcode',
            'fc_mappingname' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $mapping_mst = MappingMaster::where('fc_mappingcode', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();

        if (empty($mapping_mst)) {
            // create TempInvoiceMst
            $insert = MappingMaster::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_mappingname' => $request->fc_mappingname,
                'fc_status' => 'I',
                'fv_desription' => $request->fv_desription,
                'created_by' => auth()->user()->fc_userid,
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/master-mapping/create'
                ];
            } else {
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } else {
            return [
                'status' => 300,
                'message' => 'Data sudah ada'
            ];
        }
    }
}
