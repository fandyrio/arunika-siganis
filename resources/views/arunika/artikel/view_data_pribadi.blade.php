<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
        Form Data Pribadi
        </h3>
    </div>
    <div class="card-toolbar">
        <div class='row'>
            <div class='col-9'>
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
                        <th>Jabatan</th>
                        <td>{!! $data['jabatan'] !!}</td>
                    </tr>
                    <tr>
                        <th>Satker</th>
                        <td>{!! $data['satker'] !!}</td>
                    </tr>
                    <tr>
                        <th>Pangkat</th>
                        <td>{!! $data['pangkat'] !!}</td>
                    </tr>
                    <tr>
                        <th>No. Handphone</th>
                        <td>{!! $data['no_handphone'] !!}</td>
                    </tr>
                </table>
            </div>
            <div class='col-3'>
                <img src="{!! asset($data['foto_penulis']) !!}" width='100%'>
            </div>
        </div>
        <div class='row'>
            <div class="col-12">
                <hr />
                    <button class='btn btn-danger btn-md' onClick="loadDataPribadi('form')">Edit</button>
                    <button class='btn btn-info btn-md tabs' style='float:right;' data-target="artikel">Selanjutnya ></button>

            </div>
        </div>
    </div>
</div>
<script src="{!! asset('../resources/views/assets/js/arunika_services.js') !!}"></script>
<script src="{!! asset('../resources/views/assets/js/fn_arunika.js') !!}"></script>