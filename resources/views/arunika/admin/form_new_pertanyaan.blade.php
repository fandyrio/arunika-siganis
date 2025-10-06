@php
    $token_id="";
    $pertanyaan="";
    $required_field="";
    $url="save-pertanyaan";
    if(isset($data)){
        $token_id=$data['token_id'];
        $pertanyaan=$data['pertanyaan'];
        $required_field="required_field";
        $url="update-pertanyaan";
    }

@endphp
<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Form Tambah Pertanyaan</h3>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ $url }}">
            @csrf
            <div class='row mb-6'>
                <div class='col-lg-12'>
                    <label>Pertanyaan</label>
                    <input type='text' class='form-control required_field' name='pertanyaan' value="{{ $pertanyaan }}">
                    <input type="hidden" class="form-control {!! $required_field !!}" name="token_i" value="{{ $token_id }}">
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-12'>
                    <button class='btn btn-success btn-sm saveArtikel' type='submit'>Simpan</button>
                    <button class='btn btn-danger btn-sm backToList' data-fn="callLink" data-dst="list-pertanyaan-review/{!! $page !!}" type="button" data-paste="callLink('list-pertanyaan-review/{!! $page !!}')">< Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
{{-- <script src="{!! asset('../resources/views/assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('../resources/views/assets/js/arunika_services_config.js?q=test1') !!}"></script> --}}