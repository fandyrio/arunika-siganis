@extends('web/content_template')
@section('content')
<div class="row" style='margin-top:70px !important;'>
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
    <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:8rem;'>
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-header-page shadow-info border-radius-lg p-3">
            <span class="text-white text-primary mb-0 fn-sz-md text-bold">{!! $title  !!}</span>
        </div>
        </div>
        <div class="card-body">
        <div class='row' style='color:black;'>
            <div class="col-md-12">
                @if(is_null($syarat))
                    <center>Kontent Belum dimuat</center>
                @else
                    @if($source === "config")
                        {!! $syarat['config_value'] !!}
                    @endif($source === "checklist")
                        <ol>
                        @foreach($syarat as $list)
                            <li>{!! $list['pertanyaan'] !!}</li>
                        @endforeach
                        </ol>
                        <span style='font-size:0.6rem;color:grey;'>* <i>Checklist dapat berubah, sesuai dengan kebutuhan</i> </span>
                @endif
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>