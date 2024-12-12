
<div class='row mb-6'> 
    <div class='col-md-8'>
        <h5 style='color:#1BC5BD;font-weight:bold;'>Data Personal</h5>
        <table class='table'>
            <tr>
                <th>Nama</th>
                <td>{!! $data['nama'] !!}</td>
            </tr>
            <tr>
                <th>NIP</th>
                <td>{!! $data['nip'] !!}</td>
            </tr>
            <tr>
                <th>Pangkat</th>
                <td>{!! $data['pangkat'] !!}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{!! $data['jabatan'] !!}</td>
            </tr>
            <tr>
                <th>Satuan Kerja</th>
                <td>{!! $data['satker'] !!}</td>
            </tr>
        </table>
    </div>
    <div class='col-md-4'>
        <img src="{!! $data['foto_penulis'] !!}" width="100%">
    </div>
</div>
<div class="row mb-3">
    <div class='col-md-12'>
        <h5 style='color:#1BC5BD;font-weight:bold;'>Data Artikel</h5>
        <table class="table">
            <tr>
                <th>Judul</th>
                <td>{!! $data['judul'] !!}</td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{!! $data['kategori'] !!}</td>
            </tr>
            <tr>
                <th>Tentang Artikel</th>
                <td>{!! $data['tentang_artikel'] !!}</td>
            </tr>
            <tr>
                <th>Keyword</th>
                <td>
                    @foreach($keyword as $list_keyword)
                        <li>{!! $list_keyword['keyword'] !!}</li>
                    @endforeach
                </td>
            </tr>
            <tr>
                <th>eDoc</th>
                <td><a href="download/{!! Crypt::encrypt($data['edoc_artikel']) !!}/edoc_artikel" target="_blank">Download</a></td>
            </tr>
        </table>
    </div>
</div>

<div class="row mb-3">
    <div class='col-md-12'>
    </div>
</div>