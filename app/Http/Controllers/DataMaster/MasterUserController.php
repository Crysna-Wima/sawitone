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

class MasterUserController extends Controller
{
    public function index(){
        return view('data-master.master-user.index');
    }

    public function detail($fc_username){
        return User::where('fc_username', $fc_username)->first();
    }

    public function datatables(){
        $data = User::with('branch', 'group_user')->orderBy('created_at', 'DESC')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){

        $validation_array = [
            'fc_divisioncode' => 'required',
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

        $request->merge(['fc_password' => Hash::make($request->fc_password)]);
        if($request->fc_branch){
            User::updateOrCreate([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch,
                'fc_userid' => $request->fc_userid,
            ], $request->all());

            return [
                'status' => 200, // SUCCESS
                'message' => 'Data berhasil disimpan'
            ];
        }else{
            User::updateOrCreate([
                'fc_divisioncode' => $request->fc_divisioncode,
                'fc_branch' => $request->fc_branch_value,
                'fc_userid' => $request->fc_userid,
            ], $request->all());

            return [
                'status' => 200, // SUCCESS
                'message' => 'Data berhasil disimpan'
            ];
        }
        
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
