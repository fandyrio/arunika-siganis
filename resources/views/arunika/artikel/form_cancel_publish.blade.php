<div class='row mb-6'>
    <div class='col-8'>
        <form action='cancel-publish'>
            @csrf
            <input type='hidden' name='token_r' value="{!! $token_r !!}">
            <div class='row mb-6'>
                <div class='col-12 mb-6'>
                    <label>Alasan Pembatalan</label>
                    <textarea class='form-control required_field' name="catatan_jm"></textarea>
                </div>
                <div class='col-12'>
                    <button class='btn btn-danger btn-sm' data-dismiss="modal">< Kembali</button>
                    <button class='btn btn-success btn-sm saveArtikel'>Simpan</button>
                </div>
            </div>
        </form>
        <input type='hidden' name='token_a' value='{!! $token_a !!}'>
    </div>
</div>
<script src="{!! asset('../resources/views/assets/js/arunika_services.js?q=11') !!}"></script>
<script src="{!! asset('../resources/views/assets/js/fn_arunika.js') !!}"></script>