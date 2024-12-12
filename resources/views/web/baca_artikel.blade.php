
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
  <meta name="csrf-token-web" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{!! asset('web/assets/img/apple-icon.png') !!}">
  <link rel="icon" type="image/png" href="{!! asset('web/assets/img/favicon.png') !!}">
  <title>
    {!! $artikel['judul'] !!}
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{!! asset('web/assets/css/nucleo-icons.css') !!}" rel="stylesheet" />
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

<body class="blog-author bg-gray-200">
  <!-- Navbar Transparent -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3  navbar-transparent ">
    <div class="container">
      <a class="navbar-brand  text-white " href="{!! url('/home') !!}" rel="tooltip" title="Kembali Ke Home" data-placement="bottom">
        Arunika (Artikel Hukum Hakim Indonesia)
      </a>
      <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon mt-2">
          <span class="navbar-toggler-bar bar1"></span>
          <span class="navbar-toggler-bar bar2"></span>
          <span class="navbar-toggler-bar bar3"></span>
        </span>
      </button>
      <div class="collapse navbar-collapse w-100 pt-3 pb-2 py-lg-0 ms-lg-12 ps-lg-5" id="navigation">
        <ul class="navbar-nav navbar-nav-hover ms-auto">
        <li class="nav-item dropdown dropdown-hover mx-2">
          <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
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
    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" href="{!! url('/search') !!}">
      <i class="material-icons opacity-6 me-2 text-md">search</i> Search
    </a>
  </li>
  <li class="nav-item dropdown dropdown-hover mx-2">
    <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuBlocks" data-bs-toggle="dropdown" aria-expanded="false">
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
              <a class="dropdown-item ps-3 border-radius-md mb-1" href="./sections/page-sections/hero-sections.html">
                Syarat Penulisan
              </a>
              <a class="dropdown-item ps-3 border-radius-md mb-1" href="./sections/page-sections/features.html">
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
  <!-- -------- START HEADER 4 w/ search book a ticket form ------- -->
  <header>
    <div class="page-header min-height-200" style="background-image: url('{!! asset('web/assets/img/city-profile.jpg') !!}')" loading="lazy">
      <span class="mask bg-gradient-dark opacity-8"></span>
    </div>
  </header>
  <!-- -------- END HEADER 4 w/ search book a ticket form -------background-color:#f8f8f800 -->
  <div class="card card-body blur shadow-blur mx-3 mx-md-4 mt-n6 mb-4" style=''>
    <!-- START Testimonials w/ user image & text & info -->
    <section class="py-sm-7 py-5 position-relative">
      <div class="container">
        <div class="row">
          <div class="col-12 mx-auto">
            <div class="mt-n8 mt-md-n9 text-center">
              <img class="avatar avatar-xxl shadow-xl position-relative z-index-2" src="{!! asset($artikel['foto_penulis']) !!}" alt="bruce" loading="lazy">
            </div>
            <div class="row py-5">
              <div class="col-lg-7 col-md-7 z-index-2 position-relative px-md-2 px-sm-5 mx-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style=''>
                            <li class="breadcrumb-item text-dark"><a href="{!! url('/home') !!}" >Home</a></li>
                            <li class="breadcrumb-item text-dark"><a href="{!! url('issue/'.$artikel['code_issue']) !!}" >Library</a></li>
                            <li class="breadcrumb-item text-dark active" aria-current="page">Data</li>
                        </ol>
                    </nav>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <h3 class="mb-0">{!! $artikel['judul'] !!}</h3>
                  <div class="d-block">
                    <!-- <button type="button" class="btn btn-sm btn-outline-info text-nowrap mb-0">Follow</button> -->
                  </div>
                </div>
                <div class="row mb-4">
                  <div class="col-lg-12">
                    <span class="h6">{!! date('d F Y', strtotime($artikel['publish_at'])) !!}</span> | 
                    <span><a class="text-info icon-move-right">{!! $artikel['nama'] !!}</a></span>
                  </div>
                </div>
                <p class="fn-sz-md mb-0 artikel-read-text" style='text-align:justify;color:black;font-size:1rem;'>
                  {!! $artikel['tentang_artikel'] !!}
                  <hr />
                    <p class="text-lg">
                        {!! str_replace('Times New Roman', 'Arial', $artikel['text_tulisan']) !!}
                    </p>
                </p>
                <div class="row">
                <div class="col-lg-8 col-md-7">
                    <span class="badge rounded-pill bg-secondary">Tags : </span><br /><br />
                    @foreach($keyword as $list_keyword)
                        <a href="{!! url('tags/'.str_replace(' ','-', strtolower($list_keyword['keyword']))) !!}"><span class="badge rounded-pill bg-info">#{!! $list_keyword['keyword'] !!}</span></a>
                    @endforeach
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-4 mt-6">
              <div class="row ">
                <div class="col-md-12" style='background-color:white;padding:10px;border-radius:2%;filter: drop-shadow(8px 8px 10px gray);'>
                  <span class='text-info text-bold'>File PDF</span><br />
                    <a href="{!! url('download-artikel/'.Crypt::encrypt($artikel['edoc_pdf']).'/edoc-pdf') !!}">
                      <i class="material-icons opacity-6 me-2" style='font-size:1rem;'>file_download</i>Download
                    </a>
                  </span>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-12" style='background-color:white;padding:10px;border-radius:2%;filter: drop-shadow(8px 8px 10px gray);'>
                  <span class='text-info text-bold'>Artikel Terkait</span><br />
                
                @if($jumlah_similar === 0)
                  <i>No Artikel related</i>
                @else
                  @php $x=0; @endphp
                  @foreach($similar as $list_similar)
                    @php
                      $replace_1=str_replace('../resources/upload/edoc/artikel/pdf/', '', $list_similar['edoc_pdf']);
                      $edoc=str_replace(".pdf", "", $replace_1);
                    @endphp
                    <div class="row" style='padding-left:2%;padding-right:2%;margin-top:10px;'>
                        <div class="col-lg-3 foto_penulis img artikel_terbaru_{!! $x !!}" style="background-image:url('../../{!! $list_similar['foto_penulis'] !!}');height:100px;"></div>
                        <div class="col-lg-9">
                          <a href="{!! url('baca-artikel/'.strtolower($edoc).'/'.Crypt::encrypt($list_similar['id'])) !!}">
                          <span class='artikel-title text-hover' data-target='artikel_terbaru' data-idx="{!! $x !!}">{!! ucwords(strtolower($list_similar['judul'])) !!}</span></a>
                        </div>

                    </div>
                  @php $x++; @endphp
                  @endforeach
                @endif
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-12" style='background-color:white;padding:10px;border-radius:2%;filter: drop-shadow(8px 8px 10px gray);'>
                  <span class='text-info text-bold'>Artikel Lainnya</span><br />

                @if($jlh_other === 0)
                  <i>No More Artikel</i>
                @else
                  @php $x=0; @endphp
                  @foreach($other as $list_other)
                    @php
                    
                      $replace_1=str_replace('upload/edoc/artikel/pdf/', '', $list_other['edoc_pdf']);
                      $edoc=str_replace(".pdf", "", $replace_1);
                    @endphp
                    <div class="row" style='padding-left:2%;padding-right:2%;margin-top:10px;'>
                        <div class="col-lg-3 skleton_loading img artikel_terbaru_{!! $x !!}" data-target="{!! str_replace('upload/image/', '', $list_other['foto_penulis']) !!}" data-prefix="artikel-img" style="height:100px;width:30%"></div>
                        <div class="col-lg-9" style='width:70%;'>
                          <a href="{!! url('baca-artikel/'.strtolower($edoc).'/'.Crypt::encrypt($list_other['id'])) !!}">
                            <span class='text-red text-bold'>{!! $list_other['kategori'] !!}</span><br />
                          <span class='artikel-title text-hover' data-target='artikel_terbaru' data-idx="{!! $x !!}">{!! ucwords(strtolower($list_other['judul'])) !!}</span></a>
                        </div>

                    </div>
                  @php $x++; @endphp
                  @endforeach
                @endif
                </div>
              </div>
            
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END Testimonials w/ user image & text & info -->
    <!-- START Blogs w/ 4 cards w/ image & text & link -->
    <!-- <section class="py-3">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <h3 class="mb-5">Artikel Lainnya</h3>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-3 col-sm-6">
            <div class="card card-plain">
              <div class="card-header p-0 position-relative">
                <a class="d-block blur-shadow-image">
                  <img src="{!! asset('web/assets/img/examples/testimonial-6-2..jpg') !!}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg" loading="lazy">
                </a>
              </div>
              <div class="card-body px-0">
                <h5>
                  <a href="javascript:;" class="text-dark font-weight-bold">Rover raised $65 million</a>
                </h5>
                <p>
                  Finding temporary housing for your dog should be as easy as
                  renting an Airbnb. That’s the idea behind Rover ...
                </p>
                <a href="javascript:;" class="text-info text-sm icon-move-right">Read More
                  <i class="fas fa-arrow-right text-xs ms-1"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="card card-plain">
              <div class="card-header p-0 position-relative">
                <a class="d-block blur-shadow-image">
                  <img src="{!! asset('web/assets/img/examples/testimonial-6-3..jpg') !!}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg" loading="lazy">
                </a>
              </div>
              <div class="card-body px-0">
                <h5>
                  <a href="javascript:;" class="text-dark font-weight-bold">MateLabs machine learning</a>
                </h5>
                <p>
                  If you’ve ever wanted to train a machine learning model
                  and integrate it with IFTTT, you now can with ...
                </p>
                <a href="javascript:;" class="text-info text-sm icon-move-right">Read More
                  <i class="fas fa-arrow-right text-xs ms-1"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-sm-6">
            <div class="card card-plain">
              <div class="card-header p-0 position-relative">
                <a class="d-block blur-shadow-image">
                  <img src="{!! asset('web/assets/img/examples/blog-9-4..jpg') !!}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg" loading="lazy">
                </a>
              </div>
              <div class="card-body px-0">
                <h5>
                  <a href="javascript:;" class="text-dark font-weight-bold">MateLabs machine learning</a>
                </h5>
                <p>
                  If you’ve ever wanted to train a machine learning model
                  and integrate it with IFTTT, you now can with ...
                </p>
                <a href="javascript:;" class="text-info text-sm icon-move-right">Read More
                  <i class="fas fa-arrow-right text-xs ms-1"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-12 col-12">
            <div class="card card-blog card-background cursor-pointer">
              <div class="full-background" style="background-image: url('{!! asset('web/assets/img/examples/blog2.jpg') !!}')" loading="lazy"></div>
              <div class="card-body">
                <div class="content-left text-start my-auto py-4">
                  <h2 class="card-title text-white">Flexible work hours</h2>
                  <p class="card-description text-white">Rather than worrying about switching offices every couple years, you stay in the same place.</p>
                  <a href="javascript:;" class="text-white text-sm icon-move-right">Read More
                    <i class="fas fa-arrow-right text-xs ms-1"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->





    <!-- END Blogs w/ 4 cards w/ image & text & link -->
  </div>
  <!-- <section class="py-lg-5">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="card box-shadow-xl overflow-hidden mb-5">
            <div class="row">
              <div class="col-lg-5 position-relative bg-cover px-0" style="background-image: url('{!! asset('web/assets/img/examples/blog2.jpg') !!}')" loading="lazy">
                <div class="z-index-2 text-center d-flex h-100 w-100 d-flex m-auto justify-content-center">
                  <div class="mask bg-gradient-dark opacity-8"></div>
                  <div class="p-5 ps-sm-8 position-relative text-start my-auto z-index-2">
                    <h3 class="text-white">Contact Information</h3>
                    <p class="text-white opacity-8 mb-4">Fill up the form and our Team will get back to you within 24 hours.</p>
                    <div class="d-flex p-2 text-white">
                      <div>
                        <i class="fas fa-phone text-sm"></i>
                      </div>
                      <div class="ps-3">
                        <span class="text-sm opacity-8">(+40) 772 100 200</span>
                      </div>
                    </div>
                    <div class="d-flex p-2 text-white">
                      <div>
                        <i class="fas fa-envelope text-sm"></i>
                      </div>
                      <div class="ps-3">
                        <span class="text-sm opacity-8">hello@creative-tim.com</span>
                      </div>
                    </div>
                    <div class="d-flex p-2 text-white">
                      <div>
                        <i class="fas fa-map-marker-alt text-sm"></i>
                      </div>
                      <div class="ps-3">
                        <span class="text-sm opacity-8">Dyonisie Wolf Bucharest, RO 010458</span>
                      </div>
                    </div>
                    <div class="mt-4">
                      <button type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0" data-toggle="tooltip" data-placement="bottom" data-original-title="Log in with Facebook">
                        <i class="fab fa-facebook"></i>
                      </button>
                      <button type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0" data-toggle="tooltip" data-placement="bottom" data-original-title="Log in with Twitter">
                        <i class="fab fa-twitter"></i>
                      </button>
                      <button type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0" data-toggle="tooltip" data-placement="bottom" data-original-title="Log in with Dribbble">
                        <i class="fab fa-dribbble"></i>
                      </button>
                      <button type="button" class="btn btn-icon-only btn-link text-white btn-lg mb-0" data-toggle="tooltip" data-placement="bottom" data-original-title="Log in with Instagram">
                        <i class="fab fa-instagram"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-7">
                <form class="p-3" id="contact-form" method="post">
                  <div class="card-header px-4 py-sm-5 py-3">
                    <h2>Say Hi!</h2>
                    <p class="lead"> We'd like to talk with you.</p>
                  </div>
                  <div class="card-body pt-1">
                    <div class="row">
                      <div class="col-md-12 pe-2 mb-3">
                        <div class="input-group input-group-static mb-4">
                          <label>My name is</label>
                          <input type="text" class="form-control" placeholder="Full Name">
                        </div>
                      </div>
                      <div class="col-md-12 pe-2 mb-3">
                        <div class="input-group input-group-static mb-4">
                          <label>I'm looking for</label>
                          <input type="text" class="form-control" placeholder="What you love">
                        </div>
                      </div>
                      <div class="col-md-12 pe-2 mb-3">
                        <div class="input-group input-group-static mb-4">
                          <label>Your message</label>
                          <textarea name="message" class="form-control" id="message" rows="6" placeholder="I want to say that..."></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 text-end ms-auto">
                        <button type="submit" class="btn bg-gradient-info mb-0">Send Message</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> -->
  <!-- -------- START FOOTER 5 w/ DARK BACKGROUND ------- -->
  <footer class="footer py-5">
    <div class="container z-index-1 position-relative">
      <div class="row">
        <div class="col-lg-4 me-auto mb-lg-0 mb-4 text-lg-start text-center">
          <h6 class="text-dark font-weight-bolder text-uppercase mb-lg-4 mb-3">ARUNIKA SIGANIS</h6>
          <ul class="nav flex-row ms-n3 justify-content-lg-start justify-content-center mb-4 mt-sm-0">
            <li class="nav-item">
              <a class="nav-link text-dark opacity-8" href="{!! url('/home') !!}" target="_blank">
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark opacity-8" href="{!! url('/all-category') !!}" target="_blank">
                Kategori Artikel
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark opacity-8" href="{!! url('/arsip') !!}" target="_blank">
                Arsip
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark opacity-8" href="{!! url('/tata-cara-menulis') !!}" target="_blank">
                Penulisan
              </a>
            </li>
          </ul>
          <p class="text-sm text-dark opacity-8 mb-0">
            Copyright © 2024
          </p>
        </div>
        <div class="col-lg-6 ms-auto text-lg-end text-center">
          <p class="mb-5 text-lg text-dark font-weight-bold">
            The reward for getting on the stage is fame. The price of fame is you can’t get off the stage.
          </p>
          <a href="javascript:;" target="_blank" class="text-dark me-xl-4 me-4 opacity-5">
            <span class="fab fa-youtube"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-dark me-xl-4 me-4 opacity-5">
            <span class="fab fa-facebook"></span>
          </a>
          <a href="javascript:;" target="_blank" class="text-dark me-xl-4 me-4 opacity-5">
            <span class="fab fa-instagram"></span>
          </a>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 5 w/ DARK BACKGROUND ------- -->
  <!--   Core JS Files   -->
  <script src="{!! asset('web/assets/js/core/popper.min.js') !!}" type="text/javascript"></script>
  <script src="{!! asset('web/assets/js/core/bootstrap.min.js') !!}" type="text/javascript"></script>
  <script src="{!! asset('web/assets/js/plugins/perfect-scrollbar.min.js') !!}"></script>
  <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
  <!--  Google Maps Plugin    -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script src="{!! asset('web/assets/js/material-kit.min.js?v=3.0.4') !!}" type="text/javascript"></script>
  <script>
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token-web"]').attr('content')
      }
    });
    var x=0;
    setTimeout(function(e){
      $.post('{!! url("validate-reader") !!}', {token:"{!! Crypt::encrypt($artikel['id']) !!}"}, function(data)
      {
          console.log('validate');
      });
    }, 90000);

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
          url:"{!! url('resize-img-view') !!}",
          data:{width:width, height:height, target:target, type:type, prefix:prefix},
          dataType:'JSON',
          type:'POST',
          success:function(data){
            console.log(x);
            $(".skleton_loading[data-target='"+target+"']").addClass('foto_penulis');
            $(".skleton_loading[data-target='"+target+"']").removeClass('skleton_loading');
            // console.log("background-image:url('img/20241210031407-ari.jpg')");
            $(skleton[x]).css({"background-image":"url({!! url('"+data.background+"') !!})"});
          }
        })
    }

  </script>
</body>

</html>