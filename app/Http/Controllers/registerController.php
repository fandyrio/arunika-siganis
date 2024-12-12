<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Pegawai;
use App\User;
use App\Editorial_team;
use Illuminate\Support\Facades\DB;



class registerController extends Controller
{
    public function index(){
        return view('register/register');
    }

    public function validateNIP(Request $request){
        $msg="";
        $status=false;
        $data=false;
        $redirect="";
        try{
            $validated=$request->validate([
                'nip' => 'required|digits:18',
            ]);

            $data=DB::select('CALL SPGetHakimByNip('.$request->nip.')');
            $jumlah_data=count($data);
            if($jumlah_data === 1){
                $json_data=(array)$data[0];
                $store_pegawai=$this->storePegawai($json_data);
                if($store_pegawai){
                    $store_user=$this->createUser($json_data);
                    if($store_user !== false){
                        $data_wa['no_wa']=$json_data['NomorHandphone'];
                        //$data_wa['no_wa']="081273861528";
                        $pesan="Berikut adalah informasi akun anda. ".PHP_EOL;
                        $pesan.="NIP : ".$json_data['NipBaru'].PHP_EOL;
                        $pesan.="Password : ".$store_user.PHP_EOL;
                        $pesan.="Silahkan lanjutkan kehalaman login";
                        $data_wa['nama']=$json_data['NamaLengkap'];
                        $data_wa['pesan']=$pesan;

                        $send_wa_notif=sendWaHelp($data_wa);
                        $status=$send_wa_notif;
                        if($status === "ok"){
                            $redirect="login";
                            $msg="NIP Ditemukan.".PHP_EOL."Data akun anda telah dikirimkan melalui pesan whatsapp";
                        }else{
                            $msg="Akun anda berhasil disimpan.".PHP_EOL."Namun sistem mengalami kendala saat mengirimkan pesan informasi akun.";
                        }
                    }else{
                        $msg="Tidak dapat menyimpan data user. Silahkan hubungi pengembang";
                    }
                }else{
                    $msg="Data Pegawai sudah ada. Silahkan login, atau hubungi tim pengembang bila belum mendapatkan akun";
                }
            }else{
                $msg="NIP Tidak ditemukan";
            }
        }catch(ValidationException $e){
            $msg=[];
            $obj_msg=json_decode($e->validator->errors());
            $count=count(array($obj_msg));
            $x=0;
            for($x=0;$x<$count;$x++){
                if(isset($obj_msg->nip[$x])){
                    $msg=$obj_msg->nip[$x];
                    break;
                }
            }
        }
        return response()->json(['msg'=>$msg, 'status'=>$status, 'data'=>$data, 'redir'=>$redirect]);
    }

    public function storePegawai($data){
        //var_dump($data['N']);
        $check_pegawai=$this->checkPegawai($data['NipBaru']);
        if(is_null($check_pegawai)){
            $penulis=new Pegawai;
            $penulis->id_pegawai=$data['IdPegawai'];
            $penulis->nama=$data['NamaLengkap'];
            $penulis->nip=$data['NipBaru'];
            $penulis->no_handphone=$data['NomorHandphone'];
            $save=$penulis->save();
            if($save){
                return true;
            }
        }else{
            $id_pegawai=$check_pegawai['id'];
            $check_reviewer=Editorial_team::where('id_pegawai', $id_pegawai)->first();
            if(!is_null($check_reviewer)){
                return true;
            }
        }
        return false;
    }
    public function createUser($data){
        $check_user=$this->checkUsers($data['NipBaru']);
        if(is_null($check_user)){
            $random_str=str()->random(5);
            $user=new User;
            $user->name= $data['NamaLengkap'];
            $user->nip=$data['NipBaru'];
            $user->password=Hash::make($random_str);
            $user->role='1';//user
            $save=$user->save();
            if($save){
                return $random_str;
            } 
        }
        return false;
    }
    public function createUserAdmin(){
        //$check_user=$this->checkUsers($data['NipBaru']);
        //if(is_null($check_user)){
            $random_str=str()->random(5);
            $user=new User;
            $user->name= 'admin';
            $user->nip='adminarunika';
            $user->password=Hash::make('adminarunika@123');
            $user->role='2';//admin
            $save=$user->save();
            if($save){
                return $random_str;
            } 
        //}
        return false;
    }
    public function checkPegawai($nip){
        $get_data=Pegawai::where('nip', $nip)->first();
        return $get_data;
    }
    public function checkUsers($nip){
        $get_data=User::where('nip', $nip)->first();
        return $get_data;
    }
 
}
