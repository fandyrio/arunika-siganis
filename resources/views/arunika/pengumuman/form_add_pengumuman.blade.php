
@php
    $action="save-pengumuman";
    $judul=null;
    $keterangan=null;
    $edoc=null;
    $disabled="";
    $input_file="";
    $required="required_field";
    $token_id=null;
    if(isset($data_pengumuman)){
        $action="update-pengumuman";
        $judul=$data_pengumuman->judul;
        $keterangan=$data_pengumuman->keterangan;
        $edoc=$data_pengumuman->edoc;
        $input_file="none";
        $token_id=Crypt::encrypt($data_pengumuman->id);
        $required="";
        $disabled="disabled";
    }
@endphp
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Form Tambah Pengumuman</h3>
        </div>
    </div>
    <div class="card-body">
        <form action="{!! $action !!}">
        @csrf
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Judul</label>
                    <input type='text' class='form-control required_field' name='judul' value="{!! $judul === null ? '' : $judul !!}">
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Keterangan</label>
                    <input type='text' class='form-control required_field' name='keterangan' value="{!! $keterangan === null ? '' : $keterangan !!}">
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <label>Edoc</label>
                    <br />
                    <div class="row">
                        <div class="col-md-12">
                            @if($input_file === "none")
                                <button class='btn btn-success btn-sm changeEdocPengumuman' type="button">Ganti Edoc</button>
                                    <br /><br />
                                    <span style='font-weight:bold;font-size:1rem'>
                                        Edoc : {!! str_replace('../resources/upload/pengumuman/', '', $edoc) !!}</span>
                                <br />
                                <div class="filename_baru"></div>
                            @endif
                        </div>
                    <div>
                    <input type="file" class="form-control file_pdf {!! $required !!}"  name="file" style="display:{!! $input_file !!}">
                    <input type="hidden" name="token_i" value="{!! $token_id !!}">
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-8'>
                    <hr />
                    <button class='btn btn-success btn-md saveArtikel'>Simpan</button>
                    <button class="btn btn-danger btn-md back" type="button" onClick="callLink('list-pengumuman')">Kambali</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services_config.js?q=1234') !!}"></script>
