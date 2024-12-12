@extends('web/content_template')
@section('content')
<div class="row" style='margin-top:70px !important;'>
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
    <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:8rem;'>
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-gradient-info shadow-info border-radius-lg p-3">
            <h5 class="text-white text-primary mb-0">{!! $issue  !!}</h5>
        </div>
        </div>
        <div class="card-body">
        <p class="pb-3">
            Daftar Artikel ini telah melalui proses review yang dilakukan oleh para reviewer
        </p>
        <div class='row'>
            @foreach($artikel as $list_artikel)
            <div class="col-lg-3 col-sm-3">
                <div class="card card-plain">
                    <div class="card-header p-0 position-relative skleton_loading" data-prefix="img-artikel" data-target="{!! str_replace('upload/image/', '', $list_artikel['foto_penulis']) !!}" style="min-height:200px;width:100%;">
                        <a class="d-block blur-shadow-image">
                            
                        </a>
                    </div>
                    <div class="card-body px-0">
                        @php
                            $clean=str_replace('../resources/upload/edoc/artikel/pdf/', '', $list_artikel['edoc_pdf']);
                            $explode=explode('.pdf', $clean);
                            $link='baca-artikel/'.strtolower($explode[0]).'/'.Crypt::encrypt($list_artikel['id']);
                        @endphp
                        <span style='font-size:0.8rem'>
                        <a href="{!! url($link) !!}" class="text-dark font-weight-bold" data-bs-toggle="tooltip" data-bs-placement="top">
                            @php
                            $text=ucwords(strtolower($list_artikel['judul']));
                            $explode=explode(' ', $text);
                            $jumlah=count($explode);
                            $limit=14;
                            if($jumlah < $limit){
                                $limit=$jumlah;
                            }

                            for($x=0;$x<$limit;$x++){
                                echo $explode[$x]." ";
                            }
                            if($jumlah > $limit){
                                echo "...";
                            }else{
                                echo "<br />";
                                if($jumlah <= 9){
                                    echo "<br />";
                                }
                            }
                            
                            @endphp
                        </a>
                        </span>
                        <p style='font-size:0.8rem;'>
                        {!! substr(strip_tags($list_artikel['tentang_artikel']), 0,100) !!} ...
                        </p>
                        <a href="{!! url($link) !!}" class="text-info text-sm icon-move-right">Read More
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })
  setTimeout(function(){
            var skleton=$(".skleton_loading");
            var jumlah_skleton=$(".skleton_loading").length;
            runImg(jumlah_skleton, skleton);
        },1000)
        async function runImg(jumlah_skleton, skleton){
            for(var x=0;x<jumlah_skleton;x++){
                console.log(x);
                var target=$(skleton[x]).data('target');
                var width=$(skleton[x]).width();
                var height=$(skleton[x]).height();
                var prefix=$(skleton[x]).data('prefix');
                var type="artikel-img";
                //alert(width+"x"+height);
                let printFoto=await setPhoto(width, height, target, type, x, prefix, skleton);
            }
        }
        async function setPhoto(width, height, target, type, x, prefix, skleton){
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