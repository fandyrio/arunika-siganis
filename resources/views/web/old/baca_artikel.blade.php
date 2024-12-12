@extends('web/web')
@section('content')
    <div class='row'>
        <div class='col-md-8 mb-2'>
            <div class='row mb-6'>
                <div class="row">
                    <div class='col-12 mb-2' style=''><a href="{!! url('/home') !!}">Beranda</a> > <a href="{!! url('/home') !!}">Artikel</a> > {!! $artikel['judul'] !!}</div>
                    <div class='col-12 mb-2' style='font-size:2.5rem;font-weight:bold;'>{!! $artikel['judul'] !!}</div>
                    <div class='col-12 mb-2'>{!! $artikel['tentang_artikel'] !!}<br />
                        <p><a href="">{!! $artikel['nama'] !!}</a></p>
                    </div>
                    <img src="../../{!! $artikel['foto_penulis'] !!}" width="30%" style='float:left;margin-right:10px;'>
                    @php
                        $exp=explode('<hr>', $artikel['text_tulisan']);
                        $replace=str_replace("<br>", "", $exp[0]);
                    @endphp
                    <span>
                        {!! str_replace('</p>', '</p><br />', $replace) !!}
                    </span>
                    </div>
                    <div class='col-12 mb-2' id="text" style=''>
                        <span class="label label-info label-inline mr-2">Tags : </span>
                        @foreach($keyword as $list_keyword)
                            <a href="{!! url('tags/'.strtolower(str_replace(' ', '-', $list_keyword['keyword']))) !!}"><button class="btn font-weight-bold btn-sm btn-info">#{!! $list_keyword['keyword'] !!}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{!! asset('../resources/views/assets/js/fn_reading.js') !!}"></script>
<script>
    var x=0;
    var interval=setInterval(function(e){
        x++;
        if(x === 121){
            countReading();
            clearInterval(interval);
        }
    }, 1000)
</script>