<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artikel;
use App\Review_stage;
use Illuminate\Support\Facades\Auth;


class dashboardController extends Controller
{
    public function index(){
        $data=array();
        $jumlah_masuk=0;
        $jumlah_proses_review=0;
        $jumlah_perbaikan=0;
        $jumlah_diterima=0;
        $jumlah_siap_publish=0;
        $jumlah_artikel_personal_draft=0;
        $jumlah_artikel_personal_proses=0;
        $jumlah_artikel_personal_perbaikan=0;
        $jumlah_artikel_personal_diterima=0;
        $jumlah_artikel_personal_persiapan=0;
        $jumlah_artikel_reviewer=0;
        $nip=Auth::user()->nip;
        if(isReviewer()){
            // $get_review_artikel=Artikel::join('review_stage', function($join){
            //                             $join->on('review_stage.id_artikel', '=', 'artikel.id')
            //                             ->where('review_stage.step', 4);
            //                         })
            //                         ->join('reviewer_artikel', function($join){
            //                             $join->on('reviewer_artikel.id_review', '=', 'review_stage.id')
            //                             ->where('reviewer_artikel.status', true);
            //                         })
            //                         ->join('pegawai', function($join) use($nip){
            //                             $join->on('pegawai.id', '=', 'reviewer_artikel.id_pegawai')
            //                                 ->where('pegawai.nip', $nip);
            //                         })
            //                         ->where('artikel.step', 4)
            //                         ->get();
            $get_review_artikel=Review_stage::join('artikel', function($join){
                                    $join->on('artikel.id', '=', 'review_stage.id_artikel')
                                    ->whereRaw('artikel.step >= 3')
                                    ->whereRaw('artikel.step <= 4');
                                })
                                ->join('reviewer_artikel', function($join){
                                    $join->on('reviewer_artikel.id_review', '=', 'review_stage.id')
                                    ->where('reviewer_artikel.status', true);
                                })
                                ->join('pegawai', function($join) use($nip){
                                        $join->on('pegawai.id', '=', 'reviewer_artikel.id_pegawai')
                                            ->where('pegawai.nip', $nip);
                                    })
                                ->join('step_master', 'step_master.step_id', '=', 'artikel.step')
                                ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                                ->where('review_stage.step', 4)
                                ->orWhere(function($a){
                                    $a->where('review_stage.step', 5)
                                    ->whereRaw('review_stage.send_author_at is null');
                                })
                                ->orderBy('review_stage.updated_at', 'desc')
                                ->get();
            $jumlah_artikel_reviewer=$get_review_artikel->count();
            $data['jumlah_artikel_reviewer']=$jumlah_artikel_reviewer;
        }
        if(isJM()){

            $get_data_masuk=Artikel::join('step_master', 'step_master.step_id', '=', 'artikel.step')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->select('artikel.*', 'penulis_artikel.nama', 'penulis_artikel.nip', 'penulis_artikel.satker', 'penulis_artikel.jabatan', 'penulis_artikel.pangkat', 'step_master.step_text')
                            ->whereBetween('step', [3,7])
                            // ->orWhere('step', 6)
                            //->orWhere('step', 7)
                            ->get();
            $jumlah=$get_data_masuk->count();
            foreach($get_data_masuk as $list_artikel){
                if($list_artikel['step'] === 3){
                    $jumlah_masuk+=1;
                }
                if($list_artikel['step'] === 4){
                    $jumlah_proses_review+=1;
                }
                if($list_artikel['step'] === 5){
                    $jumlah_perbaikan+=1;
                }
                if($list_artikel['step'] === 6){
                    $jumlah_diterima+=1;
                }
                if($list_artikel['step'] === 7){
                    $jumlah_siap_publish+=1;
                }
            }
            $data['jumlah_masuk']=$jumlah_masuk;
            $data['jumlah_proses_review']=$jumlah_proses_review;
            $data['jumlah_perbaikan']=$jumlah_perbaikan;
            $data['jumlah_diterima']=$jumlah_diterima;
            $data['jumlah_siap_publish']=$jumlah_siap_publish;
            $data['total_artikel_jm']=$jumlah_masuk+$jumlah_proses_review+$jumlah_perbaikan+$jumlah_diterima+$jumlah_siap_publish;
            $data['total_artikel_proses_jm']=$jumlah_masuk+$jumlah_proses_review+$jumlah_perbaikan+$jumlah_diterima;
        }
        $get_artikel_personal=Artikel::join("penulis_artikel", function($join) use($nip){
                                            $join->on('penulis_artikel.id', '=', 'artikel.id_penulis')
                                            ->where('penulis_artikel.nip', $nip);
                                        })
                                    ->join('step_master', 'step_master.step_id', '=', 'artikel.step')
                                    ->select('artikel.*')
                                    ->get();
        $jumlah_artikel_personal=$get_artikel_personal->count();
        if($jumlah_artikel_personal > 0){
            foreach($get_artikel_personal as $list_artikel_personal){
                if($list_artikel_personal['step'] <= 2){
                    $jumlah_artikel_personal_draft+=1;
                }
                if($list_artikel_personal['step'] >= 3 && $list_artikel_personal['step'] <= 4){
                    $jumlah_artikel_personal_proses+=1;
                }
                if($list_artikel_personal['step'] === 5){
                    $jumlah_artikel_personal_perbaikan+=1;
                }
                if($list_artikel_personal['step'] === 6){
                    $jumlah_artikel_personal_diterima+=1;
                }
                if($list_artikel_personal['step'] === 7){
                    $jumlah_artikel_personal_persiapan+=1;
                }
            }
        }
        $data['jumlah_artikel_personal_draft']=$jumlah_artikel_personal_draft;
        $data['jumlah_artikel_personal_proses']=$jumlah_artikel_personal_proses;
        $data['jumlah_artikel_perbaikan_personal']=$jumlah_artikel_personal_perbaikan;
        $data['jumlah_artikel_personal_proses_all']=$jumlah_artikel_personal_proses+$jumlah_artikel_personal_perbaikan+$jumlah_artikel_personal_diterima+$jumlah_artikel_personal_persiapan;
        $data['total_artikel_personal']=$jumlah_artikel_personal_proses+$jumlah_artikel_personal_draft+$jumlah_artikel_personal_perbaikan+$jumlah_artikel_personal_diterima+$jumlah_artikel_personal_persiapan;
        return view('arunika/index_arunika', ['data'=>$data]);
    }
}
