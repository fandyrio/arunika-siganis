@extends('web/content_template')
@section('content')
<div class="row" style='margin-top:70px !important;'>
    <div class="col-xl-12 col-lg-12 col-md-12 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
    <nav aria-label="breadcrumb" style='margin-top:4rem;'>
        <ol class="breadcrumb" style=''>
            <li class="breadcrumb-item"><a href="{!! url('/home') !!}" style='color:grey;'>Home</a></li>
            <li class="breadcrumb-item"><a href="{!! url('artikel') !!}" style='color:grey;'>Artikel</a></li>
            <li class="breadcrumb-item text-dark active title_text" aria-current="page"></li>
        </ol>
    </nav>
    <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:4rem;'>
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
        <div class="bg-header-page shadow-info border-radius-lg p-3">
            <span class="text-white text-primary mb-0 fn-sz-md text-bold">Artikel Terbaru {!! date('Y') !!}</span>
        </div>
        </div>
        <div class="card-body">
        <p class="pb-3 text" style='font-size:1rem;'>
            Daftar Artikel Terbaru.
        </p>
        <div class='row'>
            @if($jumlah > 0)
                @foreach($artikel as $list_artikel)
                <div class="col-lg-3 col-sm-6 mb-3">
                    <div class="card card-plain">
                        <div class="card-header p-0 position-relative skleton_loading" data-prefix="artikel-img" data-target="{!! str_replace('upload/image/', '', $list_artikel['foto_penulis']) !!}" style="min-height:200px;width:100%;background-size:cover;border-radius:10px 10px 10px 10px;">
                            <a class="d-block blur-shadow-image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-6 mb-3">
                    <div class="card-body px-0">
                        @php
                            $clean=str_replace('upload/edoc/artikel/pdf/', '', $list_artikel['edoc_pdf']);
                            $explode=explode('.pdf', $clean);
                            $link='baca-artikel/'.strtolower($explode[0]).'/'.Crypt::encrypt($list_artikel['id']);
                            $link='baca-artikel/'.strtolower($explode[0]).'/a-'.''.$list_artikel['id'].'arn'.$list_artikel['code_issue'];
                        @endphp
                        <span class='text-purple fn-sz-1  text-bold'>{!! $list_artikel['nama'] !!}</span>
                        <h6>
                            <a href="{!! url($link) !!}" class="text-dark font-weight-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{!! $list_artikel['judul'] !!}">
                                @php
                                    $text=ucwords(strtolower($list_artikel['judul']));
                                    echo $text;
                                @endphp
                            </a>
                            <br />
                            <span style='font-size:0.8rem;color:orange;'>{!! date('d F Y', strtotime($list_artikel['publish_at'])) !!}</span>
                        </h6>
                        <p class='fn-sz-sm'>
                        {!! substr(strip_tags($list_artikel['tentang_artikel']), 0,500) !!} ...
                        </p>
                        <a href="{!! url($link) !!}" class="text-info text-sm icon-move-right">Read More
                        <i class="fas fa-arrow-right text-xs ms-1"></i>
                        </a>
                    </div>
                </div>

                
                @endforeach
                <div class="col-md-12">
                    <hr />
                    <span style='float:right;'><b>Total : </b> {!! $jumlah !!}</span>
                    Page : 
                    @for($x=1;$x<=$jumlah_halaman;$x++)
                        @php
                        $class='btn-default';
                        if($x === (int)$page){
                            $class='btn-info';
                        }
                        $url='artikel/'.$x;
                        @endphp
                        <a href="{!! url($url) !!}"><button class='btn {!! $class !!} btn-sm'>{!! $x !!}</button></a>
                    @endfor
                </div>
            @else
                <center><h3>Mohon maaf, Saat ini Belum ada artikel yang di Publish</h3></center>
            @endif
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
        $(skleton[x]).css({"background-image":"url('{!! url('"+data.background+"') !!}')"});
        }
    })
}

</script>