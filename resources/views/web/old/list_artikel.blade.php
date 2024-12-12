@extends('web/web')
@section('content')

    <div class="row" style="font-family:'Montserrat', 'Helvetica', Arial, sans-serif">
        <div class='col-12 mb-2' style=''><a href="{!! url('/home') !!}">Beranda</a> > <a href="{!! url('/search') !!}">Artikel</a> > {!! $tag !!}</div>
        <div class="col-md-6">
            <h5 style='margin:0'>Tag</h5>
            <h3 style='margin:0;font-weight:bold;color:#141D38'>#{!! $tag !!}</h3>
            <hr />
        </div>
        <div class="col-md-8" style="text-align:justify;">
            <ul class="nav nav-tabs nav-tabs-line" style='border-bottom:0.5px solid #0001;'>               
                    <li class="nav-item" style='border-bottom:2px solid #141D38;font-size:2rem;'>
                        <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1" style="padding:0;color:#141D38"> Artikel &nbsp&nbsp&nbsp</a>
                    </li>
                </ul>
            <div class="tab-content mt-5" id="myTabContent">
                    <div class="tab-pane show" id="kt_tab_pane_1" role="tabpanel" aria-labelledby="kt_tab_pane_2" style="margin-top:20px;">
                        <div class="row">
                            @if($artikel->count() > 0)
                                @foreach($artikel as $list_artikel)
                                <a href="{!! url('/baca-artikel/'.strtolower($list_artikel['edoc_pdf']).'/'.Crypt::encrypt($list_artikel['id'])) !!}" style='color:#66615b !important'>
                                    <div class="col-md-4" style="background-image:url('../{!! $list_artikel['foto_penulis'] !!}');height:200px;background-size:cover;border-radius:3%;">
                                    </div>
                                    <div class='col-md-8'>
                                        <span style='font-size:1.5rem;font-weight:bold;'>{!! $list_artikel['judul'] !!}</span>
                                        <br /><br />
                                        <p><span style='text-align:justify'>{!! str_replace(array('Times New Roman', 'serif'), '', $list_artikel['tentang_artikel']) !!} ...</span></p>

                                        <span>{!! date('d M Y', strtotime($list_artikel['publish_at'])) !!} </span>
                                    </div>
                                    <div class="col-md-12"><hr /></div>
                                </a>
                                @endforeach
                            @else
                                <center><h4>Artikel tidak ditemukan</h4></center>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection