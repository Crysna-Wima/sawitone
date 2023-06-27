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

use App\Models\DoDetail;
use App\Models\DoMaster;
use App\Models\InvMaster;
use Yajra\DataTables\DataTables as DataTables;

class MasterDeliveryOrderController extends Controller
{

    public function index(){
        $data['do_mst']= DoMaster::with('somst.customer')->first();

        return view('apps.master-delivery-order.index', $data);
    }

    public function detail($fc_dono){
        // kalau encode pakai base64_encode
        // kalau decode pakai base64_decode
        $encoded_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $encoded_fc_dono]);
        $data['do_mst'] = DoMaster::with('somst.customer')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl'] = DoDetail::with('invstore.stock')->where('fc_dono', $encoded_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        return view('apps.master-delivery-order.detail', $data);
        // dd($data);
    }


    public function datatables(){
        $data = DoMaster::with('somst.customer')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
    }

    public function datatables_do_detail($fc_dono){
        $decode_dono = base64_decode($fc_dono);
        $data = DoDetail::with('invstore.stock')->where('fc_branch', auth()->user()->fc_branch)->where('fc_dono', $decode_dono)->get();

        return DataTables::of($data)
        ->addIndexColumn()
        ->make(true);
        // dd($request);
    }

    public function datatables_detail(Request $request){
        $data = DoMaster::with('somst.customer')->where('fc_dono', $request->fc_dono)->first();;

        // return response json
        return response()->json($data);
    }

    public function cancel(Request $request){
        // ubah fc_sostatus yang fc_sono sama dengan $request->fc_sono

        $fc_dono = $request->fc_dono;

        // update
        $do_master = DoMaster::where('fc_dono', $fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();

        $update_status = $do_master->update([
            'fc_dostatus' => 'CC',
        ]);

        if ($update_status) {
            return [
                'status' => 201,
                'message' => 'Data berhasil dicancel',
                'link' => '/apps/master-delivery-order'
            ];
        }

        return [
            'status' => 300,
            'message' => 'Data gagal dicancel'
        ];
    }

    public function pdf(Request $request){
        // dd($request);
        $encode_fc_dono = base64_encode($request->fc_dono);
        $data['do_mst']= DoMaster::with('somst')->where('fc_dono', $request->fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl']= DoDetail::with('invstore.stock')->where('fc_dono', $request->fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
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
            'link' => '/apps/master-delivery-order/get_pdf/' . $encode_fc_dono . '/' . $data['nama_pj'],
        ];
        // dd($data['do_dtl']);
    }

    public function get_pdf($fc_dono,$nama_pj){
        $decode_fc_dono = base64_decode($fc_dono);
        $data['do_mst']= DoMaster::with('somst')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl']= DoDetail::with('invstore.stock')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $data['nama_pj'] = $nama_pj;
        $pdf = PDF::loadView('pdf.report-do', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function pdf_sj($fc_dono)
    {
        $decode_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $decode_fc_dono]);
        $data['do_mst']= DoMaster::with('somst')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl']= DoDetail::with('invstore.stock')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        $pdf = PDF::loadView('pdf.surat-jalan', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function inv($fc_dono)
    {
        $decode_fc_dono = base64_decode($fc_dono);
        session(['fc_dono_global' => $decode_fc_dono]);
        $data['do_mst']= DoMaster::with('somst')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->first();
        $data['do_dtl']= DoDetail::with('invstore.stock')->where('fc_dono', $decode_fc_dono)->where('fc_branch', auth()->user()->fc_branch)->get();
        // get data invmaster
        $data['inv_mst'] = InvMaster::where('fc_dono', $decode_fc_dono)->first();
        $pdf = PDF::loadView('pdf.invoice', $data)->setPaper('a4');
        return $pdf->stream();
    }

    public function publish(Request $request){
       // validasi semua request
    //    dd($request);
         $validator = Validator::make($request->all(),[
          'fc_dono' => 'required',
          'fc_divisioncode' => 'required',
          'fc_branch' => 'required',
        //   'fn_dodateinputuser' => 'required',
          'fn_dodetail' => 'required',
          'fm_disctotal' => 'required',
          'fm_netto' => 'required',
          'fm_servpay' => 'required',
          'fm_tax' => 'required',
          'fm_brutto' => 'required',
          'fd_inv_releasedate' => 'required',
          'fn_inv_agingday' => 'required',
          'fd_inv_agingdate' => 'required'
         ],
         [
            // pesan validasi
            'fc_dono' => 'Nomor DO tidak boleh kosong',
            'fc_divisioncode' => 'Kode Divisi tidak boleh kosong',
            // 'fn_dodateinputuser' => 'Tanggal DO tidak boleh kosong',
            'fd_inv_releasedate' => 'Tanggal Terbit Invoice tidak boleh kosong',
            'fn_inv_agingday' => 'Masa Invoice tidak boleh kosong',
            'fd_inv_agingdate' => 'Tanggal Jatuh Tempo Invoice tidak boleh kosong',
         ]); 

         // apabila validasi tidak sesuai
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()]);
            }

        // create  data in InvMaster
        $inv_mst = InvMaster::Create(
            // ['fc_dono' => $request->fc_dono],
            [
                'fc_dono' => $request->fc_dono,
                'fc_branch' => $request->fc_branch,
                'fc_invno' => auth()->user()->fc_userid,
                'fc_sono' => $request->fc_sono,
                'fc_invtype' => 'OTG',
                'fc_divisioncode' => $request->fc_divisioncode,
                'fn_invdetail' => $request->fn_dodetail,
                'fm_disctotal' => $request->fm_disctotal,
                'fm_netto' => $request->fm_netto,
                'fc_userid' => auth()->user()->fc_userid,
                'fm_servpay' => $request->fm_servpay,
                'fm_tax' => $request->fm_tax,
                'fm_brutto' => $request->fm_brutto,
                'fd_inv_releasedate' => $request->fd_inv_releasedate,
                'fn_inv_agingday' => $request->fn_inv_agingday,
                'fd_inv_agingdate' => $request->fd_inv_agingdate,
                'fd_inv_releasedate' => $request->fd_inv_releasedate,
            ]);


        // // update data fc_invstatus in DoMaster
        // $do_mst = DoMaster::where('fc_dono', $request->fc_dono)->update(['fc_invstatus' => 'Y']);

         // // jika validasi sukses dan $do_master berhasil response 200
         if ($inv_mst) {
            return response()->json(
                [
                    'status' => 200,
                    'message' => 'Invoice berhasil diterbitkan',
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 300,
                    'message' => 'Invoice gagal diterbitkan'
                ]
            );
        }

    }
}
