<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
            Data Artikel
        </h3>
    </div>
    
</div>
<div class="card-toolbar">
    <table class='table'>
        <tr>
            <th>Judul</th>
            <td>{!! $artikel['judul'] !!}</td>
        </tr>
        <tr>
            <th>Kategori</th>
            <td>{!! $artikel['kategori'] !!}</td>
        </tr>
        <tr>
            <th>Tentang Artikel</th>
            <td>{!! $artikel['tentang_artikel'] !!}</td>
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
            <td><a href="download/{!! Crypt::encrypt($artikel['edoc_artikel']) !!}/edoc_artikel">Download</a></td>
        </tr>
    </table>
    <hr />
        <button class='btn btn-info btn-md tabs' data-target="data_pribadi" style='float:left;'>< Sebelumnya</button> &nbsp
        <button class='btn btn-danger btn-md edit' onClick="loadDataArtikel('form')">Edit</button>
        <button class='btn btn-info btn-md tabs' data-target="confirmation" style='float:right;'>Selanjutnya ></button>
</div>
<!-- <script src="{!! asset('assets/js/arunika_services.js') !!}"></script>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script> -->