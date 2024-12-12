<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Daftar Tema Publish</h3>
        </div>
        <button class='btn btn-info btn-sm add-new' data-target='issue-artikel' style='float:right;height:100%;margin-top:2%;'>Tambah</button>
    </div>
    <div class="card-body">
        <table class='table'>
            <tr>
                <th>No</th>
                <th>Tema</th>
                <th>Tahun</th>
            </tr>
            @if($jumlah === 0)
                <tr><td colspan="3">Data tidak ditemukan</td></th>
            @else
                @php $no=1; @endphp
                @foreach($data as $list_issue)
                    <tr>
                        <td>{!! $no !!}</td>
                        <td>{!! $list_issue['name'] !!}</td>
                        <td>{!! $list_issue['year'] !!}</td>
                        <td>
                            <button class='btn btn-success btn-sm edit' data-pattern="issue_artikel" data-token_i="{!! Crypt::encrypt($list_issue['id']) !!}" style='border-radius:45%;'>
                                <span class='fas fa-pencil-alt'></span>
                            </button>
                            <button class='btn btn-danger btn-sm delete' data-pattern="issue_artikel" data-token_i="{!! Crypt::encrypt($list_issue['id']) !!}"  style='border-radius:45%'>
                                <span class="far fa-trash-alt"></span>
                            </button>
                        </td>
                    </tr>
                    @php $no++; @endphp
                @endforeach
            @endif
        </table>
    </div>
</div>

<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services_config.js?q=451') !!}"></script>