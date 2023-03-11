<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceivingDetailOrderController extends Controller
{
    public function index(){
        return view('apps.receiving-order.create-index');
    }

    
    public function create(){
        // $data = PoMaster::with('supplier')->where('fc_pono', auth()->user()->fc_userid)->first();
        return view('apps.receiving-order.create-index');
        // $romst = RoMaster::where('fc_dono', auth()->user()->fc_userid)->first();
        // $data['romst'] = $romst;
        // dd($data);
    }
}
