<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use DataTables;
use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\SoMaster;
use App\Models\SoDetail;
use App\Models\TempSoPay;
use App\Models\Invstore;
use App\Models\DoDetail;
use App\Models\DoMaster;

class DeliveryOrderController extends Controller
{

    public function index(){
        // cari di domst yang userid nya sama dengan userid yang login
        $do_master = DoMaster::where('fc_dono', auth()->user()->fc_userid)->first();
        // jika $do_master tidak kosong return ke route create_do
        if(!empty($do_master)){
            return redirect()->route('create_do');
        }

        return view('apps.delivery-order.index');
        // dd($do_master);
    }

    public function detail($fc_sono){
        session(['fc_sono_global' => $fc_sono]);
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $fc_sono)->first();
        
        return view('apps.delivery-order.detail', $data);
        // dd($data);
    }

    public function insert_do(Request $request){
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_sono' => 'required',
            'fc_sostatus' => 'required',
            // 'fc_userid' => 'required',
            'fc_dono' => 'required',
        ], [
            'fc_divisioncode.required' => 'Division Code tidak boleh kosong',
            'fc_sono.required' => 'SO Number tidak boleh kosong',
            'fc_sostatus.required' => 'SO Status tidak boleh kosong',
            // 'fc_userid.required' => 'User ID tidak boleh kosong',
            'fc_dono.required' => 'DO Number tidak boleh kosong',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // cek apakah Do sudah ada apa belum berdasarkan dono dari userid yang login
        $do_master = DoMaster::where('fc_dono', $request->fc_dono)->first();
        if(!empty($do_master)){
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Edit Do'
                ]
            );
        }

        $create_do_master = DoMaster::create([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_sono' => $request->fc_sono,
            'fc_sostatus' => $request->fc_sostatus,
            'fc_userid' => auth()->user()->fc_userid,
            'fc_dono' => $request->fc_dono,
            'fc_dostatus' => 'I',
        ]);

        // jika validasi sukses dan $do_master berhasil response 200
        if($create_do_master){
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Insert Do'
                ]
            );
        }else{
            return response()->json(
                [
                    'status' => 300,
                    'message' => 'Gagal Buat DO'
                ]
            );
        }

        
    }

    public function create(){
        // get fc_sono dari t_domst fc_userid yang login
        $domst = DoMaster::where('fc_userid', auth()->user()->fc_userid)->first();
        $fc_sono_domst = $domst->fc_sono;
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status', 'domst')->where('fc_sono', $fc_sono_domst)->first();
        return view('apps.delivery-order.do', $data);
        // dd($data);
    }

    public function datatables_so_payment(){
        $data = TempSoPay::where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make();
    }

    public function datatables_stock_inventory($fc_stockcode){
        // get data from Invstore

        $data = Invstore::with('stock')->where('fc_stockcode', $fc_stockcode)->orderBy('fd_expired','ASC')->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_so_detail()
    {
        

        //  jika session fc_sono_global tidak sama dengan null
        if(session('fc_sono_global') != null){
            $fc_sono = session('fc_sono_global');
        }else{
            $domst = DoMaster::where('fc_userid', auth()->user()->fc_userid)->first();
            $fc_sono_domst = $domst->fc_sono;
            $fc_sono = $fc_sono_domst;
        }
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack','somst')->where('fc_sono', $fc_sono)->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
        // dd($domst);
    }

    public function datatables(){
        $data = SoMaster::all();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }


    public function cart_stock(request $request){
        $validator = Validator::make($request->all(), [
            'fc_barcode' => 'required',
            'quantity' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        //CHECK DATA STOCK
        $data_stock = Invstore::where('fc_barcode', $request->fc_barcode)->first();
        if($data_stock->fn_quantity < $request->quantity){
            return [
                'status' => 300,
                'message' => 'Quantity yang anda masukkan melebihi stock yang tersedia'
            ];
        }


        // Stock kosong
        if($data_stock->fn_quantity == 0){
            return [
                'status' => 300,
                'message' => 'Stock Kosong'
            ];
        }

        // dd($data_stock);

        //INSERT DoDetail dari data stock
        $do_dtl = DoDetail::create([
            'fc_divisioncode' => $data_stock->fc_divisioncode,
            'fc_branch' => $data_stock->fc_branch,
            'fc_dono' => auth()->user()->fc_userid,
            'fc_barcode' => $request->fc_barcode,
            'fn_qty_do' => $request->quantity,
            'fc_namepack' => $data_stock->stock->fc_namepack,
            'fc_rackcode' => $data_stock->fc_rackcode,
            'fc_batch' => $data_stock->fc_batch,
            'fc_catnumber' => $data_stock->fc_catnumber,
            'fd_expired' => $data_stock->fd_expired,
        ]);

        //UPDATE STOCK
        $stock_update = Invstore::where('fc_barcode', $request->fc_barcode)
        ->update([
            'fn_quantity' => $data_stock->fn_quantity - $request->quantity
        ]);

        // jika $do_dtl dan $stock_update bisa
        if($do_dtl && $stock_update){
            return [
                'status' => 200,
                'message' => 'Data berhasil ditambahkan'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal ditambahkan'
            ];
        }
    }
    
    // datatable deliver item
    public function datatables_do_detail()
    {
        $data = DoDetail::with('invstore.stock')->where('fc_dono', auth()->user()->fc_userid)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd(auth()->user()->fc_userid);
    }

    public function delete_item($fc_barcode){
        // validasi $fc_barcode require
        $validator = Validator::make(['fc_barcode' => $fc_barcode], [
            'fc_barcode' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        // get data stock dari fc_qty_do 
        $data_stock = DoDetail::where('fc_barcode', $fc_barcode)->first();
        $data_invstore = Invstore::where('fc_barcode', $fc_barcode)->first();

        // update invstore kembalikan stock di invstore
        $update_invstore = Invstore::where('fc_barcode', $fc_barcode)
        ->update([
            'fn_quantity' => $data_invstore->fn_quantity + $data_stock->fn_qty_do
        ]);

        // hapus
        $hapus_item = DoDetail::where('fc_barcode', $fc_barcode)->delete();
        // kemudian tambah
        if($update_invstore && $hapus_item){
            return [
                'status' => 200,
                'message' => 'Data berhasil dihapus'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal dihapus'
            ];
        }
    }

    public function update_transport(Request $request,$fc_sono){
        // validasi $fc_sono require
        $validator = Validator::make(['fc_sono' => $fc_sono], [
            'fc_sono' => 'required',
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }
        // dd($request);

       
        $update_transport = DoMaster::where('fc_sono', $fc_sono)
        ->update([
            'fc_sotransport' => $request->fc_sotransport,
            'fc_transporter' => $request->fc_transporter,
            'fd_dodatesysinput' => $request->fd_dodatesysinput,
            'fd_dodate' => $request->fd_dodate,
            'fm_servpay' => $request->fm_servpay,
        ]);

        // jika $update_transport bisa
        if($update_transport){
            return [
                'status' => 201,
                'message' => 'Data berhasil diupdate'
            ];
        }else{
            return [
                'status' => 300,
                'message' => 'Data gagal diupdate'
            ];
        }
    }
}
