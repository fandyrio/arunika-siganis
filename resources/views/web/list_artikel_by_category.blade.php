@extends('web/content_template')
@section('content')
<div class="row" style='margin-top:70px !important;'>
    <div class="col-xl-9">
        @if($content === "found")
            <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:8rem;min-height:300px;'>
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-header-page shadow-info border-radius-lg p-3">
                        <span class="text-white text-primary mb-0 fn-sz-md text-bold">Kategori Artikel : {!! $category  !!}</span>
                    </div>
                </div>
                <div class="card-body">
                    <p class="pb-3 text" style='font-size:1rem;'>
                        Daftar Artikel ini telah melalui proses review yang dilakukan oleh para reviewer
                    </p>
                <div class='row'>
                    @if($total === 0)
                        <div class="col-lg-12 col-sm-6" >
                            <center>
                            <span style='color:grey;text-align:center'><i class="material-icons opacity-6 me-2 text-xl" style='font-size:3rem;'>folder_open</i></center><center>There is no artikel found</center> </span>
                        </div>
                    @else
                        @for($x=0;$x<$jumlah_data;$x++)
                        <div class="col-lg-3 col-sm-6" >
                            <div class="card card-plain">
                                <div class="card-header p-0 position-relative" style="min-height:5rem;">
                                    <a class="d-block blur-shadow-image">
                                        <img src="{!! asset($artikel[$x]['foto_penulis']) !!}" alt="img-blur-shadow" class="img-fluid shadow border-radius-lg" loading="lazy">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-sm-6" >
                            <div class="card-body px-0">
                                @php
                                $clean=str_replace('../resources/upload/edoc/artikel/pdf/', '', $artikel[$x]['edoc_pdf']);
                                $explode=explode('.pdf', $clean);
                                $link='baca-artikel/'.strtolower($explode[0]).'/'.$artikel[$x]['token_a'];

                                @endphp
                                <span class='text-purple fn-sz-1  text-bold'>{!! $artikel[$x]['nama'] !!}</span>
                                <h6>
                                    <a href="{!! url($link) !!}" class="text-dark font-weight-bold" data-bs-toggle="tooltip" data-bs-placement="top" title="{!! $artikel[$x]['judul'] !!}">
                                        @php
                                            $text=ucwords(strtolower($artikel[$x]['judul']));
                                            echo $text;
                                        @endphp
                                    </a>
                                </h6>
                                <p class='fn-sz-sm'>
                                {!! substr(strip_tags($artikel[$x]['tentang_artikel']), 0,500) !!} ...
                                </p>
                                <a href="{!! url($link) !!}" class="text-info text-sm icon-move-right">Read More
                                <i class="fas fa-arrow-right text-xs ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class='col-lg-12'>
                            <hr />
                            Halaman<br />
                            @for($x=0;$x<$jumlah_halaman;$x++)
                                @php
                                    if(($x+1) === (int)$page){
                                        $class_info="info";
                                    }else{
                                        $class_info="default";
                                    }
                                @endphp
                                <a href="{!! url('/category/'.$category_link.'/'.$x+1) !!}"><button class='btn btn-{!! $class_info !!} btn-sm'>{!! $x+1 !!}</button></a>
                            @endfor
                        </div>
                        @endfor
                    @endif
                </div>
            </div></div>
        @else
            <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:8rem;'>
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                    <div class="bg-header-page shadow-info border-radius-lg p-3">
                        <span class="text-white text-primary mb-0 fn-sz-md text-bold">Not Found</span>
                    </div>
                </div>
                <div class="card-body">
                    <span style='color:grey;text-align:center'><i class="material-icons opacity-6 me-2 text-xl" style='font-size:3rem;'>folder_open</i><center></center>Data Not Found </span>
                </div>
            </div>
        @endif
    </div>
    <div class="col-xl-3">
        <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:8rem;'>
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-header-page shadow-info border-radius-lg p-3">
                    <span class="text-white text-primary mb-0 fn-sz-md text-bold">Kategori Artikel</span>
                </div>
            </div>
            <div class="card-body">
                
                    @php
                        $jumlah_kategori=count($kategori_artikel);
                        for($x=0;$x<$jumlah_kategori;$x++){
                            $link="/category/".strtolower($kategori_artikel[$x]['link'])."/";
                            $filter="";
                            if($category === $kategori_artikel[$x]['category']){
                                $filter="filter:drop-shadow(0px 2px 3px purple)";
                            }
                            echo "
                            <div class='row'>
                                <div class='col-lg-12 mt-2' style='".$filter.";background-color:linen;border-radius:3%;padding:2%;'>
                                    <a href='".url($link)."' style='float:left;'>
                                        <span class='fn-sz-md' style='font-size:0.8rem;'>".$kategori_artikel[$x]['category']." </span><i class='material-icons' style='font-size:1rem;'>chevron_right</i><br />
                                    </a>
                                </div>
                            </div>
                            ";
                        }
                    @endphp
                
                <div class='row'></div>
            </div>
        </div>
    </div>
</div>
@endsection
