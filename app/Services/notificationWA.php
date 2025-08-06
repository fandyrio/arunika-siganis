<?php
    namespace App\Services;
    use App\Config;
    use App\Editorial_team;


    class notificationWA{
        public function __construct(){
            // $this->artikelService=$artikel_service;
        }

        public function sendWaNotification($category, $data_wa){
            $domain="domain belum disetting";
            $get_config=Config::where('config_name', 'domain')->first();
            if(!is_null($get_config)){
                $domain=$get_config['config_value'];
            }
            if($category === "send_artikel_to_jm"){
                $get_jm=$this->getJM();
                $judul=$data_wa['judul'];
                $no_wa=$get_jm['no_hp'];
                $nama_penerima=$get_jm['nama'];

                $msg="Artikel dengan judul : *_".$judul."_* baru saja di kirimkan.";
                $msg.="\r\rSilahkan untuk menentukan reviewer untuk dapat melanjutkan proses review.";
                
            }else if($category === "assign_reviewer"){
                $msg="Anda telah ditunjuk untuk melakukan review artikel dengan judul _: ".$data_wa['judul']."_\r\r";
                $msg.="Silahkan login untuk melihat lebih lanjut.\r";
                $judul=$data_wa['judul'];
                $no_wa=$data_wa['no_handphone'];
                $nama_penerima=$data_wa['nama_penerima'];
            }else if($category === "reviewer_result"){    //hasil review reviewer kepada author
                $judul=$data_wa['judul'];
                $msg="Artikel anda dengan judul _".$judul."_ telah selesai direview,  \rdengan hasil : _".$data_wa['hasil_reviewer']."_\r\r";
                if($data_wa['hasil_reviewer']){
                    $msg.="Untuk melihat catatan reviewer, silahkan login kehalaman arunika\r";
                }else{
                    $msg.="Silahkan login kehalaman arunika untuk melihat lebih detil.\r";
                }
                $nama_penerima=$data_wa['nama_penerima'];
                $no_wa=$data_wa['no_wa'];
                $nama_penerima=$data_wa['nama_penerima'];
            }else if($category === "send_perbaikan_author"){    //daro author kepada jm
                $get_jm=$this->getJM();
                $judul=$data_wa['judul'];
                $no_wa=$get_jm['no_hp'];
                $nama_penerima=$get_jm['nama'];

                $msg="Perbaikan Artikel dengan judul : _".$judul."_ baru saja di kirimkan.";
                $msg.="\r\rSilahkan untuk menentukan reviewer untuk dapat melanjutkan proses review.\r";
            }else if($category === "artikel_accepted"){
                $get_jm=$this->getJM();
                $judul=$data_wa['judul'];
                $no_wa=$get_jm['no_hp'];
                $nama_penerima=$get_jm['nama'];

                $msg="Artikel dengan judul : _".$judul."_\rtelah di Setujui oleh reviewer.";
                $msg.="\r\rSilahkan login untuk melakukan persiapan publish.".PHP_EOL;
            }else if($category === "notification_publish"){
                $nama_penerima=$data_wa['nama_penerima'];
                $judul=$data_wa['judul'];
                $no_wa=$data_wa['no_handphone'];
                $msg="Artikel anda dengan judul ".$judul." telah publish.\r\r";
                $msg.="Silahkan kunjungi halaman arunika\r";
            }
            
            $msg.="\rTerimakasih";
            $msg.="\r\rHalaman arunika dapat diakses melalui : ".strip_tags($domain);
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
            return ['nama'=>$get_jm['nama'], 'no_hp'=>$get_jm['no_handphone']];
        }
    }


?>