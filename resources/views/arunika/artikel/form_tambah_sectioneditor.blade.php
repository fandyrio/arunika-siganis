<div class='row mb-6'>
    <div class='col-8'>
        <form action='save-section-editor' class="form-artikel">
            @csrf
            <input type='hidden' name='token' value='{!! $token !!}'>
            <div class='row mb-6'>
                <div class='col-12'>
                    <label>Nama Section Editor</label>
                    <select class='form-control required_field' name='nama'>
                        <option value=''>Pilih Section Editor</option>
                        @for($x=0;$x<$list_se['jumlah'];$x++)
                            <option value="{!! $list_se['data'][$x]['editorial_token'] !!}">{!! $list_se['data'][$x]['nama'] !!}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <!-- <div class='row mb-6'>
                <div class='col-6'>
                    <label>Mulai Review</label>
                    <input type='date' class='form-control tgl_mulai required_field' name='tgl_mulai' value="{!! date('d/m/Y') !!}">
                </div>
                <div class='col-6'>
                    <label>Estimasi Review Selesai</label>
                    <input type='date' class='form-control tgl_selesai required_field' name='tgl_selesai'>
                </div>
            </div> -->
            <div class='row mb-3'>
                <div class='col-12'>
                    <hr />
                    <button class="btn btn-primary saveArtikel" type='submit'>Save Reviewer</button>  
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
    <div class='col-4' >
        <h5>Status Section Editor</h5>
        <table class='table' style='font-size:0.8vw;'>
            <tr>
                <th>Nama</th>
                <th>Artikel Aktif</th>
            </tr>
            @if($active_se['jumlah'] === 0)
                <tr><th>Tidak ada reviewer</th></tr>
            @else
                @for($x=0;$x<$active_se['jumlah'];$x++)
                    <tr>
                        <td>{!! $active_se['data'][$x]['nama'] !!}</td>
                        <td>{!! $active_se['data'][$x]['jumlah'] !!}</td>
                    </tr>

                @endfor
            @endif
        </table>
    </div>
</div>