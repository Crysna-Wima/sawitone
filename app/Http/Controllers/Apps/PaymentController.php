<?php

namespace App\Http\Controllers\Apps;

use App\Models\BankAcc;
use App\Http\Controllers\Controller;
use App\Models\TempSoMaster;
use App\Models\TempSoPay;
use App\Models\TransaksiType;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function datatable()
    {
        $temp_so_pay = TempSoPay::where('fc_sono', auth()->user()->fc_userid)->get();
        // dd($temp_so_pay);
        return DataTables::of($temp_so_pay)
            ->addIndexColumn()
            ->make();
    }

    public function index()
    {
        $temp_so_master = TempSoMaster::with('branch', 'member_tax_code', 'sales', 'customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', auth()->user()->fc_userid)->first();
        // get data tempsopay dimana fc_trx = "PAYMENTCODE"
        $temp_so_pay = TransaksiType::where('fc_trx', "PAYMENTCODE")->get();
        if (!empty($temp_so_master)) {
            $data['data'] = $temp_so_master;
            return view('apps.sales-order.payment', [
                'data' => $data['data'],
                'kode_bayar' => $temp_so_pay
            ]);
        }
        // dd($temp_so_pay);
    }


    public function store_update($fc_sono, Request $request)
    {
        $temp_so_master = TempSoMaster::where('fc_sono', $fc_sono)->first();
        $temp_so_master->update([
            'fc_sotransport' => $request->fc_sotransport,
            'fm_servpay' => $request->fm_servpay,
            'fc_memberaddress_loading1' => $request->fc_memberaddress_loading1
        ]);

        $temp_so_master = TempSoMaster::with('branch', 'member_tax_code', 'sales', 'customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', auth()->user()->fc_userid)->first();
        $data = [];
        if (!empty($temp_so_master)) {
            $data['data'] = $temp_so_master;
        }


        return [
            'status' => 201,
            // 'data' => $data,
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function getData(Request $request)
    {
        $data = TransaksiType::where('fc_kode', $request->fc_kode)->where('fc_trx', "PAYMENTCODE")->get();
        return response()->json($data);
      
    }

    // create
    public function create(Request $request)
    {

        
        $temp_so_master = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)->first();

        // dd($temp_so_master->fc_membercode);
        

        $temp_so_pay = TempSoPay::create([
            'fc_divisioncode' => auth()->user()->fc_divisioncode,
            'fc_branch' => auth()->user()->fc_branch,
            'fc_sono' => auth()->user()->fc_userid,
            'fc_sopaymentcode' => $request->fc_kode,
            'fm_valuepayment' => $request->fm_valuepayment,
            'fc_userid' => auth()->user()->fc_userid,
            'fd_paymentdate' => $request->fd_paymentdate,
            'fc_description' => $request->fc_description,
            'fv_keterangan' => $request->fv_keterangan,
            'fc_membercode' => $temp_so_master->fc_membercode
        ]);

        // jika berhasil create tampilkan response
        if ($temp_so_pay) {
           // redirect ke view yang sama dengan mengirim data yang sama dengan function index
            return redirect()->route('payment.index')->with('success', 'Data berhasil disimpan');
          
        }

        // jika gagal create tampilkan response
        return [
            'status' => 300,
            'message' => 'Data gagal disimpan'
        ];
        
    }

    public function delete($fc_sono, $fn_sopayrownum){
        $temp_so_pay = TempSoPay::where('fn_sopayrownum', $fn_sopayrownum)->delete();
        if ($temp_so_pay) {
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus',
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal dihapus'
        ];
        // dd($temp_so_pay);

    }


  
}
