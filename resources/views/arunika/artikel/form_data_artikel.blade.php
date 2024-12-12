
<div class="card card-custom">
    <div class="card-header">
        <h3 class="card-title">
        Form Data Artikel
        </h3>
    </div>
        <div class="card-toolbar">
            <form action="update-data-artikel" data-target='artikel'>
                <div class='row mb-6'>
                    <div class='col-lg-10'>
                        <label>Judul Artikel</label>
                        <input type='text' class='form-control judul required_field' name='judul_artikel' value="<?= $artikel['judul'] ?>">
                        <div class="valid-feedback">Valid.</div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class='row mb-6'>
                    <div class='col-lg-10'>
                        <label>Kategori Artikel</label>
                        <select class='form-control required_field' name='kategori_artikel'>
                            <option value="">Pilih Kategori</option>
                            <?php
                                foreach($kategori as $row){
                                    $selected="";
                                    if($artikel['kategori_artikel_kode'] === $row['kode']){
                                        $selected="selected";
                                    }
                                    echo "<option value='".$row['kode']."' $selected>".$row['kategori']."</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class='row mb-6'>
                    <div class='col-lg-10'>
                        <label>Tentang artikel</label>
                        <textarea name='tentang_artikel' id="textStatement"></textarea>
                    </div>
                </div>
                <div class='row mb-6'>
                    <div class='col-lg-8'>
                        <label>Keywords</label>
                        <input type='text' class='form-control keyword' name='keyword'>
                        <div class="valid-feedback" style='display:block'>Setelah mengetik kata kunci, seliahkan tekan enter untuk menyimpannya.</div>
                    </div>
                    <div class='col-lg-4 all_keyword'>
                        <?php
                            $x=1;
                            foreach($keyword as $list_keyword){
                                $id_art_key=$artikel['id']."::".$list_keyword['id'];
                                $token=Crypt::encrypt($id_art_key);
                                echo "<span class='badge bg-info text-white exists_keyword badge_".$x."' style='margin-left:3px;font-size:0.8vw;'>".$list_keyword['keyword']." <span class='remove_keyword hide_keyword hide_keyword_".$x."' data-token='".$token."' data-target='".$x."' style='cursor:pointer;font-weight:bold;' title='hapus'>x</span></span>";
                                $x++;
                            }
                        ?>
                    </div>
                </div>
                <div class='row mb-6'>
                    <div class='col-lg-10'>
                        <label>eDoc Artikel</label>
                        <?php
                            if($artikel['edoc_artikel'] === NULL){
                                $display="block";
                                $required_field="required_field";
                            }else{
                                $required_field="";
                                $display="none";
                                $path="download/".Crypt::encrypt($artikel['edoc_artikel'])."/edoc_artikel";
                                echo "<br /><a href='".$path."' target='_blank'>Download eDoc</a>";
                                echo "<button class='btn btn-danger btn-sm changeDoc' style='float:right;' type='button'>Ganti Dokumen</button>";
                            }
                        ?>
                        <input type='file' class='form-control edoc_artikel <?= $required_field ?>' name='file_artikel' style="display:<?= $display; ?>">
                        <span class='filename_baru' style='color:red;'></span>
                    </div>
                </div>
                <div class='row mb-6'>
                    <div class='col-lg-10'>
                        <hr />
                        <center>
                        <button class='btn btn-info btn-sm saveArtikel' type='submit'>Simpan</button> 
                        <button class='btn btn-danger btn-sm' onClick="loadDataArtikel('view')">Kembali</button>
                        </center>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{!! asset('assets/js/arunika_services.js') !!}"></script>
<script src="{!! asset('assets/js/fn_arunika.js') !!}"></script>
<script>
    $(document).ready(function(){
    $("#textStatement").summernote({
        height: "500px",
      lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video']],
        ['view', ['fullscreen', 'help']],
        ['height', ['height']],
      ],
      codeviewFilter: false,
      codeviewIframeFilter: true
    });
});
$("#textStatement").summernote("code", "<?php echo filter_var(str_replace(array("\n","\r"), '', (str_replace('"', "'", $artikel['tentang_artikel']))), FILTER_SANITIZE_STRING) ?>");
$(document).on('keypress', '.keyword', function(e){
    var value=$(this).val();
    if(value !== ""){
        if(e.which === 13){
            e.preventDefault();
            var badge=$(".list_keyword").length;
            var num_class=badge+1;
            var appended="<span class='badge bg-info text-white list_keyword badge_"+num_class+"' style='margin-left:3px;'>"+value+" <span class='hide_keyword hide_keyword_"+num_class+"' data-target='"+num_class+"' style='cursor:pointer;'>x</span></span>";
            $(".all_keyword").append(appended);
            $(".keyword").val("");
        }
    }
})
$(document).on('click', ".hide_keyword", function(e){
    var target=$(this).data('target');
    $(".badge_"+target).hide('slow');
})
</script>