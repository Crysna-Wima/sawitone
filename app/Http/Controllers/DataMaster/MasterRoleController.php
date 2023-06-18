<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Convert;
use App\Helpers\NoDocument;
use App\Models\User;
use Auth;
use DataTables;
use Carbon\Carbon;
use File;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MasterRoleController extends Controller
{
    public $user;
    // public function __construct(){
    //     $this->middleware(function ($request, $next) {
    //         $this->user = Auth::guard('web')->user();
    //         return $next($request);
    //     });
    // }

    public function datatable(){
        // role has permission
        $data = Role::select('id', 'name', 'guard_name')
            ->with('permissions')
            ->get();
        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function index(){
        // if (is_null($this->user) || !$this->user->can('Master Role')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create any role !');
        // }

        $all_permissions  = Permission::all();
        $permission_groups = User::getpermissionGroups();
        
        return view('data-master.master-role.index', compact('all_permissions', 'permission_groups'));
    }

    public function create(Request $request){
        // if (is_null($this->user) || !$this->user->can('Master Role')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create any role !');
        // }

        // Validation Data
        $request->validate([
            'name' => 'required|max:100|unique:roles'
        ], [
            'name.requried' => 'Please give a role name'
        ]);

        // Process Data
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        // $role = DB::table('roles')->where('name', $request->name)->first();
        $permissions = $request->input('permissions');

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        return response()->json([
            'status' => 200,
            'message' => "Role User Berhasil dibuat"
        ]);
    }
}
