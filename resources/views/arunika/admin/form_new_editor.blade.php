<div class="card card-custom gutter-b">
    <div class="card-header">
        <div class="card-title" style=''>
            <h3 class="card-label">Form Tambah Team Editorial</h3>
        </div>
    </div>
    <div class="card-body">
        <form action="save-editor">
            @csrf
            <div class='row mb-6'>
                <div class='col-lg-5'>
                    <label>NIP</label>
                    <input type='number' class='form-control nip required_field' name='nip' value="">
                    <input type="hidden" class='form-control token' name='token' value=''>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback"></div>
                </div>
                <div class='col-lg-1'><br /><button class='btn btn-info btn-sm search-nip'>Cari NIP</button></div>
                <div class='col-lg-5'>
                <label>Sebagai</label>
                <select class='form-control required_field' name='sebagai'>
                    <option value='editor'>Editor</option>
                    <option value='jurnal_manager'>Jurnal Manager</option>
                </select>
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-6'>
                    <label>Nama</label>
                    <input type='text' class='form-control data-hakim nama_hakim required_field' name='nama_hakim' value="" disabled>
                </div>
                <div class='col-lg-3'>
                    <label>Pangkat</label>
                    <input type='text' class='form-control data-hakim pangkat_hakim required_field' name='pangkat_hakim' value="" disabled>
                </div>
                <div class='col-lg-3'>
                    <label>No HP</label>
                    <input type='text' class='form-control data-hakim kontak_hakim required_field' name='kontak_hakim' value="" disabled>
                </div>
            </div>
            <div class='row mb-6'>
                <div class='col-lg-6'>
                    <label>Jabatan</label>
                    <input type='text' class='form-control data-hakim jabatan_hakim required_field' name='jabatan_hakim' value="" disabled>
                </div>
                <div class='col-lg-6'>
                    <label>Satker</label>
                    <input type='text' class='form-control data-hakim satker_hakim required_field' name='satker_hakim' value="" disabled disabled>
                </div>
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <hr />
                        <center>
                            <button class='btn btn-primary btn-sm saveArtikel' type='submit'>Simpan</button>     
                            <button class='btn btn-danger btn-sm list_menu' data-target='editorial_team' type='button' onClick="callLink('list-editorial-team')">Kembali</button>
                        </center>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{!! asset('../resources/views/assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('../resources/views/assets/js/arunika_services_config.js') !!}"></script>