@extends('web/content_template')
@section('content')
<div class="row" style='margin-top:70px !important;'>
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
        <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:8rem;'>
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-header-page shadow-info border-radius-lg p-3">
                    <span class="text-white text-primary mb-0 fn-sz-md text-bold">Cari Berdasarkan Kategori Artikel</span>
                </div>
            </div>
            <div class="card-body" style='color:black;'>
                <p class="pb-3 text" style='font-size:1rem;'>
                   Daftar Seluruh Kategori Artikel Arunika
                </p>
                <div class="row">
                    @for($x=0;$x<$jlh_category;$x++)
                        <div class="col-lg-6 mt-3" style=''>
                            <div class="row">
                                <div class='col-lg-10' style='filter:drop-shadow(0px 2px 3px purple);background-color:linen;border-radius:2%;padding:2%;'>
                                    <a href="{!! url('/category/'.strtolower($category[$x]['link'])) !!}/" style='float:left;'>
                                        <span class='fn-sz-md'>{!! $category[$x]['category'] !!} </span><br />
                                        <span class='fn-sz-sm text-bold'>Total Submitted Article : {!! $category[$x]['jumlah'] !!}</span>
                                    </a>
                                    <a href="{!! url('/category/'.strtolower($category[$x]['link'])) !!}/" style='float:right;'>
                                        <button class='btn btn-default btn-round' style='float:right;'><i class="material-icons" style="font-size:1.5rem;">chevron_right</i></button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</div>
@endsection