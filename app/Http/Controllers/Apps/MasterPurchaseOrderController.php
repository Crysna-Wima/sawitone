<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\NoDocument;
use App\Helpers\Convert;

use PDF;
use Carbon\Carbon;
use File;
use DB;

use App\Models\PoMaster;
use App\Models\PoDetail;
use App\Models\RoMaster;
use App\Models\RoDetail;
use Yajra\DataTables\DataTables as DataTables;

class MasterPurchaseOrderController extends Controller
{

    public function index()
    {
        return view('apps.master-purchase-order.index');
    }

    public function detail($fc_pono)
    {
        $decode_fc_pono = base64_decode($fc_pono);
        session(['fc_pono_global' => $decode_fc_pono]);
        $data['po_master'] = PoMaster::with('supplier')->where('fc_pono', $decode_fc_pono)->where('fc_branch', auth()->user()->fc_branch)->first();

        return view('apps.master-purchase-order.detail', $data);
        // dd($data);
    }

    public function datatables(){
        $data = PoMaster::with('supplier')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }

    public function datatables_good_reception($fc_suppliercode){
        $data = PoMaster::with('supplier')->where('fc_suppliercode', $fc_suppliercode)->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
        // dd($data);
    }


    public function datatables_po_detail(){

        //  jika session fc_sono_global tidak sama dengan null
        if (session('fc_pono_global') != null) {
            $fc_pono = session('fc_pono_global');
        } else {
            $pomst = PoMaster::where('fc_userid', auth()->user()->fc_userid)->first();
            $fc_pono_pomst = $pomst->fc_pono;
            $fc_pono = $fc_pono_pomst;
        }

        $data = PoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_pono', $fc_pono)->where('fc_branch', auth()->user()->fc_branch)->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatables_receiving_order()
    {

        $data = RoMaster::with('pomst.supplier')->where('fc_pono', session('fc_pono_global'))->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function pdf(Request $request){
        // dd($request);
        $encode_fc_pono = base64_encode($request->fc_pono);
        $data['po_mst'] = PoMaster::with('supplier')->where('fc_pono', $request->fc_pono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['po_dtl'] = PoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_pono', $request->fc_pono)->where('fc_branch', auth()->user()->fc_branch)->get();
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        // $pdf = PDF::loadView('pdf.purchase-order', $data)->setPaper('a4');
        // return $pdf->stream();
        // dd($data);

        //redirect ke /apps/master-purchase-order/pdf dengan mengirimkan $data
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-purchase-order/get_pdf/' . $encode_fc_pono . '/' . $data['nama_pj'],
        ];
    }

    public function get_pdf($fc_pono,$nama_pj){
        $decode_fc_pono = base64_decode($fc_pono);
        $data['po_mst'] = PoMaster::with('supplier')->where('fc_pono', $decode_fc_pono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['po_dtl'] = PoDetail::with('branch', 'warehouse', 'stock', 'namepack')->where('fc_pono', $decode_fc_pono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.purchase-order', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function pdf_ro(Request $request){
        // dd($request);
        $decode_fc_rono = base64_encode($request->fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        if($request->name_pj){
            $data['nama_pj'] = $request->name_pj;
        }else{
            $data['nama_pj'] = auth()->user()->fc_username;
        }
        // $pdf = PDF::loadView('pdf.purchase-order', $data)->setPaper('a4');
        // return $pdf->stream();
        // dd($data);

        //redirect ke /apps/master-receiving-order/pdf dengan mengirimkan $data
        return [
            'status' => 201,
            'message' => 'PDF Berhasil ditampilkan',
            'link' => '/apps/master-receiving-order/get_pdf/' . $decode_fc_rono . '/' . $data['nama_pj'],
        ];
    }

    public function get_pdf_ro($fc_rono,$nama_pj){
        $decode_fc_rono = base64_decode($fc_rono);
        $data['ro_mst'] = RoMaster::with('pomst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['ro_dtl'] = RoDetail::with('invstore.stock', 'romst')->where('fc_rono', $decode_fc_rono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.receiving-order', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function close_po(Request $request){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $fc_pono = $request->fc_pono;
        $fc_postatus = $request->fc_postatus;

        // update
        $po_master = PoMaster::where('fc_pono', $fc_pono)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $po_master->update([
            'fc_postatus' => $fc_postatus,
        ]);


        if ($update_status) {
            return [
                'status' => 200,
                'message' => 'Data berhasil diclose',
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal diclose'
        ];
    }

    public function cancel_po(Request $request){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $fc_pono = $request->fc_pono;

        // update
        $po_master = PoMaster::where('fc_pono', $fc_pono)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $po_master->update([
            'fc_postatus' => 'CC',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Data berhasil dicancel',
                'link' => '/apps/master-purchase-order'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal dicancel'
        ];
    }

}
