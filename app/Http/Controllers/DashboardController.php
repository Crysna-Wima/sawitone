<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SoMaster;
use App\Models\PoMaster;
use App\Models\InvMaster;
use App\Models\NotificationMaster;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller{
    
    public function index() {
        $userCount = User::all()->count();
        $soCount = SoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count(); 
        $poCount = PoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();
        $invCount = InvMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count(); 
       
        return view('dashboard.index', compact('userCount', 'soCount', 'poCount', 'invCount'));
        // dd($notifList);
    }

}
