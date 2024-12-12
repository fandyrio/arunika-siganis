<h5 style='color:#1BC5BD;font-weight:bold;'>Form Catatan Reviwer</h5>
<form action="save-catatan-reviewer">
    @csrf
    <div class='row mb-6'>
        <div class='col-lg-12'>
            <label>Status Artikel</label>
            <select class='form-control required_field' name='status_artikel'>
                <option value="">Pilih Status</option>
                <option value="{!! Crypt::encrypt('5') !!}" {!! $step === 5 ? 'selected' : '' !!}>Perbaikan</option>
                <option value="{!! Crypt::encrypt('6') !!}" {!! $step === 6 ? 'selected' : '' !!}>>Diterima</option>
            </select>
        </div>
    </div>
    <div class='row mb-6'>
        <div class='col-lg-12'>
            <label>Catatan Hasil Review</label>
            <textarea class='form-control' name='catatan'>{!! $catatan_reviewer !!}</textarea>
        </div>
    </div>
    <div class='row mb-6'>
        <div class="col-lg-12">
            <input type='hidden' name='token_r' value="{!! $review_id !!}">
            <button class='btn btn-sm btn-success saveArtikel'>Simpan</button>
            <button class='btn btn-danger btn-sm' class="close" data-dismiss="modal">< Kembali</button>
        </div>
    </div>
</form>
<script src="{!! asset('assets/js/arunika_services.js?q=2') !!}"></script>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>