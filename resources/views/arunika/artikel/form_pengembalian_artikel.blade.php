<div class='row'>
    <div class='col-12'>
        <form id="form_pengembalian">
            @csrf
            <input type='hidden' name='token' class='required' value='{!! $artikel_id !!}'>
            <div class='row'>
                <div class='col-12'>
                    <label>Alasan Pengembalian</label>
                    <textarea class="form-control required" name='alasan_pengembalian' row="5"></textarea>
                </div>
                <div class="col-12 mt-4">
                    <hr />
                    <button class='btn btn-danger btn-sm savePengembalian'>Simpan</button>
                    <button class="btn btn-success btn-sm " data-dismiss='modal'>Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
