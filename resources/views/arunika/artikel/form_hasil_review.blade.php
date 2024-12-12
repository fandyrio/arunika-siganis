<h5 style='color:#1BC5BD;font-weight:bold;'>Form Hasil Review Artikel</h5>
<form action="{!! $action !!}">
    @csrf
    <div class='row mb-6'>
        <div class='col-lg-12'>
            <label>Hasil Review</label>
            <input type='text' class='form-control required_field' name='hasil_review' value="{!! isset($data_hasil['hasil_review']) ? $data_hasil['hasil_review'] : '' !!}">
        </div>
    </div>
    <div class='row mb-6'>
        <div class='col-lg-12'>
            <label>Keterangan Hasil Review</label>
            <textarea class='form-control' name='keterangan'>{!! isset($data_hasil['keterangan']) ? $data_hasil['keterangan'] : '' !!}</textarea>
        </div>
    </div>
    <div class='row mb-6'>
        <div class="col-lg-12">
            <hr />
            <input type='hidden' name='token_r' value="{!! $review_id !!}">
            <input type='hidden' name='token_h' value="{!! $hasil_id !!}">
            <button class='btn btn-success btn-sm saveArtikel'>Simpan</button>
            <button class='btn btn-danger btn-sm back' class="close" data-dismiss="modal">< Kembali</button>
        </div>
    </div>
</form>
<script src="{!! asset('assets/js/arunika_services.js?q=2') !!}"></script>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>