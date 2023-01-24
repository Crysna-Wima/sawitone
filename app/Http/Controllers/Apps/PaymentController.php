<?php

namespace App\Http\Controllers\Apps;

use App\Models\BankAcc;
use App\Http\Controllers\Controller;
use App\Models\TempSoDetail;
use App\Models\TempSoMaster;
use App\Models\TempSoPay;
use App\Models\TransaksiType;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;
use Validator;
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
        $validator = Validator::make($request->all(), [
            'fc_sotransport' => 'required',
            'fc_memberaddress_loading1' => 'required',
        ],[
            'fc_sotransport.required' => 'Transport harus diisi',
            'fc_memberaddress_loading1.required' => 'Alamat Tujuan harus diisi',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
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

    public function create(Request $request)
    {

        $temp_so_master = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)->first();

        // jumlah nominal yang dibayarkan
        $nominal = TempSoPay::where('fc_sono', auth()->user()->fc_userid)->sum('fm_valuepayment');

        // get total pembayaran
        $data_bayar = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->get();
        $total_bayar = 0;
        foreach ($data_bayar as $key => $value) {
            $total_bayar += $value->fm_so_oriprice * $value->fn_so_qty;
        }


        // dd($total_bayar);


        // validasi request
        $validator = Validator::make($request->all(), [
            'fc_kode' => 'required',
            'fc_description' => 'required',
            'fm_valuepayment' => 'required',
            'fd_paymentdate' => 'required',
        ], [
            'fc_kode.required' => 'Kode Bayar harus diisi',
            'fc_description.required' => 'Description harus diisi',
            'fm_valuepayment.required' => 'Nominal harus diisi',
            'fd_paymentdate.required' => 'Tanggal pembayaran harus diisi',
        ]);

        // jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else if (($nominal + $request->fm_valuepayment) > $temp_so_master->fm_brutto) {
            // tampilkan pesan error jika nominal yang dibayarkan lebih besar dari total pembayaran
            return redirect()->back()->with('error', 'Nominal yang dibayarkan lebih besar dari total pembayaran');
        } else {
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
        }

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

    public function delete($fc_sono, $fn_sopayrownum)
    {
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

    public function submit_pembayaran(Request $request){

        $temp_so_master = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)->first();

        // jumlah item SO detail
        $temp_detail = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->get();
        $total = count($temp_detail);

        // jumlah nominal yang dibayarkan
        $nominal = TempSoPay::where('fc_sono', auth()->user()->fc_userid)->sum('fm_valuepayment');

        // get total pembayaran
        $data_bayar = TempSoDetail::where('fc_sono', auth()->user()->fc_userid)->get();
        $total_bayar = 0;
        foreach ($data_bayar as $key => $value) {
            $total_bayar += $value->fm_so_oriprice * $value->fn_so_qty;
        }


        // kemudian hitung jumlah datanya
        $count_row_pay = TempSoPay::where('fc_sono', auth()->user()->fc_userid)->count();

        // validasi
        $validator = Validator::make($request->all(), [
            'fd_sodateinputuser' => 'required',
            'fd_soexpired' => 'required',
        ], [
            'fd_sodateinputuser.required' => 'Date Order harus diisi',
            'fd_soexpired.required' => 'Date Expired harus diisi',
        ]);

        // jika validasi gagal
        if($validator->fails()){
            return [
                'status' => 300,
                'message' => 'Date Order atau Date Expired Kosong',
            ];
        }else if($count_row_pay == 0) {
            return [
                'status' => 300,
                'message' => 'Data pembayaran tidak boleh kosong',
                'data' => $count_row_pay
            ];
        } else if ($temp_so_master->fm_brutto - $nominal != 0 && $temp_so_master->fm_brutto > $nominal) {
            return [
                'status' => 301,
                'message' => 'Masih ada kekurangan',
            ];
        } else if ($temp_so_master->fm_brutto < $nominal) {
            return [
                'status' => 301,
                'message' => 'Masih ada kelebihan pembayaran',
            ];
        } else {
            // insert into TempSoMaster
            if($total == 0){
                return [
                    'status' => 300,
                    'message' => 'Tambahkan Item terlebih dahulu',
                ];
            }
            $temp_so_master = TempSoMaster::where('fc_sono', auth()->user()->fc_userid)->update([
                'fc_sostatus' => 'F',
                'fd_sodateinputuser' => $request->fd_sodateinputuser,
                'fd_soexpired' => $request->fd_soexpired,
                'fm_brutto' => $total_bayar + $temp_so_master->fm_servpay,
                'fm_netto' => $total_bayar,
                'fn_sodetail' => $total
                // 'fd_sodatesysinput' => waktu sekarang timestamp
                
                
            ]);

            // jika update berhasil
            if ($temp_so_master) {
                // Tambahkan session flash message
                // session()->flash("message", "Pembayaran Berhasil"); 

                // // Kirim data message yang didapat dari session
                // $message = session()->get("message");
                return response()->json(["status" => 200, "message" => "Pembayaran Berhasil"]);
            }

            return [
                'status' => 300,
                'message' => 'Data gagal disimpan',
            ];
        }
    }
}
