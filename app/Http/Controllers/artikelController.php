<?php

namespace App\Http\Controllers;
require '../resources/vendor/autoload.php';
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use File;
use App\Penulis_artikel;
use App\Artikel;
use App\Kategori_artikel;
use App\Keyword;
use App\Config;
use App\Step_master;
use App\Reviewer_artikel;
use App\Editorial_team;
use App\Review_stage;
use App\Checklist_review;
use App\Checklist_Review_result;
use App\Hasil_reviewer;
use App\Publish_artikel;
use App\Statistik_baca;
use App\Pegawai;
use App\Pengumuman_arunika;
use ZipArchive;
use App\Issue_artikel;
use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;

class artikelController extends Controller
{
    public function formNewArtikel($id_artikel){
        $id_artikel_dec=Crypt::decrypt($id_artikel);
        $jumlah_review=0;
        $step=0;
        if($id_artikel_dec !== "null"){
            $get_data=Artikel::where('id', $id_artikel_dec)
                        ->first();
            $step=$get_data['step'];
            $review_stage=Review_stage::where('id_artikel', $id_artikel_dec)->get();
            $jumlah_review=$review_stage->count();
        }
        return view("arunika/artikel/tab_new_artikel", ['id_artikel'=>$id_artikel, 'jumlah_review'=>$jumlah_review, 'step'=>$step]);
    }
    public function formDataPribadi(Request $request){
        try{
            $id_artikel=Crypt::decrypt($request->token);
            if($id_artikel === "null"){
                $nip=Auth::user()->nip;
                $enc_nip=Crypt::encrypt($nip);
                $id_pegawai=Crypt::encrypt('null');
                return view('arunika/artikel/form_data_pribadi', ['nip'=>$nip, 'enc_nip'=>$enc_nip, 'id_pegawai'=>$id_pegawai, 'link_save'=>'save-data-pribadi']);
            }else{
                $get_data=Artikel::join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                        ->select('penulis_artikel.*', 'artikel.foto_penulis', 'artikel.step')
                        ->where('artikel.id', $id_artikel)
                        ->first();
                if(!is_null($get_data)){
                    if($request->view === "view"){
                        return view('arunika/artikel/view_data_pribadi', ['data'=>$get_data]);
                    }else if($request->view === 'form'){
                        $validate_edit=$this->checkValidateEdit(Crypt::encrypt($get_data['step']));
                        if($validate_edit->edit){
                            return view('arunika/artikel/form_data_pribadi', ['nip'=>Auth::user()->nip, 'enc_nip'=>Crypt::encrypt(Auth::user()->nip), 'id_pegawai'=>Crypt::encrypt($get_data['id']), 'foto_penulis'=>$get_data['foto_penulis'], 'link_save'=>'update-data-pribadi']);
                        }else{
                            echo "<center><span class='fas fa-exclamation-circle' style='font-size:5vw;color:red;'></span><br /><br /></center><b><h5><center>".$validate_edit->msg."</center></h5></b><center><button class='btn btn-info btn-sm tabs' data-target='data_pribadi'>< Kembali</button></center>";
                        }
                    }
                }else{
                    echo "Data tidak ditemukan ".$id_artikel;
                }
            }
        }catch(DecryptException $e){
            echo "Invalid token ";
        }
    }
    public function formDataArtikel(Request $request){
        $status=false;
        try{
            $id_artikel=Crypt::decrypt($request->token);
            $check=$this->checkValidateTabsRequest($request->token, 2);
            if($check->status){
                $kategori_artikel=Kategori_artikel::all();
                $artikel=Artikel::leftJoin('kategori_artikel', 'kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                        ->select('artikel.*', 'kategori_artikel.kategori')
                        ->where('artikel.id', $id_artikel)->first();
                $keyword=Keyword::where('id_artikel', $id_artikel)->get();
                if($artikel->judul === null){
                    return view('arunika/artikel/form_data_artikel', ['kategori'=>$kategori_artikel, 'artikel'=>$artikel, 'keyword'=>$keyword]);
                }else{
                    if($request->view === "form"){
                        $validate_edit=$this->checkValidateEdit(Crypt::encrypt($artikel['step']));
                        if($validate_edit->edit){
                            return view('arunika/artikel/form_data_artikel', ['kategori'=>$kategori_artikel, 'artikel'=>$artikel, 'keyword'=>$keyword]);
                        }else{
                            echo "<center><span class='fas fa-exclamation-circle' style='font-size:5vw;color:red;'></span><br /><br /></center><b><h5><center>".$validate_edit->msg."</center></h5></b><center><button class='btn btn-info btn-sm tabs' data-target='artikel'>< Kembali</button></center>";
                        }
                    }else{
                        return view('arunika/artikel/view_data_artikel', ['artikel'=>$artikel, 'keyword'=>$keyword]);
                    }
                }
            }else{
                return response()->json(['status'=>$status, 'msg'=>$check->msg]);
            }
        }catch(DecryptException){
            echo "Invalid token";
            die();
        }
    }
    public function dataKonfirmasi(Request $request){
        $status=false;
        try{
            $id_artikel=Crypt::decrypt($request->token);
            $check=$this->checkValidateTabsRequest($request->token, 3);
            if($check->status){
                $get_config=Config::where('config_name', 'Konfirmasi Pernyataan')
                                ->first();
                
                if(!is_null($get_config)){
                    $pernyataan=$get_config['config_value'];
                }else{
                    $pernyataan="Pernyataan belum disetting";
                }
                $checked="";
                $class_btn="btn-send";
                if($check->data->step === 3){
                    $checked="checked";
                    $class_btn="";
                }
                return view('arunika/artikel/konfirmasi_artikel', ['pernyataan'=>$pernyataan, 'checked'=>$checked, 'class_btn'=>$class_btn]);
            }else{
                return response()->json(['status'=>$status, 'msg'=>$check->msg]);
            }
        }catch(DecryptException $e){
            echo "Invalid Token";
            die();
        }
    }
    public function checkValidateEdit($step){
        $edit = false;
        $msg="";
        try{
            $step=Crypt::decrypt($step);
            if(($step <= 2 && $step === 5) || $step !== null){
                $edit=true;
            }else{
                $msg="Data sudah tidak dapat diubah kembali. Mohon menunggu sampai review artikel selesai";
            }
        }catch(DecryptException $e){
            $msg="Token tidak valid";
        }
        return response()->json(['edit'=>$edit, 'msg'=>$msg])->getData();
    }
    public function checkValidateStep($review_id, $artikel_id, $step, $step_name){
        $get_data=Review_stage::where('id', $review_id)
                    ->where('id_artikel', $artikel_id)
                    ->whereRaw('edoc_perbaikan_penulis is null')
                    ->first();
        if(!is_null($get_data)){
            if(($step_name === "saveChecklistReview" || $step_name === "saveHasilReview" || $step_name === "removeHasilReview" || $step_name === "sendHasilToAuthor" || $step_name === "saveCatatanReview") && $step === 4){
                return true;
            }else if($step === 5 and $step_name === "cancelHasilToAuthor"){
                return true;
            }
        }
        return false;
    }
    public function checkValidateTabsRequest($artikel_id, $next_step){
        $check=false;
        $msg="";
        $get_data=null;
        try{
            $artikel_id_dec=Crypt::decrypt($artikel_id);
            if($next_step === 3){
                $get_data=Artikel::where('id', $artikel_id_dec)
                        ->where('step', ($next_step-1))
                ->first();
            }else{
                $get_data=Artikel::where('id', $artikel_id_dec)
                        ->where(function($q) use($next_step){
                            $q->where('step', ($next_step-1))
                                ->orWhereRaw('step >= '.$next_step);
                        })
                ->first();
            }
            if(!is_null($get_data)){
                $check=true;
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            $msg="Token tidak valid";
        }
        return response()->json(['status'=>$check, 'msg'=>$msg, 'data'=>$get_data])->getData();
    }
    public function searchNIP(Request $request){
        $status=false;
        $data=[];
        $msg="";
        try{
            $nip=$request->nip;
            $dec_nip=Crypt::decrypt($nip);
            $login_nip=Auth::user()->nip;

            if($dec_nip === $login_nip){
                $data_sikep=DB::select('CALL SPGetHakimByNip('.$dec_nip.')');
                $jumlah_data=count($data_sikep);
                if($jumlah_data === 1){
                    $status=true;
                    $json_data=(array)$data_sikep[0];
                    $data['nama']=$json_data['NamaLengkap'];
                    $data['token']=Crypt::encrypt($json_data['IdPegawai']);
                    $data['no_hp']=$json_data['NomorHandphone'];
                    $data['satker']=$json_data['NamaStruktur'];
                    $data['jabatan']=$json_data['NamaJabatan'];
                    $data['pangkat']=$json_data['KodeGolonganRuang'];
                }else{
                    $msg="NIP Anda tidak ditemukan. Silahkan hubungi Developer";
                }
                
            }else{
                $msg="Data anda tidak valid. Silahkan input NIP yang sesuai ";
            }
        }catch(DecyptException $e){
            $msg="Data NIP Tidak valid";
        }
        return response()->json(['status'=>$status, 'msg'=>$msg, 'data'=>$data]);
    }
    public function createThumbnail($filename, $path){
        $source = imagecreatefromjpeg($path);
        list($width, $height) = getimagesize($path);

        // Define new dimensions (200x200 pixels)
        $newWidth = 300;
        $newHeight = 450;

        // Create a new image
        $thumb = imagecreatetruecolor($newWidth, $newHeight);

        // Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save the resized image
        imagejpeg($thumb, 'upload/image/thumbnail/thumbnail_'.$filename, 100);
    }
    
    public function saveDataPribadi(Request $request){
        $msg="";
        $token_id=Crypt::encrypt('null');
        $callFn="";
        $status=false;
        try{
            $validated=$request->validate([
                'token' => ['required'],
                'nip' => ['required','digits:18'],
                'foto_hakim' => ['required', 'image'],
            ]);
            try{
                $dec_nip=Crypt::decrypt($request->nip_baru);
                $id_pegawai=Crypt::decrypt($request->token);
                if($dec_nip === Auth::user()->nip){
                    $data_sikep=DB::select('CALL SPGetHakimByNip('.$dec_nip.')');
                    $jumlah_data=count($data_sikep);
                    if($jumlah_data === 1){
                        $json_data=(array)$data_sikep[0];
                        if($dec_nip === Auth::user()->nip){
                            $file_foto=$request->foto_hakim;
                            $size=$file_foto->getSize();
                            $type=$file_foto->getMimeType();
                            if($size <= 3145728){
                                if($type === "image/png" || $type === "image/jpeg" || $type === "image/png"){
                                    $destination="upload/image";
                                    $filename=date('YmdHis')."-".$file_foto->getClientOriginalName();
                                    $file_foto->move($destination, $filename);
                                    $path=$destination."/".$filename;
                                    if(File::exists($path)){
                                        $generateThumbnail=$this->createThumbnail($filename, $path);
                                        $penulis=new Penulis_artikel;
                                        $penulis->id_pegawai=$json_data['IdPegawai'];
                                        $penulis->nama=$json_data['NamaLengkap'];
                                        $penulis->nip=$request->nip;
                                        $penulis->no_handphone=$json_data['NomorHandphone'];
                                        $penulis->satker=$json_data['NamaStruktur'];
                                        $penulis->jabatan=$json_data['NamaJabatan'];
                                        $penulis->pangkat=$json_data['KodeGolonganRuang'];
                                        $save_penulis=$penulis->save();
                                        if($save_penulis){
                                            $penulis_id=$penulis->id;
                                            $artikel=new Artikel;
                                            $artikel->id_penulis=$penulis_id;
                                            $artikel->foto_penulis=$path;
                                            $artikel->step=1;
                                            if($artikel->save()){
                                                $status=true;
                                                $token_id=Crypt::encrypt($artikel->id);
                                                $callFn="loadDataPribadi('view')";
                                                $msg="Berhasil menyimpan data penulis";
                                            }else{
                                                $msg="Terjadi kesalahan saat menyimpan artikel";
                                            }
                                        }else{
                                            $msg="Terjadi kesalahan saat menyimpan data penulis";
                                        }
                                    }else{
                                        $msg="Terjadi kesalahan saat upload image";
                                    }
                                }else{
                                    $msg="Tipe data harus Gambar (JPG / PNG)";
                                }
                            }else{
                                $msg="Ukuran File harus lebih kecil dari 3mb";
                            }
                        }else{
                            $msg="Data NIP tidak valid";
                        }    
                    }else{
                        $msg="NIP Anda tidak ditemukan. Silahkan hubungi Developer";
                    }
                }else{
                    $msg="Anda tidak berhak mengubah data ini";
                }
            }catch(DecryptException $e){
                $msg="NIP Tidak valid";
            }
        }catch(ValidationException $e){
            $msg="";
            $obj_msg=json_decode($e->validator->errors());
            $count=count(array($obj_msg));
            $x=0;
            for($x=0;$x<$count;$x++){
                if(isset($obj_msg->nip[$x])){
                    $msg=$obj_msg->nip[$x];
                    break;
                }
                if(isset($obj_msg->foto_hakim[$x])){
                    $msg=$obj_msg->foto_hakim[$x];
                    break;
                }   
            }
        }
        return response()->json(['status'=>$status, 'msg'=>$msg, 'token_id'=>$token_id, 'callForm'=>$callFn]);
    }
    public function updateDataPribadi(Request $request){
        $status=false;
        $artikel_id=null;
        try{
            $id_pegawai=Crypt::decrypt($request->token);
            $artikel_id=Crypt::decrypt($request->token_a);
            $nip=Crypt::decrypt($request->nip_baru);
            if(isYourArtikel($artikel_id)){
                if($artikel_id !== "null"){
                    $get_data=Penulis_artikel::where('id', $id_pegawai)
                                ->first();
                    $get_artikel=Artikel::where('id', $artikel_id)->first();
                    if(!is_null($get_data) && !is_null($get_artikel)){
                        try{
                            $validated=$request->validate([
                                'token' => ['required'],
                                'nip' => ['required','digits:18'],
                            ]);
                            $file_foto=$request->foto_hakim;
                            $upload=true;
                            $path=null;
                            if($file_foto !== "" && $file_foto !== NULL){
                                $upload=false;
                                $size=$file_foto->getSize();
                                $type=$file_foto->getMimeType();
                                if($size <= 3145728){
                                    if($type === "image/png" || $type === "image/jpeg" || $type === "image/png"){
                                        $filename=date('YmdHis')."-".$file_foto->getClientOriginalName();
                                        $destination="upload/image";
                                        $file_foto->move($destination, $filename);
                                        $path=$destination."/".$filename;
                                        if(File::exists($path)){
                                            $upload=true;
                                        }else{
                                            $msg="Terjadi kesalahan saat upload foto";
                                        }
                                    }else{
                                        $msg="Tipe data harus Image (JPG / PNG)";
                                    }
                                }else{
                                    $msg="Ukuran file harus lebih kecil dari 3mb";
                                }
                            }
    
                            if($upload === true){
                                $get_data_sikep=DB::select("CALL SPGetHakimByNip('".$nip."')");
                                $jumlah_data=count($get_data_sikep);
                                if($jumlah_data === 1){
                                    $json_data=(array)$get_data_sikep[0];
                                    $get_data->id_pegawai=$json_data['IdPegawai'];
                                    $get_data->nama=$json_data['NamaLengkap'];
                                    $get_data->nip=$nip;
                                    $get_data->no_handphone=$json_data['NomorHandphone'];
                                    $get_data->satker=$json_data['NamaStruktur'];
                                    $get_data->jabatan=$json_data['NamaJabatan'];
                                    $get_data->pangkat=$json_data['KodeGolonganRuang'];
                                    $update=$get_data->update();
                                    if($update){
                                        $update_artikel=true;
                                        if($path !== null){
                                            $update_artikel=false;
                                            $get_artikel->foto_penulis=$path;
                                            $update_artikel=$get_artikel->update();
                                        }
                                        if($update_artikel){
                                            $status=true;
                                            $msg="Berhasil mengubah data";
                                        }else{
                                            $msg="Terjadi kesalahan saat update data artikel";
                                        }
                                    }else{
                                        $msg="Tidak dapat mengubah data penulis";
                                    }
                                }else{
                                    $msg="Data tidak ditemukan pada SIKEP";
                                }
                            }
                        }catch(ValidationException $e){
                            $msg="";
                            $obj_msg=json_decode($e->validator->errors());
                            $jumlah_data=count(array($obj_msg));
                            for($x=0;$x<$jumlah_data;$x++){
                                if(isset($obj_msg->nip[$x])){
                                    $msg=$obj_msg->nip[$x];
                                    break;
                                }
                            }
                        }
                    }else{
                        $msg="Data tidak ditemukan ";
                    }
                }else{
                    $msg="Artikel tidak valid";
                }
            }else{
                $msg="Tidak dapat mengubah data ini.";
            }
        }catch(DecryptException $e){
            $msg="Data Hakim tidak sesuai";
        }
        
        return response()->json(['status'=>$status, 'msg'=>$msg, 'callForm'=>"loadDataPribadi('view')", 'token_id'=>Crypt::encrypt($artikel_id)]);
    }
    public function updateDataArtikel(Request $request){
        $status=false;
        $callForm="";
        $save_keyword=false;
        try{
            $artikel_id=Crypt::decrypt($request->token_a);
            if(isYourArtikel($artikel_id)){
                $step_id=[1,2,5];
                $check_data=Artikel::where('id', $artikel_id)
                        ->whereIn('step', $step_id)
                        ->first();
                try{
                    if(!is_null($check_data)){
                        if($check_data['judul'] === null || $check_data['judul'] === ""){
                            $validated=$request->validate([
                                'judul_artikel' => ['required'],
                                'kategori_artikel' => ['required','max:4'],
                                'tentang_artikel' => ['required'],
                                'file_artikel' => ['required', 'file'],
                            ]);
                        }else{
                            $validated=$request->validate([
                                'judul_artikel' => ['required'],
                                'kategori_artikel' => ['required','max:4'],
                                'tentang_artikel' => ['required'],
                            ]);
                        }
                        if($check_data['step'] === 1){
                            $step_id=2;
                        }else{
                            $step_id=$check_data['step'];
                        }
                        $list_keyword=json_decode($request->list_keyword);
                        $jlh_keyword=count($list_keyword);
                        if($jlh_keyword > 0){
                            $deleted_keyword=0;
                            $real_keyword=[];
                            $index_real_keyword=0;
                            for($x=0;$x<$jlh_keyword;$x++){
                                if(strpos($list_keyword[$x], 'removed') !== false){
                                    $deleted_keyword+=1;
                                }else{
                                    $real_keyword[$index_real_keyword]=$list_keyword[$x];
                                    $index_real_keyword++;
                                }
                            }
                            if($deleted_keyword < $jlh_keyword){
                                //insert keyword
                                $saved_keyword=0;
                                for($x=0;$x<count($real_keyword);$x++){
                                    $key=str_replace(" x", "",  $real_keyword[$x]);
                                    $keyword=new Keyword;
                                    $keyword->id_artikel=$artikel_id;
                                    $keyword->keyword=$key;
                                    $save_keyword=$keyword->save();
                                    if($save_keyword){
                                        $saved_keyword+=1;
                                    }
                                }
                                if($saved_keyword === count($real_keyword)){
                                    $save_keyword=true;
                                }else{
                                    $msg="Terjadi keslahan saat menyimpan keyword. Silahkan hubungi pengembang aplikasi";
                                }
                            }elseif($deleted_keyword < $jlh_keyword && $check_data['judul'] !== null){
                                $save_keyword=true;
                            }else{
                                $msg="Keyword harus diisi";
                            }
                        }else{
                            if($check_data['judul'] !== null || $check_data['judul'] !== ""){
                                $save_keyword=true;
                            }else{
                                $msg="Keyword harus diisi";
                            }
                        }

                        if($save_keyword === true){
                            $edoc_artikel=$request->file_artikel;
                            $path=null;
                            $upload=true;
                            if($edoc_artikel !== "" && $edoc_artikel !== NULL){
                                $upload=false;
                                $size=$edoc_artikel->getSize();
                                $type=$edoc_artikel->getMimeType();
                                if($size <= 6291456){
                                    // 'doc' => 'application/msword',
                                    // 'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    // 'rtf' => 'application/msword',
                                    // 'odt' => 'application/vnd.oasis.opendocument.text',
                                    // 'txt' => 'text/plain',
                                    // 'pdf' => 'application/pdf',
                                    if($type === "application/pdf" || $type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $type === "pplication/msword"){
                                        $destination="upload/edoc/artikel";
                                        $filename=date('YmdHis')."-".$edoc_artikel->getClientOriginalName();
                                        $edoc_artikel->move($destination, $filename);
                                        $path=$destination."/".$filename;
                                        if(File::exists($path)){
                                            $upload=true;
                                        }else{
                                            $msg="Terjadi kesalahan pada saat upload file";
                                        }
                                    }else{
                                        $msg="Tipe file harus *.doc / *.docx / *.rtf / *.pdf";
                                    }
                                }else{
                                    $msg="Ukuran file harus lebih kecil dari 6 mb ".$size;
                                }   
                            }
                            if($upload){
                                $check_data->judul=$request->judul_artikel;
                                $check_data->kategori_artikel_kode=$request->kategori_artikel;
                                if($path !== null){
                                    $check_data->edoc_artikel=$path;
                                }
                                $check_data->tentang_artikel=filter_var(str_replace(array("\n","\r"), '', (str_replace('"', "'", $request->tentang_artikel))), FILTER_SANITIZE_STRING);
                                $check_data->step=$step_id;
                                $update=$check_data->update();
                                if($update){
                                    $callForm="loadDataArtikel('view')";
                                    $status=true;
                                    $msg="Berhasil menyimpan data artikel";
                                }else{
                                    $msg="Terjadi kesalahan saat menyimpan data artikel. Silahkan hubungi tim developer";
                                }
                            }
                        }
                    }else{
                        $msg="Artikel ini tidak bisa diubah";
                    }
                }catch(ValidationException $e){
                    $msg="";
                    $obj_msg=json_decode($e->validator->errors());
                    $count=count(array($obj_msg));
                    $x=0;
                    for($x=0;$x<$count;$x++){
                        if(isset($obj_msg->judul_artikel[$x])){
                            $msg=$obj_msg->judul_artikel[$x];
                            break;
                        }
                        if(isset($obj_msg->kategori_artikel[$x])){
                            $msg=$obj_msg->kategori_artikel[$x];
                            break;
                        }
                        if(isset($obj_msg->tentang_artikel[$x])){
                            $msg=$obj_msg->tentang_artikel[$x];
                            break;
                        }
                        if(isset($obj_msg->file_artikel[$x])){
                            $msg=$obj_msg->file_artikel[$x];
                            break;
                        }   
                    }
                }
            }else{
                $msg="Anda tidak dapat melakukan perubahan data.";
            }
        }catch(DecryptExcecption $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$status, 'msg'=>$msg, 'token_id'=>Crypt::encrypt($artikel_id), 'callForm'=>$callForm]);
    }
    public function downloadFile($file, $type){
        try{
            $file_path=Crypt::decrypt($file);
            // var_dump($file_path);die();
            if(File::exists($file_path)){
                if($type === "edoc_artikel"){
                    $prefix_path="upload/edoc/artikel/pdf/";
                }elseif($type === "edoc_pengumuman"){
                    $prefix_path="upload/pengumuman/";
                }elseif($type === "image_config"){
                    $prefix_path="upload/config/";
                }
                $file_name=str_replace($prefix_path, '', $file_path);
                return response()->download($file_path, $file_name);
            }else{
                echo "<center><h2>404</h2><h5>File not Found</h5></center>";
            }
        }catch(DecryptException $e){
            echo "<center><h2>500</h2><h5>Err Found. Undefined data</h5></center>";
        }
    }
    public function removeKeyword(Request $request){
        $delete=false;
        try{
            $id_art_key=Crypt::decrypt($request->token);
            $explode=explode("::", $id_art_key);
            $id_artikel=$explode[0];
            $id_keyword=$explode[1];
            if(isYourArtikel($id_artikel)){
                $step_id=[2, 5];
                $get_keyword=Keyword::join('artikel', function($q) use($step_id){
                                    $q->on('artikel.id', '=', 'keyword_artikel.id_artikel')
                                    ->whereIn('artikel.step', $step_id);
                                })
                ->where('keyword_artikel.id_artikel', $id_artikel)
                ->where('keyword_artikel.id', $id_keyword)
                ->first();
                if(!is_null($get_keyword)){
                    $delete=$get_keyword->delete();
                    if($delete){
                        $msg="Keyword berhasil dihapus";
                    }else{
                        $msg="Terjadi kesalahan saat menghapus keyword";
                    }
                }else{
                    $msg="Tidak dapat menghapus Keyword";
                }
            }else{
                $msg="Anda tidak dapat melakukan penghapusan data ini";
            }
        }catch(DecryptException $e){
            $msg="Data tidak valid";
        }
        return response()->json(['status'=>$delete, 'msg'=>$msg]);
    }


    public function finishPage(Request $request){
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $validate_page=$this->checkValidateTabsRequest($request->token, 4);
            if($validate_page->status){
                return view('arunika/artikel/finish_page');
            }else{
                $msg=$validate_page->msg;
            }
        }catch(DecryptException $e){
            $msg="Invalid token ".$request->token;
        }
        return response()->json(['status'=>false, 'msg'=>$msg]);
    }
    public function sendArtikel(Request $request){
        $update=false;
        try{
            $artikel_id=Crypt::decrypt($request->token);
            if(isYourArtikel($artikel_id)){
                $validate_page=$this->checkValidateTabsRequest($request->token, 3);
                if($validate_page->status){
                    $get_data=Artikel::where('id', $artikel_id)->first();
                    $step=(int)$get_data['step'];
                    if(!is_null($get_data)){
                        $get_data->step=$step+1;
                        $update=$get_data->update();
                        if($update){
                            $category='send_artikel_to_jm';
                            $data_wa['judul']=$get_data['judul'];
                            $send_wa=$this->sendWaNotification($category, $data_wa);
                            $msg="Berhasil mengirimkan artikel";
                        }else{
                            $msg="Terjadi kesalahan pada saat mengirimkan artikel";
                        }
                    }else{
                        $msg="Data tidak ditemukan";
                    }
                }else{
                    $msg=$validate_page->msg;
                }
            }else{
                $msg="Anda tidak dapat mengirimkan artikel ini.";
            }
        }catch(DecryptExecption $e){
            $msg="Token tidak valid";
        }
        return response()->json(['status'=>$update, 'msg'=>$msg]);
    }
    public function listArtikelProses(){
        $nip=Auth::user()->nip;
        $get_data=Penulis_artikel::join('artikel', 'artikel.id_penulis', '=', 'penulis_artikel.id')
                        ->join('step_master', 'step_master.step_id', '=', 'artikel.step')
                        ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text')
                        ->where('nip', $nip)
                        ->whereRaw('step >= 3')
                        ->whereRaw('step <= 7')
                        ->get();
        $jumlah=$get_data->count();
        return view('arunika/artikel/list_artikel', ['data'=>$get_data, 'jumlah'=>$jumlah, 'class'=>'list_menu', 'target'=>'artikel_baru', 'title'=>'Artikel Anda', 'keterangan_title'=> 'Dafar artikel anda']);
    }
    public function listDraft(){
        $nip=Auth::user()->nip;
        $step_draft=[1,2];
        $get_data=Artikel::join('penulis_artikel', function($join) use($nip){
                                    $join->on('penulis_artikel.id', '=', 'artikel.id_penulis')
                                        ->where('penulis_artikel.nip', $nip);
                                })
                                ->join('step_master', 'step_master.id', '=', 'artikel.step')
                                ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text')
                                ->whereIn('artikel.step', $step_draft)
                                ->get();
        $jumlah_draft=$get_data->count();
        return view('arunika/artikel/list_draft', ['data'=>$get_data, 'jumlah'=>$jumlah_draft, 'class'=>'list_menu', 'target'=>'artikel_baru', 'title'=>'Artikel Anda', 'keterangan_title'=> 'Dafar Draft Artikel']);
    }
    public function listArtikelProsesReviewer(){
        $nip=Auth::user()->nip;
        $get_data=Artikel::join('step_master', 'step_master.step_id', '=', 'artikel.step')
                        ->join('reviewer_artikel', 'reviewer_artikel.id_artikel', '=', 'artikel.id')
                        ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                        ->join('pegawai', 'pegawai.id', '=', 'reviewer_artikel.id_pegawai')
                        ->join('review_stage', function($q){
                            $q->on('review_stage.id', '=', 'reviewer_artikel.id_review')
                            ->where('review_stage.step', 4);
                        })
                        ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text')
                        ->where('pegawai.nip', $nip)
                        ->whereRaw('artikel.step >= 3')
                        ->whereRaw('artikel.step <= 6')
                        ->get();
        $jumlah=$get_data->count();
        return view('arunika/artikel/list_artikel', ['data'=>$get_data, 'jumlah'=>$jumlah, 'class'=>'detil_artikel', 'target'=>'', 'title'=> 'Artikel Proses', 'keterangan_title'=> 'Dafar artikel yang sedang anda review']);
    }
    public function listArtikelProsesJM(){
        if(isJM()){
            $nip=Auth::user()->nip;
            $get_data=Artikel::join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text')
                            ->where('step', 3)
                            ->orWhere('step', 6)
                            //->orWhere('step', 7)
                            ->get();
            $jumlah=$get_data->count();
            return view('arunika/artikel/list_artikel', ['data'=>$get_data, 'jumlah'=>$jumlah, 'class'=>'detil_artikel', 'target'=>'', 'title'=> 'Artikel Proses Journal Manager', 'keterangan_title'=> 'Dafar artikel yang dalam Proses Review']);
        }else{
            echo "Access denied";
        }
    }
    public function listArtikelPublish(){
        $nip=Auth::user()->nip;
        $get_data=Artikel::join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                            ->join('issue_artikel', 'issue_artikel.code_issue', '=', 'publish_artikel.code_issue')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text', 'issue_artikel.name')
                            ->where('artikel.step', 8)
                            ->where('penulis_artikel.nip', $nip)
                            ->get();
        $jumlah=$get_data->count();
        return view('arunika/artikel/list_artikel', ['data'=>$get_data, 'jumlah'=>$jumlah, 'class'=>'detil_artikel', 'target'=>'', 'title'=> 'Artikel Publish', 'keterangan_title'=> 'Dafar artikel anda yang Publish']);
    }
    public function linkArtikelPublishJM(){
        if(isJM()){
            $get_data=Artikel::join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                            ->join('issue_artikel', 'issue_artikel.code_issue', '=', 'publish_artikel.code_issue')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text', 'issue_artikel.name')
                            ->where('step', 8)
                            ->get();
            $jumlah=$get_data->count();
            return view('arunika/artikel/list_artikel', ['data'=>$get_data, 'jumlah'=>$jumlah, 'class'=>'detil_artikel', 'target'=>'', 'title'=> 'Artikel Proses', 'keterangan_title'=>'List Artikel yang telah Publish']);
        }else{
            echo "Akses ditolak";
        }
    }
    public function listArtikelWaitingPublish(){
        if(isJM()){
            $get_data=Artikel::join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                            ->leftJoin('issue_artikel', 'issue_artikel.code_issue', '=', 'publish_artikel.code_issue')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text', 'issue_artikel.name')
                            ->where('step', 7)
                            ->get();
            $jumlah=$get_data->count();
            return view('arunika/artikel/list_artikel', ['data'=>$get_data, 'jumlah'=>$jumlah, 'class'=>'detil_artikel', 'target'=>'', 'title'=> 'Artikel Menunggu Publish (Early View)', 'keterangan_title'=>'List Artikel Menunggu Publish (Early View)']);
        }else{
            echo "Akses ditolak";
        }
    }
    public function listArtikelSelesaiReview(){
        if(isReviewer()){
            $get_data=Artikel::join('reviewer_artikel', 'reviewer_artikel.id_artikel', '=', 'artikel.id')
                            ->join('review_stage', function($q){
                                        $q->on('review_stage.id_artikel', '=', 'artikel.id')
                                        ->on('review_stage.id', '=', 'reviewer_artikel.id_review');
                                    })
                            ->join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->join('pegawai', 'pegawai.id', '=', 'reviewer_artikel.id_pegawai')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text', 'review_stage.review_ke')
                            ->where('pegawai.nip', Auth::user()->nip)
                            ->get();
            $jumlah=$get_data->count();
            return view('arunika/artikel/list_artikel', ['data'=>$get_data, 'jumlah'=>$jumlah, 'class'=>'detil_artikel', 'target'=>'', 'title'=> 'Artikel Proses', 'keterangan_title'=>'List Artikel yang selesai direview']);
        }else{
            echo "Akses ditolak";
        }
    }
    public function detilArtikel($artikel_id){
        try{
            $artikel_id_dec=Crypt::decrypt($artikel_id);
            $get_artikel=Artikel::where('id', $artikel_id_dec)->first();
            $step=$get_artikel['step'];
            return view("arunika/artikel/detil_artikel", ["id_artikel" => $artikel_id, 'step'=>$step, 'target'=>'list_artikel_publish_jm']);
        }catch(DecryptException $e){
            echo "invalid token";
        }
    }
    public function dataUmumArtikel(Request $request){
        try{
            $artikel_id_dec=Crypt::decrypt($request->token);
            $get_data=$get_data=Penulis_artikel::join('artikel', 'artikel.id_penulis', '=', 'penulis_artikel.id')
                            ->join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('kategori_artikel', 'kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text', 'kategori_artikel.kategori')
                            ->where('artikel.id', $artikel_id_dec)
                            ->whereRaw('step >= 3')
                            ->whereRaw('step <= 8')
                            ->first();
            if(!is_null($get_data)){
                $get_keyword=Keyword::where('id_artikel', $artikel_id_dec)->get();
                return view('arunika/artikel/data_umum_artikel', ['keyword'=>$get_keyword, 'data'=>$get_data]);
            }else{
                echo "Data tidak ditemukan";
            }
        }catch(DecryptException $e){
            echo "Invalid token";
        }
    }
    public function getDataReview($artikel_id){
        $data_review=[];
        $get_checklist_result=[];
        $get_review_stage=Review_stage::leftJoin('step_master', 'step_master.step_id', '=', 'review_stage.step')
                                ->select('review_stage.*', 'step_master.step_text')
                                ->where('id_artikel', $artikel_id)
                                ->orderBy('id', 'desc')
                                ->get();
        $jumlah_review=$get_review_stage->count();
        $data_review=[];
        if($jumlah_review > 0){
            $x=0;
            foreach($get_review_stage as $list_review_stage){
                $data_review[$x]['isYourReviewArtikel']=isYourReviewArtikel($list_review_stage['id'], $artikel_id);
                $data_review[$x]['id_review']=$list_review_stage['id'];
                $data_review[$x]['id_artikel']=$list_review_stage['id_artikel'];
                $data_review[$x]['review_ke']=$list_review_stage['review_ke'];
                $data_review[$x]['catatan_reviewer']=$list_review_stage['catatan_reviewer'];
                $data_review[$x]['status_artikel']=$list_review_stage['step_text'];
                $data_review[$x]['step_id']=$list_review_stage['step'];
                $data_review[$x]['sent_at']=$list_review_stage['send_author_at'];
                $data_review[$x]['sent_by']=$list_review_stage['send_by'];
                $data_review[$x]['catatan_penulis']=$list_review_stage['catatan_penulis'];
                $data_review[$x]['edoc_perbaikan_penulis']=$list_review_stage['edoc_perbaikan_penulis'];
                $data_review[$x]['send_reviewer_at']=$list_review_stage['send_reviewer_at'];
                $data_review[$x]['catatan_jm']=$list_review_stage['catatan_jm'];
                $get_checklist_result[$x]=Checklist_review_result::join('checklist_review', 'checklist_review.id', '=', 'checklist_review_result.id_pertanyaan')
                                    ->select('checklist_review_result.*', 'checklist_review.pertanyaan')
                                    ->where('id_artikel', $artikel_id)
                                    ->where('id_review', $list_review_stage['id'])
                            ->get();
                    $data_review[$x]['jumlah_checklist_result']=$get_checklist_result[$x]->count();
                $get_hasil_review=Hasil_reviewer::where('id_review', $list_review_stage['id'])
                                    ->get();
                $data_review[$x]['jumlah_hasil_review']=$get_hasil_review->count();
                $data_review[$x]['hasil_review']=[];
                if($get_hasil_review->count() > 0){
                    $y=0;
                    foreach($get_hasil_review as $list_hasil_review){
                        $data_review[$x]['hasil_review'][$y]['id_catatan']=$list_hasil_review['id'];
                        $data_review[$x]['hasil_review'][$y]['hasil_review']=$list_hasil_review['hasil_review'];
                        $data_review[$x]['hasil_review'][$y]['keterangan']=$list_hasil_review['keterangan'];
                        $y++;
                    }
                }

                if($x>0){
                    $data_review[$x-1]['edoc_perbaikan']=$list_review_stage['edoc_perbaikan_penulis'];
                }

                $x++;
            }
        }
        $get_artikel=Artikel::where('id', $artikel_id)->first();
        return response()->json(['jumlah_review'=>$jumlah_review, 'data_review'=>$data_review, 'checklist_result'=>$get_checklist_result, 'artikel'=>$get_artikel])->getData();
    }
    public function dataReviewAuthor(Request $request){
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $get_data=Reviewer_artikel::join('pegawai', 'pegawai.id', '=', 'reviewer_artikel.id_pegawai')
                        ->join('review_stage', function($q){
                            $q->on('review_stage.id', '=', 'reviewer_artikel.id_review')
                                ->where('reviewer_artikel.status', true);
                        })
                        ->select('pegawai.*', 'reviewer_artikel.tgl_pilih', 'reviewer_artikel.tgl_mulai', 'reviewer_artikel.tgl_estimasi_selesai', 'reviewer_artikel.status', 'review_stage.review_ke')
                        ->where('reviewer_artikel.id_artikel', $artikel_id)
                        ->where('reviewer_artikel.status', true)
                        ->orderBy('reviewer_artikel.id', 'desc')
                        ->get();
            $jumlah_reviewer=$get_data->count();
            $data_review=$this->getDataReview($artikel_id);
            //var_dump(count($data_review->data_review));die();
            //$get_hasil_review=Catatan_hasil_review::where('id_review', )

            return view('arunika/artikel/view_review_artikel', ['reviewer'=>$get_data, 'jumlah_reviewer' => $jumlah_reviewer, 'data_review'=>$data_review, 'jumlah_review'=>$data_review->jumlah_review]);
        }catch(DecryptException $e){
            echo "Token tidak valid";
        }
    }
    public function dataReview(Request $request){
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $get_data=Reviewer_artikel::join('pegawai', 'pegawai.id', '=', 'reviewer_artikel.id_pegawai')
                        ->join('review_stage', 'review_stage.id', 'reviewer_artikel.id_review')
                        ->select('pegawai.*', 'reviewer_artikel.tgl_pilih', 'reviewer_artikel.tgl_mulai', 'reviewer_artikel.tgl_estimasi_selesai', 'reviewer_artikel.status', 'review_stage.review_ke')
                        ->where('reviewer_artikel.id_artikel', $artikel_id)
                        ->where('reviewer_artikel.status', true)
                        ->orderBy('reviewer_artikel.id', 'desc')
                        ->get();
            $jumlah_reviewer=$get_data->count();
            $data_review=$this->getDataReview($artikel_id);
            //var_dump(count($data_review->data_review));die();
            //$get_hasil_review=Catatan_hasil_review::where('id_review', )

            return view('arunika/artikel/data_review_artikel', ['reviewer'=>$get_data, 'jumlah_reviewer' => $jumlah_reviewer, 'data_review'=>$data_review, 'jumlah_review'=>$data_review->jumlah_review, 'artikel_id'=>$artikel_id]);
        }catch(DecryptException $e){
            echo "Token tidak valid";
        }
    }
    public function formTambahReviewer(Request $request){
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $get_reviewer=Editorial_team::join('pegawai', 'pegawai.id', '=', 'editorial_team.id_pegawai')
                            ->select('pegawai.*', 'editorial_team.sebagai')
                            ->where('editorial_team.active', true)
                            ->get();
            $get_reviewer_active=Editorial_team::leftJoin('reviewer_artikel', function($q){
                                        $q->on('reviewer_artikel.id_pegawai','=', 'editorial_team.id_pegawai')
                                        ->where('reviewer_artikel.status', true);
                                    })
                                    ->leftJoin('review_stage', function($q){
                                        $q->on('review_stage.id_artikel', '=', 'reviewer_artikel.id_artikel')
                                            ->on('review_stage.id', '=', 'reviewer_artikel.id_review')
                                        ->where('step', 4);
                                    })
                                    ->join('pegawai', 'pegawai.id', '=', 'editorial_team.id_pegawai')
                                    ->select('pegawai.nama',  DB::raw('count(review_stage.id) as jumlah_aktif'))
                                    ->groupBy('pegawai.nama')
                                    ->get();
            $jumlah_reviewer=$get_reviewer->count();
            return view('arunika/artikel/form_tambah_reviewer', ['reviewer'=>$get_reviewer, 'reviewer_active' => $get_reviewer_active, 'jlh_reviewer'=>$jumlah_reviewer, 'token'=>Crypt::encrypt($artikel_id)]);
        }catch(DecryptException $e){
            echo "Data tidak valid";
            die();
        }
    }
    public function saveReviewer(Request $request){
        $update_step=false;
        try{
            if(isJM()){
                $artikel_id=Crypt::decrypt($request->token_a);
                $artikel_id_compare=Crypt::decrypt($request->token);
                if($artikel_id === $artikel_id_compare){
                    $id_pegawai=Crypt::decrypt($request->nama);
                    $get_artikel=Artikel::where('id', $artikel_id)
                                    ->whereIn('step', [3,4])
                                    ->first();
                    if(!is_null($get_artikel)){
                        $step=$get_artikel['step'];
                        $get_reviewer_before=Reviewer_artikel::join('review_stage', 'review_stage.id_artikel', '=', 'reviewer_artikel.id_artikel')
                                                ->whereRaw('review_stage.step <> 5')
                                                ->where('reviewer_artikel.id_artikel', $artikel_id)
                                                ->where('reviewer_artikel.status', true)
                                                ->first();
                        $update_reviewer_before=true;
                        $review_baru=true;
                        if(!is_null($get_reviewer_before)){
                            $update_reviewer_before=false;
                            $get_reviewer_before->status=false;
                            $update_reviewer_before=$get_reviewer_before->update();
                            $review_baru=false;    
                        }
                        if($update_reviewer_before){
                            //insert artikel badge
                            $save_review=true;
                            if($review_baru){
                                $save_review=false;
                                $check_review_stage=Review_stage::where('id_artikel', $artikel_id)->get();
                                $jumlah=$check_review_stage->count();
                                $review_stage=new Review_stage;
                                $review_stage->id_artikel=$artikel_id;
                                $review_stage->step=4;
                                $review_stage->review_ke=$jumlah+=1;
                                $save_review=$review_stage->save();
                            }
                            if($save_review){
                                //insert reviewer
                                $id_review=$review_stage->id;
                                $reviewer_artikel=new Reviewer_artikel;
                                $reviewer_artikel->id_pegawai=$id_pegawai;
                                $reviewer_artikel->id_review=$id_review;
                                $reviewer_artikel->id_artikel=$artikel_id;
                                $reviewer_artikel->tgl_pilih=date('Y-m-d H:i:s');
                                $reviewer_artikel->tgl_mulai=$request->tgl_mulai;
                                $reviewer_artikel->tgl_estimasi_selesai=$request->tgl_selesai;
                                $reviewer_artikel->status=true;
                                $save_reviewer=$reviewer_artikel->save();
                                if($save_reviewer){
                                    $get_artikel->step=4;
                                    $update_step=$get_artikel->update();
                                    if($update_step){
                                        
                                        $get_pegawai=$this->getPegawaiById($id_pegawai);
                                        $data_pegawai=$get_pegawai->getData();
                                        $data_wa['judul']=$get_artikel['judul'];
                                        $data_wa['no_handphone']=$data_pegawai->no_handphone;
                                        $data_wa['nama_penerima']=$data_pegawai->nama;
                                        $this->sendWaNotification('assign_reviewer', $data_wa);
                                        $msg="Berhasil menyimpan reviewer";
                                    }else{
                                        $msg="Terjadi kesalahan sistem saat mengubah tahapan";
                                    }
                                }else{
                                    $msg="Terjadi kesalahan sistem saat menyimpan reviewer";
                                }
                            }else{
                                $msg="Terjadi kesalahan sistem saat menyimpan data review";
                            }
                        }else{
                            $msg="Keslahan sistem. Reviewer aktif tidak dapat di ganti";
                        }
                    }else{
                        $msg="Tidak dapat menambahkan reviewer";
                    }
                }else{
                    $msg="Unconsistent data";
                }
            }else{
                $msg="Akese ditolak";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update_step, 'msg'=>$msg, 'token_id'=>Crypt::encrypt($artikel_id), 'callForm'=>'loadDataReview()', 'closeModal'=>true]);
    }
    public function formTambahReview(Request $request){
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $review_id=Crypt::decrypt($request->target);
            $get_artikel=Artikel::where('id', $artikel_id)->first();
            if(!is_null($get_artikel)){
                $get_checklist_result=Checklist_review_result::join('checklist_review', 'checklist_review.id', '=', 'checklist_review_result.id_pertanyaan')
                                        ->select('checklist_review.*', 'checklist_review_result.hasil', 'checklist_review_result.keterangan')
                                        ->where('id_review', $review_id)->get();
                $get_checklist=$get_checklist_result;
                $can_edit=true;
                if($get_checklist_result->count() > 0 && $request->view !== "form"){
                    if($get_artikel['step'] === 4){
                        $can_edit=true;
                    }
                    $view="arunika/artikel/view_form_review";
                }else{
                    if($get_checklist_result->count() === 0){
                        $get_checklist=Checklist_review::where('active', true)->get();
                    }
                    $view="arunika/artikel/form_review";
                }
                return view($view, ['checklist'=>$get_checklist, 'review_id'=>$request->target, 'can_edit'=>$can_edit, 'index'=>$request->index]);
            }else{
                echo "<center><h4>Artikel tidak ditemukan</h4></center>";
            }
        }catch(DecryptException $e){
            echo "<center><h4>Invalid token</h4></center>";
        }
    }
    public function saveChecklistReview(Request $request){
        $close_modal=false;
        $save_hasil=false;
        $token_id=$request->token_a;
        $msg="";
        try{
            $artikel_id=Crypt::decrypt($request->token_a);
            $review_id=Crypt::decrypt($request->token_r);
            if(isYourReviewArtikel($review_id, $artikel_id)){
                $check=$this->checkValidateTabsRequest($request->token_a, 4);
                $get_pertanyaan=Checklist_review::where('active', true)->get();
                if($check->status){
                    $x=0;
                    $next=true;
                    foreach($get_pertanyaan as $list){
                        $data[]=$list;
                        $pertanyaan="pertanyaan_".$list['id'];
                        if(!isset($request->$pertanyaan)){
                            $next=false;break;   
                        }
                    }
                    $validate_step=$this->checkValidateStep($review_id, $artikel_id, $check->data->step, 'saveChecklistReview');
                    if($next === true && $validate_step === true){
                        $get_list_before=Checklist_review_result::where('id_artikel', $artikel_id)
                                        ->where('id_review', $review_id)
                                        ->delete();
                        foreach($data as $list_pernyataan){
                            $hasil_review=new Checklist_review_result;
                            $catatan="catatan_".$list_pernyataan['id'];
                            $pertanyaan='pertanyaan_'.$list_pernyataan['id'];
                            $hasil_review->id_pertanyaan=$list_pernyataan['id'];
                            $hasil_review->id_artikel=$artikel_id;
                            $hasil_review->id_review=$review_id;
                            $hasil_review->hasil=$request->$pertanyaan;
                            $hasil_review->keterangan=$request->$catatan;
                            $save_hasil=$hasil_review->save();
                            if($save_hasil){
                                $msg="Berhasil menyimpan hasil checklist ";
                                $close_modal=true;
                            }else{
                                $msg="Terjadi kesalahan pada saat menyimpan hasil";
                            }
                            $x++;
                        }
                    }else{
                        $msg="Pastikan seluruh checklist telah dicentang dan Tahapan benar";
                    }
                    
                }else{
                    $msg=$check->msg;
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            //$msg="Pastikan semua telah dicheck";
            $msg="Invalid token";
        }
        return response()->json(['status'=>$save_hasil, 'msg'=>$msg, 'token_id'=>Crypt::encrypt($artikel_id), 'closeModal'=>$close_modal, 'callForm'=>'loadDataReview()']);
    }
    public function formTambahHasilReview(Request $request){
        try{
            $data_hasil=null;
            $id_hasil=0;
            $artikel_id=Crypt::decrypt($request->token);
            $review_id=Crypt::decrypt($request->target);
            if(isYourReviewArtikel($review_id, $artikel_id)){
                $action="save-hasil-review";
                if(isset($request->target_id)){
                    $id_hasil=Crypt::decrypt($request->target_id);
                    $get_data=Hasil_reviewer::where('id', $id_hasil)->first();
                    if(!is_null($get_data)){
                        $data_hasil['hasil_review']=$get_data['hasil_review'];
                        $data_hasil['keterangan']=$get_data['keterangan'];
                        $action="update-hasil-review";
                    }
                }
                $get_artikel=Artikel::where('id', $artikel_id)->first();
                if(!is_null($get_artikel)){
                    return response()->view('arunika/artikel/form_hasil_review', ['review_id'=>Crypt::encrypt($review_id), 'data_hasil'=>$data_hasil, 'action'=>$action, 'hasil_id'=>Crypt::encrypt($id_hasil)]);
                }else{
                    echo "Data tidak ditemukan";
                }
            }else{
                echo "Akses ditolak";
            }
        }catch(DecryptException $e){
            echo "Invalid token";
        }
    }    
    public function saveHasilReview(Request $request){
        $save_hasil=false;
        $close_modal=false;
        try{
            $artikel_id=Crypt::decrypt($request->token_a);
            $review_id=Crypt::decrypt($request->token_r);
            if(isYourReviewArtikel($review_id, $artikel_id)){
                try{
                    $validate=$request->validate([
                        'hasil_review' => 'required',
                        'keterangan' => 'required',
                    ]);
                    $check=$this->checkValidateTabsRequest($request->token_a, 4);
                    if($check->status){
                        $check_step=$this->checkValidateStep($review_id, $artikel_id, $check->data->step, 'saveHasilReview');
                        $get_data=Review_stage::where('id', $review_id)
                                    ->whereRaw('edoc_perbaikan_penulis is not null')
                                    ->first();
                        if($check_step && is_null($get_data)){
                            $hasil=new Hasil_reviewer;
                            $hasil->id_review=$review_id;
                            $hasil->hasil_review=$request->hasil_review;
                            $hasil->keterangan=$request->keterangan;
                            $hasil->active=true;
                            $save_hasil=$hasil->save();
                            if($save_hasil){
                                $close_modal=true;
                                $msg="Berhasil menyimpan hasil review";
                            }else{
                                $msg="Terjadi kesalahan sistem saat menyimpan review";
                            }
                        }else{
                            $msg="Saat ini Anda tidak dapat melakukan pengisian data hasil review .";
                        }
                    }else{
                        $msg=$check->msg;
                    }
                }catch(ValidationException $e){
                    $msg=$e->validator->errors()->first();
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$save_hasil, 'msg'=>$msg, 'closeModal'=>$close_modal, 'callForm'=>'loadDataReview()', 'token_id'=>Crypt::encrypt($artikel_id)]);
    }
    public function updateHasilReview(Request $request){
        $update_hasil=false;
        $close_modal=false;
        try{
            $artikel_id=Crypt::decrypt($request->token_a);
            $review_id=Crypt::decrypt($request->token_r);
            if(isYourReviewArtikel($review_id, $artikel_id)){
                $hasil_id=Crypt::decrypt($request->token_h);
                try{
                    $validate=$request->validate([
                        'hasil_review' => 'required',
                        'keterangan' => 'required',
                    ]);
                    $check=$this->checkValidateTabsRequest($request->token_a, 4);
                    if($check->status){
                        $check_step=$this->checkValidateStep($review_id, $artikel_id, $check->data->step, 'saveHasilReview');
                        if($check_step){
                            $get_hasil=Hasil_reviewer::where('id', $hasil_id)->first();
                            if(!is_null($get_hasil)){
                                $get_hasil->hasil_review=$request->hasil_review;
                                $get_hasil->keterangan=$request->keterangan;
                                $update_hasil=$get_hasil->update();
                                if($update_hasil){
                                    $close_modal=true;
                                    $msg="Berhasil mengubah data hasil review";
                                }else{
                                    $msg="Terjadi kesalahan sistem saat menyimpan review";
                                }
                            }else{
                                $msg="Data tidak ditemukan";
                            }
                        }else{
                            $msg="Saat ini Anda tidak dapat melakukan pengisian data hasil review .";
                        }
                    }else{
                        $msg=$check->msg;
                    }
                }catch(ValidationException $e){
                    $msg=$e->validator->errors()->first('body');
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update_hasil, 'msg'=>$msg, 'closeModal'=>$close_modal, 'callForm'=>'loadDataReview()', 'token_id'=>Crypt::encrypt($artikel_id)]);
    }
public function removeHasilReview(Request $request){
        $remove_hasil=false;
        $artikel_id=null;
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $review_id=Crypt::decrypt($request->target);
            if(isYourReviewArtikel($review_id, $artikel_id)){
                $hasil_id=Crypt::decrypt($request->target_id);
                $check=$this->checkValidateTabsRequest($request->token, 4);
                if($check->status){
                    $check_step=$this->checkValidateStep($review_id, $artikel_id, $check->data->step, 'removeHasilReview');
                    $get_data=Review_stage::where('id', $review_id)
                                ->whereRaw('edoc_perbaikan_penulis is not null')
                                ->first();
                    if($check_step && is_null($get_data)){
                        $get_hasil=Hasil_reviewer::where('id', $hasil_id)->first();
                        if(!is_null($get_hasil)){
                            $remove_hasil=$get_hasil->delete();
                            if($remove_hasil){
                                $msg="Berhasil menghapus data hasil review";
                            }else{
                                $msg="Terjadi kesalahan sistem saat menghapus hasil review";
                            }
                        }else{
                            $msg="Data tidak ditemukan";
                        }
                    }else{
                        $msg="Saat ini Anda tidak dapat melakukan penghapusan data .";
                    }
                }else{
                    $msg=$check->msg;
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$remove_hasil, 'msg'=>$msg, 'callLink'=>'loadDataReview()', 'token_id'=>Crypt::encrypt($artikel_id)]);
    }
    public function formTambahCatatan(Request $request){
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $review_id=Crypt::decrypt($request->target);
            if(isYourReviewArtikel($review_id, $artikel_id)){
                $get_data=Review_stage::where('id', $review_id)
                        ->where('id_artikel', $artikel_id)
                        ->first();
                if(!is_null($get_data)){
                    $catatan_reviewer=$get_data['catatan_reviewer'];
                    $step=$get_data['step'];
                    return view('arunika/artikel/form_tambah_catatan', ['catatan_reviewer'=>$catatan_reviewer, 'step'=>$step, 'review_id'=>Crypt::encrypt($review_id)]);
                }else{
                    echo "Data tidak ditemukan";
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            echo "Invalid token";
            die();
        }
    }
    public function saveCatatanReviewer(Request $request){
        $update=false;
        $artikel_id="";
        $close_modal=false;
        try{
            $validate=$request->validate([
                'status_artikel'=>'required',
                'catatan'=>'required',
            ]);
            try{
                $artikel_id=Crypt::decrypt($request->token_a);
                $review_id=Crypt::decrypt($request->token_r);
                if(isYourReviewArtikel($review_id, $artikel_id)){
                    $step=Crypt::decrypt($request->status_artikel);
                    $check=$this->checkValidateTabsRequest($request->token_a, 4);
                    if($check->status){
                        $validate_step=$this->checkValidateStep($review_id, $artikel_id, $check->data->step, 'saveCatatanReview');
                        if($validate_step){
                            $get_data=Review_stage::where('id', $review_id)
                                ->where('id_artikel', $artikel_id)
                                ->first();
                            if(!is_null($get_data)){
                                $get_data->catatan_reviewer=$request->catatan;
                                $get_data->step=$step;
                                $update=$get_data->update();
                                if($update){
                                    $close_modal=true;
                                    $msg="Berhasil menyimpan data catatan";
                                }else{
                                    $msg="Terjadi kesalahan saat menyimpan catatan";
                                }
                            }else{
                                $msg="Data tidak ditemukan";
                            }
                        }else{
                            $msg="Tidak dapat menyimpan data pada tahapan ini";
                        }
                    }else{
                        $msg=$check->msg;
                    }
                }else{
                    $msg="Akses ditolak";
                }
            }catch(DecryptException $e){
                $msg="Invalid token";
            }

        }catch(ValidationException $e){
            $msg=$e->validator->errors()->first();
        }
        return response()->json(['status'=>$update, 'msg'=>$msg, 'callLink'=>'loadDataReview()', 'token_id'=>Crypt::encrypt($artikel_id), 'closeModal'=>$close_modal]);
    }
    public function sendReviewResult(Request $request){
        $update_review_stage=false;
        $artikel_id="";
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $review_id=Crypt::decrypt($request->target);
            if(isYourReviewArtikel($review_id, $artikel_id)){
                $check=$this->checkValidateTabsRequest($request->token, 4);
                if($check->status){
                    $validate_send=$this->checkValidateStep($review_id, $artikel_id, $check->data->step, 'sendHasilToAuthor');
                    if($validate_send){
                        $get_checklist_result=Checklist_review_result::where('id_artikel', $artikel_id)
                                    ->where('id_review', $review_id)
                                    ->get()->count();
                        $get_hasil_review=Hasil_reviewer::where('id_review', $review_id)
                                        ->get()->count();
                        $get_review_stage=Review_stage::where('id_artikel', $artikel_id)
                                            ->join('step_master', 'step_master.step_id', '=', 'review_stage.step')
                                            ->select('review_stage.*', 'step_master.step_text', 'step_master.step_id')
                                            ->where('review_stage.id', $review_id)
                                            ->whereIn('review_stage.step', [5,6])
                                            ->whereRaw('catatan_reviewer is not null')
                                            ->first();
                        if(!is_null($get_review_stage)){
                            if($get_checklist_result > 0){
                                if($get_hasil_review > 0){
                                    $artikel=Artikel::where('id', $artikel_id)
                                                ->where('step', 4)
                                                ->first();
                                    try{
                                        DB::beginTransaction();
                                    
                                        //update step artikel
                                        $artikel->step=$get_review_stage['step'];
                                        $artikel->update();
                                        
                                        //update waktu kirim dan tanggal kirim reviewer ke author
                                        $get_review_stage->send_author_at=date('Y-m-d H:i:s');
                                        $get_review_stage->send_by=Auth::user()->name;
                                        $get_review_stage->update();
                                        
                                        $msg="Berhasil mengirimkan hasil review kepada author";
                                        $update_review_stage=true;
                                        DB::commit();
                                    }catch(\Exception $e){
                                        DB::rollBack();
                                        $msg="Terjadi kesalahan saat mengirimkan hasil. Silahkan ulang. ";
                                        //$e->getMessage() =>save it
                                    }
                                    if($update_review_stage){
                                        //perbaikan
                                        
                                        $get_pegawai=Penulis_artikel::where('id', $artikel['id_penulis'])->first();
                                        
                                        //kirim kepada penulis
                                        $category="reviewer_result";
                                        //judul, no_hp, nama_penerima
                                        $data_wa['judul']=$artikel['judul'];
                                        $data_wa['no_wa']="081273861528";
                                        //$data_wa['no_hp']=$get_pegawai['no_handphone'];
                                        $data_wa['nama_penerima']=$get_pegawai['nama'];
                                        $data_wa['hasil_reviewer']=$get_review_stage['step_text'];
                                        $this->sendWaNotification($category, $data_wa);

                                        //kirim kepada jm bila accepted
                                        if($get_review_stage['step_id'] === 6){
                                            $this->sendWaNotification('artikel_accepted', $data_wa);
                                        }
                                    }
                                }else{
                                    $msg="Form Hasil Review harus diisi terelbih dahulu";
                                }
                            }else{
                                $msg="Form Checklist harus dilengkapi terlebih dahulu";
                            }
                        }else{
                            $msg="Data artikel tidak ditemukan, atau catatan artikel belum diisi. Silahkan dicek kembali";
                        }
                    }else{
                        $msg="Sudah tidak dapat mengirimkan hasil review.";
                    }
                }else{
                    $msg=$check->msg;
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update_review_stage, 'msg'=>$msg, 'token_id'=>Crypt::encrypt($artikel_id), 'callForm'=>'loadDataReview()']);
    }
    public function cancelReviewResultSent(Request $request){
        $update_review_stage=false;
        $artikel_id="";
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $review_id=Crypt::decrypt($request->target);
            if(isYourReviewArtikel($review_id, $artikel_id)){
                $check=$this->checkValidateTabsRequest($request->token, 5);
                if($check->status){
                    $validate_send=$this->checkValidateStep($review_id, $artikel_id, $check->data->step, 'cancelHasilToAuthor');
                    if($validate_send){
                        $get_checklist_result=Checklist_review_result::where('id_artikel', $artikel_id)
                                    ->where('id_review', $review_id)
                                    ->get()->count();
                        $get_hasil_review=Hasil_reviewer::where('id_review', $review_id)
                                        ->get()->count();
                        $get_review_stage=Review_stage::where('id_artikel', $artikel_id)
                                            ->where('id', $review_id)
                                            ->whereIn('step', [5,6])
                                            ->whereRaw('catatan_reviewer is not null')
                                            ->first();
                        if(!is_null($get_review_stage)){
                            if($get_checklist_result > 0){
                                if($get_hasil_review > 0){
                                    if($get_review_stage['edoc_perbaikan_penulis'] === null){
                                        $artikel=Artikel::where('id', $artikel_id)
                                                ->where('step', 5)
                                                ->first();
                                        $artikel->step=4;
                                        $update_step=$artikel->update();
                                        if($update_step){
                                            $get_review_stage->send_author_at=null;
                                            $get_review_stage->send_by=null;
                                            $update_review_stage=$get_review_stage->update();
                                            if($update_review_stage){
                                                $msg="Berhasil membatalkan pengiriman kepada author";
                                            }else{
                                                $msg="Terjadi kesalahan saat mengubah data pengirim.";
                                            }
                                        }else{
                                            $msg="Terjadi kesalahan sistem saat mengirimkan hasil review";
                                        }
                                    }else{
                                        $msg="Tidak dapat mengubah data lagi";
                                    }
                                }else{
                                    $msg="Form Hasil Review harus diisi terelbih dahulu";
                                }
                            }else{
                                $msg="Form Checklist harus dilengkapi terlebih dahulu";
                            }
                        }else{
                            $msg="Data artikel tidak ditemukan, atau catatan artikel belum diisi. Silahkan dicek kembali";
                        }
                    }else{
                        $msg="Sudah tidak dapat mengubah hasil review.";
                    }
                }else{
                    $msg=$check->msg;
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update_review_stage, 'msg'=>$msg, 'token_id'=>Crypt::encrypt($artikel_id), 'callForm'=>'loadDataReview()']);        
    }
    public function savePerbaikanArtikel(Request $request){
        $update_perbaikan=false;
        $id_artikel="null";
        try{
            $id_review=Crypt::decrypt($request->token_r);
            $id_artikel=Crypt::decrypt($request->token_a);
            if(isYourArtikel($id_artikel)){
                try{
                    $get_data=Review_stage::join('artikel', 'artikel.id', '=', 'review_stage.id_artikel')
                                ->select('review_stage.*')
                                ->where('id_artikel', $id_artikel)
                                ->where('review_stage.id', $id_review)
                                ->where('review_stage.step', 5)
                                ->first();
                    if($get_data->edoc_perbaikan_penulis === null){
                        $validate=$request->validate([
                            'edoc_perbaikan' => ['required', 'file'],
                            'catatan_penulis' =>['required'],
                        ]);
                    }else{
                        $validate=$request->validate([
                            'edoc_perbaikan' => ['required', 'file'],
                        ]);
                    }
                    if(!is_null($get_data)){
                        $upload=true;
                        if($get_data->edoc_perbaikan !== null || $get_data->edoc_perbaikan !== ""){
                            $upload=false;
                            $file=$request->edoc_perbaikan;
                            $size=$file->getSize();
                            $type=$file->getMimeType();
                            if($size <= 6291456){
                                if($type === "application/pdf" || $type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $type === "application/msword"){
                                    $destination="upload/edoc/artikel";
                                    $filename=date('YmdHis')."-".$file->getClientOriginalName();
                                    $file->move($destination, $filename);
                                    $path=$destination."/".$filename;
                                    if(File::exists($path)){
                                        $upload=true;
                                        $get_data->edoc_perbaikan_penulis=$path;
                                    }else{
                                        $msg="Tidak dapat mengupload file. Silahkan hubungi tim pengembang";
                                    }
                                }else{
                                    $msg="Tipe data harus dokumen (Pdf / doc / docx)";
                                }
                            }else{
                                $msg="Maksimum ukuran file 6mb";
                            }
                        }
                        if($upload){
                            $get_data->catatan_penulis=$request->catatan_penulis;
                            $update_perbaikan=$get_data->update();
                            if($update_perbaikan){
                                $msg="Berhasil menyimpan data";
                            }else{
                                $msg="Terjadi kesalahan sistem saat menyimpan data";
                            }
                        }   
                    }else{
                        $msg="Data tidak ditemukan";
                    }
                }catch(ValidationException $e){
                    $msg=$e->validator->errors()->first();
                }
            }else{
                $msg="Anda tidak dapat melakukan perubahan data";
            }
        }catch(DecryptException $e){
           $msg="Invalid token";
        }
        return response()->json(['status'=>$update_perbaikan, 'msg'=>$msg, 'token_id'=>Crypt::encrypt($id_artikel), 'callForm'=>"loadDataReviewAuthor()"]);
    }
    public function removeEdocPerbaikan(Request $request){
        $update_edoc_perbaikan=false;
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $review_id=Crypt::decrypt($request->target_id);
            $get_review=Review_stage::where('id', $review_id)
                            ->where('id_artikel', $artikel_id)
                            ->whereRaw('send_reviewer_at is null')
                            ->first();
            if(isYourArtikel($artikel_id) && !is_null($get_review)){
                $get_artikel=Artikel::where('id', $artikel_id)->first();
                if($get_artikel['step'] === 5){
                    $get_review->edoc_perbaikan_penulis=null;
                    $get_review->catatan_penulis=null;
                    $update_edoc_perbaikan=$get_review->update();
                    if($update_edoc_perbaikan){
                        $msg="Berhasil menghapus data";
                    }else{
                        $msg="Terjadi kesalahan saat menghapus data";
                    }
                }else{
                    $msg="Tidak dapat dilakukan penghapusan data";
                }
            }else{
                $msg="Tidak dapat melakukan perbahan data";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update_edoc_perbaikan, 'msg'=>$msg, 'token_id'=>Crypt::encrypt($artikel_id), 'callForm'=>'loadDataReviewAuthor()']);
    }
    public function sendPerbaikanPenulis(Request $request){
        $update_step=false;
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $review_id=Crypt::decrypt($request->target);
            if(isYourArtikel($artikel_id)){
                $check_data=Review_stage::join('artikel', 'artikel.id', '=', 'review_stage.id_artikel')
                            ->select('review_stage.*')
                            ->where('artikel.step', 5)
                            ->where('review_stage.id', $review_id)
                            ->where('review_stage.id_artikel', $artikel_id)
                            ->whereRaw('review_stage.edoc_perbaikan_penulis is not null')
                            ->first();
                if(!is_null($check_data)){
                    try{
                        DB::beginTransaction();
                        DB::table('artikel')->where('id', $artikel_id)
                                    ->limit(1)
                                    ->update(array('step'=>3));
                        $check_data->send_reviewer_at=date('Y-m-d H:i:s');
                        $check_data->update();
                        DB::commit();
                        $update_step=true;
                        $msg="Berhasil mengirimkan artikel";
                    }catch(\Exception $e){
                        $msg="Tidak dapat melakukan proses pengiriman perbaikan artikel";
                        DB::rollBack();
                    }
                    if($update_step){
                        $get_artikel=Artikel::where('id', $artikel_id)->first();
                        $data_wa['judul']=$get_artikel['judul'];
                        $this->sendWaNotification('send_perbaikan_author', $data_wa);
                    }
                }else{
                    $msg="Artikel ini tidak pada tahap pengiriman perbaikan";
                }
            }else{
                $msg="Anda tidak dapat melakukan pengiriman";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update_step, 'msg'=>$msg, 'token_id'=>Crypt::encrypt($artikel_id), 'callForm'=>'loadDataReviewAuthor()']);
    }
    public function formCancelPublish(Request $request){
        try{
            $review_id=Crypt::decrypt($request->token_r);
            $artikel_id=Crypt::decrypt($request->token_a);
            if(isJm()){
                $get_data=Artikel::join('review_stage', function($q) use($review_id){
                                        $q->on('review_stage.id_artikel', '=', 'artikel.id')
                                        ->where('review_stage.id', $review_id);
                                    })
                                ->where('artikel.id', $artikel_id)
                                ->where('artikel.step', 6)
                                ->first();
                if(!is_null($get_data)){
                    return view('arunika/artikel/form_cancel_publish', ['token_a'=>$request->token_a, 'token_r'=>Crypt::encrypt($review_id)]);
                }else{
                    echo "Tidak dapat melakukan perubahan data";
                }
            }else{
                echo "Akses ditolak";
            }
        }catch(DecryptException $e){
            echo "Invalid token";
        }
    }
    public function cancelPublish(Request $request){
        $update_data=false;
        try{
            $review_id=Crypt::decrypt($request->token_r);
            $artikel_id=Crypt::decrypt($request->token_a);
            try{
                $validate=$request->validate([
                    'catatan_jm'=> 'required',
                ]);
                if(isJm()){
                    $get_data=Artikel::join('review_stage', function($q) use($review_id){
                                            $q->on('review_stage.id_artikel', '=', 'artikel.id')
                                            ->where('review_stage.id', $review_id);
                                        })
                                    ->select('artikel.*')
                                    ->where('artikel.id', $artikel_id)
                                    ->where('artikel.step', 6)
                                    ->first();
                    if(!is_null($get_data)){
                        $review_stage=Review_stage::find($review_id);
                        try{
                            DB::beginTransaction();
                            $get_data->step=4;
                            $update_step=$get_data->update();
    
                            $review_stage->step=4;
                            $review_stage->catatan_jm=$request->catatan_jm;
                            $review_stage->catatan_reviewer=null;
                            $review_stage->send_author_at=null;
                            $update_stage=$review_stage->update();
                            $update_data=true;
                            $msg="Berhasil membatalkan publish";
                            DB::commit();
                        }catch(\Exception $e){
                            DB::rollback();
                            $msg="Terjadi kesalahan saat mengubah data";
                        }
                    }else{
                        $msg= "Tidak dapat melakukan perubahan data";
                    }
                }else{
                    $msg= "Akses ditolak";
                }
            }catch(ValidationException $e){
                $msg=$e->validator->errors()->first();
            }
        }catch(DecryptException $e){
            echo "Invalid token";
        }
        return response()->json(['status'=>$update_data, 'msg'=>$msg, 'callForm'=>'loadDataReview()', 'token_id'=>$request->token_a, 'closeModal'=>true]);
    }
    public function acceptToPublish(Request $request){
        $publish=false;
        try{
            $review_id=Crypt::decrypt($request->token_r);
            $artikel_id=Crypt::decrypt($request->token_a);
            if(isJM()){
                $check_data=Artikel::join('review_stage', function($q) use($review_id){
                                $q->on('review_stage.id_artikel', '=', 'artikel.id')
                                    ->where('review_stage.step', 6)
                                    ->whereRaw('review_stage.edoc_perbaikan_penulis is null')
                                    ->whereRaw('review_stage.catatan_jm is null')
                                    ->where('review_stage.id', $review_id);
                            })
                            ->select('artikel.*')
                            ->where('artikel.id', $artikel_id)
                            ->first();
                if(!is_null($check_data)){
                    $get_review_stage=Review_stage::find($review_id);
                    $review_before=$get_review_stage->review_ke-1;
                    $get_penulis=Penulis_artikel::where('id', $check_data['penulis_artikel'])->first();
                    if($review_before === 0){
                        $get_edoc=Artikel::where('id', $artikel_id)
                                    ->first();
                        $edoc_acc=$get_edoc['edoc_artikel'];
                    }else{
                        $get_edoc=Review_stage::where('review_ke', $review_before)
                            ->where('id_artikel', $artikel_id)
                            ->first();
                        $edoc_acc=$get_edoc['edoc_perbaikan_penulis'];
                    }
                    if(is_null($get_edoc)){
                        echo "Operation stop ";
                        die();
                    }
                    try{
                        DB::beginTransaction();
                        //ubah step artikel menjadi persiapan publish
                        $check_data->step=7;
                        $check_data->update();
                        
                        //ubah stepp review menjadi persiapan publish
                        $get_review_stage->step=7;
                        $get_review_stage->update();
                        
                        //insert new publish
                        $publish_artikel=new Publish_artikel;
                        $publish_artikel->id_artikel=$artikel_id;
                        $publish_artikel->edoc=$edoc_acc;
                        $publish_artikel->save();
                        $msg="Artikel dipersiapkan untuk dipublish";
                        DB::commit();
                        $publish=true;
                    }catch(\Exception $e){
                        DB::rollback();
                        $msg="Terjadi kesalahan saat menyimpan data publish ".$e->getMessage(). " ".$get_review_stage->review_ke - 1;
                    }
                }else{
                    $msg="Data tidak ditemukan";
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$publish, 'msg'=>$msg, 'callForm'=>'loadDataPublish()']);
    }
    public function directToPublish(Request $request){
        $publish=false;
        try{
            $artikel_id=Crypt::decrypt($request->target);
            //$artikel_id=Crypt::decrypt($request->token_a);
            if(isJM()){
                $check_data=Artikel::select('artikel.*')
                            ->where('artikel.id', $artikel_id)
                            ->first();
                if(!is_null($check_data)){
                    try{
                        DB::beginTransaction();
                        //ubah step artikel menjadi persiapan publish
                        $check_data->step=7;
                        $check_data->update();
                        
                        //insert new publish
                        $publish_artikel=new Publish_artikel;
                        $publish_artikel->id_artikel=$artikel_id;
                        $publish_artikel->edoc=$check_data['edoc_artikel'];
                        $publish_artikel->save();
                        $msg="Artikel dipersiapkan untuk dipublish";
                        DB::commit();
                        $publish=true;
                    }catch(\Exception $e){
                        DB::rollback();
                        $msg="Terjadi kesalahan saat menyimpan data publish ".$e->getMessage(). " ".$get_review_stage->review_ke - 1;
                    }
                }else{
                    $msg="Data tidak ditemukan";
                }
            }else{
                $msg="Akses ditolak";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$publish, 'msg'=>$msg, 'callForm'=>'loadDataPublish()']);
    }
    public function dataPublish(Request $request){
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $get_data_artikel=Artikel::join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                                ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                                ->join('kategori_artikel', 'kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                                ->leftjoin('review_stage', function($q){
                                                            $q->on('review_stage.id_artikel', '=', 'artikel.id')
                                                                ->where('review_stage.step', 7)
                                                                ->whereRaw('catatan_jm is null')
                                                                ->whereRaw('edoc_perbaikan_penulis is null');
                                                        })
                                ->leftJoin('issue_artikel', 'issue_artikel.code_issue', '=', 'publish_artikel.code_issue')
                                ->select('artikel.id','artikel.judul', 'artikel.foto_penulis', 'artikel.tentang_artikel', 'penulis_artikel.nama', 'penulis_artikel.satker', 'kategori_artikel.kategori', 'publish_artikel.edoc', 'publish_artikel.text_tulisan', 'artikel.step', 'publish_artikel.code_issue', 'issue_artikel.name', 'publish_artikel.edoc_pdf')
                                ->where('artikel.id', $artikel_id)
                                ->whereRaw('artikel.step >= 7')
                                ->first();
            $get_keyword=Keyword::where('id_artikel', $artikel_id)->get();
            if(!is_null($get_data_artikel)){
                $text=$this->readDoc($get_data_artikel['edoc']);
                // var_dump($text);
                return view('arunika/artikel/data_publish', ['data'=>$get_data_artikel, 'keyword'=>$get_keyword, 'text'=>$text]);
            }else{
                echo "Data tidak ditemukan";
            }
        }catch(DecryptExceptio $e){
            echo "Token tidak valid";
            die();
        }
    }

    public function readDoc($filePath){
        $phpWord = IOFactory::load($filePath); 
        $htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($phpWord);
        // Generate the HTML content
        //$htmlWriter = new HTML($phpWord);
        $htmlContent = $htmlWriter->getContent();

        // Parse the HTML content using DOMDocument
        $dom = new \DOMDocument();
        $dom->loadHTML($htmlContent, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Get the body content without the HTML, HEAD, and BODY tags
        $bodyContent = '';
        $bodyNodes = $dom->getElementsByTagName('body')->item(0)->childNodes;
        foreach ($bodyNodes as $node) {
            $bodyContent .= $dom->saveHTML($node);
        }

        // Save or use the $bodyContent as needed
        return $bodyContent;   
    }
    public function updateEdocPub(Request $request){
        $update=false;
        if(isJM()){
            try{
                $artikel_id=Crypt::decrypt($request->token_a);
                $get_data=Publish_artikel::where('id_artikel', $artikel_id)
                            ->first();
                if(!is_null($get_data)){
                    try{
                        $validate=$request->validate([
                            'new_edoc' => ['required', 'file'],
                        ]);
                        $file=$request->new_edoc;
                        $size=$file->getSize();
                        $type=$file->getMimeType();
                        if($type === "application/pdf" || $type === "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $type === "pplication/msword"){
                            if($size <= 6291456){
                                $destination="upload/edoc/artikel";
                                $filename=date('YmdHis')."-".$file->getClientOriginalName();
                                $path=$destination."/".$filename;
                                $file->move($destination, $filename);
                                if(File::exists($path)){
                                    $get_data->edoc=$path;
                                    $update=$get_data->update();
                                    if($update){
                                        $msg="Berhasil mengubah edoc";
                                    }else{
                                        $msg="Terjadi kesalahan pada saat mengubah edoc";
                                    }
                                }else{
                                    $msg="Tidak dapat melakukan upload edoc. Silahkan hubungi tim pengembang";
                                }
                            }else{
                                $msg="Ukuran file harus lebih kecil dari 6mb";
                            }
                        }else{
                            $msg="Tipe data harus Document *.docx / *.doc / *.rtf / *.pdf";
                        }
                    }catch(ValidationException $e){
                        $msg=$e->validator->errors()->first();
                    }
                }else{
                    $msg="Data tidak ditemukan";
                }
            }catch(DecryptException $e){
                $msg="Invalid token";
            }
        }else{
            $msg="Akses ditolak";
        }
        return response()->json(['status'=>$update, 'callForm'=>'loadDataPublish()', 'msg'=>$msg]);
    }
    public function previewArtikel($artikel_id){
        if(isJM()){
            try{
                $artikel_id_dec=Crypt::decrypt($artikel_id);
                $get_artikel=Publish_artikel::join('artikel', 'artikel.id', '=', 'publish_artikel.id_artikel')
                            ->join('penulis_artikel', 'artikel.id_penulis', '=', 'penulis_artikel.id')
                            ->select('artikel.*', 'publish_artikel.edoc', 'penulis_artikel.nama', 'publish_artikel.text_tulisan')
                            ->where('artikel.id', $artikel_id_dec)
                            ->first();
                if(!is_null($get_artikel)){
                    $get_keyword=Keyword::where('id_artikel', $artikel_id_dec)->get();
                    $text=$this->readDoc($get_artikel['edoc']);
                    return view('web/preview_artikel', ['artikel'=>$get_artikel, 'text'=>$text, 'keyword'=>$get_keyword, 'jumlah_similar'=>0, 'jlh_other'=>0]);
                }else{
                    echo "Artikel tidak ditemukan";
                }
            }catch(DecryptException $e){
                echo "Error 404";
            }
        }else{
            echo "Akses ditolak";
        }
    }
    public function generatePDF($text, $judul, $penulis){
        $dompdf = new Dompdf();
        $header="<center><h2>".$judul."</h2><br />".$penulis."</center>";
        $dompdf->loadHtml($header."<br />".$text);

        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        //$filename=str_replace(' ', '-',$judul);
        $judul=preg_replace('/[^A-Za-z0-9\-]/', '-', $judul);
        $filename="upload/edoc/artikel/pdf/".$judul.".pdf";
        file_put_contents($filename, $output);
        return $filename;
        //$dompdf->stream("codexworld",array("Attachment"=>1));
    }
    public function publishArtikel(Request $request){
        $publish=false;
        $msg="";
        if(isJM()){
            try{
                $artikel_id=Crypt::decrypt($request->token_a);
                $get_publish=Publish_artikel::join('artikel', 'artikel.id', '=', 'publish_artikel.id_artikel')
                                ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                                ->select('publish_artikel.edoc', 'artikel.judul', 'penulis_artikel.nama')
                                ->where('id_artikel', $artikel_id)
                                ->first();
                if(!is_null($get_publish)){
                    $text=$this->readDoc($get_publish['edoc']);
                    $generate=$this->generatePDF($text, $get_publish['judul'], $get_publish['nama']);
                    if(File::exists($generate)){
                        $publish=true;
                        $get_data=Artikel::where('id', $artikel_id)->first();
                        $publish_artikel=Publish_artikel::where('id_artikel', $artikel_id)->first();
                        $code_issue=$publish_artikel['code_issue'];
                        try{
                            DB::beginTransaction();
                            $publish_artikel->text_tulisan=$text;
                            $publish_artikel->edoc_pdf=$generate;
                            $publish_artikel->publish_at=date("Y-m-d");
                            $publish_artikel->update();

                            $get_data->step=8;
                            $get_data->update();

                            $statistik=new Statistik_baca;
                            $statistik->id_artikel=$artikel_id;
                            $statistik->jumlah=0;
                            $statistik->save();

                            Issue_artikel::where('status', 2)->update(array('status'=>3));
                            $get_issue=Issue_artikel::where('code_issue', $code_issue)->first();
                            $get_issue->status=2;//set to publish
                            $get_issue->update();

                            $publish=true;
                            $msg="Berhasil Melakukan Publish terhadap artikel";
                            DB::commit();
                        }catch(\Exception $e){
                            DB::rollBack();
                            $msg="Terjadi kesalahan sistem saat publish ".$e->getMessage();
                        }
                        if($publish){
                            $get_penulis=Penulis_artikel::where('id', $get_data['id_penulis'])->first();
                            $data_wa['judul']=$get_data['judul'];
                            $data_wa['nama_penerima']=$get_penulis['nama'];
                            $data_wa['no_handphone']=$get_penulis['no_handphone'];
                            $category="notification_publish";
                            $this->sendWaNotification($category, $data_wa);
                        }
                    }else{
                        $msg="Dokumen Artikel tidak dapat dipublish. Mohon hubungi tim pengembang";
                    }
                }else{
                    $msg="Data tidak ditemukan";
                }
            }catch(DecryptException $e){
                $msg="Invalid token";
            }
        }else{
            $msg="Akses ditolak";
        }
        return response()->json(['status'=>$publish, 'msg'=>$msg, 'callForm'=>'loadDataPublish()']);
    }
    public function checkDataPersonal(Request $request){
        $check=false;
        $msg="";
        try{
            $artikel_id=Crypt::decrypt($request->token_a);
            $get_penulis=Penulis_artikel::join('artikel', 'artikel.id_penulis', '=', 'penulis_artikel.id')
                            ->where('artikel.step', 7)
                            ->where('artikel.id', $artikel_id)
                            ->first();
            if(!is_null($get_penulis)){
                $check=true;
            }else{
                $msg="Data personal tidak ditemukan";
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$check, 'msg'=>$msg]);
    }
    public function checkDataArtikel(Request $request){
        $msg="";
        $check=false;
        if(isJM()){
            try{
                $artikel_id=Crypt::decrypt($request->token_a);
                $get_artikel=Artikel::join('kategori_artikel', 'kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                                ->where('artikel.step', 7)
                                ->whereRaw('foto_penulis is not null')
                                ->first();
                if(!is_null($get_artikel)){
                    $get_keyword=Keyword::where('id_artikel', $artikel_id)->get();
                    if($get_keyword->count() == 0){
                        $msg="Data keyword tidak lengkap";
                    }else{
                        $check=true;
                    }
                }else{
                    $msg="Data artikel tidak lengkap";
                }
            }catch(DecryptException $e){
                $msg="Invalid token";
            }
        }else{
            $msg="Akses ditolak";
        }
        return response()->json(['status'=>$check, 'msg'=>$msg]);
    }
    public function checkDataReview(Request $request){
        $check=false;
        $msg="";
        $warning=null;
        if(isJM()){
            try{
                $artikel_id=Crypt::decrypt($request->token_a);
                $get_data_review=Review_stage::where('step', 7)
                                ->whereRaw('edoc_catatan_reviewer is null')
                                ->whereRaw('edoc_perbaikan_penulis is null')
                                ->whereRaw('catatan_jm is null')
                                ->where('review_stage.id_artikel', $artikel_id)
                                ->first();
                $check=true;
                if(is_null($get_data_review)){
                    $warning="Artikel ini akan dipublish tanpa review.";
                }
            }catch(DecryptException $e){
                $msg="Invalid token";
            }
        }else{
            $msg="Akses ditolak";
        }
        return response()->json(['status'=>$check, 'msg'=>$msg, 'warning'=>$warning]);
    }
    public function checkDataPublish(Request $request){
        $check=false;
        $msg="";
        if(isJM()){
            try{
                $artikel_id=Crypt::decrypt($request->token_a);
                $get_data=Publish_artikel::where('id_artikel', $artikel_id)
                                        ->whereRaw('text_tulisan is null')
                                        ->whereRaw('edoc is not null')
                                        ->first();
                if(!is_null($get_data)){
                    $check=true;
                }else{
                    $msg="Data publish artikel tidak ditemukan";
                }
            }catch(DecryptException $e){
                $msg="Invalid token";
            }
        }else{
            $msg="AKses ditolak";
        }
        return response()->json(['status'=>$check, 'msg'=>$msg]);
    }
    public function formTambahTema(Request $request){
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $get_artikel=Publish_artikel::join('artikel', 'artikel.id', '=', 'publish_artikel.id_artikel')
                                        ->select('publish_artikel.id', 'artikel.judul')
                                        ->where('artikel.step', 7)
                                        ->where('artikel.id', $artikel_id)
                                        ->first();
            if(!is_null($get_artikel)){
                $get_tema=Issue_artikel::where('cfp', true)->get();
                return view('arunika/artikel/form_tambah_tema', ['artikel'=>$get_artikel, 'tema'=>$get_tema]);
            }else{
                echo "Artikel tidak ditemukan";
            }

        }catch(DecryptException $e){
            echo "Invalid token";
        }
    }
    public function updateTema(Request $request){
        $update=false;
        try{
            $publish_id=Crypt::decrypt($request->token_id);
            try{
                $validation=$request->validate([
                    'tema'=>'required',
                ]);
                $get_publish_data=Publish_artikel::where('id', $publish_id)->first();
                if(!is_null($get_publish_data)){
                    $get_publish_data->code_issue=Crypt::decrypt($request->tema);
                    $update=$get_publish_data->update();
                    if($update){
                        $msg="Berhasil menambahkan tema";
                    }else{
                        $msg="Terjadi kesalahan sistem saat menyimpan Tema Artikel";
                    }
                }else{
                    $msg="Data Publish tidak ditemukan";
                }
            }catch(ValidationException $e){
                $msg=$e->validator->errors()->first();
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        return response()->json(['status'=>$update, 'msg'=>$msg, 'callForm'=>'loadDataPublish()', 'token_id'=>Crypt::encrypt($get_publish_data['id_artikel']), 'closeModal'=>true]);
    }
    public function sendWaNotification($category, $data_wa){
        if($category === "send_artikel_to_jm"){
            $get_jm=$this->getJM();
            $judul=$data_wa['judul'];
            $data_penerima=$get_jm->getData();
            $no_wa=$data_penerima->no_hp;
            $nama_penerima=$data_penerima->nama;

            $msg="Artikel dengan judul : _".$judul.'_'.PHP_EOL." baru saja di kirimkan.";
            $msg.=PHP_EOL."Silahkan untuk menentukan reviewer untuk dapat melanjutkan proses review.".PHP_EOL;
            
        }else if($category === "assign_reviewer"){
            $msg="Anda telah ditunjuk untuk melakukan review artikel dengan judul : ".$data_wa['judul'].PHP_EOL;
            $msg.="Silahkan login untuk melihat lebih lanjut.".PHP_EOL;
            $judul=$data_wa['judul'];
            $no_wa=$data_wa['no_handphone'];
            $nama_penerima=$data_wa['nama_penerima'];
        }else if($category === "reviewer_result"){    //hasil review reviewer kepada author
            $judul=$data_wa['judul'];
            $msg="Artikel anda dengan judul ".$judul." telah selesai direview,  dengan hasil : _".$data_wa['hasil_reviewer'].'_'.PHP_EOL;
            $msg.="Silahkan login kehalaman arunika untuk melihat lebih detil";
            
            $nama_penerima=$data_wa['nama_penerima'];
            $no_wa=$data_wa['no_wa'];
            $nama_penerima=$data_wa['nama_penerima'];
        }else if($category === "send_perbaikan_author"){    //daro author kepada jm
            $get_jm=$this->getJM();
            $judul=$data_wa['judul'];
            $data_penerima=$get_jm->getData();
            $no_wa=$data_penerima->no_hp;
            $nama_penerima=$data_penerima->nama;

            $msg="Perbaikan Artikel dengan judul : _".$judul.'_'.PHP_EOL." baru saja di kirimkan.";
            $msg.=PHP_EOL."Silahkan untuk menentukan reviewer untuk dapat melanjutkan proses review.".PHP_EOL;
        }else if($category === "artikel_accepted"){
            $get_jm=$this->getJM();
            $judul=$data_wa['judul'];
            $data_penerima=$get_jm->getData();
            $no_wa=$data_penerima->no_hp;
            $nama_penerima=$data_penerima->nama;

            $msg="Artikel dengan judul : _".$judul.'_'.PHP_EOL." telah di Setujui oleh reviewer.";
            $msg.=PHP_EOL."Silahkan login untuk melakukan persiapan publish.".PHP_EOL;
        }else if($category === "notification_publish"){
            $nama_penerima=$data_wa['nama_penerima'];
            $judul=$data_wa['judul'];
            //$no_wa=$data_wa['no_handphone'];
            $no_wa="081273861528";
            $msg="Artikel anda dengan judul ".$judul." telah publish.".PHP_EOL;
            $msg.="Silahkan kunjungi halaman arunika";
        }
        
        $msg.="Terimakasih";
        $data_wa['no_wa']=$no_wa;
        //$data_wa['no_wa']="081273861528";
        $data_wa['nama']=$nama_penerima;
        $data_wa['pesan']=$msg;
        $send_wa_notif=sendWaHelp($data_wa);
        $status=$send_wa_notif;
        if($status === "ok"){

        }else{
            //harus disimpan
        }
    }
    public function getJM(){
        $get_jm=Editorial_team::join('pegawai', 'pegawai.id', '=', 'editorial_team.id_pegawai')
                            ->where('sebagai', 'jurnal_manager')
                            ->where('editorial_team.active', true)
                            ->select('pegawai.nama', 'pegawai.no_handphone')
                            ->first();
        return response()->json(['nama'=>$get_jm['nama'], 'no_hp'=>$get_jm['no_handphone']]);
    }
    public function validateJM(){
        if(isJM()){
            return true;
        }else{
            echo "Access denied";
            exit();
        }
    }
    public function getPegawaiById($id){
        $get_data=Pegawai::where('id', $id)->first();
        return response()->json(['nama'=>$get_data['nama'], 'no_handphone'=>$get_data['no_handphone']]);
    }
    public function addPengumuman(){
        $this->validateJM();
        return view('arunika/pengumuman/form_add_pengumuman');
    }
    public function listPengumuman(){
        $this->validateJM();
        $get_pengumuman=Pengumuman_arunika::all();
        $jumlah=$get_pengumuman->count();
        return view('arunika/pengumuman/list_pengumuman', ['data_pengumuman'=>$get_pengumuman, 'jumlah'=>$jumlah]);
    }
    public function savePengumuman(Request $request){
        $save=false;
        try{
            $validate=$request->validate([
                'judul'=>'required',
                'file'=>['required', 'file'],
                'keterangan'=>['required'],
            ]);
            $file=$request->file;
            $size=$file->getSize();
            $type=$file->getMimeType();
            if($size <= 6291456){
                if($type === "application/pdf"){
                    $file_name=date('YmdHis')."_".$file->getClientOriginalName();
                    $destination="upload/pengumuman";
                    $file->move($destination, $file_name);
                    if(File::exists($destination."/".$file_name)){
                        $path=$destination."/".$file_name;
                        $pengumuman=new Pengumuman_arunika;
                        $pengumuman->judul=$request->judul;
                        $pengumuman->edoc=$path;
                        $pengumuman->keterangan=$request->keterangan;
                        $save=$pengumuman->save();
                        if($save){
                            $msg="Berhasil menyimpan data";
                        }else{
                            $msg="Terjadi kesalahan saat menyimpan data";
                        }
                    }else{
                        $msg="Terjadi kesalahan saat upload dokumen";
                    }
                }else{
                    $msg="Tipe file harus PDF";
                }
            }else{
                $msg="Ukuran File harus lebih kecil dari 6 mb";
            }
        }catch(ValidationException $e){
            $msg=$e->validator->errors()->first();
        }
        return response()->json(['status'=>$save, 'msg'=>$msg, 'callLink'=>'list-pengumuman']);
    }
    public function getPengumumanById($pengumuman_id, $action){
        $get_pengumuman=null;
        $msg="";
        try{
            $id=Crypt::decrypt($pengumuman_id);
            $get_pengumuman=Pengumuman_arunika::where('id', $id)->first();
            if(is_null($get_pengumuman)){
                $msg="Data tidak ditemukan";   
            }
        }catch(DecryptException $e){
            $msg="Invalid token";
        }
        if($action === "display"){
            return response()->json(['data'=>$get_pengumuman, 'msg'=>$msg])->getData();
        }else if($action === "update"){
            return $get_pengumuman;
        }
    }
    public function editPengumuman(Request $request){
        $get_data=$this->getPengumumanById($request->token_id, 'display');
        $data_pengumuman=$get_data->data;
        return view('arunika/pengumuman/form_add_pengumuman', ['data_pengumuman'=>$data_pengumuman, 'msg'=>$get_data->msg]);
    }
    public function updatePengumuman(Request $request){
        $this->validateJM();
        $update=false;
        $data_pengumuman=$this->getPengumumanById($request->token_i, 'update');
        if($data_pengumuman !== null){
            try{
                $validate=$request->validate([
                    'judul'=>'required',
                    'keterangan'=>['required'],
                ]);
                $upload=true;
                if(isset($request->file) && $request->file !== null){
                    $upload=false;
                    $file=$request->file;
                    $size=$file->getSize();
                    $type=$file->getMimeType();
                    if($size <= 6291456){
                        if($type === "application/pdf"){
                            $file_name=date('YmdHis')."_".$file->getClientOriginalName();
                            $destination="upload/pengumuman";
                            $file->move($destination, $file_name);
                            if(File::exists($destination."/".$file_name)){
                                $upload=true;
                                $path=$destination."/".$file_name;
                                $data_pengumuman->edoc=$path;
                            }else{
                                $msg="Terjadi kesalahan saat upload data";
                            } 
                        }else{
                            $msg="Tipe file harus PDF";
                        }
                    }else{
                        $msg="Ukuran file maximal 6mb";
                    }
                }
                if($upload){
                    $data_pengumuman->judul=$request->judul;
                    $data_pengumuman->keterangan=$request->keterangan;
                    $update=$data_pengumuman->save();
                    if($update){
                        $msg="Berhasil ubah data ".$data_pengumuman->judul;
                    }else{
                        $msg="Terjadi kesalahan saat update data";
                    }
                }
            }catch(ValidationException $e){
                $msg=$e->validator->errors()->first();
            }
        }else{
            $msg=$get_data->msg;
        }
        return response()->json(['status'=>$update, 'msg'=>$msg, 'callLink'=>'list-pengumuman']);
    }
    
}
