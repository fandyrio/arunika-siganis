<?php
    namespace App\Services;

    use App\Artikel;
    use App\Editorial_team;
    use App\Reviewer_artikel;
    use Illuminate\Support\Facades\DB;
    use App\Review_stage;
    use App\Pegawai;
use App\Penulis_artikel;
use App\Services\notificationWA;
use App\Step_master;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

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

        public function getStepArtikelByStepId($step_id){
            $get_step=Step_master::where('step_id', $step_id)->first();
            return $get_step;
        }

        public function saveNewStepArtikel($step_id, $step_text){
            $step=new Step_master;
            $step->step_id=$step_id;
            $step->step_text=$step_text;
            return $step->save();
        }

        public function listArtikelDikembalikan(){
            $get_step=$this->getStepArtikelByStepId(9);
            if(is_null($get_step)){
                $this->saveNewStepArtikel(9, "Ditolak");
            }

            $get_data=Artikel::join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'step_master.step_text')
                            ->where('step', 9)
                            ->get();
            $jumlah=$get_data->count();
            return ['data'=>$get_data, 'jumlah'=>$jumlah];
        }

         public function listArtikelDikembalikanSE($nip){
            $get_step=$this->getStepArtikelByStepId(9);
            if(is_null($get_step)){
                $this->saveNewStepArtikel(9, "Ditolak");
            }
            $get_pegawai = Editorial_team::join("pegawai as p", "p.id", "=", "editorial_team.id_pegawai")
                                        ->where("p.nip", $nip)->first();
            
            $id_pegawai = $get_pegawai->id;

            $get_data=Artikel::join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'step_master.step_text')
                            ->where('step', 9)
                            ->where("artikel.section_editor_id", $id_pegawai)
                            ->get();
            $jumlah=$get_data->count();
            return ['data'=>$get_data, 'jumlah'=>$jumlah];
        }

        public function savePengembalian($artikel_id, $alasan_pengembalian){
            $data_wa=[];
            $status=false;
            $get_artikel=Artikel::where('id', $artikel_id)
                            ->where('step', '>', 2)
                            ->where('step', '<', 6)
                            ->first();
            if(!is_null($get_artikel)){
                $get_penulis=Penulis_artikel::where('id', $get_artikel['id_penulis'])->first();
                if(!is_null($get_penulis)){
                    $get_artikel->keterangan=$alasan_pengembalian;
                    $get_artikel->step=9;
                    if($get_artikel->update()){
                        $data_wa['judul']=$get_artikel['judul'];
                        $data_wa['nama_penerima']=$get_penulis['nama'];
                        $data_wa['no_handphone']=$get_penulis['no_handphone'];
                        $data_wa['alasan']=$alasan_pengembalian;
                        $data_wa['nip_penerima'] = $get_penulis['nip'];
                        
                        $status=true;
                        $msg="Berhasil mengembalikan artikel";
                    }else{
                        $msg="Terjadi kesalahan sistem saat update data";
                    }
                }else{
                    $msg="Data Penulis tidak ditemukan";
                }
            }else{
                $msg="Data artikel tidak ditemukan";
            }

            return ['status'=>$status, 'msg'=>$msg, 'data_wa'=>$data_wa];
        }

        public function cancelPengembalianArtikel($artikel_id){
            $status=false;
            $data_wa=[];
            $get_artikel=Artikel::where('id', $artikel_id)
                            ->where('step', 9)
                            ->first();
            if(!is_null($get_artikel)){
                $get_penulis=Penulis_artikel::where('id', $get_artikel['id_penulis'])->first();
                if(!is_null($get_penulis)){
                    $data_wa['judul']=$get_artikel['judul'];
                    $data_wa['nama_penerima']=$get_penulis['nama'];
                    $data_wa['no_handphone']=$get_penulis['no_handphone'];
                    $data_wa['nip_penerima']=$get_penulis['nip'];
                    
                    //update artikel
                    $get_artikel->step=3;
                    $get_artikel->keterangan=null;
                    if($get_artikel->update()){
                        $status=true;
                        $msg="Berhasil menyimpan data ";
                    }else{
                        $msg="Terjadi kesalahan sistem saat mengubah data";
                    }
                }else{
                    $msg="Data Penulis artikel tidak ditemukan";
                }
                
            }else{
                $msg="Artikel tidak ditemukan";
            }

            return ['status'=>$status, 'msg'=>$msg, 'data_wa'=>$data_wa];
        }

        public function getSectionEditor(){
            $data = [];
            $get_se = Editorial_team::join("pegawai as p", "p.id", "editorial_team.id_pegawai")
                                    ->select("p.nama", "editorial_team.id", "p.id_pegawai")
                                    ->where("editorial_team.sebagai", "section_editor")
                                    ->get();
            $jumlah = $get_se->count();
            if($jumlah > 0){
                foreach($get_se as $list){
                    $data[]=[
                        "nama"=>$list['nama'],
                        "editorial_token"=>Crypt::encrypt($list['id']),
                        "pegawai_token"=>Crypt::encrypt($list['id_pegawai'])
                    ];
                }
            }

            return ['jumlah'=>$jumlah, 'data'=>$data];
        }

        public function getActiveSectionEditor(){
            $data = [];
            $get_data = Editorial_team::join("pegawai as p", "p.id", "=", "editorial_team.id_pegawai")
                                    ->leftJoin("artikel as a", function($join){
                                        $join->on("a.section_editor_id", "=", 'editorial_team.id')
                                            ->where("a.step", "<", 8);
                                    })
                                ->where("editorial_team.sebagai", "section_editor")
                                ->select("p.nama", DB::raw('count(a.id) as jumlah'))
                                ->groupBy('p.nama')
                                ->get();
            $jumlah = $get_data->count();
            if($jumlah > 0){
                foreach($get_data as $list){
                    $data[] = [
                        'nama'=>$list['nama'],
                        'jumlah'=>$list['jumlah']
                    ];
                }
            }
            return ['jumlah'=>$jumlah, 'data'=>$data];
        }

        public function getSectionEditorArtikel($artikel_id){
            $ada_se = false;
            $data_artikel = null;
            $get_data = Artikel::join("editorial_team as et", "et.id", "artikel.section_editor_id")
                                ->join("pegawai as p", "p.id", "et.id_pegawai")
                                ->where("artikel.id", $artikel_id)
                                ->select("p.nama", "artikel.judul")
                                ->first();
            if(!is_null($get_data)){
                $ada_se = true;
                // $nama = $get_data->nama;
                $data_artikel['judul'] = $get_data->judul;
                $data_artikel['nama'] = $get_data->nama;
            }

            return ['ada_se'=>$ada_se, 'data'=>$data_artikel];
        }

        public function getSectionEditorById($section_editor_id){
            $get_data = Editorial_team::join("pegawai as p", "p.id", "editorial_team.id_pegawai")
                                        ->where("editorial_team.id", $section_editor_id)
                                        ->where("editorial_team.sebagai", "section_editor")
                                        ->where("editorial_team.active", true)
                                        ->select("editorial_team.*", "p.no_handphone", "p.nama", "p.nip")
                                        ->first();
            return $get_data;
        }

        public function assignSectionEditor($artikel_id, $section_editor_id){
            $status = false;
            $judul = "";
            $msg = "Tidak dapat menambahkan Section Editor. Artikel sudah dipublish atau sudah dihapus";
            $get_data = Artikel::where("id", $artikel_id)
                            ->whereRaw("section_editor_id is null")
                            ->where("visible", true)
                            ->whereRaw("step < 8")
                            ->first();
            if(!is_null($get_data)){
                $get_data->section_editor_id = $section_editor_id;
                $status = $get_data->update();
                if($status === true){
                    $msg = "Berhasil menambahkan Section Editor";
                    $judul = $get_data->judul;
                }
            }
            return ['status'=>$status, 'msg'=>$msg, 'judul'=>$judul];
        }

        public function getSE($artikel_id){
            $get_data = Artikel::join("editorial_team as et", "et.id", "=", "artikel.section_editor_id")
                                ->join("pegawai as p", "p.id", '=', 'et.id_pegawai')
                                ->where("artikel.id", $artikel_id)
                                ->select("artikel.judul", "p.nama", "p.no_handphone", "p.nip")
                                ->first();
            return ['nama'=>$get_data->nama, 'no_hp'=>$get_data->no_handphone, 'nip'=>$get_data->nip, 'judul'=>$get_data->judul];
        }

        public function sendwalocal(){
            $msg = "";
            $status = false;
            $url = "https://api.pt-bengkulu.go.id/api";
            $response = Http::acceptJson()->get($url);
            if($response->successful()){
                $send = Http::acceptJson()
                                ->withHeaders([
                                    'Authorization' => "simpeg-wa_live_ptd8defb6bd3338c6c56b4aa35a500a0280be2e328668c9d2879545a3accb02676",
                                    'Accept' => 'application/json'
                                ])
                                ->post($url."/v1/send-wa", [
                                    'reciver'=>"081273861528",
                                    'msg'=>"test",
                                    'type'=>'text'
                                ]);
                $result = json_decode($send);
                $status = $result->status;
                $msg = $result->msg;
            }else{
                $msg = "Server WA tidak dapat dihubungi";
            }
            return ['status'=>$status, 'msg'=>$msg];
        }

    }

?>