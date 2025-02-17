<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Daftar Pengguna</h3>
        </div>
        <!-- <button class='btn btn-info btn-sm add-new' data-target='new-konfigurasi' style='float:right;height:100%;margin-top:2%;'>Tambah</button> -->
    </div>
    <div class="card-body">
        <table class='table'>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>#</th>
            </tr>
            @if($jumlah === 0)
                <tr><td colspan="4">Tidak ada data</td></tr>
            @else
                @php $no=1; @endphp
                @foreach($data as $list_pengguna)
                <tr>
                    <td>{!! $no !!}</td>
                    <td>{!! $list_pengguna['nama'] !!}</td>
                    <td>
                        {!! $list_pengguna['nip_users'] === null ? 'User belum ada' : $list_pengguna['nip_users'] !!}
                    </td>
                    <td>
                        <button class='btn btn-danger btn-sm removePegawai' data-target="{!! Crypt::encrypt($list_pengguna['id_pegawai_lokal']) !!}">
                            <span class='far fa-trash-alt'></span>
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
<script src="{!! asset('assets/js/arunika_services_config.js?q=test233') !!}"></script>