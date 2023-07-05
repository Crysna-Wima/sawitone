<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SoMaster;
use App\Models\PoMaster;
use App\Models\InvMaster;
use App\Models\Invstore;
use App\Models\NotificationMaster;
use Carbon\Carbon;
use DB;
use App\Models\NotificationDetail;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{

    public function index()
    {
        $userCount = User::all()->count();
        $soCount = SoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();
        $poCount = PoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();
        $invCount = InvMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count(); 

        $expiredDateCount = Invstore::with('stock')
            ->where('t_invstore.fc_branch', auth()->user()->fc_branch)
            ->whereDate('t_invstore.fd_expired', '<=', now())
            ->count();

            $subquery = DB::table('t_invstore')
                ->select(DB::raw('SUM(fn_quantity)'))
                ->where('fc_branch', auth()->user()->fc_branch);

            $maqCount = DB::table('t_invstore as a')
            ->select('a.fc_stockcode', DB::raw('SUM(a.fn_quantity) as total_quantity'), 'b.fn_maxonhand')
            ->leftJoin('t_stock as b', 'a.fc_stockcode', '=', 'b.fc_stockcode')
            ->groupBy('a.fc_stockcode')
            ->havingRaw('SUM(a.fn_quantity) > b.fn_maxonhand')
            ->count();


            $moqCount = DB::table('t_invstore as a')
                ->select('a.fc_stockcode', DB::raw('SUM(a.fn_quantity) as total_quantity'), 'b.fn_reorderlevel')
                ->leftJoin('t_stock as b', 'a.fc_stockcode', '=', 'b.fc_stockcode')
                ->groupBy('a.fc_stockcode')
                ->havingRaw('SUM(a.fn_quantity) < b.fn_reorderlevel')
                ->count();


       
        return view('dashboard.index', compact('userCount', 'soCount', 'poCount', 'invCount', 'expiredDateCount','moqCount','maqCount'));
        // dd($expiredDateCount);
        // dd($notifList);
    }

    public function datatable($tipe){

        if ($tipe == 'expired') {
            $data = Invstore::with('stock')
            ->where('fc_branch', auth()->user()->fc_branch)
            ->where('fc_divisioncode', auth()->user()->fc_divisioncode)
            ->whereDate('fd_expired', '<', now())
            ->get();
        }else if($tipe == 'moq'){
            $data = Invstore::with('stock')
            ->join('t_stock', 't_invstore.fc_stockcode', '=', 't_stock.fc_stockcode')
            ->where('t_invstore.fc_branch', auth()->user()->fc_branch)
            ->groupBy('t_invstore.fc_stockcode')
            ->havingRaw('SUM(t_invstore.fn_quantity) < t_stock.fn_reorderlevel')
            ->get();
        }else{
            $data = Invstore::with('stock')
            ->join('t_stock', 't_invstore.fc_stockcode', '=', 't_stock.fc_stockcode')
            ->where('t_invstore.fc_branch', auth()->user()->fc_branch)
            ->groupBy('t_invstore.fc_stockcode')
            ->havingRaw('SUM(t_invstore.fn_quantity) > t_stock.fn_maxonhand')
            ->get();
        }
    
        // return datatables
        return DataTables::of($data )
            ->addIndexColumn()
            ->make();
    }



    public function view_all_notif()
    {
        $data = NotificationMaster::with('notifdtl')
            ->whereHas('notifdtl', function ($query) {
                $query->where('fc_userid', auth()->user()->fc_userid);
                // ->whereNull('fd_watchingdate');
            })
            ->orderBy('fd_notifdate', 'DESC')
            ->get();

        return view('dashboard.view-all-notif', $data);
    }
}
