<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artikel;
use App\Publish_artikel;
use App\Keyword;
use App\Issue_artikel;
use App\Statistik_baca;
use App\Editorial_team;
use App\Detil_statistik_baca;
use App\Unique_visitor;
use App\Penulis_artikel;
use App\Pengumuman_arunika;
use File;
use Illuminate\Support\Facades\Cookie;
use App\Kategori_artikel;
use App\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\ValidationException;

class arunikaController extends Controller
{
    public function __construct(Request $request){
        checkUniqueVisitor();
        $id_config=["2", "4",  "5", "6"];

        $get_config=Config::whereIn('id', $id_config)->get();
        $logo_arunika=$get_config[0]['file_value'];
        $page_header=$get_config[1]['file_value'];
        $loading_animation=$get_config[2]['file_value'];
        $logo_siganis=$get_config[3]['file_value'];
        return $this->data=array('logo_arunika'=>$logo_arunika, 'page_header'=>$page_header, 'loading_animation'=>$loading_animation, 'logo_siganis'=>$logo_siganis);
        // $value = Cookie::get('visitor_id');
        // var_dump($value);
    }
    public function index(){
        $get_publish_populer=Artikel::join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                        ->join('kategori_artikel', 'kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                        ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                        ->join("statistik_baca", function($join){
                            $join->on('statistik_baca.id_artikel', '=', 'artikel.id')
                                ->whereRaw('statistik_baca.jumlah > 0');
                        })
                        ->select('artikel.id','artikel.judul', 'artikel.foto_penulis', 'publish_artikel.publish_at', 'publish_artikel.edoc_pdf', 'artikel.tentang_artikel', 'penulis_artikel.nama', 'kategori_artikel.kategori')
                        ->whereRaw('publish_artikel.code_issue is not null')
                        ->orderBy('statistik_baca.jumlah', 'desc')
                        ->get();
        //$get_kategori
        $data_artikel_populer=[];
        $x=0;
        $get_issue=Issue_artikel::all();
        $jumlah_issue=$get_issue->count();
        foreach($get_publish_populer as $list_artikel_populer){
            $replace_1=str_replace('upload/edoc/artikel/pdf/', '', $list_artikel_populer['edoc_pdf']);
            
            $foto_penulis=$list_artikel_populer['foto_penulis'];
            $str_replace=str_replace("upload/image/", "", $foto_penulis);
            $thumbnail_path="upload/image/thumbnail/thumbnail_".$str_replace;

            $tentang_artikel=substr($list_artikel_populer['tentang_artikel'],0,200);
            $data_artikel_populer[$x]['edoc_pdf']=str_replace('.pdf', '', $replace_1);
            $data_artikel_populer[$x]['judul']=$list_artikel_populer['judul'];
            $data_artikel_populer[$x]['foto_penulis']=$foto_penulis;
            $data_artikel_populer[$x]['publish_at']=$list_artikel_populer['publish_at'];
            $data_artikel_populer[$x]['tentang_artikel']=$tentang_artikel;
            $data_artikel_populer[$x]['nama']=$list_artikel_populer['nama'];
            $data_artikel_populer[$x]['kategori_artikel']=$list_artikel_populer['kategori'];
            $data_artikel_populer[$x]['token_a']=Crypt::encrypt($list_artikel_populer['id']);
            $x++;
        }
        $jumlah_publish=$get_publish_populer->count();


