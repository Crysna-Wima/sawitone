<?php

namespace App\Http\Controllers\Apps;

use App\Models\KasBon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class KasBonController extends Controller
{
    public function index()
    {
        // $data = KasBon::all();
        $data = array(
            [
                "title" => "Test",
                "content" => "Est reprehenderit commodo excepteur in nisi duis fugiat culpa ipsum sit sunt quis. Dolor esse et amet duis. Veniam officia veniam enim exercitation ut ad."
            ],
            [
                "title" => "Test",
                "content" => "Est reprehenderit commodo excepteur in nisi duis fugiat culpa ipsum sit sunt quis. Dolor esse et amet duis. Veniam officia veniam enim exercitation ut ad."
            ],
            [
                "title" => "Test",
                "content" => "Est reprehenderit commodo excepteur in nisi duis fugiat culpa ipsum sit sunt quis. Dolor esse et amet duis. Veniam officia veniam enim exercitation ut ad."
            ],
        );
        return view('apps.kas-bon.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validation = [
            'fc_userapplicant' => 'required',
            'fd_kasbondate' => 'required',
            'fm_nominal' => 'required',
        ];

        $validator = Validator::make($request->all(), $validation);

        if ($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $create_kasbon = KasBon::create([
            'fc_userapplicant' => $request->fc_userapplicant,
            'fd_kasbondate' => $request->fd_kasbondate,
            'fv_description' => $request->fv_description,
            'fm_nominal' => $request->fm_nominal,
            'fc_status' => 'J'
        ]);

        if ($create_kasbon) {
            dd('Kas Bon Berhasil ditambahkan');
            // return response()->json([
            //     'status' => 200,
            //     'message' => "Kas Bon Berhasil ditambahkan"
            // ]);
        } else {
            dd('Kas Bon Tidak Berhasil ditambahkan');
            // return response()->json([
            //     'status' => 300,
            //     'message' => 'Kas Bon tidak berhasil ditambahkan'
            // ]);
        }
    }

    public function update(KasBon $KasBon, Request $request)
    {
    }

    public function delete(KasBon $KasBon)
    {
    }

    public function datatables()
    {
    }
}
