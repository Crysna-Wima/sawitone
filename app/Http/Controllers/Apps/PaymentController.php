<?php

namespace App\Http\Controllers\Apps;

use App\Models\BankAcc;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Builder\Function_;

class PaymentController extends Controller
{
    public function index(){
        return view('apps.sales-order.payment');
    }
}
