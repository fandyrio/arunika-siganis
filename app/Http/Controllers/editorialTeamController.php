<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Editorial_team;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use App\Pegawai;

class editorialTeamController extends Controller
{
    public function listTeam(){
        $get_data=Editorial_team::join('pegawai', 'pegawai.id', '=', 'editorial_team.id_pegawai')
                    ->select('pegawai.*', 'editorial_team.sebagai')   
                    ->where('editorial_team.active', true) 
                    ->get();
        $jumlah_data=$get_data->count();
        return view('arunika/admin/list_team', ['team'=>$get_data, 'jumlah'=>$jumlah_data]);
    }

    public function formAddNew(){
        return view('arunika/admin/form_new_editor');
    }
    public function searchNip(Request $request){
        $data=[];
        $status=false;
        $msg="";
        $nip=$request->nip;
        $get_data=DB::select("CALL SPGetHakimByNip('".$nip."')");
        $jumlah_data=count($get_data);
        if($jumlah_data === 1){
            $status=true;
            $arr_data=(array)$get_data[0];
            $data['nama']=$arr_data['NamaLengkap'];
            $data['token']=Crypt::encrypt($arr_data['IdPegawai']);
            $data['no_hp']=$arr_data['NomorHandphone'];
            $data['satker']=$arr_data['NamaStruktur'];
            $data['jabatan']=$arr_data['NamaJabatan'];
            $data['pangkat']=$arr_data['KodeGolonganRuang'];
            $msg="Data ditemukan";
        }else{
            $msg="Data tidak ditemukan";
        }

        return response()->json(['status'=>$status, 'msg'=>$msg, 'data'=>$data]);
    }
    public function saveEditor(Request $request){
        $id_pegawai=null;
        $status=false;
        try{
            $id_pegawai_sikep=Crypt::decrypt($request->token);
            $check=Pegawai::leftJoin('editorial_team', 'editorial_team.id_pegawai', '=', 'pegawai.id')
                        ->select('pegawai.*', 'editorial_team.sebagai')
                        ->where('pegawai.id_pegawai', $id_pegawai_sikep)
                        ->first();
            
            if(is_null($check)){
                $call_data=DB::select("CALL SPGetHakimByNip('".$request->nip."')");
                $jumlah_data=count($call_data);
                if($jumlah_data === 1){
                        $arr_data=(array)$call_data[0];
                        $no_hp=$arr_data['NomorHandphone'];
                        $nama=$arr_data['NamaLengkap'];
                    
                        $pegawai=new Pegawai;
                        $pegawai->id_pegawai=$arr_data['IdPegawai'];
                        $pegawai->nama=$arr_data['NamaLengkap'];
                        $pegawai->nip=$request->nip;
                        $pegawai->no_handphone=$arr_data['NomorHandphone'];
                        $save_pegawai=$pegawai->save();
                        if($save_pegawai){
                            $id_pegawai=$pegawai->id;
                        }else{
                            $msg="Terjadi kesalahan sistem saat menyimpan data Hakim";
                        }
                }else{
                    $msg="Data anda tidak valid";
                }
            }elseif($check['sebagai'] !== null){
                $msg="Data sudah ada";
            }else{
                $id_pegawai=$check['id'];
                $no_hp=$check['no_handphone'];
                $nama=$check['nama'];
            }

            if($id_pegawai !== null){
                $editorial_team=new Editorial_team;
                $editorial_team->id_pegawai=$id_pegawai;
                $editorial_team->sebagai=$request->sebagai;
                $editorial_team->active=true;
                $save_editorial=$editorial_team->save();
                if($save_editorial){
                    $status=true;
                    $data_wa['no_wa']=$no_hp;
                    //$data_wa['no_wa']="081273861528";
                    $data_wa['nama']=$nama;
                    $data_wa['pesan']="Anda telah ditentukan menjadi Reviewer Artikel Pada Arunika (Artikel Hukum Hakim Indonesia).".PHP_EOL."Terimakasih";
                    $send_wa_notif=sendWaHelp($data_wa);
                    $msg="Berhasil menyimpan editor";
                }else{
                    $msg="Terjadi kesalahan pada saat penyimpanan data editor";
                }
            }
        }catch(DecrpytException $e){
            $msg="Invalid data NIP";
        }
        return response()->json(['status'=>$status, 'msg'=>$msg, 'callLink'=>"list-editorial-team"]);
    }
    public function removeEditor(Request $request){
        $status=false;
        $callLink="";
        try{
            $id_pegawai=Crypt::decrypt($request->target);
            $get_data=Editorial_team::where('id_pegawai', $id_pegawai)->first();
            if(!is_null($get_data)){
                $get_data->active=false;
                $update_data=$get_data->update();
                if($update_data){
                    $status=true;
                    $msg="Berhasil menghapus data";
                }else{
                    $msg="Terjadi kesalahan saat menghapus data";
                }
            }else{
                $msg="Data tidak ditemukan ".$editor_id;
            }
        }catch(DecryptException $e){
            $msg="Data tidak valid";
        }
        return response()->json(['status'=>$status, 'msg'=>$msg, 'callLink'=>"callLink('list-editorial-team')"]);
    }
}
