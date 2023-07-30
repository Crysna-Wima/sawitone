<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\MappingMaster;
use App\Models\MappingDetail;
use Carbon\Carbon;
use DB;
use App\Models\NotificationDetail;
use App\Models\TempTrxAccountingMaster;
use App\Models\TempTrxAccountingDetail;
use Validator;
use Auth;
use App\Helpers\ApiFormatter;
use App\Models\InvoiceMst;
use App\Models\MappingUser;
use App\Models\MasterCoa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransaksiDetailController extends Controller
{
    public function datatables(){
        $data = TempTrxAccountingDetail::with('coamst', 'payment')->where('fc_branch', auth()->user()->fc_branch)->where('fc_trxno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_debit(){
        $data = TempTrxAccountingDetail::with('coamst', 'payment')->where('fc_statuspos', 'D')->where('fc_branch', auth()->user()->fc_branch)->where('fc_trxno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_kredit(){
        $data = TempTrxAccountingDetail::with('coamst', 'payment')->where('fc_statuspos', 'C')->where('fc_branch', auth()->user()->fc_branch)->where('fc_trxno', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function get_data_coa($coacode)
    {
        $fc_coacode = base64_decode($coacode);

        $data = MappingDetail::with('mst_coa.transaksitype')->where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_coacode' => $fc_coacode,
        ])
            ->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_data_coa_kredit($coacode)
    {
        $fc_coacode = base64_decode($coacode);

        $data = MappingDetail::with('mst_coa.transaksitype')->where([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_coacode' => $fc_coacode,
        ])
            ->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_coa()
    {
        $data = MappingDetail::with('mst_coa')->where('fc_branch', auth()->user()->fc_branch)->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_coa_kredit()
    {
        $data = MappingDetail::with('mst_coa')->where('fc_branch', auth()->user()->fc_branch)->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function delete($fc_coacode, $fn_rownum)
    {
        // hitung jumlah data di TempPoDetail
        $count_trx_dtl = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)->where('fc_branch', auth()->user()->fc_branch)->count();
        $delete = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)->where('fn_rownum', $fn_rownum)->delete();
        if ($delete) {
            if($count_trx_dtl < 2){
                return response()->json([
                    'status' => 201,
                    'message' => 'Data berhasil dihapus',
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ]);
        }
        return [
            'status' => 300,
            'message' => 'Error'
        ];
    }

    public function store_debit(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_coacode' => 'required',
            'fc_paymentmethod' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $temp_detail = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
        $fn_rownum = 1;
        if (!empty($temp_detail)) {
            $fn_rownum = $temp_detail->fn_rownum + 1;
        }

        $insert_debit = TempTrxAccountingDetail::create([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_trxno' => auth()->user()->fc_userid,
            'fn_rownum' => $fn_rownum,
            'fc_coacode' => $request->fc_coacode,
            'fc_statuspos' => 'D',
            'fc_paymentmethod' => $request->fc_paymentmethod,
            'created_by' => auth()->user()->fc_userid
        ]);

        if($insert_debit){
            return [
                'status' => 200,
                'message' => 'Data berhasil disimpan'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal disimpan'
            ];
        }
    }

    public function store_kredit(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_coacode_kredit' => 'required',
            'fc_paymentmethod_kredit' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $temp_detail = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)->orderBy('fn_rownum', 'DESC')->first();
        $fn_rownum = 1;
        if (!empty($temp_detail)) {
            $fn_rownum = $temp_detail->fn_rownum + 1;
        }

        $insert_kredit = TempTrxAccountingDetail::create([
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_trxno' => auth()->user()->fc_userid,
            'fc_coacode' => $request->fc_coacode_kredit,
            'fn_rownum' => $fn_rownum,
            'fc_statuspos' => 'C',
            'fc_paymentmethod' => $request->fc_paymentmethod_kredit,
            'created_by' => auth()->user()->fc_userid
        ]);

        if($insert_kredit){
            return [
                'status' => 200,
                'message' => 'Data berhasil disimpan'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal disimpan'
            ];
        }
    }

    public function update_debit_transaksi(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fn_rownum' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // update data
        $update = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
        ->where('fn_rownum', $request->fn_rownum)
        ->where('fc_statuspos', 'D')->update([
            'fm_nominal' => $request->fm_nominal,
            'fv_description' => $request->fv_description,
            'updated_by' => auth()->user()->fc_userid
        ]);

        if($update){
            return [
                'status' => 200,
                'message' => 'Data berhasil diubah'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal diubah'
            ];
        }
    }

    public function update_kredit_transaksi(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'fn_rownum' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // update data
        $update = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
        ->where('fn_rownum', $request->fn_rownum)
        ->where('fc_statuspos', 'C')->update([
            'fm_nominal' => $request->fm_nominal,
            'fv_description' => $request->fv_description,
            'updated_by' => auth()->user()->fc_userid
        ]);

        if($update){
            return [
                'status' => 200,
                'message' => 'Data berhasil diubah'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal diubah'
            ];
        }
    }
}
