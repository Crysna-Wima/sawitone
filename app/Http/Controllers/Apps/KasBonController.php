<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KasBonController extends Controller
{
    public function index()
    {
        return view('apps.kas-bon.index');
    }
}
