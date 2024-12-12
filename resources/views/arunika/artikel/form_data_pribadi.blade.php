<div class="card card-custom">
 <div class="card-header">
  <h3 class="card-title">
   Form Data Pribadi
  </h3>
  <div class="card-toolbar">
   <div class="example-tools justify-content-center">
    <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
    <span class="example-copy" data-toggle="tooltip" title="Copy code"></span>
   </div>
  </div>
 </div>
 <!--begin::Form-->
 <form action="{!! $link_save !!}">
    @csrf
  <div class="card-body">
   <div class="form-group mb-8">
    <div class="alert alert-custom alert-default" role="alert">
     <div class="alert-icon"><i class="flaticon-warning text-primary"></i></div>
     <div class="alert-text">
        Data Pribadi ini diambil sesuai dengan data SIKEP
     </div>
    </div>
   </div>
   <div class='row mb-6'>
            <div class='col-lg-10'>
                <label>NIP</label>
                <input type='number' class='form-control nip required_field' name='nip' value="">
                <input type='hidden' class='form-control nip_baru required_field' name='nip_baru' value="{!! $enc_nip !!}">
                <input type="hidden" class='form-control token' name='token' value='{!! $id_pegawai !!}'>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback"></div>
            </div>
            <div class='col-lg-2'><br /><button class='btn btn-info btn-sm search-nip'>Cari NIP</button></div>
        </div>
        <div class='row mb-6'>
            <div class='col-lg-6'>
                <label>Nama</label>
                <input type='text' class='form-control data-hakim nama_hakim required_field' name='nama_hakim' value="<?= isset($hakim['nama']) ? $hakim['nama'] : "" ?>" disabled>
            </div>
            <div class='col-lg-3'>
                <label>Pangkat</label>
                <input type='text' class='form-control data-hakim pangkat_hakim required_field' name='pangkat_hakim' value="<?= isset($hakim['pangkat']) ? $hakim['pangkat'] : "" ?>" disabled>
            </div>
            <div class='col-lg-3'>
                <label>No HP</label>
                <input type='text' class='form-control data-hakim kontak_hakim required_field' name='kontak_hakim' value="<?= isset($hakim['no_handphone']) ? $hakim['no_handphone'] : "" ?>" disabled>
            </div>
        </div>
        <div class='row mb-6'>
            <div class='col-lg-6'>
                <label>Jabatan</label>
                <input type='text' class='form-control data-hakim jabatan_hakim required_field' name='jabatan_hakim' value="<?= isset($hakim['jabatan']) ? $hakim['jabatan'] : "" ?>" disabled>
            </div>
            <div class='col-lg-6'>
                <label>Satker</label>
                <input type='text' class='form-control data-hakim satker_hakim required_field' name='satker_hakim' value="<?= isset($hakim['satker']) ? $hakim['satker'] : "" ?>" disabled disabled>
            </div>
        </div>
        <div class='row mb-6'>
            <div class='col-lg-6'>
                <label>Foto Terbaru</label>
                <input type='file' class='form-control foto_hakim <?= isset($foto_penulis) ? '' :'required_field' ?>' name='foto_hakim'>
            </div>
            <div class='col-lg-6 imagePreview'>
                <?= isset($foto_penulis) ? "<img src='".$foto_penulis."' width='40%'>" : "" ?>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-12'>
                <hr />
                    <center>
                        <button class='btn btn-primary btn-sm saveArtikel' type='submit'>Simpan</button>     
                        <button class='btn btn-danger btn-sm back' onClick="loadDataPribadi('view')">Kembali</button>
                    </center>
            </div>
        </div>
 </form>
 <!--end::Form-->
</div>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script src="{!! asset('assets/js/arunika_services.js') !!}"></script>
@if(!isset($hakim))
    <script>
        $(".nip").val("{!! $nip !!}")
        $(".search-nip").trigger('click');
    </script>
@endif