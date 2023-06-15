<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;
use App\Helpers\NoDocument;
use App\Models\Cospertes;
use DataTables;
use Carbon\Carbon;
use File;

use App\Models\CprrCustomer;

class CprrCustomerController extends Controller
{
    public function index()
    {
        return view('data-master.cprr-customer.index');
    }

    public function get($fc_cprrcode)
    {
        $data = Cospertes::where([
            'fc_cprrcode' => $fc_cprrcode,
        ])->first();
        return response($data, 200);
    }

    public function detail($fc_divisioncode, $fc_branch, $fc_cprrcode, $fc_membercode)
    {
        $data = CprrCustomer::with('cospertes')->where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_cprrcode' => $fc_cprrcode,
            'fc_membercode' => $fc_membercode,
        ])->first();
        return response($data, 200);
    }

    public function datatables()
    {
        $data = CprrCustomer::with('cospertes', 'customer', 'branch')->where('fc_branch', auth()->user()->fc_branch)->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }

    public function store_update(request $request)
    {
        $validator = Validator::make($request->all(), [
            'fc_divisioncode' => 'required',
            'fc_cprrcode' => 'required',
            'fc_membercode' => 'required',
            'fm_price' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $request->request->add(['fc_branch' => auth()->user()->fc_branch]);
        if (empty($request->type)) {
            $cek_data = CprrCustomer::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_cprrcode' => $request->fc_cprrcode,
                'fc_membercode' => $request->fc_membercode,
                'fm_price' => $request->fm_price,
            ])->withTrashed()->count();

            if ($cek_data > 0) {
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        $request->merge(['fm_price' => Convert::convert_to_double($request->fm_price)]);

        if ($request->has('fm_price')) {
            $request->request->add(['updated_at' => Carbon::now()]);
        }

        CprrCustomer::updateOrCreate([
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_cprrcode' => $request->fc_cprrcode,
            'fc_membercode' => $request->fc_membercode,
            'fm_price' => $request->fm_price,
        ], $request->all());

        return [
            'status' => 200, // SUCCESS
            'message' => 'Data berhasil disimpan'
        ];
    }

    public function delete($fc_divisioncode, $fc_branch, $fc_cprrcode, $fc_membercode)
    {
        CprrCustomer::where([
            'fc_divisioncode' => $fc_divisioncode,
            'fc_branch' => $fc_branch,
            'fc_cprrcode' => $fc_cprrcode,
            'fc_membercode' => $fc_membercode,
        ])->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }
}
