<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Issue_artikel;
use App\Publish_artikel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use File;

class issueArtikelController extends Controller
{
    public function index(){
        if(isJM()){
            $get_issue=Issue_artikel::orderBy('id', 'desc')->get();
            $jumlah=$get_issue->count();
            return response()->view('arunika/issue/list_issue', ['data'=>$get_issue, 'jumlah'=>$jumlah]);
        }else{
            echo "Access denied";
        }
    }
    public function formAddIssue(){
        if(isJM()){
            return response()->view('arunika/issue/form_add_issue');
        }else{
            echo "Access denied";
        }
    }
    public function saveIssueArtikel(Request $request){
        if(!isJM()){
            echo "Access denied";die();
        }
        $save=false;
        try{
            $validation=$request->validate([
                'name'=>'required',
                'description'=>'required',
                'year'=>['required', 'digits:4'],
                'flyer'=>['required', 'file'],
            ]);

            $check=Issue_artikel::where('status',1)->first();
            if(!is_null($check)){
                $msg="Tidak dapat menyimpan tema ini, karena masih ada tema yang belum dipublish";
            }else{
                $file=$request->flyer;
                $size=$file->getSize();
                $type=$file->getMimeType();
                if($size <= 3145728){
                    if($type === "image/jpg" || $type === "image/png" || $type === "image/jpeg" || $type === "image/webp"){
                        $filename='flyer_'.date('YmdHis').'_'.$file->getClientOriginalName();
                        $destination="upload/image";
                        $file->move($destination, $filename);
                        $path=$destination."/".$filename;
                        if(File::exists($path)){
                            $code=$this->generateCode();;
                            $issue=new Issue_artikel;
                            $issue->code_issue=$code;
                            $issue->name=$request->name;
                            $issue->description=$request->description;
                            $issue->year=$request->year;
                            $issue->flyer=$path;
                            $issue->status=1;
                            $save=$issue->save();
                            if($save){
                                $msg="Berhasil menyimpan data issue";
                            }else{
                                $msg="Terjadi kesalahan sistem saat menyimpan data issue";
                            }
                        }else{
                            $msg="Terjadi kesalahan sistem saat upload Dokumen. Silahkan hubungi tim IT";
                        }
                    }else{
                        $msg="Tipe file harus JPG / PNG. ".$type;
                    }
                }else{
                    $msg="Ukuran file harus dibahwah atas sama dengan 3mb";
                }
            }
        }catch(ValidationException $e){
            $msg=$e->validator->errors()->first();
        }
        return response()->json(['status'=>$save, 'msg'=>$msg, 'btnBack'=>'back']);
    }
    public function getIssueById(Request $request){
        try{
            $issue_id=Crypt::decrypt($request->token_id);
            if($request->pattern === "issue_artikel"){
                $get_data=Issue_artikel::where('id', $issue_id)->first();
                if(!is_null($get_data)){
                    return view('arunika/issue/form_add_issue', ['data'=>$get_data]);
                }else{
                    $msg="Issue artikel tidak ditemukan";
                }
            }else{
                $msg="Rute salah";
            }
        }catch(DecryptException $e){
            $msg="Data tidak ditemukan";
        }
    }
    public function updateIssueArtikel(Request $request){
        $update=false;
        try{
            $issue_id=Crypt::decrypt($request->token_i);
            try{
                $validate=$request->validate([
                    'name'=>'required',
                    'description'=>'required',
                    'year'=>['required', 'digits:4'],
                    "status"=>["required"],
                ]);
                $upload=true;
                $path=null;
                $check_data=Issue_artikel::where('id', $issue_id)->first();
                if(!is_null($check_data)){
                    if(isset($request->flyer) && $request->flyer !== "" && $request->flyer !=="NULL"){
                        $upload=false;
                        $file=$request->flyer;
                        $size=$file->getSize();
                        $type=$file->getMimeType();
                        if($size <= 3145728){
                            if($type === "image/jpg" || $type === "image/png" || $type === "image/jpeg" || $type === "image/webp"){
                                    $destination="upload/image";
                                    $filename=$file->getClientOriginalName();
                                    $file->move($destination, $filename);
                                    $path=$destination."/".$filename;
                                    if(File::exists($path)){
                                        $upload=true;
                                    }else{
                                        $msg="Dokumen tidak dapat diupload";
                                    }
                            }else{
                                $msg="Tipe file harus Image JPG / PNG ".$type;
                            }
                        }else{
                            $msg="Ukuran file harus dibawah 3mb";
                        }
                    }
                }else{
                    $upload=false;
                    $msg="Data tidak ditemukan";
                }
                if($upload === true){
                    $check_data->name=$request->name;
                    $check_data->description=$request->description;
                    $check_data->year=$request->year;
                    $check_data->status=$request->status;
                    if($path !== null){
                        $check_data->flyer=$path;
                    }
                    $update=$check_data->update();
                    if($update){
                        $msg="Berhasil mengubah data";
                    }else{
                        $msg="Terjadi kesalahan sistem saat mengubah data";
                    }
                }
            }catch(\Exception $e){
                $msg=$e->validator->errors()->first();
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update, 'msg'=>$msg, 'btnBack'=>'back']);
    }
    public function deleteIssueArtikel(Request $request){
        $delete=false;
        try{
            $issue_id=Crypt::decrypt($request->token_i);
            $get_data=Issue_artikel::where('id', $issue_id)->first();
            if(!is_null($get_data)){
                $check_data=Publish_artikel::where('code_issue', $get_data['code_issue'])->get();
                if($check_data->count() > 0){
                    $msg="Tidak dapat melakukan penghapusan karena ada beberapa data yang terkait";
                }else{
                    $delete=$get_data->delete();
                    if($delete){
                        $msg="Berhasil menghapus data";
                    }else{
                        $msg="Terjadi kesalahan saat menghapus data";
                    }
                }
            }else{
                $msg="Data tidak ditemukan";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$delete, 'msg'=>$msg, 'callLink'=>'list-issue-artikel']);
    }
    public function generateCode(){
        $code=str()->random(5);
        $check=Issue_artikel::where('code_issue', $code)->first();
        if(!is_null($check)){
            $this->generateCode();
        }
        return $code;
    }
}
