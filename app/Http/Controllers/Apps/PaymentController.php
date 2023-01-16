<?php

namespace App\Http\Controllers\Apps;

use App\Models\BankAcc;
use App\Http\Controllers\Controller;
use App\Models\TempSoMaster;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class PaymentController extends Controller
{
    public function index(){
        $temp_so_master = TempSoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', auth()->user()->fc_userid)->first();
        if(!empty($temp_so_master)){
            $data['data'] = $temp_so_master;
            return view('apps.sales-order.payment',$data);
           
        } 
    }

    public function store_update($fc_sono, Request $request){
        $temp_so_master = TempSoMaster::where('fc_sono', $fc_sono)->first();
        $temp_so_master->update([
            'fc_sotransport' => $request->fc_sotransport,
            'fm_servpay' => $request->fm_servpay,
            'fc_memberaddress_loading1' => $request->fc_memberaddress_loading1
        ]);

        $temp_so_master = TempSoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', auth()->user()->fc_userid)->first();
        $data = [];
        if(!empty($temp_so_master)){
            $data['data'] = $temp_so_master;
            
        } 

        // arahkan ke url tertentu
        return [
            'status' => 201,
            // 'data' => $data,
            'message' => 'Data berhasil disimpan'
        ];
        
    }
}
