<h5 style='color:#1BC5BD;font-weight:bold;'>Checklist Form Artikel</h5>
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
                    <td>{!! $list_checklist['pertanyaan'] !!}</td>
                    <td>{!! $list_checklist['hasil'] === 1 ? "<b><span style='color:green;'>V</span></b>" : '' !!}</td>
                    <td>{!! $list_checklist['hasil'] === 0 ? "<b><span style='color:red;'>V</span></b>" : '' !!}</td>
                    <td>{!! $list_checklist['keterangan'] !!}</td>
                </tr>
                @php $x++; @endphp
            @endforeach
</table>
<hr />
@if($can_edit)
    <button class='btn btn-danger btn-sm addReview' data-index="{!! $index !!}" data-view="form">Ubah data</button>
@endif    

<script src="{!! asset('../resources/views/assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('../resources/views/assets/js/arunika_services.js') !!}"></script>