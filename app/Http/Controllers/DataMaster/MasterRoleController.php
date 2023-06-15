<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;
use App\Helpers\NoDocument;

use DataTables;
use Carbon\Carbon;
use File;

class MasterRoleController extends Controller
{
    public function index()
    {
        return view('data-master.master-role.index');
    }
}
