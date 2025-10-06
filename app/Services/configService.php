<?php
    namespace App\Services;

    use App\Checklist_review;

    class configService{

        public function getPertanyaanById($id_pertanyaan){
            $get_data=Checklist_review::where('id', $id_pertanyaan)->first();
            return $get_data;
        }

        public function updatePertanyaan($request, $token_id){
            $update=false;
            $get_data=Checklist_review::where('id', $token_id)->first();
            if(!is_null($get_data)){
                $get_data->pertanyaan=$request->pertanyaan;
                if($get_data->update()){
                    $msg="Berhasil mengubah data pertanyaan";
                    $update=true;
                }else{
                    $msg="Terjadi kesalahan sistem saat mengubah data";
                }
            }else{
                $msg="Data tidak ditemukan";
            }

            return [
                'status'=>$update,
                'msg'=>$msg
            ];
        }
    }

?>