<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingMaster;
use App\Models\MappingDetail;
use Carbon\Carbon;
use DB;
use App\Models\TrxAccountingMaster;
use App\Models\TempTrxAccountingMaster;
use App\Models\TempTrxAccountingDetail;
use Validator;
use Auth;
use App\Helpers\ApiFormatter;
use App\Models\InvoiceMst;
use App\Models\MappingUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiController extends Controller
{

    public function index()
    {
        return view('apps.transaksi.index');
    }

    public function bookmark_index(){
        return view('apps.transaksi.bookmark-index');
    }

    public function create()
    {
        $temp_trxaccounting_mst = TempTrxAccountingMaster::with('transaksitype', 'mapping', 'branch')->where('fc_trxno', auth()->user()->fc_userid)->first();
        $temp_trxaccounting_dtl = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->get();

        $total = count($temp_trxaccounting_dtl);
        if (!empty($temp_trxaccounting_mst)) {
            $data['data'] = $temp_trxaccounting_mst;
            $data['total'] = $total;

            return view('apps.transaksi.create-detail', $data);
            // dd($data);
        }
        return view('apps.transaksi.create-index');
    }

    public function get_detail($fc_mappingcode)
    {
        $mappingcode = base64_decode($fc_mappingcode);

        $data = MappingMaster::with('tipe','transaksi')
            ->where([
                'fc_mappingcode' =>  $mappingcode,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
            ])
            ->first();

        return ApiFormatter::getResponse($data);
    }

    public function datatables(){
        $data = TrxAccountingMaster::with('transaksitype', 'mapping')->where('fc_status', 'F')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_bookmark(){
        $data = TempTrxAccountingMaster::with('transaksitype', 'mapping')
        ->where('fc_status', 'P')
        ->where('fc_userid', auth()->user()->fc_userid)
        ->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_mapping()
    {
        $data = MappingUser::with('mappingmst.tipe', 'mappingmst.transaksi','user')->where('fc_userid', auth()->user()->fc_userid)->where('fc_hold', 'F')->where('fc_branch', auth()->user()->fc_branch)->get();


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

    public function datatables_invoice(){
        $data = InvoiceMst::with('domst','pomst', 'somst', 'romst', 'supplier', 'customer')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function store_update(Request $request)
    {
        // validator
        $validator = Validator::make($request->all(), [
            'fc_mappingcode' => 'required',
            'fc_docreference' => 'required_if:fc_informtrx,==,LREF',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $temp_trxaccounting_mst = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->first();

        if (empty($temp_trxaccounting_mst)) {
            $insert = TempTrxAccountingMaster::create([
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_branch' => auth()->user()->fc_branch,
                'fc_trxno' => auth()->user()->fc_userid,
                'fc_mappingcode' => $request->fc_mappingcode,
                'fc_mappingtrxtype' => $request->fc_mappingtrxtype_hidden,
                'fc_docreference' => $request->fc_docreference !== null ? $request->fc_docreference : "",
                'fc_status' => 'I',
                'fd_trxdate_byuser' => date('Y-m-d H:i:s', strtotime($request->fd_trxdate_byuser)),
                'fc_userid' => auth()->user()->fc_userid,
            ]);

            if ($insert) {
                return [
                    'status' => 201,
                    'message' => 'Data berhasil disimpan',
                    'link' => '/apps/transaksi/create-index'
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

    public function lanjutkan_bookmark($fc_trxno){
        //decode
        $trxno = base64_decode($fc_trxno);
        $exist_data = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
        ->where('fc_branch', auth()->user()->fc_branch)
        ->count();

        if($exist_data > 0){
            return [
                'status' => 300,
                'message' => 'Terdapat input transaksi yang belum selesai'
            ];
        }

        $update = TempTrxAccountingMaster::where('fc_trxno', $trxno)->update([
            'fc_status' => 'I',
            'fc_trxno' => auth()->user()->fc_userid,
        ]);
        
        if ($update) {
            // return response
            return[
                'status' => 201,
                'message' =>'success',
                'link' => '/apps/transaksi/create-index'
            ];
        } else {
            return[
                'status' => 300,
                'message' =>'failed'
            ];
        }

    }

    public function pending(Request $request)
    {
        $data = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)->update([
                'fc_status' => 'P',
                'fv_description' => $request->fv_description
            ]);

        if ($data) {
            return [
                'status' => 200,
                'message' => 'Data berhasil di Pending',
                'link' => '/apps/transaksi'
            ];
        } else {
            return [
                'status' => 300,
                'message' => 'Data gagal di Pending'
            ];
        }
    }

    public function cancel_transaksi(){
        DB::beginTransaction();

		try{
            TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->delete();
            TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)->where('fc_branch', auth()->user()->fc_branch)->delete();

			DB::commit();

			return [
				'status' => 201, // SUCCESS
                'link' => '/apps/transaksi',
				'message' => 'Data berhasil dicancel'
			];
		}

		catch(\Exception $e){

			DB::rollback();

			return [
				'status' 	=> 300, // GAGAL
				'message'       => (env('APP_DEBUG', 'true') == 'true')? $e->getMessage() : 'Operation error'
			];

		}
    }

    public function submit_transaksi(Request $request){

    }
}
