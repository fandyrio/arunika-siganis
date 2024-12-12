@extends('web/web')
@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <div class="row">
                <div class="col-md-12">
                    <img src="../resources/upload/config/tentang_arunika.jpg" style="width:100%">
                </div>
                <div class="col-md-12">
                    <h3>Call For Paper</h3>
                    <div class="slideshow-container">
                        <div class="mySlides">
                            <div class="numbertext">2 / 3</div>
                            <img src="../resources/upload/config/flyer1.jpg" style="width:50%">
                            <div class="text">Caption Two</div>
                        </div>
                    </div>
                    <br>    
                </div>
            </div>
        </div>
        <div class='col-md-5'>
            <div class='row'>
                @if(count($artikel) >= 2)
                    @for($x=1;$x<=4;$x++)
                        <div class='col-md-1'></div>
                        <div class='col-md-3 img' style="background-image:url('{!! $artikel[$x]['foto_penulis'] !!}');height:120px;background-size:cover;border-radius:10%;">   
                        </div>
                        <div class='col-md-8'>
                            <a href="baca-artikel/{!! strtolower($artikel[$x]['edoc_pdf']) !!}/{!! $artikel[$x]['token_a'] !!}">
                                <span class='text_judul' style=''>{!! $artikel[$x]['judul'] !!}</span>
                            </a>
                            <br /><br />
                            <span style='font-size:1rem;'>{!! date('d M Y', strtotime($artikel[$x]['publish_at'])) !!}</span>
                        </div>
                        <div class='col-md-12'>
                            <div class="separator separator-solid separator-border-3"></div>
                        </div>
                    @endfor
                @else
                    <div class='col-md-12'><i>Belum ada artikel</i></div>
                @endif
            </div>
        </div>
    </div>
    <div class="row" style='margin-top:60px;min-height:400px;'>
        <div class='col-md-8'>
            @if(count($artikel) >= 5)
                <div class="row">
                    <div class='col-md-4' style="background-image:url('{!! $artikel[$x]['foto_penulis'] !!}');height:200px;background-size:cover;border-radius:3%;"></div>
                    <div class='col-md-8'>
                        <span style='font-size:2rem;font-weight:bold;'>{!! $artikel[$x]['judul'] !!}</span>
                        <br /><br />
                        <p><span style='text-align:justify'>{!! strip_tags($artikel[$x]['tentang_artikel']) !!} ...</span></p>

                        <span>{!! date('d M Y', strtotime($artikel[$x]['publish_at'])) !!} <span>
                    </div>
                </div>
            @else
                <div class='col-md-12'><i>Belum ada artikel</i></div>
            @endif
        </div>
    </div>


@endsection
