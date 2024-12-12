<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Daftar Team Editorial</h3>
        </div>
        <button class='btn btn-info btn-sm add-new' data-target='editorial-team' style='float:right;height:100%;margin-top:2%;'>Tambah</button>
    </div>
    <div class="card-body">
        <table class='table'>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Sebagai</th>
                    <th>#</th>
                </tr>
                @if($jumlah === 0)
                    <tr><td colspan='3'><center>Tidak ada data</center></td></tr>
                @else
                @php $no=1; @endphp
                    @foreach($team as $list_team)
                        <tr>
                            <td>{!! $no !!}</td>
                            <td>{!! $list_team['nama'] !!}</td>
                            <td>{!! $list_team['sebagai'] !!}</td>
                            <td>
                                <button class='btn btn-danger btn-sm remove_config' data-pattern='remove-editor' data-target="{!! Crypt::encrypt($list_team['id']) !!}" style='border-radius:45%;'>
                                <span class='far fa-trash-alt'></span></button>
                            </td>
                        </tr>
                        @php $no++ @endphp
                    @endforeach
                @endif
        </table>
    </div>
</div>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services_config.js?q=test1') !!}"></script>