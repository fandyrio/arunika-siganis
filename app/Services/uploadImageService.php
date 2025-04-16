<?php
	namespace App\Services;
	use Intervention\Image\Laravel\Facades\Image;	
	use Illuminate\Support\Facades\Log;
	use Illuminate\Support\Facades\Storage;
	use File;

	class uploadImageService{
		public function uploadImage($file_foto){
			$status=false;
			$msg="";
			$path="";
			$validate_image=$this->validateImage($file_foto);
			if($validate_image['status']){
				$filename=date('YmdHis')."-".$file_foto->getClientOriginalName();
	            // $file_foto->move($destination, $filename);
	            $img=Image::read($file_foto)->encodeByExtension($validate_image['ext'], quality:70);
	            // $path=$destination."/".$filename;
	            Storage::put('public/upload/image/'.$filename, $img);
	            $path='public/upload/image/'.$filename;
	            if(Storage::exists($path)){
	                // var_dump($real_extention);die();
	                $generateThumbnail=$this->createThumbnail($img, $filename, $validate_image['ext']);
	                if($generateThumbnail){
	                	$status=true;
	                }else{
	                	$msg="Perhatian!!. thumbnail tidak dapat dibuat. Silahkan Laporkan kepada tim Development";
	                }  
	            }else{
	                $msg="Terjadi kesalahan saat upload image";
	            }
			}else{
				$msg=$validate_image['msg'];
			}
			return [
				'status'=>$status,
				'msg'=>$msg,
				'path'=>$path
			];
		}

		public function validateImage($file_foto){
			$valid=false;
			$msg="";
			$real_extention="";
			$size=$file_foto->getSize();
            $type=$file_foto->getMimeType();
			 if($size <= 3145728){
                if($type === "image/png" || $type === "image/jpeg" || $type === "image/jpg"){
                    $real_extention=$file_foto->getClientOriginalExtension();
                    if(in_array($real_extention, $this->allowedExtentionImage())){
                    	if(!@getimagesize($file_foto)){
                    		$msg="File Bukan Gambar :)";
                    	}else{
                    		$valid=true;
                    	}
                    }else{
                    	$msg="Tipe data tidak valid";
                    }
                }else{
               		$msg="Tipe data harus Gambar (JPG / PNG)";
	            }
	        }else{
	            $msg="Ukuran File harus lebih kecil dari 3mb";
	        }
	        $data['status']=$valid;
	        $data['msg']=$msg;
	        $data['ext']=$real_extention;
	        return $data;
		}

		public function allowedExtentionImage(){
			return $allowedExts = ['jpg', 'jpeg', 'png'];
		}
		public function createThumbnail($file, $filename, $ext){
			$size=[100, 200];
			for($x=0;$x<count($size);$x++){
				$thumbnail=Image::read($file)->scaleDown($size[$x], $size[$x]);
				$path="public/upload/image/thumbnail/";
				Storage::put($path."/".$size[$x]."_".$filename, $thumbnail->encodeByExtension($ext, quality: 70));
				if(!Storage::exists($path."/".$size[$x]."_".$filename)){
					return false;
				}
			}
			return true;
		}
	}



?>