<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Daftar Konfigurasi</h3>
        </div>
        <button class='btn btn-info btn-sm add-new' data-target='new-konfigurasi' style='float:right;height:100%;margin-top:2%;'>Tambah</button>
    </div>
    <div class="card-body">
        <table class='table'>
            <tr>
                <th>No</th>
                <th>Config</th>
                <th>Value</th>
                <th>#</th>
            </tr>
            @if($jumlah === 0)
                <tr><td colspan="4">Tidak ada data</td></tr>
            @else
                @php $no=1; @endphp
                @foreach($config as $list_config)
                <tr>
                    <td>{!! $no !!}</td>
                    <td>{!! $list_config['config_name'] !!}</td>
                    <td>
                        <?=  $list_config['config_value'] === null ? '' : "<b>Text :". $list_config['config_value']."</b>";  ?>
                        <?= $list_config['file_value'] === null ? '' : "<b>File : </b> <a href='download/".Crypt::encrypt($list_config['file_value'])."/image_config'>Download</a>" ?>
                    </td>
                    <td>
                        <button class='btn btn-info btn-sm edit' data-pattern="config" data-token_i="{!! Crypt::encrypt($list_config['id']) !!}">Edit</button>
                    </td>
                </tr>
                @php $no++; @endphp
                @endforeach
            @endif
        </table>
    </div>
</div>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services_config.js?q=test1') !!}"></script>