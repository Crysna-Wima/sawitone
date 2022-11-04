<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use DataTables;
use Carbon\Carbon;

use App\Models\Role;
use App\Models\Menu;

class SettingRoleController extends Controller
{
    public function index(){
        return view('data-master.master-role.master-role-index');
    }

    public function detail($id){
        return Role::find($id);
    }

    public function add_menu($id){
        $master_menu = Menu::where('parent_id', '0')->orderBy('index','asc')->get();
        $prepared_sub_menu = Menu::orderBy('index','asc')->get();
        $master_role = Role::find($id);

        $array = [];
        foreach($master_menu as $key => $value){
            $array[$key]['id'] = $value->id;
            $array[$key]['nama'] = $value->nama_menu;
            $array[$key]['icon'] = $value->icon;
            $array[$key]['link'] = $value->link;
            $array[$key]['status'] = isset($master_role->json_menu) ? (in_array($value->id, $master_role->json_menu) ? 1 : 0) : 0;

            $sub_menu = $prepared_sub_menu->where('parent_id', $value->id);
            foreach($sub_menu as $value2){
                $array[$key]['submenu'][] = [
                    'id' => $value2->id,
                    'nama' => $value2->nama_menu,
                    'icon' => $value2->icon,
                    'link' => $value2->link,
                    'parent_id' => $value2->parent_id,
                    'status' => isset($master_role->json_menu) ? (in_array($value2->id, $master_role->json_menu) ? 1 : 0) : 0,
                ];
            }
        }

        $data['master_menu'] = $array;
        $data['master_role'] = $master_role;

        return view('data-master.master-role.master-role-detail',$data);
    }

    public function datatables(){
        
        $data = Role::orderBy('id','desc')->get();
        if(auth()->user()->master_role_id != 1){
            $data = $data->where('id', '!=', '1');
        }

        return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
    }

    public function store_update(request $request){
       $validator = Validator::make($request->all(), [
            'role' => 'required',
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
        }

        Role::updateOrCreate(['id' => $request->id],$request->all() );

		return [
			'status' => 200, // SUCCESS 
			'message' => 'Data berhasil disimpan'
		];		
    }

    public function delete($id){
        $delete = Role::find($id);

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
