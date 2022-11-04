<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use DataTables;
use Carbon\Carbon;

use App\Models\User;
use App\Models\MasterMenu;

class SettingUserController extends Controller
{
    public function index(){
        return view('data-master.master-user.master-user-index');
    }

    public function detail($id){
        return User::with('master_role')->find($id);
    }

    public function datatables(){
        $data = User::orderBy('id','desc')->with('master_role')->get();

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function add_menu($id){
        $master_menu = MasterMenu::where('parent_id', '0')->orderBy('index','asc')->get();
        $prepared_sub_menu = MasterMenu::orderBy('index','asc')->get();
        $user = User::with('master_role')->find($id);

        $array = [];
        foreach($master_menu as $key => $value){
            $array[$key]['id'] = $value->id;
            $array[$key]['nama'] = $value->nama_menu;
            $array[$key]['icon'] = $value->icon;
            $array[$key]['link'] = $value->link;
            $array[$key]['status'] = isset($user->json_menu) ? (in_array($value->id, $user->json_menu) ? 1 : 0) : 0;

            $sub_menu = $prepared_sub_menu->where('parent_id', $value->id);
            foreach($sub_menu as $value2){
                $array[$key]['submenu'][] = [
                    'id' => $value2->id,
                    'nama' => $value2->nama_menu,
                    'icon' => $value2->icon,
                    'link' => $value2->link,
                    'parent_id' => $value2->parent_id,
                    'status' => isset($user->json_menu) ? (in_array($value2->id, $user->json_menu) ? 1 : 0) : 0,
                ];
            }
        }

        $data['master_menu'] = $array;
        $data['user'] = $user;
        return view('data-master.master-user.master-user-detail',$data);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'master_role_id' => 'required',
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$request->id,
        ]);

        if($validator->fails()) {
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        if($request->exists('json_menu')){

            $explode = array_unique(explode(",",$request->json_menu));
            $request->merge(['json_menu' => json_encode($explode)]);

        }else{
            if($request->type != 'update') $request->request->add(['password' => Hash::make($request->username)]); 
        }
        
        User::updateOrCreate(['id' => $request->id],$request->all() );

        return response()->json([
            'status' => 200,
            'message' => "Data berhasil ditambahkan"
        ]);
    }

    public function delete($id){
        $delete = User::find($id);

		if($delete != null){
			
			$delete->delete();
	
			return response()->json([
				'status' => 200,
				'message' => "Data berhasil dihapus"
			]);
		}else{
			return response()->json([
				'status' => 300, // FAILED
				'message' => "Proses gagal, Data tidak ditemukan"
			]);
		}
    }
}
