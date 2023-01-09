<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class SalesOrder2Controller extends Controller
{
    public function detail_customer($fc_membercode){
        return Customer::where([
            'fc_membercode' => $fc_membercode,
        ])->first();
    }
}
