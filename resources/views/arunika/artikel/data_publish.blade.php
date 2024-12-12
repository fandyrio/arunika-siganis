<div class='row mb-3'>
    <div class="col-8" style='min-height:100px;'>
        <!-- <div class="separator separator-dashed separator-border-2 mb-6"></div> --><br />
         @if($data['step'] === 8)
            <span style='float:right;color:green;font-weight:bold;'>
                <span class="far fa-bookmark"></span> <span>Published</span>
            </span>

         @endif
        <h5 style='color:#1BC5BD;font-weight:bold;'>Publish Artikel</h5>
        <table class='table table-hover table-stripped'>
            <tr>
                <th>Judul </th>
                <td>{!! $data['judul'] !!}</td>
            </tr>
            <tr>
                <th>Penulis</th>
                <td>{!! $data['nama'] !!}<br /><span style='color:orange;font-size:1rem;font-weight:bold;'>{!! $data['satker'] !!}</span></td>
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
                <th>Edoc</th>
                <td>
                    <a href="download/{!! Crypt::encrypt($data['edoc']) !!}/edoc_artikel">
                        <span class='far fa-file-word'></span> Download Doc</a>
                    @if($data['step'] === 7)
                        @if(isJM())
                            <form action="update-edoc-pub">
                                <button class='btn btn-success btn-sm changeDocPub' style='float:right;'>Ganti Edoc</button>
                                <br /><br />
                                <input type='hidden' name='token_a' value="{!! Crypt::encrypt($data['id']) !!}">
                                <input type='file' class='form-control edoc_artikel_pub' style='display:none;' name='new_edoc'>
                            </form>
                            <span style='color:red;font-size:1rem;'><b>Catatan : </b>* Mengganti edoc dilakukan apabila ada perbaikan minor yang tidak perlu dilakukan review.</span>
                        @endif
                    @else
                        <br />
                        <a href="download/{!! Crypt::encrypt($data['edoc_pdf']) !!}/edoc_artikel">
                            <span class='far fa-file-pdf'></span> Download PDF</a>
                    @endif
                </td>
            </tr>
            @if($data['name'] !== null)
                <tr>
                    <th>Tema</th>
                    <td>
                        <span style='color:green;font-size:1.2rem;font-weight:bold;'>{!! $data['name'] !!}</span>
                    </td>
                </tr>
            @endif
        </table>
    </div>
    <div class='col-4'>
        <img src="{!! $data['foto_penulis'] !!}" width='100%'>
    </div>
</div>
<div class='row mb-3'>
    <div class='col-12'>
        <hr />
        <h5>Text artikel</h5>
        @php
            $exp=explode('<hr>', $text);
        @endphp
        {!! str_replace('</p>', '</p><br />', $exp[0]) !!}
        <hr />
        @if($data['step'] === 7)
        <a href="preview/{!! Crypt::encrypt($data['id']) !!}" target="_blank"><button class='btn btn-info btn-sm' style='float:right;'><span class='fas fa-search'></span> Preview</button></a>
            @if(isJM())
                @if($data['code_issue'] === null)
                    <button class='btn btn-success btn-sm' disabled><span class='fab fa-telegram-plane'></span> Direct Publish</button>
                @else
                    <button class='btn btn-success btn-sm confirmPublish' data-target="{!! Crypt::encrypt($data['id']) !!}" onClick="confirmPublsih()"><span class='fab fa-telegram-plane'></span> Direct Publish</button>
                @endif
                @if($data['code_issue'] === null)
                    <button class='btn btn-warning btn-sm addTema' data-target="{!! Crypt::encrypt($data['id']) !!}">Masukkan Tema Artikel</button>
                @endif
            @endif
        @endif   
    </div>
</div>
<script src="{!! asset('assets/js/fn_arunika.js?q=5') !!}"></script>
<script src="{!! asset('assets/js/arunika_services.js?q=3') !!}"></script>
<script>
    $(document).ready(function(){
        $("#textTulisan").summernote({
            height:400,
            minHeight: 400,             // set minimum height of editor
            maxHeight: 400,  
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
        });
        //$("#textTulisan").summernote('fontName', 'Times New Roman');
        $('.note-editable').css({'font-family': 'Times New Roman', 'text-align':'justify'});
    }); 
    // $("#textTulisan").summernote("code", "<?php echo filter_var(str_replace(array("\n","\r"), '', (str_replace('"', "'", $text))), FILTER_SANITIZE_STRING) ?>");

</script>