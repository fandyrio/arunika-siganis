@extends('web/content_template')
@section('content')
<section>
  <div class="container py-4">
    <div class="card d-flex blur justify-content-center shadow-lg my-sm-0 my-sm-6 mb-5" style='margin-top:8rem;'>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-5">
                    <h3 class="text-center" style='color:#684DF4'>Parameter Pencarian</h3>
                    <form role="form" id="contact-form" method="post" action="search">
                        @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <label class="form-label">Keyword</label>
                                        <input class="form-control" aria-label="Nama Penulis..." type="text" name="kata_kunci" value="{!! isset($keyword) === true ? $keyword : '' !!}">
                                    </div>
                                </div>
                                <div class="col-md-12 ps-2">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <label class="form-label">Judul Artikel</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Last Name..." name="judul" value="{!! isset($judul) === true ? $judul : '' !!}" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="input-group input-group-dynamic mb-4">
                                        <label class="form-label">Nama Penulis</label>
                                        <input type="text" class="form-control" name="nama_penulis" value="{!! isset($nama) === true ? $nama : '' !!}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn bg-gradient-info w-100">Search</button>
                                </div>
                            </div>
                        
                    </form>
                </div>
                <div class="col-lg-7">
                    @if(isset($hasil_search))
                        <h5>Hasil Pencarian untuk {!! $search_for !!} </h5>
                        <p><i>{!! $jumlah !!} artikel ditemukan</i></p>
                        <br />
                        @if($jumlah > 0)
                            @for($x=0;$x<$jumlah;$x++)
                                <a href="{!! url('/baca-artikel/'.$hasil_search[$x]['edoc_pdf'].'/'.$hasil_search[$x]['id']) !!}">
                                <div class="row mb-2" style='border-bottom:0.1rem solid #684DF4'>
                                    <div class="col-lg-12">
                                        <h6>{!! $hasil_search[$x]['judul'] !!}</h6>
                                        <span style='font-size:1rem;float:right;'>{!! $hasil_search[$x]['penulis'] !!}</span>
                                    </div>
                                </div></a>
                            @endfor
                        @else
                            <h6>Hasil Tidak ditemukan</h6>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
</section>
@endsection
