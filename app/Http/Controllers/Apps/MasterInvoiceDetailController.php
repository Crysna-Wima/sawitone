<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\InvMaster;
use App\Models\RoDetail;
use App\Models\RoMaster;

use DB;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class MasterInvoiceDetailController extends Controller
{
    public function create($fc_rono)
    {
        $data['ro_mst'] = RoMaster::with('pomst.supplier.supplier_tax_code')->where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['tipe_cabang'] = RoMaster::with('pomst.supplier.supplier_typebranch')->where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['tipe_bisnis'] = RoMaster::with('pomst.supplier.supplier_type_business')->where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['legal_status'] = RoMaster::with('pomst.supplier.supplier_legal_status')->where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();

        // jika ada InvMaster dimana 'fc_rono' sama dengan $fc_rono
        $count_inv_mst = InvMaster::where('fc_rono', $fc_rono)->where('fc_branch', auth()->user()->fc_branch)->count();

        if ($count_inv_mst === 0) {
            return view('apps.master-invoice.create-index', $data);
        }
         return view('apps.master-invoice.create-detail', $data);       
        // dd($data);
    }

    // incoming_insert
    public function incoming_insert(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_pono' => 'required',
            'fc_rono' => 'required',
            'fc_userid' => 'required',
            'fd_inv_releasedate' => 'required',
            'fd_inv_agingdate' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // fc_inv_agingday = $request->fd_inv_agingdate - $request->fd_inv_releasedate, konvert jumlah harinya
        $date1 = strtotime($request->fd_inv_releasedate);
        $date2 = strtotime($request->fd_inv_agingdate);
        $diff = abs($date2 - $date1);
        dd($diff);

        // insert into inv master
        // $insert_inv_mst = InvMaster::create([
        //     'fc_divisioncode' => auth()->user()->fc_divisioncode,
        //     'fc_branch' => auth()->user()->fc_branch,
        //     'fc_pono' => $request->fc_pono,
        //     'fc_rono' => $request->fc_rono,
        //     'fc_userid' => $request->fc_userid,
        //     'fd_inv_releasedate' => $request->fd_inv_releasedate,
        //     'fd_inv_agingdate' => $request->fd_inv_agingdate,
        //     'fc_status' => 'R',
        //     'fc_invtype' => 'INC',
        // ]);
    }

    public function datatables_ro()
    {

        $data = RoDetail::with('invstore.stock', 'romst')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


}
