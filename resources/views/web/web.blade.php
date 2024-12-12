<!--
=========================================================
* Material Kit 2 - v3.0.4
=========================================================

* Product Page:  https://www.creative-tim.com/product/material-kit 
* Copyright 2023 Creative Tim (https://www.creative-tim.com)
* Coded by www.creative-tim.com

 =========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/WebPage">

<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="apple-touch-icon" sizes="76x76" href="{!! asset('web/assets/img/apple-icon.png') !!}">
<link rel="icon" type="image/png" href="{!! asset('web/assets/img/favicon.png') !!}">

<title>Arunika By SIGANIS</title>
<!--     Fonts and icons     -->
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
<!-- Nucleo Icons -->
<link href="{!! asset('web/assets/css/nucleo-icons.css') !!}" rel="stylesheet" />
<meta name="csrf-token-web" content="{{ csrf_token() }}">
<link href="{!! asset('web/assets/css/nucleo-svg.css') !!}" rel="stylesheet" />
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<!-- Material Icons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
<!-- CSS Files -->
<link id="pagestyle" href="{!! asset('web/assets/css/material-kit.css?v=3.0.4') !!}" rel="stylesheet" />
<link href="{!! asset('web/assets/css/style.css') !!}" rel="stylesheet"/>
<!-- Nepcha Analytics (nepcha.com) -->
<!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
<script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="index-page bg-gray-200">
  
<!-- <span style='color:#58b2e1'>A</span>
      <span style='color:#e86162'>R</span>
      <span style='color:#5cd260'>U</span>
      <span style='color:#d2c167'>N</span>
      <span style='color:#5cd260'>I</span>
      <span style='color:#e86162'>K</span>
      <span style='color:#58b2e1'>A</span> -->
  <!-- Navbar -->
  <div class="loadingScreen" style='z-index:999;'>
<!--My content is the word "soundscape" but the o is replaced with a disc-->
    <center><img src="{!! asset($logo['loading_animation']) !!}"><br /><br />
    <h4>L o a d i n g ... </h4><br /></center>
  </div>
<div class="container position-sticky z-index-sticky top-0">
  <div class="row" style=''>
  <div class="col-12">
<nav class="navbar navbar-expand-lg  blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4 bg-white-transparent">
  <div class="container-fluid px-0">
    <a class="navbar-brand font-weight-bolder ms-sm-3 logo-top" href="{!! url('/home') !!}" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom" target="_blank">
    <img src="{!! $logo['logo_arunika'] !!}" class='arunika_top' style=''> <span class='text-arunika'>- Artikel Hukum <span style='background:#344767;color:white;padding:5px;border-radius:10%;'>Hakim Indonesia</span></span>
    </a>
    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon mt-2">
        <span class="navbar-toggler-bar bar1"></span>
        <span class="navbar-toggler-bar bar2"></span>
        <span class="navbar-toggler-bar bar3"></span>
      </span>
    </button>
    <div class="collapse navbar-collapse pt-3 pb-2 py-lg-0 w-100" id="navigation">
      <ul class="navbar-nav navbar-nav-hover ms-auto">
        <li class="nav-item dropdown dropdown-hover mx-2">
          <a class="nav-link ps-2 d-flex cursor-pointer align-items-center text-bold" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="material-icons opacity-6 me-2 text-md">dashboard</i>
            Artikel
            <img src="{!! asset('web/assets/img/down-arrow-dark.svg') !!}" alt="down-arrow" class="arrow ms-auto ms-md-2">
          </a>
          <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-xl mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
            <div class="d-none d-lg-block">
  <h6 class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-1">
    Status Artikel
  </h6>
  <a href="{!! url('/sedang-publish') !!}" class="dropdown-item border-radius-md">
    <span>Sedang Publish</span>
  </a>
  <a href="{!! url('/arsip') !!}" class="dropdown-item border-radius-md">
    <span>Arsip</span>
  </a>
  <a href="{!! url('/early-view') !!}" class="dropdown-item border-radius-md">
    <span>Early View</span>
  </a>
  <h6 class="dropdown-header text-dark font-weight-bolder d-flex align-items-center px-1 mt-3">
    Pencarian
  </h6>
  <a href="{!! url('/all-category') !!}" class="dropdown-item border-radius-md">
    <span>Cari Berdasarkan Kategori

    </span>
  </a>
</div>

          </div>
        </li>
  <li class="nav-item ms-lg-auto">
    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center text-bold" href="{!! url('/search') !!}">
      <i class="material-icons opacity-6 me-2 text-bd">search</i> Search
    </a>
  </li>
  <li class="nav-item dropdown dropdown-hover mx-2">
    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center text-bold" id="dropdownMenuBlocks" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="material-icons opacity-6 me-2 text-md">view_day</i>
            Penulisan <img src="{!! asset('web/assets/img/down-arrow-dark.svg') !!}" alt="down-arrow" class="arrow ms-auto ms-md-2">
    </a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-animation dropdown-md dropdown-md-responsive p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuBlocks">
        <div class="d-none d-lg-block">
          <li class="nav-item dropdown dropdown-hover dropdown-subitem">
            <a class="dropdown-item py-2 ps-3 border-radius-md" href="./presentation.html">
              <div class="w-100 d-flex align-items-center justify-content-between">
                <div>
                  <h6 class="dropdown-header text-dark font-weight-bolder d-flex justify-content-cente align-items-center p-0">Pedoman</h6>
                  <span class="text-sm">Penulisan Artikel</span>
                </div>
                <img src="{!! asset('web/assets/img/down-arrow.svg') !!}" alt="down-arrow" class="arrow">
              </div>
            </a>
            <div class="dropdown-menu mt-0 py-3 px-2 mt-3">
              <a class="dropdown-item ps-3 border-radius-md mb-1" href="{!! url('/syarat-penulisan') !!}">
                Syarat Penulisan
              </a>
              <a class="dropdown-item ps-3 border-radius-md mb-1" href="{!! url('/checklist-penilaian') !!}">
                Checklist Penilaian Penulisan
              </a>
            </div>
          </li>
          </ul>
        </li>
        <li class="nav-item my-auto ms-3 ms-lg-0">
          <a href="{!! url('/login') !!}" class="btn btn-sm  bg-gradient-info  mb-0 me-1 mt-2 mt-md-0" target="_blank">
            {!! isset(Auth::user()->name) === true ? Auth::user()->name : 'Login' !!}
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->
</div></div></div>
<header class="header-2" style="background-image: url('{!! asset($logo['page_header']) !!}');background-size:cover;background-repeat:no-repeat;background-position:center;height:500px">
  
  <div class="page-header relative" style="height:500px;">
  <img src="upload/config/logo_arunika_complate.png" class='arunika_logo'>
  <img src="{!! $logo['logo_siganis'] !!}" class='siganis_logo'>
    <div class="containers" style="bottom:0px;position:absolute;background-image:linear-gradient(to top, #684DF4 0%,  rgba(255,255,255,0) 100%);">
      <div class="row" style="padding-bottom:30px;padding-left:8%;background-image:linear-gradient(to top, #000 0%,  rgba(255,255,255,0) 100%)">
        <div class="col-lg-8 position-relative" style="left:2%;">
          <span class="text-white" style='background-color:#F44335;padding:5px;font-size:1rem;border-radius:10px;'>Call For Paper</span>
          <p class="lead text-white mt-3" style=''>{!! $issue[$jumlah_issue-1]['description'] !!} </p>
        </div>
        <div class="col-lg-2" style="padding-top:5%;">
        <a href="{!! url('/login') !!}" target="_blank"><button class='btn btn-danger' style="white-space:nowrap;">Submit Now <i class="material-icons" style="font-size:1.5rem;">chevron_right</i> </button></a>
        </div>
      </div>
    </div>
  </div>
</header>

<div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n4" style="z-index:99;">

  <section class="pt-3 pb-4" id="count-stats">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 mx-auto py-3">
          <div class="row">
            <div class="col-md-3 position-relative">
              <div class="p-3 text-center">
                <h1 class="text-gradient text-primary"><span id="state1" countTo="{!! $jumlah_publish !!}">0</span></h1>
                <h5 class="mt-3">Artikel Publish</h5>
                <p class="text-sm font-weight-normal">Artikel Masuk dan Sudah dipublish</p>
              </div>
              <hr class="vertical dark">
            </div>
            <div class="col-md-3 position-relative">
              <div class="p-3 text-center">
                <h1 class="text-gradient text-primary"> <span id="state2" countTo="{!! $jumlah_issue !!}">0</span>+</h1>
                <h5 class="mt-3">Volume Tema</h5>
                <p class="text-sm font-weight-normal">Arunika Publish Theme</p>
              </div>
              <hr class="vertical dark">
            </div>
            <div class="col-md-3 postition-relative">
              <div class="p-3 text-center">
                <h1 class="text-gradient text-primary" id="state3" countTo="{!! count($kategori_artikel) !!}">0</h1>
                <h5 class="mt-3">Kategori Tulisan</h5>
                <p class="text-sm font-weight-normal">Kategori Tulisan Artikel</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="p-3 text-center">
                <h1 class="text-gradient text-primary" id="state4" countTo="">{!! $jumlah_persiapan !!}</h1>
                <h5 class="mt-3">Early View</h5>
                <p class="text-sm font-weight-normal">Artikel Siap untuk dipulish</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="">
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="rotating-card-container" style='height:60%;'>
            <div class="card card-rotate card-background card-background-mask-primary mt-md-0 mt-5" style=''>
              <div class="front front-background" style="background-image: url(https://images.unsplash.com/photo-1569683795645-b62e50fbf103?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=987&q=80); background-size: cover;height:100%;background-position:center;">
                <div class="card-body py-7 text-center" style="height:100%;padding:0 !important;">
                  <i class="material-icons text-white text-4xl my-3">touch_app</i>
                  <h3 class="text-white">Submit <br /> Artikelmu</h3>
                  <p class="text-white opacity-8">Arunika memberikan kesempatan bagi Hakim dibawah Badan Peradilan Umum untuk menulis artikel dan opini.</p>
                </div>
              </div>
              <div class="back back-backgrounds" style="background-image: url('{!! $issue[$jumlah_issue-1]['flyer'] !!}'); background-size: contain;height:100%;background-position:center;background-repeat:no-repeat;">
                <div class="card-body pt-7 text-center" >
                  <a href="{!! url('/login') !!}" target="_blank" class="btn btn-warning btn-sm w-90 mx-auto mt-3" style='bottom:0;position:fixed;'>Submit Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row justify-content-start">
            <div class="col-md-12">
              <div class="info">      
                <h5 class="font-weight-bolder mt-3" style='color:#684DF4'>Kategori Artikel</h5>
              </div>
            </div>
            <div class="col-md-12">
              @for($x=0;$x<count($kategori_artikel);$x++)
                @if($x <= 4)
                  <a class='text-hover' href="{!! url('category/'.strtolower($kategori_artikel[$x]['link']).'/') !!}"><span style='font-size:0.9rem;line-height:2.2'><i class="material-icons">&#xe5cc</i> {!! $kategori_artikel[$x]['kategori'] !!}</span><br /></a>
                @endif
              @endfor
              <br />
              <a href="{!! url('/all-category') !!}"><button class='btn btn-light btn-sm' style='color:#F44335;font-size:0.6rem;'>Selengkapnya <i class="material-icons" style="font-size:1.5rem;">chevron_right</i> </button></a>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="row justify-content-start">
            <div class="col-md-12">
              <div class="info">      
                <h5 class="font-weight-bolder mt-3" style='color:#684DF4'> Artikel Terpopuler</h5>
              </div>
            </div>
          </div>
          @php $index=1 @endphp
          @foreach($artikel as $list_artikel)
            <a href="{!! url('baca-artikel/'.strtolower($list_artikel['edoc_pdf']).'/'.$list_artikel['token_a']) !!}">
              <div class="row justify-content-start mb-4">
                <div class="col-md-12">
                  <div class="row">
                  <!-- style="background-image:url({!! $list_artikel['foto_penulis'] !!});" -->
                    <div class="col-md-3 img img_{!! $index !!} skleton_loading" data-prefix="pop" data-target="{!! str_replace('upload/image/', '', $list_artikel['foto_penulis']) !!}" id="">
                      
                    </div>
                    <div class="col-md-9 mt-3 text-judul text-hover" data-target='img' data-idx='{!! $index !!}'>
                      <span class="artikel-title">{!! ucwords(strtolower($list_artikel['judul'])) !!}</span>
                      <br />
                      <span class='datetime_artikel'>{!! date('d F Y', strtotime($list_artikel['publish_at'])) !!}</span>
                    </div>
                  </div>
                </div>
              </div>
            </a>
            @php 
              $index++;
              if($index === 4){
                break;
              }
            @endphp
          @endforeach
          <div>
        <div>
      </div>
    </div>
  </section>
  <section>
  <div class="container mt-sm 5 mt-3">
      <div class="row">
        <div class="col-lg-12">
          <hr class="horizontal dark" style='background-image:linear-gradient(180deg, rgba(0,0,0,0.7) 40%, #684DF4 106%);margin:0;'>
        </div>
      </div>
    </div>
  </section>
  <section class="my-2 py-2">
    <div class="container">
      <div class="row">
        <div class="row" style='font-family:Montserrat-FF,Arial,Tahoma,sans-serif'>
          <div class="col-lg-6" style="margin-bottom:16px;">
            <span style='font-size:16px;color:#684DF4;font-weight:bold;'>Arunika<span class='gradient_text'>Terbaru</span> </span>
          </div>
        </div>
        <div class="row">
          @php $x=1 @endphp
          @foreach($new_artikel as $list_artikel)
          <div class="col-lg-3">
            <a href="{!! url('baca-artikel/'.strtolower($list_artikel['edoc_pdf']).'/'.$list_artikel['token_a']) !!}">
              <div class="row" style='padding:3%;'>
                <div class="col-lg-12 skleton_loading foto_penulis_grid img artikel_terbaru_{!! $x !!}" data-prefix="news" data-target="{!! str_replace('upload/image/', '', $list_artikel['foto_penulis']) !!}" style=""></div>
                <div class="col-lg-12 text-judul text-hover" data-target='artikel_terbaru' data-idx="{!! $x !!}" style='padding:0'>
                  <span class='text-sm text-red text-bold line-height-3'>{!! $list_artikel['kategori_artikel'] !!}</span><br />
                  <span class='artikel-title'>{!! ucwords(strtolower($list_artikel['judul'])) !!}</span><br />
                  <span class="text-purple text-bold fn-sz-1 line-height-3">{!! $list_artikel['nama'] !!}</span>
                </div>
              </div>
            </a>
          </div>
            @php $x++ @endphp
          @endforeach
        </div>
      </div>
    </div>
  </section>
  <section>
  <div class="container">
    <div class="row">
        <div class="col-lg-12">
          <hr class="horizontal dark" style='background-image:linear-gradient(180deg, rgba(0,0,0,0.7) 40%, #684DF4 106%);margin:0;'>
        </div>
      </div>
    </div>
  </section>
  <section class="my-2 py-2">
    <div class="container">
      <div class="row">
        <div class="row" style='font-family:Montserrat-FF,Arial,Tahoma,sans-serif'>
          <div class="col-lg-6" style="margin-bottom:16px;">
            <span style='font-size:16px;color:#684DF4;font-weight:bold;'>Arunika Early<span class='gradient_text'>View</span> </span>
          </div>
        </div>
        <div class="row">
          @php $x=1 @endphp
          @if($jlh_early_view === 0)
            <span style='color:grey;text-align:center'><i class="material-icons opacity-6 me-2 text-xl" style='font-size:3rem;'>folder_open</i><center></center>No Early View yet </span>   
          @else
              @foreach($early_view as $list_early_view)
              <div class="col-lg-4 mt-3">
                <a href="{!! url('baca-artikel/'.strtolower($list_early_view['edoc_pdf']).'/'.$list_early_view['token_a']) !!}">
                  <div class="row">
                    <div class="col-lg-4 skleton_loading img early_view_{!! $x !!}" data-prefix="news" data-target="{!! str_replace('upload/image/', '', $list_early_view['foto_penulis']) !!}" style=""></div>
                    <div class="col-lg-8 text-judul">
                      <span class='text-red text-bold line-height-3'>{!! $list_early_view['kategori_artikel'] !!}</span><br />
                      <span class='artikel-title text-hover' data-target='early_view' data-idx="{!! $x !!}">{!! ucwords(strtolower($list_early_view['judul'])) !!}</span><br />
                      <span class="text-purple text-bold fn-sz-1 line-height-3">{!! $list_early_view['nama'] !!}</span>
                    </div>
                  </div>
                </a>
              </div>
              @php $x++ @endphp
              @endforeach
          @endif
        </div>
      </div>
    </div>
  </section>
  <section>
  <div class="container mt-sm 5 mt-3">
      <div class="row">
        <div class="col-lg-12">
          <hr class="horizontal dark" style='background-image:linear-gradient(180deg, rgba(0,0,0,0.7) 40%, #684DF4 106%);margin:0;'>
        </div>
      </div>
    </div>
  </section>
  <section class="my-2 py-2">
    <div class="container">
      <div class="row">
        <div class="row" style='font-family:Montserrat-FF,Arial,Tahoma,sans-serif'>
          <div class="col-lg-6" style="margin-bottom:16px;">
            <span style='font-size:16px;color:#684DF4;font-weight:bold;'>Arunika<span class='gradient_text'>Paper</span></span>
          </div>
          <div class="col-lg-6 sisi2_" style="">
            <a href="{!! url('arsip') !!}"><span class='text_nav'>Lihat Selengkapnya ></span></a>
          </div>
        </div>
        <div class="row">
          @php $x=1 @endphp
          @foreach($issue as $list_issue)
            <div class="col-lg-3 list_tema mt-3">
              <div class="row">
                <div class="col-lg-12 flyer_theme img list_issue_{!! $x !!}" style="background-image:url('{!! $list_issue['flyer'] !!}');background-image:">
                  <span class='badge bg-theme badge-text' style=''>Arunika {!! $x !!}</span>
                </div>
                <div class="col-lg-12" style='font-family:Montserrat-FF,Arial,Tahoma,sans-serif;border-radius: 0 0 5% 5%;background-color:linen;min-height:104px;'>
                  <a class='text-hover' href="{!! url('issue/'.$list_issue['code_issue']) !!}">
                  <span class='text-hover' data-target="list_issue" data-idx="{!! $x !!}" style='font-size:0.8rem;font-weight:bold;'>{!! $list_issue['name'] !!}</span>
                  <br /><span style='color:black;font-size:0.8rem;'>({!! $list_issue['year'] !!})</span></a>  
                  <br />
                </div>
              </div>
            </div>
            @php $x++ @endphp
          @endforeach
        </div>
      </div>
    </div>
    <div class="container mt-sm 5 mt-">
    </div>
    <div class="container mt-sm 5 mt-5" style='background-color:#f0f0f0;border-radius:20px;box-shadow:0 calc(8px / 2) 8px 0 rgba(0, 0, 0, 0.15)'>
      <div class="row">
        <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-12">
                <div class="row">
                  <div class="col-lg-4 mt-3" style="margin-bottom:16px;">
                    <span style='font-size:16px;color:#684DF4;font-weight:bold;'>Arunika<span class='gradient_text'> Pengumuman</span></span><br />
                    <div class="row">
                      <div class="col-lg-12" style='font-size:0.9rem;color:black;'>
                        @if($jumlah_pengumuman === 0)
                          <span style='color:grey;'>** Belum ada Pengumuman **</span>
                        @else
                          <div class='row' style='margin-left:1%;margin-right:1%;'>
                          @foreach($pengumuman as $list_pengumuman)
                            <div class='col-lg-11 mt-3' style='list-style-type:square;background-color:#fff;padding:5%;border-radius:10px;max-height:200px;'>
                              <span style='font-weight:700;'>{!! $list_pengumuman['judul'] !!}</span>
                              <p><span style='color:#6c757d;font-size:0.8rem;line-height:1.1'>{!! $list_pengumuman['keterangan'] !!}</span></p>
                              <br />
                              <a href="{!! url('download-artikel/'.Crypt::encrypt($list_pengumuman['edoc'])) !!}/edoc-pengumuman">
                                <button class='btn btn-light btn-sm' style='color:#F44335'>
                                    <i class="material-icons opacity-6 me-2" style='font-size:1rem;'>file_download</i> Download
                                </button>
                              </a><br  />
                            </div>
                          @endforeach
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4 mt-3" style="margin-bottom:16px;">
                    <span style='font-size:16px;color:#684DF4;font-weight:bold;'>Penulis Terbanyak</span>
                      @foreach($data_penulis as $list_penulis)
                      <div class="row mt-3">
                        <div class="col-lg-2 inline-view" style='width:20% !important'>
                            <center>
                            <a href="javascript:;" class="avatar avatar-lg rounded-circle" style='align-items:unset;'>
                              <img alt="Image placeholder" src="{!! $list_penulis['foto_profile'] === null ? 'img/no-profile.jpg' : $list_penulis['foto_profile'] !!}" style="box-shadow:0 calc(8px / 2) 8px 0 rgba(0, 0, 0, 0.15)">
                            </a></center>
                          </div>
                          <div class="col-lg-1 inline-view mt-2" style='width:5% !important;border-radius:10px 0 0 30px;background:#fff;box-shadow:0 calc(8px / 2) 8px 0 rgba(0, 0, 0, 0.15)'></div>
                          <div class="col-lg-9 inline-view mt-2" style='width:70% !important;background: #fff;padding: 3%;border-radius: 0 10px 10px 0;box-shadow:0 calc(8px / 2) 8px 0 rgba(0, 0, 0, 0.15);'>
                              <span class='text-hover'>{!! $list_penulis['nama'] !!}</span>
                          </div>
                        </div>
                      @endforeach
                  </div>
                  <div class="col-lg-4 mt-3" style="margin-bottom:16px;">
                    <span style='font-size:16px;color:#684DF4;font-weight:bold;'>Arunika<span class='gradient_text'> EditorialTeam</span></span>
                    <div class="row">
                      @php
                        if($jumlah_editorial === 0){
                          echo "<i>Team editorial belum ada</i>";
                        }else{
                          for($x=0;$x<$jumlah_editorial;$x++){
                            echo "
                            <div class='col-lg-12 mt-3'>
                              <div class='row'>
                                <div class='col-lg-2 inline-view foto-profile img img_kecil editorial_team_$x' style='width:20%'>
                                  <a href='javascript:;' class='avatar avatar-lg rounded-circle' style='align-items:unset;'>
                                  <center><img alt='Image placeholder' src='".$editorial_team[$x]["foto_profile"]."' style='box-shadow:0 calc(8px / 2) 8px 0 rgba(0, 0, 0, 0.15);'></center>
                                  </a>
                                </div>
                                <div class='col-lg-1 inline-view mt-3' style='width:1%'></div>
                                <div class='col col-lg-9 inline-view mt-3' style='width:70%'>
                                    <span class='text-hover text-bold' data-target='editorial_team' data-idx='".$x."'>".$editorial_team[$x]['nama']."</span><br />
                                    <span class='text-red text-bold '>".str_replace('_', ' ', $editorial_team[$x]['sebagai'])."</span>
                                </div>
                              </div>
                            </div>";
                          }
                        }
                      @endphp
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>
        </div>

      </div>
    </div>
  </section>
<!-- -------   START PRE-FOOTER 2 - simple social line w/ title & 3 buttons    -------- -->

<!-- -------   END PRE-FOOTER 2 - simple social line w/ title & 3 buttons    -------- -->

</div>


  

  <footer class="footer pt-5 mt-5">
  <div class="container">
    <div class=" row">
      <div class="col-md-3 mb-4 ms-auto">
        <div>
          <a href="{!! url('/home') !!}">
            <img src="{!! asset($logo['logo_arunika']) !!}" class="mb-3 footer-logo" alt="main_logo" style='max-width:7rem;scale:2'>
          </a>
          <h6 class="font-weight-bolder mb-4">By Siganis Badilum</h6>
        </div>
        <div>
          <ul class="d-flex flex-row ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link pe-1 text-hover" href="https://www.facebook.com/badilummari" target="_blank">
                <i class="fab fa-facebook text-lg opacity-8"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link pe-1 text-hover-red" href="https://www.youtube.com/channel/UCsWlBEzA0R9pOs7vwejpz4A" target="_blank">
                <i class="fab fa-youtube text-lg opacity-8"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link pe-1 text-hover-pink" href="https://www.instagram.com/ditjenbadilum/" target="_blank">
                <i class="fab fa-instagram text-lg opacity-8"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>



      <div class="col-md-2 col-sm-6 col-6 mb-4">
        <div>
          <h6 class="text-sm">Arunika</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link text-hover" href="{!! url('/about-us') !!}" target="_blank">
                About Us
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-hover" href="https://siganisbadilum.mahkamahagung.go.id/" target="_blank">
                Siganis
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-hover" href="https://badilum.mahkamahagung.go.id/" target="_blank">
                Dirjen Badilum
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-md-2 col-sm-6 col-6 mb-4">
        <div>
          <h6 class="text-sm">Resources</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link" href="https://iradesign.io/" target="_blank">
                Illustrations
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="https://www.creative-tim.com/bits" target="_blank">
                Bits & Snippets
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="https://www.creative-tim.com/affiliates/new" target="_blank">
                Affiliate Program
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-md-2 col-sm-6 col-6 mb-4">
        <div>
          <h6 class="text-sm">Help & Support</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link text-hover" href="{!! url('contact/') !!}" target="_blank">
                Contact Us
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link text-hover" href="{!! url('/faq') !!}" target="_blank">
                FAQ
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{!! url('/cara-penggunaan-arunika') !!}" target="_blank">
                How to Use
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-md-2 col-sm-6 col-6 mb-4 me-auto">
        <div>
          <h6 class="text-sm">Legal</h6>
          <ul class="flex-column ms-n3 nav">
            <li class="nav-item">
              <a class="nav-link" href="https://www.creative-tim.com/knowledge-center/terms-of-service" target="_blank">
                Terms & Conditions
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="https://www.creative-tim.com/knowledge-center/privacy-policy" target="_blank">
                Privacy Policy
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="https://www.creative-tim.com/license" target="_blank">
                Licenses (EULA)
              </a>
            </li>
          </ul>
        </div>
      </div>

      <div class="col-12">
        <div class="text-center">
          <p class="text-dark my-4 text-sm font-weight-normal">
            All rights reserved. Copyright © <script>document.write(new Date().getFullYear())</script> Tim Siganis <a href="https://siganisbadilum.mahkamahagung.go.id/" target="_blank">Dev Team</a>.
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
<!--   Core JS Files   -->
<script src="{!! asset('web/assets/js/core/popper.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('web/assets/js/core/bootstrap.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('web/assets/js/plugins/perfect-scrollbar.min.js') !!}"></script>
<!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->
<script src="{!! asset('web/assets/js/plugins/countup.min.js') !!}"></script>
<script src="{!! asset('web/assets/js/plugins/choices.min.js') !!}"></script>
<script src="{!! asset('web/assets/js/plugins/prism.min.js') !!}"></script>
<script src="{!! asset('web/assets/js/plugins/highlight.min.js') !!}"></script>
<!--  Plugin for Parallax, full documentation here: https://github.com/dixonandmoe/rellax -->
<script src="{!! asset('web/assets/js/plugins/rellax.min.js') !!}"></script>
<!--  Plugin for TiltJS, full documentation here: https://gijsroge.github.io/tilt.js/ -->
<script src="{!! asset('web/assets/js/plugins/tilt.min.js') !!}"></script>
<!--  Plugin for Selectpicker - ChoicesJS, full documentation here: https://github.com/jshjohnson/Choices -->
<script src="{!! asset('web/assets/js/plugins/choices.min.js') !!}"></script>
<!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
<!--  Google Maps Plugin    -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{!! asset('web/assets/js/material-kit.min.js?v=3.0.4') !!}" type="text/javascript"></script>


<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token-web"]').attr('content')
    }
});
  if (document.getElementById('state1')) {
    const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      console.error(countUp.error);
    }
  }
  if (document.getElementById('state2')) {
    const countUp1 = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));
    if (!countUp1.error) {
      countUp1.start();
    } else {
      console.error(countUp1.error);
    }
  }
  if (document.getElementById('state3')) {
    const countUp2 = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));
    if (!countUp2.error) {
      countUp2.start();
    } else {
      console.error(countUp2.error);
    };
  }
  var loadingScreen = document.querySelector(".loadingScreen");
  window.addEventListener('load', function() {
    loadingScreen.style.display = 'none';
    setTimeout(function(){
      
    }, 2000)
    
  });
  var jumlah_skleton=$(".skleton_loading").length;
  var skleton=$(".skleton_loading");
  runImg(jumlah_skleton, skleton);
  async function runImg(jumlah_skleton, skleton){
    for(var x=0;x<jumlah_skleton;x++){
      console.log(x);
      var target=$(skleton[x]).data('target');
      var width=$(skleton[x]).width();
      var height=$(skleton[x]).height();
      var prefix=$(skleton[x]).data('prefix');
      var type="artikel-img";
      // alert(width+"x"+height);
      let printFoto=await setPhoto(width, height, target, type, x, prefix);
    }
  }
  async function setPhoto(width, height, target, type, x, prefix){
    $.ajax({
        url:'resize-img-view',
        data:{width:width, height:height, target:target, type:type, prefix:prefix},
        dataType:'JSON',
        type:'POST',
        success:function(data){
          console.log(x);
          $(".skleton_loading[data-target='"+target+"']").addClass('foto_penulis');
          $(".skleton_loading[data-target='"+target+"']").removeClass('skleton_loading');
          // console.log("background-image:url('img/20241210031407-ari.jpg')");
          $(skleton[x]).css({"background-image":"url("+data.background+")"});
        }
      })
  }
$(".text-hover").mouseenter(function(e){
  e.preventDefault();
  e.stopPropagation();
  var target=$(this).data('target');
  var index=$(this).data('idx');
  var classSelector=target+"_"+index;
  if($("."+classSelector).hasClass('img_kecil')){
    $("."+target+"_"+index).css({'transform':'scale(1.1)'});
  }else{
    $("."+target+"_"+index).css({'transform':'scale(1.02)'});
  }
})
$(".text-hover").mouseleave(function(e){
  e.preventDefault();
  e.stopPropagation();
  var target=$(this).data('target');
  var index=$(this).data('idx');
  $("."+target+"_"+index).css({'transform':'scale(1)'});
  $("."+target+"_"+index).css({'transform':''});
});

</script>
</body>

</html>
