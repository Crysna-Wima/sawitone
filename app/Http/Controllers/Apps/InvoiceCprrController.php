<?php

namespace App\Http\Controllers\Apps;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TempInvoiceDtl;
use App\Models\TempInvoiceMst;
use Carbon\Carbon;
use DateTime;
use DB;
use Validator;

class InvoiceCprrController extends Controller
{
    public function index(){
        $temp_inv_master = TempInvoiceMst::with('customer')->where('fc_invno', auth()->user()->fc_userid)->first();
        $temp_detail = TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)->get();
        $total = count($temp_detail);
        if(!empty($temp_inv_master)){
            $data['data'] = $temp_inv_master;
            $data['data']->fd_inv_releasedate = Carbon::createFromFormat('Y-m-d H:i:s',$temp_inv_master->fd_inv_releasedate,)->format('d-m-Y');
            $data['data']->fd_inv_agingdate = Carbon::createFromFormat('Y-m-d H:i:s',$temp_inv_master->fd_inv_agingdate,)->format('d-m-Y');
            $data['total'] = $total;
            return view('apps.invoice-cprr.detail',$data);
            // dd($data);
        }
        return view('apps.invoice-cprr.index');     
    }

    public function create(request $request){
        $validator = Validator::make( $request->all(), [
            'fc_membercode' => 'required',
            'fd_inv_releasedate' => 'required',
            'fd_inv_agingdate' => 'required',
            'fc_suppdocno' => 'required',
        ]);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' =>  $validator->errors()->first(),
            ];
        }

        $releaseDate = Carbon::createFromFormat('d-m-Y', $request->fd_inv_releasedate)->format('Y-m-d 00:00:00');
        $agingDate = Carbon::createFromFormat('d-m-Y', $request->fd_inv_agingdate)->format('Y-m-d 00:00:00');
        
        $from_date = Carbon::parse(date('Y-m-d', strtotime($releaseDate))); 
        $through_date = Carbon::parse(date('Y-m-d', strtotime($agingDate))); 
            
        // get total number of minutes between from and throung date
        $shift_difference = $from_date->diffInDays($through_date);

        $request->request->add(['fc_invno' => auth()->user()->fc_userid]);
        
        $createInv = TempInvoiceMst::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_invno' => auth()->user()->fc_userid,
            'fc_suppdocno' => $request->fc_suppdocno,
            'fc_entitycode' => $request->fc_membercode,
            'fd_inv_releasedate' => $releaseDate,
            'fd_inv_agingdate' => $agingDate,
            'fn_inv_agingday' => $shift_difference,
            'fc_userid' => auth()->user()->fc_userid,
            'fc_status' => 'I',
            'fc_invtype' => 'CPRR'
        ], $request->all());

        if($createInv){
            return response()->json([
                'status' => 201,
                'link' => '/apps/invoice-cprr',
                'message' => 'Data berhasil disimpan'
            ]);
         } else{
             return [
                 'status' => 300,
                 'link' => '/apps/invoice-cprr',
                 'message' => 'Error'
             ];
         }
        
    }

    public function delete(){
        DB::beginTransaction();

		try{
            TempInvoiceMst::where('fc_invno', auth()->user()->fc_userid)->delete();
            TempInvoiceDtl::where('fc_invno', auth()->user()->fc_userid)->delete();
            
			DB::commit();

			return [
				'status' => 201, // SUCCESS
                'link' => '/apps/invoice-cprr',
				'message' => 'Data berhasil dihapus'
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
}
