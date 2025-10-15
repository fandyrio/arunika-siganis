<h5 style='color:#1BC5BD;font-weight:bold;'>Checklist Form Artikel</h5>
<label class="checkbox" style='float:right'>
    <input type="checkbox" class="checkAll"> Check Lengkap Semua
    <span></span>
</label><br />
<form action="save-checklist-review" class="form-artikel">
    <table class='table' style='font-size:0.8vw;'>
        <tr>
            <th>No</th>
            <th>Pertanyaan</th>
            <th>Lengkap</th>
            <th>Tidak</th>
            <th>Keterangan</th>
        </tr>
        @php $x=1; @endphp
            @foreach($checklist as $list_checklist)
                <tr>
                    <td>{!! $x !!}</td>
                    <td style='width:50%;'>{!! $list_checklist['pertanyaan'] !!}</td>
                    <td>
                        <input type='checkbox' class='form-check ya' name="pertanyaan_{!! $list_checklist['id'] !!}"  value="1" {!! $list_checklist['hasil'] === 1 ? 'checked' : '' !!}>
                    </td>
                    <td><input type='checkbox' class='form-check' value="0" name="pertanyaan_{!! $list_checklist['id'] !!}" {!! $list_checklist['hasil'] === 0 ? 'checked' : '' !!}></td>
                    <td>
                        <textarea class="form-control" name="catatan_{!! $list_checklist['id'] !!}">{!! $list_checklist['keterangan'] !!}</textarea>
                    </td>
                </tr>
                @php $x++; @endphp
            @endforeach
            <tr>
                <td colspan="5">
                    <input type='hidden' name='token_r' value="{!! $review_id !!}">
                    <button class='btn btn-info btn-sm saveArtikel' type='submit'>Simpan</button>
                </td>
            </tr>
    </table>
</form>
<script nonce="arunika123">
    $(".checkAll").click(function(e){
        e.preventDefault();
        checkuncheck(this);
    })
    $(document).on("click", "input[type=checkbox]", function(e){
        e.stopPropagation();
        e.stopImmediatePropagation();
        onlyCheckOne(this);
    })
</script>
