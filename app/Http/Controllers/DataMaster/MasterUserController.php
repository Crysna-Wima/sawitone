<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Carbon\Carbon;
use File;

use App\Models\User;
use Auth;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class MasterUserController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    public function index(){
        $roles = ModelsRole::all();
        return view('data-master.master-user.index', compact('roles'));
    }

    public function detail($fc_username, $id){
        if (is_null($this->user) || !$this->user->can('Master User')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }
       
        $user = User::find($id)->where('fc_username', $fc_username)->first();
        $roles = ModelsRole::all();

        // user punya role apa sajakah?
        $selected = $user->roles->pluck('name', 'name')->all();

        $response = [
            'user' => $user,
            'roles' => $roles,
            'selected' => $selected
        ];

        return $response;
        // dd($selected);
    }

    public function datatables(){
        $data = User::with('branch', 'group_user')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
        if (is_null($this->user) || !$this->user->can('Master User')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any admin !');
        }

        $id = $request->id;

        // TODO: You can delete this in your local. This is for heroku publish.
        // This is only for Super Admin role,
        // so that no-one could delete or disable it by somehow.
        if ($id === 7) {
            session()->flash('error', 'Sorry !! You are not authorized to update this Admin as this is the Super Admin. Please create new one if you need to test !');
            return back();
        }
        $validation_array = [
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_userid' => 'required',
            'fc_username' => 'required'
        ];
         
        // dd($request);
        if(empty($request->type)){
            $validation_array['fc_password'] = 'required';
            $validation_array['fc_username'] = 'required|unique:t_user,fc_username,NULL,fc_username,deleted_at,NULL';
        }

       $validator = Validator::make($request->all(), $validation_array);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        if(empty($request->type)){
            $cek_data = User::where([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_userid' => $request->fc_userid,
            ])->withTrashed()->count();

            if($cek_data > 0){
                return [
                    'status' => 300,
                    'message' => 'Oops! Insert gagal karena data sudah ditemukan didalam sistem kami'
                ];
            }
        }

        if($request->type === 'update'){
            $userAdmin = User::find($id);
            $userAdmin->roles()->detach();
            if ($request->roles) {
                $userAdmin->assignRole($request->roles);
            }
        }

        $request->merge(['fc_password' => Hash::make($request->fc_password)]);
        User::updateOrCreate([
            'id' => $request->id,
            'fc_divisioncode' => $request->fc_divisioncode,
            'fc_branch' => $request->fc_branch,
            'fc_userid' => $request->fc_userid,
        ], $request->all());

		return [
			'status' => 200, // SUCCESS
			'message' => 'Data berhasil disimpan'
		];
    }

    public function delete($fc_username){
        User::where('fc_username', $fc_username)->delete();
        return response()->json([
            'status' => 200,
            'message' => "Data berhasil dihapus"
        ]);
    }

    public function reset_password($fc_username){
        User::where('fc_username', $fc_username)->update(['fc_password' => Hash::make('passworddefault')]);
        return [
            'status' => 200,
            'message' => 'Password berhasil dirubah menjadi -- passworddefault --',
        ];
    }
}
