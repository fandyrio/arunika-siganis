<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Daftar Pertanyaan</h3>
        </div>
        <button class='btn btn-info btn-sm add-new' data-target='checklist-pertanyaan' style='float:right;height:100%;margin-top:2%;'>Tambah</button>
    </div>
    <div class="card-body">
        <table class='table'>
            <tr>
                <th>No</td>
                <th>Pertanyaan</th>
                <th></th>
            </tr>
            @if($total > 0)
                @foreach($list_pertanyaan as $list)
                    <tr>
                        <td>{!! $no !!}</td>
                        <td>{!! $list['pertanyaan'] !!}</td>
                        <td>
                            <button class='btn btn-danger btn-sm remove_config' style='border-radius:30%;height:100%;' data-pattern='remove-pertanyaan' data-target="{!! Crypt::encrypt($list['id']) !!}">
                                <span class='far fa-trash-alt'></span>
                            </button>
                        </td>
                    </tr>
                    @php $no+=1; @endphp
                @endforeach
            @else
                <tr><td colspan="2">Tidak ada data</td></tr>
            @endif
        </table>
        <hr />
        Page | 
        @for($x=1;$x<=$jumlah_halaman;$x++)
            @php
                $class_btn="btn-secondary";
                if($page === $x){
                    $class_btn="btn-info";
                }
            @endphp
            <button class='btn {!! $class_btn !!} btn-sm' onClick="callLink('list-pertanyaan-review/{!! Crypt::encrypt($x) !!}')">{!! $x !!}</button> 
        @endfor
        <span style='float:right;font-weight:bold'>Total data : {!! $total !!}</span>
    </div>
</div>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services_config.js?q=test1') !!}"></script>