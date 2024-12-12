<div class='row mb-6'>
    <div class='col-8'>
        <form action='save-reviewer'>
            @csrf
            <input type='hidden' name='token' value='{!! $token !!}'>
            <div class='row mb-6'>
                <div class='col-12'>
                    <label>Nama Reviewer</label>
                    <select class='form-control required_field' name='nama'>
                        <option value=''>Pilih Reviewer</option>
                        @foreach($reviewer as $list_reviewer)
                            <option value="{!! Crypt::encrypt($list_reviewer['id']) !!}">{!! $list_reviewer['nama'] !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-6'>
                    <label>Mulai Review</label>
                    <input type='date' class='form-control tgl_mulai required_field' name='tgl_mulai' value="{!! date('d/m/Y') !!}">
                </div>
                <div class='col-6'>
                    <label>Estimasi Review Selesai</label>
                    <input type='date' class='form-control tgl_selesai required_field' name='tgl_selesai'>
                </div>
            </div>
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
        <h5>Status Reviewer</h5>
        <table class='table' style='font-size:0.8vw;'>
            <tr>
                <th>Nama</th>
                <th>Artikel Aktif</th>
            </tr>
            @if($jlh_reviewer === 0)
                <tr><th>Tidak ada reviewer</th></tr>
            @else
                @foreach($reviewer_active as $list_aktif)
                    <tr>
                        <td>{!! $list_aktif['nama'] !!}</td>
                        <td>{!! $list_aktif['jumlah_aktif'] !!}</td>
                    </tr>

                @endforeach
            @endif
        </table>
    </div>
</div>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services.js') !!}"></script>