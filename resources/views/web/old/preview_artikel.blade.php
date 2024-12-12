@extends('web/web')
@section('content')
    <div class='row'>
        <div class='col-md-8 mb-2'>
            <div class='row mb-6'>
                <div class='col-12 mb-2'><a href="">Beranda</a> > <a href="">Artikel</a> > {!! $artikel['judul'] !!}</div>
                <div class='col-12 mb-2'><h2>{!! $artikel['judul'] !!}</h2></div>
                <div class='col-12 mb-2'>{!! $artikel['tentang_artikel'] !!}</div>
                <div class='col-12 mb-6'>
                    <br /><br />
                    <p><a href="">{!! $artikel['nama'] !!}</a></p>
                    <img src="../{!! $artikel['foto_penulis'] !!}" width="100%">
                </div>
                <div class='col-12 mb-2' id="text" style=''>
                    @php
                        $exp=explode('<hr>', $text);
                    @endphp
                    {!! str_replace('</p>', '</p><br />', $exp[0]) !!}
                </div>
            </div>
        </div>
        <div class='col-md-3 mb-2 ml-5'>test</div>
    </div>
@endsection