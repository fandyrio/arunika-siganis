<?php
    namespace App\Services;

    use App\Artikel;
    use App\Editorial_team;
    use App\Reviewer_artikel;
    use Illuminate\Support\Facades\DB;
    use App\Review_stage;
    use App\Pegawai;
    use App\Services\notificationWA;

    class artikelService{

        protected $notifService;

        public function __construct(notificationWA $notification_wa){
            $this->notifService=$notification_wa;
        }

        public function saveNextReviewer($artikel_id){
            $save_next_reviewer=false;
            $get_reviewer_before=Reviewer_artikel::join('review_stage', 'review_stage.id', '=', 'reviewer_artikel.id_review')
                                                ->where('review_stage.step', 5)
                                                ->where('reviewer_artikel.id_artikel', $artikel_id)
                                                ->where('reviewer_artikel.status', true)
                                                ->select('reviewer_artikel.*')
                                                ->orderBy('reviewer_artikel.id', 'desc')
                                                ->first();
            //insert artikel badge
            //$save_review=false;
            
            // $reviewer_ke=$check_review_stage->count();
            if(!is_null($get_reviewer_before)){
                try{
                    DB::beginTransaction();
                    
                    //jika ada reviewer sebelumnya yang masih aktif dan sedang melakukan reviewer
                    $reviewer_id=$get_reviewer_before['id_pegawai'];
                    $check_review_stage=Review_stage::where('id', $get_reviewer_before['id_review'])->first();
                    $review_ke=$check_review_stage['review_ke']+=1;
                    // $get_reviewer_before->status=false;
                    // $get_reviewer_before->update();

                    //insert review stage
                    $review_stage=new Review_stage;
                    $review_stage->id_artikel=$artikel_id;
                    $review_stage->step=4;
                    $review_stage->review_ke=$review_ke;
                    $review_stage->status=false;
                    $review_stage->save();
                    
                    //insert reviewer
                    $id_review=$review_stage->id;
                    $reviewer_artikel=new Reviewer_artikel;
                    $reviewer_artikel->id_pegawai=$reviewer_id;
                    $reviewer_artikel->id_review=$id_review;
                    $reviewer_artikel->id_artikel=$artikel_id;
                    $reviewer_artikel->tgl_pilih=date('Y-m-d H:i:s');
                    $reviewer_artikel->tgl_mulai=date('Y-m-d');
                    $reviewer_artikel->tgl_estimasi_selesai=date('Y-m-d');
                    $reviewer_artikel->status=true;
                    $reviewer_artikel->save();
                    
                    //set artikel step menjadi sedang di review
                    $get_artikel=Artikel::where('id', $artikel_id)->first();
                    // $get_artikel->step=4;
                    // $get_artikel->update();
                    
                    //kirim pemberitahuan ke reviewer
                    $get_pegawai=$this->getPegawaiById($reviewer_id);
                    $data_wa['judul']=$get_artikel['judul'];
                    $data_wa['no_handphone']=$get_pegawai['no_handphone'];
                    $data_wa['nama_penerima']=$get_pegawai['nama'];
                    $this->notifService->sendWaNotification('assign_reviewer', $data_wa);
                    $msg="Berhasil menyimpan reviewer";
                    $save_next_reviewer=true;
                    DB::commit();   
                }catch(\Exception $e){
                    DB::rollback();
                    $msg="Terjadi kesalahan sistem saat menyimpan reviewer ".$e->getMessage();
                }
            }else{
                $msg="Data reviewer tidak ditemukan";
            }

            return [
                'status'=>$save_next_reviewer,
                'msg'=>$msg
            ];
        }
        public function getPegawaiById($id){
            $get_data=Pegawai::where('id', $id)->first();
            return [
                'nama'=>$get_data['nama'], 
                'no_handphone'=>$get_data['no_handphone']
            ];
        }

    }

?>