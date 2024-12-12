<form action="update-tema">
    @csrf
        <div class='row mb-12'>
            <div class='col-lg-12'>
                <span style='color:grey;font-weight:bold;font-size:1.2rem'>Judul Artikel : {!! $artikel['judul'] !!}</span><br /><br />
                <label>Tema</label>
                <select class="form-control required_field" name="tema">
                    <option value="">Pilih Tema</option>
                    @foreach($tema as $list_tema)
                        <option value="{!! Crypt::encrypt($list_tema['code_issue']) !!}">{!! $list_tema['name'] !!}</option>
                    @endforeach
                </select>
                <input type="hidden" name="token_id" class="required_field" value="{!! Crypt::encrypt($artikel['id']) !!}">
            </div>
            <div class='col-lg-12'>
                <hr />
                <button class='btn btn-success btn-sm saveArtikel' type="submit">Simpan</button>
                <button class='btn btn-danger btn-sm' data-dismiss="modal">Tutup</button>
            </div>
        </div>
</form>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services.js') !!}"></script>