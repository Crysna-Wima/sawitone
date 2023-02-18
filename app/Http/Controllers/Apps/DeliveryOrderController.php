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

class DeliveryOrderController extends Controller
{

    public function index(){
        return view('apps.delivery-order.index');
    }

    public function detail($fc_sono){
        session(['fc_sono_global' => $fc_sono]);
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', $fc_sono)->first();
        return view('apps.delivery-order.detail', $data);
    }

    public function create(){
        $data['data'] = SoMaster::with('branch','member_tax_code','sales','customer.member_type_business', 'customer.member_typebranch', 'customer.member_legal_status')->where('fc_sono', session('fc_sono_global'))->first();
        return view('apps.delivery-order.do', $data);
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
        $data = SoDetail::with('branch', 'warehouse', 'stock', 'namepack','somst')->where('fc_sono', session('fc_sono_global'))->get();

        return DataTables::of($data)
            ->addColumn('total_harga', function ($item) {
                return $item->fn_so_qty * $item->fm_so_oriprice;
            })
            ->addIndexColumn()
            ->make(true);
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

    public function pdf(){
        $data['so_master'] = SoMaster::with('branch', 'sales')->where('fc_sono', auth()->user()->fc_userid)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', auth()->user()->fc_userid)->get();

        $pdf = PDF::loadView('pdf.preview-do', $data)->setPaper('a4');
        return $pdf->stream();
    }
}
