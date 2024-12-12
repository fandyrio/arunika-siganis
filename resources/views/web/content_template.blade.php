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
  <link rel="apple-touch-icon" sizes="76x76" href="{!! url('web/assets/img/apple-icon.png') !!}">
  <link rel="icon" type="image/png" href="{!! url('web/assets/img/favicon.png') !!}">
  <title>
    {!! $title !!}
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{!! url('web/assets/css/nucleo-icons.css') !!}" rel="stylesheet" />
  <link href="{!! url('web/assets/css/nucleo-svg.css') !!}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{!! url('web/assets/css/material-kit.css?v=3.0.4') !!}" rel="stylesheet" />
  <link href="{!! asset('web/assets/css/style.css') !!}" rel="stylesheet"/>
  <!-- Nepcha Analytics (nepcha.com) -->
  <!-- Nepcha is a easy-to-use web analytics. No cookies and fully compliant with GDPR, CCPA and PECR. -->
  <script defer data-site="YOUR_DOMAIN_HERE" src="https://api.nepcha.com/js/nepcha-analytics.js"></script>
</head>

<body class="contact-us">
  <div class="loadingScreen" style='z-index:999;'>
    <center><img src="{!! asset($logo['loading_animation']) !!}"><br /><br />
    <h4>L o a d i n g ... Please Wait ...</h4><br /></center>
  </div>
<div class="container position-sticky z-index-sticky top-0">
  <div class="row">
    <div class="col-12">
      <nav class="navbar navbar-expand-lg  blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4 bg-white-transparent">
        <div class="container-fluid px-0">
          <a class="navbar-brand font-weight-bolder ms-sm-3" href="{!! url('/home') !!}" rel="tooltip" title="Designed and Coded by Creative Tim" data-placement="bottom">
            ARUNIKA - Artikel Hukum <span style='background:#344767;color:white;padding:5px;border-radius:10%;'>Hakim Indonesia</span>
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
                  </div>
                </ul>
            </li>
            <li class="nav-item my-auto ms-3 ms-lg-0">
              <a href="{!! url('/login') !!}" class="btn btn-sm  bg-gradient-info  mb-0 me-1 mt-2 mt-md-0" target="_blank">
                {!! isset(Auth::user()->name) === true ? Auth::user()->name : 'Login' !!}
              </a>
            </li>
          </div>
        </div>
      </nav>
    </div>
  </div>
</div>
  <!-- -------- START HEADER 8 w/ card over right bg image ------- -->
  <section>
    <div class="page-header min-vh-30">
      <div class="container">
        @yield('content')
      </div>
    </div>
  </section>
  <!-- -------- END HEADER 8 w/ card over right bg image ------- -->
  
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
  <script src="{!! url('web/assets/js/core/popper.min.js') !!}" type="text/javascript"></script>
  <script src="{!! url('web/assets/js/core/bootstrap.min.js') !!}" type="text/javascript"></script>
  <script src="{!! url('web/assets/js/plugins/perfect-scrollbar.min.js') !!}"></script>
  <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTTfWur0PDbZWPr7Pmq8K3jiDp0_xUziI"></script>
  <script src="{!! url('web/assets/js/material-kit.min.js?v=3.0.4') !!}" type="text/javascript"></script>

  <script>
    var loadingScreen = document.querySelector(".loadingScreen");
    window.addEventListener('load', function() {
      loadingScreen.style.display = 'none';
    });
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token-web"]').attr('content')
            }
        });
  </script>
</body>

</html>