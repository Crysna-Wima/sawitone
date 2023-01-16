<?php

namespace App\Http\Controllers\Apps;

use App\Models\BankAcc;
use App\Http\Controllers\Controller;
use App\Models\TempSoMaster;
use App\Models\TempSoPay;
use App\Models\TransaksiType;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class PaymentController extends Controller
{
    public function index(){
        $temp_so_master = TempSoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', auth()->user()->fc_userid)->first();
        // get data tempsopay dimana fc_trx = "PAYMENTCODE"
        $temp_so_pay = TransaksiType::where('fc_trx', "PAYMENTCODE")->get();
        if(!empty($temp_so_master)){
            $data['data'] = $temp_so_master;
            return view('apps.sales-order.payment',[
                'data' => $data['data'],
                'kode_bayar' => $temp_so_pay
            ]);
           
        } 
        // dd($temp_so_pay);
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


        return [
            'status' => 201,
            // 'data' => $data,
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function getData(Request $request){
        $data = TransaksiType::where('fc_kode', $request->fc_kode)->where('fc_trx', "PAYMENTCODE")->get();
        return response()->json($data);
    }

    // create
    public function create(Request $request){

        $request->validate([
     
        
        ]);

    }


}
