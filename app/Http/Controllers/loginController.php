<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Editorial_team;

class loginController extends Controller
{
    public function index(){
        return view('login/login');
    }
    public function login(Request $request){
        $msg="";
        $status=false;
        $redirect="";
        try{
            if($request->nip !== "adminarunika"){
                $validated=$request->validate([
                    'nip' => 'required|digits:18',
                    'password' => 'required'
                ]);
            }else{
                $validated=$request->validate([
                    'password' => 'required'
                ]);
            }
            $check_data=checkUserByNip(preg_replace("/[^A-Za-z0-9]/", "", $request->nip), 'login');
            if($check_data !== false){
                $check_pwd=Hash::check($request->password, $check_data['password']);
                if($check_pwd){
                    Auth::login($check_data);
                    $status=true;
                    $msg="Selamat datang di Arunika.";
                    $redirect='dashboard';
                    $check_data=null;
                }else{
                    $msg="Pastikan NIP dan Password anda tepat";
                }
            }else{
                $msg="Pastikan NIP dan Password anda tepat";
            }
        }catch(ValidationException $e){
            $msg="-";
            $obj_msg=json_decode($e->validator->errors());
            $count=count(array($obj_msg));
            $x=0;
            for($x=0;$x<$count;$x++){
                if(isset($obj_msg->nip[$x])){
                    $msg=$obj_msg->nip[$x];
                    break;
                }
                if(isset($obj_msg->password[$x])){
                    $msg=$obj_msg->password[$x];
                }
            }
        }
        return response()->json(['status'=>$status, 'msg'=>$msg, 'redir'=>$redirect]);
    }
    public function logout(){
        Auth::logout();
        return redirect('login');
    }

}
