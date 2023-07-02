<?php

namespace App\Http\Controllers;

use App\Models\InvMaster;
use App\Models\PoMaster;
use App\Models\SoMaster;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Carbon;

use App\Models\User;

class LoginController extends Controller
{
    public function index(){
        if (Auth::check()) {
            $userCount = User::all()->count();
            $soCount = SoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count(); 
            $poCount = PoMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count();
            $invCount = InvMaster::all()->where('fc_branch', auth()->user()->fc_branch)->count(); 
            return view('dashboard.index', compact('userCount', 'soCount', 'poCount', 'invCount'));
        }
        return view('login.index');
    }

    public function login(Request $request){
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        $messages = [
            'username.required' => 'Username wajib di isi',
            'password.required' => 'Password wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return [
                'status' => 300,
                'message' => $validator->errors()->first()
            ];
        }

        $user = User::where(['fc_username' => $request->username])->first();
        if(!empty($user)){
            if (Hash::check($request->password, $user->fc_password)) {

                if($user->fl_hold == 'T'){
                    return [
                        'status' => 300,
                        'message' => 'Akun anda saat ini sedang di hold silahkan hubungi admin untuk aktivasi'
                    ];
                }

                if($user->fd_expired != null && $user->fd_expired < Carbon::now()->format('Y-m-d')){
                    return [
                        'status' => 300,
                        'message' => 'Akun anda saat ini sudah expired'
                    ];
                }

                Auth::login($user);
            }
        }

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            return [
                'status' => 201,
                'message' => 'Anda berhasil login',
                'link' => '/dashboard',
            ];
        }else{

            return [
                'status' => 300,
                'message' => 'Username atau password anda salah silahkan coba lagi'
            ];
        }
    }

    public function change_password(){
        return view('login.change-password');
    }

    public function action_change_password(request $request){
        $validator = Validator::make($request->all(), [
			'old_password' => 'required',
			'new_password' => 'required| min:6',
			'retype_password' => 'required|same:new_password',
		]);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

		$user = User::where('id',Auth::user()->id)->first();

		if (password_verify($request->old_password, $user['password'])) {
			$user->password = hash::make($request->new_password);
			$user->save();

			return [
				'status' => 200,
				'message' => 'Password berhasil diganti'
			];

		}else{
			return [
				'status' => 300,
				'message' => 'Password lama anda salah, silahkan coba lagi'
			];
		}


    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
