@extends('web/content_template')
@section('content')
<div class="row" style='margin-top:70px !important;'>
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
    <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:8rem;'>
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-info shadow-info border-radius-lg p-3">
            <h6 class="text-white text-primary mb-0">{!! $title  !!}</h6>
        </div>
        </div>
        <div class="card-body">
        <p class="pb-3">
           Daftar Tema Artikel yang telah dipublish
        </p>
        <div class='row'>
            @foreach($issue as $list_issue)
            <div class="col-lg-3 col-sm-6">
                <div class="card card-plain">
                    <div class="card-header p-0 position-relative" style="min-height:5rem;">
                        <a class="d-block blur-shadow-image">
                            <img src="{!! url($list_issue['flyer']) !!}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg" loading="lazy">
                        </a>
                    </div>
                    <div class="card-body px-0">
                        <h6>
                        <a href="{!! url('/issue/'.$list_issue['code_issue']) !!}" class="text-dark font-weight-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{!! $list_issue['name'] !!}">
                            {!! $list_issue['name'] !!}
                        </a>
                        </h6>
                        <p>
                        {!! substr(strip_tags($list_issue['description']), 0,100) !!} ...
                        </p>
                        <a href="{!!  url('/issue/'.$list_issue['code_issue']) !!}" class="text-info text-sm icon-move-right">Read More
                        <i class="fas fa-arrow-right text-xs ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    </div>
</div>
@endsection
<script>
    <script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
</script>
</script>