<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Config;
use App\Checklist_review;
use File;

class configController extends Controller
{
    public function listConfig(){
        $get_data=Config::where('active', true)->get();
        $jumlah=$get_data->count();
        return view('arunika/admin/list_config', ['config'=>$get_data, 'jumlah'=>$jumlah]);
    }
    public function formAddConfig(){
        return view('arunika/admin/form_add_config', ['value'=>'']);
    }
    public function saveWebContent(Request $request){
        $save=false;
        $text_value=null;
        $path=null;
        try{
            $validate=$request->validate([
                'config_name' => 'required'
            ]);
            if(($request->value_text !== null || $request->value_text !== "")  && $request->value_file !== null){
                if($request->value_text !== null && $request->value_text !== ""){
                    $text_value=$request->value_text;
                }
                if($request->value_file !== null){
                    $file=$request->value_file;
                    $size=$file->getSize();
                    $type=$file->getMimeType();
                    if($size <= 6291456){
                        $type_allowed=["application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "image/png", "image/jpeg", "image/jpg", "image/webp", "image/gif"];
                        if(in_array($type, $type_allowed)){
                            $destination="upload/config";
                            $filename=date('YmdHis')."-".$file->getClientOriginalName();
                            $file->move($destination, $filename);
                            if(File::exists($destination."/".$filename)){
                                $path=$destination."/".$filename;
                            }
                        }else{
                            $msg="Tipe data harus document *.pdf / *.docx / *.doc / *.rtf / *.png / *.jpg bukan ".$type;
                        }
                    }else{
                        $msg="Size harus lebih kecil dari 6 mb";
                    }
                }
                $config=new Config;
                $config->config_name=$request->config_name;
                $config->config_value=$text_value;
                $config->file_value=$path;
                $config->active=true;
                $save=$config->save();
                if($save){
                    $msg="Berhasil menyimpan konfigurasi";
                }else{
                    $msg="Terjadi kesalahan saat menyimpan konfigurasi";
                }
            }else{
                $msg="Text atau File harus diisi ";
            }
        }catch(ValidationException $e){
            $msg="";
            $obj_msg=json_decode($e->validator->errors());
            $count=count(array($obj_msg));
            $x=0;
            for($x=0;$x<$count;$x++){
                if(isset($obj_msg->config_name[$x])){
                    $msg=$obj_msg->config_name[$x];
                    break;
                }
            }
        }
        return response()->json(['status'=>$save, 'msg'=>$msg, 'callLink'=>'list-config-web']);
    }
    public function editConfig(Request $request){
        try{

            $config_id=Crypt::decrypt($request->token_id);
            $get_config=Config::where('id', $config_id)->first();
            if(!is_null($get_config)){
                return view('arunika/admin/form_add_config', ['data'=>$get_config]);
            }else{
                echo "Data not found";
            }
        }catch(DecryptException $e){
            echo "Invalid token";
        }
    }
    public function updateConfig(Request $request){
        $update=false;
        $text_value=null;
        $file_value=null;
        $path=null;
        $upload=true;
        try{
            $config_id=Crypt::decrypt($request->token_id);
            $get_config=Config::where('id', $config_id)->first();
            if(!is_null($get_config)){
                $text_value=$request->value_text;
                $file_value=$request->value_file;
                if(($text_value !== "" || $text_value !== null) && $file_value !== null){
                    if($text_value !== "" && $text_value !== null){
                        $text_value=$request->value_text;
                    }
                    if($file_value !== null){
                        $upload=false;
                        $file=$request->value_file;
                        $size=$file->getSize();
                        $type=$file->getMimeType();
                        if($size <= 6291456){
                            $type_allowed=["application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "image/png", "image/jpeg", "image/jpg", "image/webp", "image/gif"];
                            if(in_array($type, $type_allowed)){
                                $destination="upload/config";
                                $filename=$file->getClientOriginalName();
                                $file->move($destination, $filename);
                                $path=$destination."/".$filename;
                                if(File::exists($path)){
                                    $upload=true;
                                }else{
                                    $msg="Terjadi kesalahan sistem saat upload file";
                                }
                            }else{
                                $msg="Tipe data harus document *.pdf / *.docx / *.doc / *.rtf / *.png / *.jpg bukan ".$type;
                            }
                        }else{
                            $msg="Maximum Filesize 6mb";
                        }
                    }

                    if($upload){
                        $get_config->config_name=$request->config_name;
                        $get_config->config_value=$text_value;
                        $get_config->file_value=$path;
                        $update=$get_config->update();
                        if($update){
                            $msg="Berhasil mengubah data";
                        }else{
                            $msg="Terjadi kesalahan saat mengubah data";
                        }
                    }
                }else{
                    $msg="File atau text harus diisi";
                }
            }else{
                $msg="Data tidak ditemukan ".$config_id;
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update, 'msg'=>$msg, 'btnBack'=>'backToList']);
    }
    public function listPertanyaan($page){
        try{
            $page_dec=Crypt::decrypt($page);
            $limit=15;
            $get_all=Checklist_review::where('active', true)
                        ->get();
            $jumlah_total=$get_all->count();
            $jumlah_halaman=ceil($jumlah_total / $limit);
            $skip=(int) $page_dec*$limit-$limit;
            $get_data=Checklist_review::where('active', true)
                        ->skip($skip)->take($limit)
                        ->get();
            return view('arunika/admin/list_pertanyaan', ['list_pertanyaan'=>$get_data, 'page'=>(int) $page_dec, 'jumlah_halaman'=>(int) $jumlah_halaman, 'no'=>$skip+=1, 'total'=>$jumlah_total]);
        }catch(DecryptException $e){
            echo "Invalid token";
        }
    }
    public function formNewPertanyaan(){
        return view('arunika/admin/form_new_pertanyaan', ['page'=>Crypt::encrypt('1')]);
    }
    public function savePertanyaan(Request $request){
        $save=false;
        try{
            $validate=$request->validate([
                'pertanyaan'=>'required'
            ]);
            $pertanyaan=new Checklist_review;
            $pertanyaan->pertanyaan=$request->pertanyaan;
            $pertanyaan->active=true;
            $save=$pertanyaan->save();
            if($save){
                $msg="Berhasil menyimpan data pertanyaan";
            }else{
                $msg="Terjadi kesalahan saat menyimpan pertanyaan";
            }
        }catch(ValidationException $e){
            $msg="Pertanyaan harus diisi";
        }
        return response()->json(['status'=>$save, 'msg'=>$msg, 'btnBack' => "list_menu[data-target='checklist_review']"]);
    }
    public function dec($str){
        echo Crypt::decrypt($str);
    }
    public function removePertanyaan(Request $request){
        $update=false;
        try{
            $pertanyaan_id=Crypt::decrypt($request->target);
            $get_data=Checklist_review::where('id', $pertanyaan_id)->first();
            if(!is_null($get_data)){
                $get_data->active=false;
                $update=$get_data->update();
                if($update){
                    $msg="Berhasil menghapus data";
                }else{
                    $msg="Terjadi kesalahan pada sistem saat menghapus data";
                }
            }else{
                $msg="Data tidak ditemukan";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update, 'msg'=>$msg, 'callLink'=>"callLink('list-pertanyaan-review/".Crypt::encrypt('1')."')"]);
    }
}
