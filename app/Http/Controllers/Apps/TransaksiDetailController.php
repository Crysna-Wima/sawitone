<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Helpers\Convert;
use App\Models\MappingMaster;
use App\Models\MappingDetail;
use Carbon\Carbon;
use DB;
use App\Models\NotificationDetail;
use App\Models\TempTrxAccountingMaster;
use App\Models\TempTrxAccountingDetail;
use App\Models\TrxAccountingMaster;
use App\Models\TrxAccountingDetail;
use Validator;
use Auth;
use App\Helpers\ApiFormatter;
use App\Models\Approvement;
use App\Models\InvMaster;
use App\Models\InvoiceMst;
use App\Models\InvTrx;
use App\Models\MappingUser;
use App\Models\MasterCoa;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Round;
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

    public function get_coa($mappingMst){
        $fc_mappingcode = base64_decode($mappingMst); 

        $data = MappingDetail::with('mst_coa')
        ->where([
            'fc_mappingcode' => $fc_mappingcode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_mappingpos' => 'D',
        ])->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function get_coa_kredit($mappingMst){
        $fc_mappingcode = base64_decode($mappingMst); 

        $data = MappingDetail::with('mst_coa')
        ->where([
            'fc_mappingcode' => $fc_mappingcode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_mappingpos' => 'C',
        ])->get();

        if (empty($data)) {
            return [
                'status' => 200,
            ];
        }

        return ApiFormatter::getResponse($data);
    }

    public function delete($fc_coacode, $fn_rownum, $fc_balancerelation)
    {
        // decode
        $fc_balancerelation_decode = base64_decode($fc_balancerelation);
        DB::beginTransaction();

        try {
            if($fc_balancerelation_decode === '1 to N'){
                $deletedRow = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)
                ->where('fn_rownum', $fn_rownum)
                ->first();

                if (!$deletedRow) {
                    return [
                        'status' => 300,
                        'message' => 'Data tidak ditemukan'
                    ];
                }

                $isCredit = $deletedRow->fc_statuspos === 'C';
                $statusLawan = $isCredit ? 'D' : 'C'; // Status yang berlawanan dengan yang dihapus

                // Hitung jumlah nominal selain row yang dihapus
                $remainingNominal = TempTrxAccountingDetail::where('fn_rownum', '!=', $fn_rownum) 
                    ->where('fc_statuspos',  $deletedRow->fc_statuspos)
                    ->where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                    ->sum('fm_nominal');
                
                $countItem = TempTrxAccountingDetail::where('fc_statuspos',  $deletedRow->fc_statuspos)
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->count();

                    // dd($remainingNominal);
                $delete = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)
                    ->where('fn_rownum', $fn_rownum)
                    ->delete();

                if ($delete) {
                    // Update nominal di debit jika yang dihapus adalah kredit, atau sebaliknya
                    if ($isCredit) {
                        if($countItem < 2){
                            TempTrxAccountingDetail::where('fc_statuspos', $statusLawan)
                            ->where('fc_trxno', auth()->user()->fc_userid)
                            ->where('fc_branch', auth()->user()->fc_branch)
                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                            ->update([
                                'fm_nominal' => '0',
                            ]);
                        }else{
                            TempTrxAccountingDetail::where('fc_statuspos', $statusLawan)
                            ->where('fc_trxno', auth()->user()->fc_userid)
                            ->where('fc_branch', auth()->user()->fc_branch)
                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                            ->update([
                                'fm_nominal' => $remainingNominal,
                            ]);
                        }
                    
                    } else {
                        if($countItem < 2){
                            TempTrxAccountingDetail::where('fc_statuspos', $statusLawan)
                            ->where('fc_trxno', auth()->user()->fc_userid)
                            ->where('fc_branch', auth()->user()->fc_branch)
                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                            ->update([
                                'fm_nominal' => '0',
                            ]);
                        }else{
                            TempTrxAccountingDetail::where('fc_statuspos', $statusLawan)
                            ->where('fc_trxno', auth()->user()->fc_userid)
                            ->where('fc_branch', auth()->user()->fc_branch)
                            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                            ->update([
                                'fm_nominal' => $remainingNominal,
                            ]);
                        }
                    
                    }

                    DB::commit(); 
                    return response()->json([
                        'status' => 200,
                        'message' => 'Data berhasil dihapus'
                    ]);
                }

                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Error'
                ];
            }else{
                $delete = TempTrxAccountingDetail::where('fc_coacode', $fc_coacode)
                ->where('fn_rownum', $fn_rownum)
                ->delete();

                if ($delete) {
                    DB::commit(); 
                    return response()->json([
                        'status' => 200,
                        'message' => 'Data berhasil dihapus'
                    ]);
                }else{
                    DB::rollback(); 
                    return [
                        'status' => 300,
                        'message' => 'Terjadi Error Saat Delete Data'
                    ];
                }
            }
            
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    
    public function update_pembayaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_paymentmethod_edit' => 'required',
            'fn_rownum' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $update_pembayaran = TempTrxAccountingDetail::where([
            'fn_rownum' => $request->fn_rownum,
        ])->update([
            'fc_paymentmethod' => $request->fc_paymentmethod_edit,
            'fc_refno' => $request->fc_refno_edit,
            'fd_agingref' => $request->fd_agingref_edit
        ]);

        if ($update_pembayaran) {
            return [
                'status' => 200,
                'message' => 'Data berhasil diupdate'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Error'
        ];
    }

    public function edit_delete($fc_trxno, $fc_coacode, $fn_rownum)
    {
        DB::beginTransaction();

        try {
            $decode_fc_trxno = base64_decode($fc_trxno);
            $deletedRow = TrxAccountingDetail::where('fc_coacode', $fc_coacode)
                ->where('fn_rownum', $fn_rownum)
                ->first();

            if (!$deletedRow) {
                return [
                    'status' => 300,
                    'message' => 'Data tidak ditemukan'
                ];
            }

            $isCredit = $deletedRow->fc_statuspos === 'C';
            $statusLawan = $isCredit ? 'D' : 'C'; // Status yang berlawanan dengan yang dihapus

            // Hitung jumlah nominal selain row yang dihapus
            $remainingNominal = TrxAccountingDetail::where('fn_rownum', '!=', $fn_rownum) 
                ->where('fc_statuspos',  $deletedRow->fc_statuspos)
                ->where('fc_trxno', $decode_fc_trxno)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                ->sum('fm_nominal');
            
            $countItem = TrxAccountingDetail::where('fc_statuspos',  $deletedRow->fc_statuspos)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->where('fc_divisioncode', auth()->user()->fc_divisioncode)->count();

                // dd($remainingNominal);
            $delete = TrxAccountingDetail::where('fc_coacode', $fc_coacode)
                ->where('fn_rownum', $fn_rownum)
                ->delete();

            if ($delete) {
                // Update nominal di debit jika yang dihapus adalah kredit, atau sebaliknya
                if ($isCredit) {
                    if($countItem < 2){
                        TrxAccountingDetail::where('fc_statuspos', $statusLawan)
                        ->where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->update([
                            'fm_nominal' => '0',
                        ]);
                    }else{
                        TrxAccountingDetail::where('fc_statuspos', $statusLawan)
                        ->where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->update([
                            'fm_nominal' => $remainingNominal,
                        ]);
                    }
                   
                } else {
                    if($countItem < 2){
                        TrxAccountingDetail::where('fc_statuspos', $statusLawan)
                        ->where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->update([
                            'fm_nominal' => '0',
                        ]);
                    }else{
                        TrxAccountingDetail::where('fc_statuspos', $statusLawan)
                        ->where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_branch', auth()->user()->fc_branch)
                        ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
                        ->update([
                            'fm_nominal' => $remainingNominal,
                        ]);
                    }
                  
                }

                DB::commit(); 
                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil dihapus'
                ]);
            }

            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Error'
            ];
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function store_debit(Request $request){
        DB::beginTransaction();
    
        try {
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
                'fc_refno' => $request->fc_refno,
                'fd_agingref' => $request->fd_agingref,
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($insert_debit){
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function store_kredit(Request $request){
        DB::beginTransaction();
    
        try {
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
                'fc_refno' => $request->fc_refno_kredit,
                'fd_agingref' => $request->fd_agingref_kredit,
                'created_by' => auth()->user()->fc_userid
            ]);
    
            if($insert_kredit){
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback();
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function edit_debit(Request $request, string $fc_trxno){
        DB::beginTransaction();
    
        try {
            $decode_fc_trxno = base64_decode($fc_trxno);
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
    
            $temp_detail = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }
    
            $insert_debit = TrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => $decode_fc_trxno,
                'fn_rownum' => $fn_rownum,
                'fc_coacode' => $request->fc_coacode,
                'fc_statuspos' => 'D',
                'fc_paymentmethod' => $request->fc_paymentmethod,
                'fc_refno' => $request->fc_refno,
                'fd_agingref' => $request->fd_agingref,
                'created_by' => auth()->user()->fc_userid
            ]);

            if($insert_debit){
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];  
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function edit_kredit(Request $request, string $fc_trxno){
        DB::beginTransaction();
    
        try {
            $decode_fc_trxno = base64_decode($fc_trxno);
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
    
            $temp_detail = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)->orderBy('fn_rownum', 'DESC')->first();
            $fn_rownum = 1;
            if (!empty($temp_detail)) {
                $fn_rownum = $temp_detail->fn_rownum + 1;
            }
    
            $insert_kredit = TrxAccountingDetail::create([
                'fc_branch' => auth()->user()->fc_branch,
                'fc_divisioncode' => auth()->user()->fc_divisioncode,
                'fc_trxno' => $decode_fc_trxno,
                'fc_coacode' => $request->fc_coacode_kredit,
                'fn_rownum' => $fn_rownum,
                'fc_statuspos' => 'C',
                'fc_paymentmethod' => $request->fc_paymentmethod_kredit,
                'fc_refno' => $request->fc_refno_kredit,
                'fd_agingref' => $request->fd_agingref_kredit,
                'created_by' => auth()->user()->fc_userid
            ]);

            if($insert_kredit){
                DB::commit(); 
                return [
                    'status' => 200,
                    'message' => 'Data berhasil disimpan'
                ];
            }else{
                DB::rollback(); 
                return [
                    'status' => 300,
                    'message' => 'Data gagal disimpan'
                ];  
            }
        } catch (\Exception $e) {
            DB::rollback(); 
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function update_edit_debit_transaksi(Request $request, string $fc_trxno){
        $decode_fc_trxno = base64_decode($fc_trxno);
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

        $invtrx = $this->validateAndUpdateInvoice($request);

        if (is_array($invtrx)) {
            return $invtrx;
        } 
    
        DB::beginTransaction();
    
        try {
            if($request->fc_balancerelation === '1 to N'){
                // Hitung jumlah nominal dari baris dengan fc_trxno yang sama dan fc_statuspos 'D'
                $totalNominalDLama = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                    ->where('fn_rownum', '!=', $request->fn_rownum) // kecuali fn_rownum request
                    ->where('fc_statuspos', 'D')
                    ->sum('fm_nominal');
        
                // Update data pada TempTrxAccountingDetail dengan fc_statuspos 'D'
                $updateD = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                    ->where('fn_rownum', $request->fn_rownum)
                    ->where('fc_statuspos', 'D')
                    ->update([
                        'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
                        'fv_description' => $request->fv_description,
                        'updated_by' => auth()->user()->fc_userid
                    ]);
        
                if ($updateD) {
                    // Update semua baris dengan fc_trxno yang sama dan fc_statuspos 'C' dengan total nominal dari 'D'
                    $updateC = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_statuspos', 'C')
                        ->update([
                            'fm_nominal' => Convert::convert_to_double($totalNominalDLama)+ Convert::convert_to_double($request->fm_nominal),
                            'updated_by' => auth()->user()->fc_userid
                        ]);
        
                    if ($updateC) {
                        DB::commit();
                        return [
                            'status' => 200,
                            'message' => 'Data berhasil diubah'
                        ];
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Data gagal diubah'
                        ];
                    }
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diubah'
                    ];
                }
            }else{
                $updateD = TempTrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                    ->where('fn_rownum', $request->fn_rownum)
                    ->where('fc_statuspos', 'D')
                    ->update([
                        'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
                        'fv_description' => $request->fv_description,
                        'updated_by' => auth()->user()->fc_userid
                    ]);
                
                if ($updateD) {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diubah'
                    ];
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Data debit gagal diubah'
                    ];
                }
                // dd($request);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function update_edit_kredit_transaksi(Request $request, string $fc_trxno){
        $decode_fc_trxno = base64_decode($fc_trxno);
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

        $invtrx = $this->validateAndUpdateInvoice($request);

        if (is_array($invtrx)) {
            return $invtrx;
        } 

        DB::beginTransaction();
    
        try {
            
          if($request->fc_balancerelation === '1 to N'){
            // Hitung jumlah nominal dari baris dengan fc_trxno yang sama dan fc_statuspos 'C'
            $totalNominalCLama = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
            ->where('fn_rownum', '!=', $request->fn_rownum) // kecuali fn_rownum request
            ->where('fc_statuspos', 'C')
            ->sum('fm_nominal');
    
            // Update data pada TempTrxAccountingDetail dengan fc_statuspos 'C'
            $updateC = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                ->where('fn_rownum', $request->fn_rownum)
                ->where('fc_statuspos', 'C')
                ->update([
                    'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
                    'fv_description' => $request->fv_description,
                    'updated_by' => auth()->user()->fc_userid
                ]);
    
                if ($updateC) {
                    // Update semua baris dengan fc_trxno yang sama dan fc_statuspos 'D' dengan total nominal dari 'C'
                    $updateD = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                        ->where('fc_statuspos', 'D')
                        ->update([
                            'fm_nominal' => Convert::convert_to_double($totalNominalCLama) + Convert::convert_to_double($request->fm_nominal),
                            'updated_by' => auth()->user()->fc_userid
                        ]);
        
                    if ($updateD) {
                        DB::commit();
                        return [
                            'status' => 200,
                            'message' => 'Data berhasil diubah'
                        ];
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Data gagal diubah'
                        ];
                    }
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diubah'
                    ];
                }
          }else{
            $updateC = TempTrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                    ->where('fn_rownum', $request->fn_rownum)
                    ->where('fc_statuspos', 'C')
                    ->update([
                        'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
                        'fv_description' => $request->fv_description,
                        'updated_by' => auth()->user()->fc_userid
                    ]);
                
                if ($updateC) {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diubah'
                    ];
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Data kredit gagal diubah'
                    ];
                }
          }
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
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
        
        $invtrx = $this->validateAndUpdateInvoice($request);

        if (is_array($invtrx)) {
            return $invtrx;
        } 

        DB::beginTransaction();
    
        try {
            if($request->fc_balancerelation === '1 to N'){
                        // Hitung jumlah nominal dari baris dengan fc_trxno yang sama dan fc_statuspos 'D'
                    $totalNominalDLama = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fn_rownum', '!=', $request->fn_rownum) // kecuali fn_rownum request
                    ->where('fc_statuspos', 'D')
                    ->sum('fm_nominal');

                // Update data pada TempTrxAccountingDetail dengan fc_statuspos 'D'
                $updateD = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fn_rownum', $request->fn_rownum)
                    ->where('fc_statuspos', 'D')
                    ->update([
                        'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
                        'fv_description' => $request->fv_description,
                        'updated_by' => auth()->user()->fc_userid
                    ]);

                if ($updateD) {
                    // Update semua baris dengan fc_trxno yang sama dan fc_statuspos 'C' dengan total nominal dari 'D'
                    $updateC = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                        ->where('fc_statuspos', 'C')
                        ->update([
                            'fm_nominal' => Convert::convert_to_double($totalNominalDLama)+ Convert::convert_to_double($request->fm_nominal),
                            'updated_by' => auth()->user()->fc_userid
                        ]);

                    if ($updateC) {
                        DB::commit();
                        return [
                            'status' => 200,
                            'message' => 'Data berhasil diubah'
                        ];
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Data gagal diubah'
                        ];
                    }
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diubah'
                    ];
                }
            }else{
                $updateD = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fn_rownum', $request->fn_rownum)
                    ->where('fc_statuspos', 'D')
                    ->update([
                        'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
                        'fv_description' => $request->fv_description,
                        'updated_by' => auth()->user()->fc_userid
                    ]);
                
                if ($updateD) {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diubah'
                    ];
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Data debit gagal diubah'
                    ];
                }
            }
            
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
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

        $invtrx = $this->validateAndUpdateInvoice($request);

        if (is_array($invtrx)) {
            return $invtrx;
        } 
    
        DB::beginTransaction();
    
        try {
            if($request-> fc_balancerelation === '1 to N'){
                 // Hitung jumlah nominal dari baris dengan fc_trxno yang sama dan fc_statuspos 'C'
                $totalNominalCLama = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                ->where('fn_rownum', '!=', $request->fn_rownum) // kecuali fn_rownum request
                ->where('fc_statuspos', 'C')
                ->sum('fm_nominal');
        
                // Update data pada TempTrxAccountingDetail dengan fc_statuspos 'C'
                $updateC = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fn_rownum', $request->fn_rownum)
                    ->where('fc_statuspos', 'C')
                    ->update([
                        'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
                        'fv_description' => $request->fv_description,
                        'updated_by' => auth()->user()->fc_userid
                    ]);
        
                if ($updateC) {
                
                    // Update semua baris dengan fc_trxno yang sama dan fc_statuspos 'D' dengan total nominal dari 'C'
                    $updateD = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                        ->where('fc_statuspos', 'D')
                        ->update([
                            'fm_nominal' => Convert::convert_to_double($totalNominalCLama) + Convert::convert_to_double($request->fm_nominal),
                            'updated_by' => auth()->user()->fc_userid
                        ]);
        
                    if ($updateD) {
                        DB::commit();
                        return [
                            'status' => 200,
                            'message' => 'Data berhasil diubah'
                        ];
                    } else {
                        DB::rollback();
                        return [
                            'status' => 300,
                            'message' => 'Data gagal diubah'
                        ];
                    }
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Data gagal diubah'
                    ];
                }
            }else{
                $updateC = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fn_rownum', $request->fn_rownum)
                    ->where('fc_statuspos', 'C')
                    ->update([
                        'fm_nominal' => Convert::convert_to_double($request->fm_nominal),
                        'fv_description' => $request->fv_description,
                        'updated_by' => auth()->user()->fc_userid
                    ]);
                
                if ($updateC) {
                    DB::commit();
                    return [
                        'status' => 200,
                        'message' => 'Data berhasil diubah'
                    ];
                } else {
                    DB::rollback();
                    return [
                        'status' => 300,
                        'message' => 'Data kredit gagal diubah'
                    ];
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return [
                'status' => 300,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ];
        }
    }

    public function submit_transaksi(Request $request){
        // validator
        $validator = Validator::make($request->all(), [
            'status_balance' => 'required',
            'tipe_jurnal' => 'required',
            'jumlah_balance' => 'required'
        ], [
            'status_balance.required' => 'Nominal Debit dan Kredit masih 0',
            'jumlah_balance.required' => 'Debit dan Kredit belum Balance, '
        ]);
    
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
    
        DB::beginTransaction();
        try {
            // Fetch TempTrxAccountingMaster
            $temp_master = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
                ->where('fc_branch', auth()->user()->fc_branch)->first();
    
            // Fetch InvMaster
            $invmst = InvMaster::where('fc_invno', $temp_master->fc_docreference)
                ->where('fc_branch', auth()->user()->fc_branch)->first();
    
            // Fetch temp detail count
            $exist_detail = TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                ->where('fm_nominal', '!=', 0)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->count();
    
            if ($exist_detail < 1) {
                throw new \Exception('Oops! Item debit atau kredit tidak boleh kosong');
            } else if ($request->status_balance == 'false') {
                throw new \Exception('Oops! Gagal submit karena tidak balance');
            } else {
                if ($request->tipe_jurnal == 'LREF') {
                    if ($request->jumlah_balance > ($invmst->fm_brutto - $invmst->fm_paidvalue)) {
                        throw new \Exception('Oops! Balance Transaksi melebihi tagihan yang tertera');
                    }
                }
    
                // Update TempTrxAccountingMaster
                $update = TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fc_branch', auth()->user()->fc_branch)->update([
                        'fc_status' => 'F',
                        'fv_description' => $request->fv_description_submit
                    ]);
    
                // Delete temp detail and master
                TempTrxAccountingDetail::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fc_branch', auth()->user()->fc_branch)->delete();
                TempTrxAccountingMaster::where('fc_trxno', auth()->user()->fc_userid)
                    ->where('fc_branch', auth()->user()->fc_branch)->delete();
    
                if (!$update) {
                    throw new \Exception('Oops! Gagal submit');
                }
    
                DB::commit();
    
                return [
                    'status' => 201,
                    'message' => 'Submit Berhasil',
                    'link' => '/apps/transaksi'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
    
            // Return error response
            return [
                'status' => 300,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function submit_edit(Request $request, string $fc_trxno){
        $decode_fc_trxno = base64_decode($fc_trxno);
        // validator
        $validator = Validator::make($request->all(), [
            'status_balance' => 'required',
            'tipe_jurnal' => 'required',
            'jumlah_balance' => 'required'
        ], [
            'status_balance.required' => 'Nominal Debit dan Kredit masih 0',
            'jumlah_balance.required' => 'Debit dan Kredit belum Balance, '
        ]);
    
        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
    
        DB::beginTransaction();
        try {
            // Fetch TempTrxAccountingMaster
            $temp_master = TrxAccountingMaster::where('fc_trxno', $decode_fc_trxno)
                ->where('fc_branch', auth()->user()->fc_branch)->first();
    
            // Fetch InvMaster
            $invmst = InvMaster::where('fc_invno', $temp_master->fc_docreference)
                ->where('fc_branch', auth()->user()->fc_branch)->first();
    
            // Fetch temp detail count
            $exist_detail = TrxAccountingDetail::where('fc_trxno', $decode_fc_trxno)
                ->where('fm_nominal', '!=', 0)
                ->where('fc_branch', auth()->user()->fc_branch)
                ->count();
    
            if ($exist_detail < 1) {
                throw new \Exception('Oops! Item debit atau kredit tidak boleh kosong');
            } else if ($request->status_balance == 'false') {
                throw new \Exception('Oops! Gagal submit karena tidak balance');
            } else {
                if ($request->tipe_jurnal == 'LREF') {
                    if ($request->jumlah_balance > ($invmst->fm_brutto - $invmst->fm_paidvalue)) {
                        throw new \Exception('Oops! Balance Transaksi melebihi tagihan yang tertera');
                    }
                }
    
                // Update TrxAccountingMaster
                $update = [TrxAccountingMaster::where('fc_trxno', $decode_fc_trxno)
                    ->where('fc_branch', auth()->user()->fc_branch)->update([
                        'fc_status' => 'F',
                    ]), Approvement::where('fc_trxno', $decode_fc_trxno)
                    ->where('fc_approvalstatus', 'A')
                    ->where('fc_branch', auth()->user()->fc_branch)
                    ->update([
                        'fc_approvalused' => 'T',
                    ])];
    
                if (!$update) {
                    throw new \Exception('Oops! Gagal submit');
                }
    
                DB::commit();
    
                return [
                    'status' => 201,
                    'message' => 'Submit Berhasil',
                    'link' => '/apps/transaksi'
                ];
            }
        } catch (\Exception $e) {
            DB::rollback();
    
            // Return error response
            return [
                'status' => 300,
                'message' => $e->getMessage(),
            ];
        }
    } 

    private function validateAndUpdateInvoice($request){
        if ($request->fv_description !== null && str_contains($request->fv_description, 'INV/')) {
            $invtrx = InvTrx::where('fc_invno', $request->fv_description)->first();
            $currInv = TempTrxAccountingDetail::where([
                'fc_trxno' => Auth()->user()->fc_userid,
                'fn_rownum' => $request->fn_rownum,
                'fc_branch' => Auth()->user()->fc_branch,
                'fc_divisioncode' => Auth()->user()->fc_divisioncode
            ])->first();

            $totalPaid = $invtrx->fm_paidinvvalue + $invtrx->fm_paidtaxvalue;
            $totalInvoice = $invtrx->fm_invnetto + $invtrx->fm_taxvalue;

            // Convert Value Request to Correct type number 
            $currentNominal = str_replace(".", "", $request->fm_nominal);
            $currentNominal = str_replace(",", ".", $currentNominal);
            $currentNominal = (double) $currentNominal;
            
            if ($totalPaid + $currentNominal > $totalInvoice && (str_contains($currInv->fc_coacode, "310.311") || str_contains($currInv->fc_coacode, "130.131"))) {
                return [
                    'status' => 300,
                    'message' => 'Data gagal diubah, karena melebihi total INV'
                ];
            }
        } else {
            $invtrx = null;
        }

        return $invtrx;
    }
}