        $get_new_artikel=Artikel::join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                        ->join('kategori_artikel', 'kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                        ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                        ->join("statistik_baca", 'statistik_baca.id_artikel', '=', 'artikel.id')
                        ->select('artikel.id','artikel.judul', 'artikel.foto_penulis', 'publish_artikel.publish_at', 'publish_artikel.edoc_pdf', 'artikel.tentang_artikel', 'penulis_artikel.nama', 'kategori_artikel.kategori')
                        ->whereRaw('publish_artikel.code_issue is not null')
                        ->orderBy('artikel.id', 'desc')
                        ->skip(0)->take(5)
                        ->get();
        $data_new_artikel=[];
        $x=0;
        foreach($get_new_artikel as $list_new_artikel){
            $replace_1=str_replace('upload/edoc/artikel/pdf/', '', $list_new_artikel['edoc_pdf']);
            
            $foto_penulis=$list_new_artikel['foto_penulis'];
            $str_replace=str_replace("upload/image/", "", $foto_penulis);
            $thumbnail_path="upload/image/thumbnail/thumbnail_".$str_replace;

            $tentang_artikel=substr($list_new_artikel['tentang_artikel'],0,200);
            $data_new_artikel[$x]['edoc_pdf']=str_replace('.pdf', '', $replace_1);
            $data_new_artikel[$x]['judul']=$list_new_artikel['judul'];
            $data_new_artikel[$x]['foto_penulis']=$foto_penulis;
            $data_new_artikel[$x]['publish_at']=$list_new_artikel['publish_at'];
            $data_new_artikel[$x]['tentang_artikel']=$tentang_artikel;
            $data_new_artikel[$x]['nama']=$list_new_artikel['nama'];
            $data_new_artikel[$x]['kategori_artikel']=$list_new_artikel['kategori'];
            $data_new_artikel[$x]['token_a']=Crypt::encrypt($list_new_artikel['id']);
            $x++;
        }
        $jumlah_new_artikel=$get_new_artikel->count();

        $get_kategori_artikel=Kategori_artikel::get();
        $x=0;
        $kategori=[];
        foreach($get_kategori_artikel as $list_kategori){
            $kategori[$x]['kategori']=$list_kategori['kategori'];
            $kategori[$x]['link']=preg_replace('/[^A-Za-z0-9\-]/', '-', $list_kategori['kategori']);
            $x++;
        }


        //get editorial team
        $editorial_team=Editorial_team::join('pegawai', 'pegawai.id', '=', 'editorial_team.id_pegawai')
                            ->select('pegawai.nama', 'editorial_team.sebagai', 'pegawai.foto_profile')
                            ->where('editorial_team.active', true)
                            ->get();
        $jumlah_editorial=$editorial_team->count();
        $list_team=[];
        $index_team=0;
        foreach($editorial_team as $list_team_editor){
            $list_team[$index_team]['nama']=$list_team_editor['nama'];
            $list_team[$index_team]['sebagai']=$list_team_editor['sebagai'];
            $list_team[$index_team]['foto_profile']=$list_team_editor['foto_profile'] === null ? 'img/no-profile.jpg' : $list_team_editor['foto_profile'];
            $index_team++;
        }

        //get Pengumuman
        $get_pengumuman=Pengumuman_arunika::orderBy('id', 'desc')
                            ->skip(0)->take(5)    
                            ->get();
        $jumlah_pengumuman=$get_pengumuman->count();
        $get_early_view=Artikel::join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                    ->join('kategori_artikel', 'kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                    ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                    ->select('artikel.id','artikel.judul', 'artikel.foto_penulis', 'publish_artikel.publish_at', 'publish_artikel.edoc_pdf', 'artikel.tentang_artikel', 'penulis_artikel.nama', 'kategori_artikel.kategori')
                    ->whereRaw('publish_artikel.code_issue is null')
                    ->orderBy('artikel.id', 'desc')
                    ->get();

        $jumlah_early_view=$get_early_view->count();
        $x=0;
        $early_view=[];
        foreach($get_early_view as $list_early_view){
            $replace_1=str_replace('upload/edoc/artikel/pdf/', '', $list_early_view['edoc_pdf']);
            
            $foto_penulis=$list_early_view['foto_penulis'];
            $str_replace=str_replace("upload/image/", "", $foto_penulis);
            $thumbnail_path="upload/image/thumbnail/thumbnail_".$str_replace;

            $tentang_artikel=substr($list_early_view['tentang_artikel'],0,200);
            $early_view[$x]['edoc_pdf']=str_replace('.pdf', '', $replace_1);
            $early_view[$x]['judul']=$list_early_view['judul'];
            $early_view[$x]['foto_penulis']=$foto_penulis;
            $early_view[$x]['publish_at']=$list_early_view['publish_at'];
            $early_view[$x]['tentang_artikel']=$tentang_artikel;
            $early_view[$x]['nama']=$list_early_view['nama'];
            $early_view[$x]['kategori_artikel']=$list_early_view['kategori'];
            $early_view[$x]['token_a']=Crypt::encrypt($list_early_view['id']);
            $x++;
        }

        $get_penulis=Penulis_artikel::join('artikel', function($join){
                                            $join->on('artikel.id_penulis', '=', 'penulis_artikel.id')
                                                ->where('artikel.step', 8);
                                        })
                                    ->join('publish_artikel', function($join){
                                        $join->on('publish_artikel.id_artikel', '=', 'artikel.id')
                                            ->whereRaw('publish_artikel.code_issue is not null');
                                    })
                                    ->join('pegawai', 'pegawai.id_pegawai', '=', 'penulis_artikel.id_pegawai')
                                    ->selectRaw('pegawai.nama, count(artikel.id) as jumlah, pegawai.foto_profile')
                                    ->groupBy('pegawai.nama', 'pegawai.foto_profile')
                                    ->get();
        $jumlah_data_penulis=$get_penulis->count();

        return view('web/web', ['artikel'=>$data_artikel_populer, 'issue'=>$get_issue, 'jumlah_issue'=>$jumlah_issue, 'jumlah_publish'=>$jumlah_publish, 'jumlah_persiapan'=>$jumlah_early_view, 'kategori_artikel'=>$kategori, 'logo'=>$this->data, 'editorial_team'=>$list_team, 'jumlah_editorial'=>$jumlah_editorial, 'early_view'=>$early_view, 'jlh_early_view'=>$jumlah_early_view, 'new_artikel'=>$data_new_artikel, 'data_penulis'=>$get_penulis, 'jumlah_data_penulis'=>$jumlah_data_penulis, 'jumlah_pengumuman'=>$jumlah_pengumuman, 'pengumuman'=>$get_pengumuman]);
    }
    
    public function bacaArtikel($judul, $id_artikel){
        try{
            $artikel_id=Crypt::decrypt($id_artikel);
            $edoc_pdf="upload/edoc/artikel/pdf/".$judul.".pdf";
            $get_artikel=Publish_artikel::where('id_artikel', $artikel_id)
                            ->join('artikel', 'artikel.id', '=', 'publish_artikel.id_artikel')
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->select('artikel.id', 'artikel.judul', 'artikel.tentang_artikel', 'publish_artikel.text_tulisan', 'artikel.foto_penulis', 'penulis_artikel.nama', 'publish_artikel.publish_at', 'publish_artikel.code_issue', 'publish_artikel.edoc_pdf')
                            ->where('edoc_pdf', $edoc_pdf)
                            ->whereRaw('publish_at is not null')
                            ->first();
            $keyword=[];
            if(!is_null($get_artikel)){
                $x=0;
                $get_keyword=Keyword::where('id_artikel', $artikel_id)->get();
                foreach($get_keyword as $list_keyword){
                    $keyword[$x]=$list_keyword['keyword'];
                    $x++;
                }

                $get_similar=Artikel::join('keyword_artikel', 'keyword_artikel.id_artikel', 'artikel.id')
                                ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                                ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                                ->select('artikel.judul', 'artikel.id', 'artikel.foto_penulis', 'publish_artikel.edoc_pdf')
                                ->whereIn("keyword_artikel.keyword", $keyword)
                                ->whereRaw('publish_artikel.publish_at is not null')
                                ->where('artikel.id', '<>', $artikel_id)
                                ->take(0)->limit(5)
                                ->orderBy('artikel.id', 'desc')
                                ->groupBy('artikel.id', 'artikel.foto_penulis', 'artikel.judul', 'publish_artikel.edoc_pdf')
                                ->get();
                $jumlah_similar=$get_similar->count();

                $get_other=Artikel::join('keyword_artikel', 'keyword_artikel.id_artikel', 'artikel.id')
                                ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                                ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                                ->join('kategori_artikel', 'kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                                ->select('artikel.judul', 'artikel.id', 'artikel.foto_penulis', 'publish_artikel.edoc_pdf', 'kategori_artikel.kategori', 'penulis_artikel.nama')
                                ->whereRaw('publish_artikel.publish_at is not null')
                                ->where('artikel.id', '<>', $artikel_id)
                                ->take(0)->limit(5)
                                ->orderBy('artikel.id', 'desc')
                                ->groupBy('artikel.id', 'artikel.foto_penulis', 'artikel.judul', 'publish_artikel.edoc_pdf', 'kategori_artikel.kategori', 'penulis_artikel.nama')
                                ->get();
                $jlh_other=$get_other->count();

                $get_keyword=Keyword::where('id_artikel', $artikel_id)->get();
                return view('web/baca_artikel', ['artikel'=>$get_artikel, 'keyword'=>$get_keyword, 'jumlah_similar'=>$jumlah_similar, 'similar'=>$get_similar, 'jlh_other'=>$jlh_other, 'other'=>$get_other]);
            }else{
                return view('web/404');    
            }
        }catch(DecryptException $e){
            return view('web/404');
        }
    }
    public function downloadFile($file, $type){
        try{
            $file_path=Crypt::decrypt($file);
            if(File::exists($file_path)){
                if($type === "edoc-pdf"){
                    $prefix_path="upload/edoc/artikel/pdf/";
                }else if($type === "edoc-pengumuman"){
                    $prefix_path="upload/pengumuman/";
                }
                $file_name=str_replace($prefix_path, '', $file_path);
                return response()->download($file_path, $file_name);
            }else{
                echo "<center><h2>404</h2><h5>File not Found ".$file_path."</h5></center>";
            }
        }catch(DecryptException $e){
            echo "<center><h2>500</h2><h5>Err Found. Undefined data</h5></center>";
        }
    }
    public function getArtikelByTag($tag){
        $real_tag=str_replace('-', ' ', $tag);
        $get_data=Artikel::join('keyword_artikel', 'keyword_artikel.id_artikel', 'artikel.id')
                        ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                        ->select('artikel.*', 'publish_artikel.publish_at', 'publish_artikel.edoc_pdf')
                        ->whereRaw("keyword_artikel.keyword like '%".$real_tag."%' ")
                        ->get();
        return view('web/list_artikel_by_tema', ['artikel'=>$get_data, 'issue'=>"#".$real_tag, 'logo'=>$this->data, 'title'=>'Daftar Artikel '.$real_tag]);
    }
    public function getListArtikelByIssue($code_issue){
        $get_data=Publish_artikel::join('artikel', 'artikel.id', '=', 'publish_artikel.id_artikel')
                                ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                                ->select('artikel.judul', 'artikel.id', 'penulis_artikel.nama', 'publish_artikel.publish_at', 'artikel.foto_penulis', 'artikel.tentang_artikel', 'publish_artikel.edoc_pdf')
                                ->where('step', 8)
                                ->get();
        // foreach($get_data as $list_data){
        //     $replace=str_replace('upload/image/', '', $list_data['foto_penulis']);
        //     if(!File::exists('upload/image/thumbnail/thumbnail_'.$replace)){
        //         $this->createThumbnail($replace, $list_data['foto_penulis']);
        //     }
        // }
        $get_issue=Issue_artikel::where('code_issue', $code_issue)->first();
        return view('web/list_artikel_by_tema', ['title'=>'Daftar Artikel '.$get_issue['name'], 'issue'=>$get_issue['name'], 'artikel'=>$get_data, 'logo'=>$this->data]);
    }
    public function err404(){

    }
    public function createThumbnail($filename, $path){
        $source = imagecreatefromjpeg($path);
        list($width, $height) = getimagesize($path);

        // Define new dimensions (200x200 pixels)
        $newWidth = 600;
        $newHeight = 550;

        // Create a new image
        $thumb = imagecreatetruecolor($newWidth, $newHeight);

        // Resize
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save the resized image
        imagejpeg($thumb, 'upload/image/thumbnail/thumbnail_'.$filename, 100);
    }
    public function artikelSedangPublish(){
        $get_artikel=Artikel::join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                            ->join('issue_artikel', function($q){
                                $q->on('issue_artikel.code_issue', '=', 'publish_artikel.code_issue')
                                ->where('issue_artikel.status', 2);
                            })
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->select('artikel.judul', 'artikel.id', 'penulis_artikel.nama', 'publish_artikel.publish_at', 'artikel.foto_penulis', 'artikel.tentang_artikel', 'publish_artikel.edoc_pdf')
                    ->where('artikel.step', 8)
                    ->get();
        $get_publish_issue=Issue_artikel::where('status', 2)->first();
        return view('web/list_artikel_publish', ['title'=>'Daftar Publish Artikel', 'issue'=>$get_publish_issue['name'], 'artikel'=>$get_artikel, 'logo'=>$this->data]);
    }
    public function arsipIssue(){
        $get_issue=Issue_artikel::whereRaw('status >= 2')->get();
        return view('web/list_arsip_issue', ['title'=>'Arsip Tema Artikel', 'issue'=>$get_issue, 'logo'=>$this->data]);
    }
    public function earlyview(){
        $get_artikel=Artikel::join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                            ->join('issue_artikel', function($q){
                                $q->on('issue_artikel.code_issue', '=', 'publish_artikel.code_issue')
                                ->where('issue_artikel.status', 2);
                            })
                            ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->select('artikel.judul', 'artikel.id', 'penulis_artikel.nama', 'publish_artikel.publish_at', 'artikel.foto_penulis', 'artikel.tentang_artikel', 'publish_artikel.edoc_pdf')
                    ->where('artikel.step', 7)
                    ->get();
        $get_publish_issue=Issue_artikel::where('status', 2)->first();
        // foreach($get_artikel as $list_artikel){
        //     $replace=str_replace('upload/image/', '', $list_artikel['foto_penulis']);
        //     if(!File::exists('upload/image/thumbnail/thumbnail_'.$replace)){
        //         $this->createThumbnail($replace, $list_artikel['foto_penulis']);
        //     }
        // }
        return view('web/list_early_view', ['title'=>'Early View Artikel', 'issue'=>$get_publish_issue['name'], 'artikel'=>$get_artikel, 'logo'=>$this->data]);
    }
    public function searchArtikel(){
        return view('web/form_search', ['title'=>'Search', 'logo'=>$this->data]);
    }
    public function searchResult(Request $request){
        $keyword=$request->kata_kunci;
        $judul=$request->judul;
        $nama=$request->nama_penulis;
        $x=0;
        $result=[];
        if($judul !== null || $keyword !== null || $nama !== null){
            if($keyword !== null){
                $kata_kunci=Artikel::join('keyword_artikel', function($q) use($keyword){
                                $q->on('keyword_artikel.id_artikel', '=', 'artikel.id')
                                ->whereRaw("keyword_artikel.keyword like '%".$keyword."%' ");
                        })
                        ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                        ->join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                        ->select('artikel.judul', 'publish_artikel.edoc_pdf', 'penulis_artikel.nama', 'artikel.id')
                        ->get();
                foreach($kata_kunci as $list_data){
                    // $replace_1=str_replace('upload/edoc/artikel/pdf/', '', $list_data['edoc_pdf']);
                    $replace_1=str_replace('upload/edoc/artikel/pdf/', '', strtolower($list_data['edoc_pdf']));
                    $link=str_replace('.pdf', '', $replace_1);
                    $result[$x]['judul']=$list_data['judul'];
                    $result[$x]['edoc_pdf']=$link;
                    $result[$x]['penulis']=$list_data['nama'];
                    $result[$x]['id']=Crypt::encrypt($list_data['id']);
                    $x++;
                }
            }
            if($nama !== null){
                $get_penulis=Artikel::join('penulis_artikel', function($q) use($nama){
                                            $q->on('penulis_artikel.id', '=', 'artikel.id_penulis')
                                            ->whereRaw("penulis_artikel.nama like '%".$nama."%' ");
                                    })
                        ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                        ->select('artikel.judul', 'publish_artikel.edoc_pdf', 'penulis_artikel.nama', 'artikel.id')
                        ->get();
                foreach($get_penulis as $list_data_penulis){
                    $replace_1=str_replace('upload/edoc/artikel/pdf/', '', strtolower($list_data_penulis['edoc_pdf']));
                    $link=str_replace('.pdf', '', $replace_1);
                    $result[$x]['judul']=$list_data_penulis['judul'];
                    $result[$x]['edoc_pdf']=$link;
                    $result[$x]['penulis']=$list_data_penulis['nama'];
                    $result[$x]['id']=Crypt::encrypt($list_data_penulis['id']);
                    $x++;
                }
            }

            if($judul !== null){
                $get_judul=Artikel::join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                                    ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                                    ->select('artikel.judul', 'publish_artikel.edoc_pdf', 'penulis_artikel.nama', 'artikel.id')
                                    ->whereRaw("judul like '%".$judul."%'")
                                    ->get();
                foreach($get_judul as $list_data_judul){
                    // $replace_1=str_replace('upload/edoc/artikel/pdf/', '', $list_data_judul['edoc_pdf']);
                    $replace_1=str_replace('upload/edoc/artikel/pdf/', '', strtolower($list_data_judul['edoc_pdf']));
                    $link=str_replace('.pdf', '', $replace_1);
                    $result[$x]['judul']=$list_data_judul['judul'];
                    $result[$x]['edoc_pdf']=$link;
                    $result[$x]['penulis']=$list_data_judul['nama'];
                    $result[$x]['id']=Crypt::encrypt($list_data_judul['id']);
                    $x++;
                }
            }
        }
        return view('web/form_search', ['title'=>'Search', 'hasil_search'=>$result, 'jumlah'=>$x, 'search_for'=>"<span style='color:orange'><i>".$nama.' '.$judul.' '.$keyword."</span></i>", 'nama'=>$nama, 'keyword'=>$keyword, 'judul'=>$judul, 'logo'=>$this->data]);
    }
    public function setReader(Request $request){
        $update=false;
        try{
            $artikel_id=Crypt::decrypt($request->token);
            $ip_address=$this->getIp();
            $visitor_id=Cookie::get('visitor_id');
            $get_visitor=Unique_visitor::leftJoin('detil_statistik_baca', function($join) use($artikel_id){
                                    $join->on('detil_statistik_baca.unique_visitor_id', '=', 'unique_visitor.id')
                                        ->where('detil_statistik_baca.artikel_id', $artikel_id);
                                })
                                ->select('unique_visitor.id','detil_statistik_baca.artikel_id')
                                ->first();
            $get_statistik_baca=Statistik_baca::where('id_artikel', $artikel_id)->first();
            if(is_null($get_visitor['artikel_id'])){
                try{
                    DB::beginTransaction();
                    $detil_statistik_baca=new Detil_statistik_baca;
                    $detil_statistik_baca->unique_visitor_id=$get_visitor['id'];
                    $detil_statistik_baca->artikel_id=$artikel_id;
                    $detil_statistik_baca->save();

                    if(is_null($get_statistik_baca)){
                        $statistik_baca=new Statistik_baca;
                        $statistik_baca->id_artikel=$artikel_id;
                        $statistik_baca->jumlah=1;
                        $statistik_baca->save();
                    }else{
                        $jumlah=(int)$get_statistik_baca['jumlah']+1;
                        $get_statistik_baca->jumlah=$jumlah;
                        $get_statistik_baca->update();
                    }
                    DB::commit();
                    $update=true;
                    $msg="Success";
                }catch(\Exception $e){
                    DB::rollBack();
                    $msg="Database error ".$e->getMessage();
                }
            }else{
                $msg="exists";
            }
        }catch(DecrpytException $e){
            $msg="Invalid token";//should be save
        }
        return response()->json(['status'=>$update, 'msg'=>$msg]);
    }
    public function getIp(){
        //get IP ADDRESS
        $ip_address="not_detect";
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {   
            $ip_address=$_SERVER['HTTP_CLIENT_IP'];   
        }   
        //if user is from the proxy   
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   
            $ip_address=$_SERVER['HTTP_X_FORWARDED_FOR'];   
        }   
        //if user is from the remote address   
        else{   
            $ip_address=$_SERVER['REMOTE_ADDR'];   
        }
        return $ip_address;
    }
    public function getAllCategory(){
        $get_all_category=Kategori_artikel::leftJoin('artikel', 'artikel.kategori_artikel_kode', '=', 'kategori_artikel.kode')
                                            ->leftJoin('publish_artikel', function($join){
                                                $join->on('publish_artikel.id_artikel', '=', 'artikel.id')
                                                    ->whereRaw('publish_artikel.code_issue is not null');
                                            })
                                            ->selectRaw("kategori_artikel.*, count(artikel.id) as jumlah")
                                            ->groupBy('kategori_artikel.kode', 'kategori_artikel.id', 'kategori_artikel.kategori', 'kategori_artikel.created_at', 'kategori_artikel.updated_at')
                                            ->get();
        $category=[];
        $x=0;
        $jlh_category=$get_all_category->count();
        foreach($get_all_category as $list_category){
            $category[$x]['category']=$list_category['kategori'];
            $category[$x]['token_id']=Crypt::encrypt($list_category['id']);
            $category[$x]['link']=preg_replace('/[^A-Za-z0-9\-]/', '-', $list_category['kategori']);
            $category[$x]['jumlah']=$list_category['jumlah'];
            $x++;
        }
        return view('web/all_category', ['category'=>$category, 'jlh_category'=>$jlh_category, 'title'=>'Kategori Artikel Arunika', 'logo'=>$this->data]);
    }
    public function getArtikelByCategory($key, $page=null){
        $category=str_replace('-', ' ', $key);
        $check_data=Kategori_artikel::where('kategori', $category)->first();
        $get_all_kategori=Kategori_artikel::all();
        $x_kat=0;
        $x=0;
        $limit=50;
        $data_artikel=[];
        $jumlah_halaman =0;
        $total=0;
        $kategori_artikel=[];
        foreach($get_all_kategori as $list_kategori){
            $kategori_artikel[$x_kat]['category']=$list_kategori['kategori'];
            $kategori_artikel[$x_kat]['token_id']=Crypt::encrypt($list_kategori['id']);
            $kategori_artikel[$x_kat]['link']=preg_replace('/[^A-Za-z0-9\-]/', '-', $list_kategori['kategori']);
            $x_kat++;
        }
        if(!is_null($check_data)){
            $content="found";
            $kode_kategori=$check_data['kode'];
            $total=Artikel::join('publish_artikel', function($join){
                                $join->on('publish_artikel.id_artikel', '=', 'artikel.id')
                                    ->whereRaw('code_issue is not null');
                            })
                            ->where('artikel.kategori_artikel_kode', $kode_kategori)
                            ->get()->count();
            $jumlah_halaman=ceil($total/$limit);
            if($page > $jumlah_halaman){
                $page=null;
            }
            if($page === null){
                $page=1;
            }
            $skip=$page * $limit - $limit;
            $get_publish=Artikel::join('penulis_artikel', 'penulis_artikel.id', '=', 'artikel.id_penulis')
                            ->join('kategori_artikel', function($join) use($kode_kategori){
                                                        $join->on('kategori_artikel.kode', '=', 'artikel.kategori_artikel_kode')
                                                                ->where('artikel.kategori_artikel_kode', $kode_kategori);
                                                    })
                            ->join('publish_artikel', 'publish_artikel.id_artikel', '=', 'artikel.id')
                            ->select('artikel.id','artikel.judul', 'artikel.foto_penulis', 'publish_artikel.publish_at', 'publish_artikel.edoc_pdf', 'artikel.tentang_artikel', 'penulis_artikel.nama', 'kategori_artikel.kategori')
                            ->whereRaw('publish_artikel.code_issue is not null')
                            ->join("statistik_baca", 'statistik_baca.id_artikel', '=', 'artikel.id')
                            ->skip($skip)->take($limit)
                            ->orderBy('statistik_baca.jumlah', 'desc')
                            ->get();
            $x=0;
            
            foreach($get_publish as $list_artikel){
                $replace_1=str_replace('upload/edoc/artikel/pdf/', '', $list_artikel['edoc_pdf']);
            
                $foto_penulis=$list_artikel['foto_penulis'];
                $str_replace=str_replace("upload/image/", "", $foto_penulis);
                $thumbnail_path="upload/image/thumbnail/thumbnail_".$str_replace;
    
                $tentang_artikel=substr($list_artikel['tentang_artikel'],0,200);
                $data_artikel[$x]['edoc_pdf']=str_replace('.pdf', '', $replace_1);
                $data_artikel[$x]['judul']=$list_artikel['judul'];
                $data_artikel[$x]['foto_penulis']=$thumbnail_path;
                $data_artikel[$x]['publish_at']=$list_artikel['publish_at'];
                $data_artikel[$x]['tentang_artikel']=$tentang_artikel;
                $data_artikel[$x]['nama']=$list_artikel['nama'];
                $data_artikel[$x]['kategori_artikel']=$list_artikel['kategori'];
                $data_artikel[$x]['token_a']=Crypt::encrypt($list_artikel['id']);
                $x++;
            }
        }else{
            $content="not_found";
        }
        return view('web/list_artikel_by_category', ['category'=>ucwords($category), 'artikel'=>$data_artikel, 'title'=>'Daftar Artikel Arunika - Kategori : '.ucwords($category), 'jumlah_halaman'=>$jumlah_halaman, 'page'=>$page, 'total'=>$total, 'jumlah_data'=>$x, 'content'=>$content, 'kategori_artikel'=>$kategori_artikel, 'category_link'=>$key, 'logo'=>$this->data]);
    }
    public function resizeImageView(Request $request){
        $width=$request->width;
        $height=$request->height;
        $file=$request->target;
        $type=$request->type;
        $prefix=$request->prefix;
        $resize=resizeImage($file, $width, $height, $type, $prefix);
        return response()->json(['background'=>$resize]);
    }
    public function getSyaratPenulisan(){
        $get_data=Config::where('config_name', 'Syarat Penulisan')->first();
        return view('web/content_static', ['syarat'=>$get_data, 'logo'=>$this->data, 'title'=>'Syarat Penulisan Arunika']);
    }
    public function getChecklistPenilaian(){
        $get_data=Config::where('config_name', 'Checklist Penilaian')->first();
        return view('web/content_static', ['syarat'=>$get_data, 'logo'=>$this->data, 'title'=>'Daftar Penilaian Arunika']);
    }
}
