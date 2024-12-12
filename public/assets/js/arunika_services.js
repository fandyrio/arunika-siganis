//const { before } = require("lodash");

//const { before } = require("lodash");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token-dashboard"]').attr('content')
    }
});
$(document).on("click",".list_menu", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(".list_menu").removeClass('menu-item-active');
    $(this).addClass('menu-item-active');
    var target=$(this).data('target');
    if(target === "artikel_baru"){
        var endpoint=$(this).data('endpoint');
        var url="form-new-artikel/"+endpoint;
        setHeader('Artikel', 'Tambah Artikel');
    }else if(target === "editorial_team"){
        var url='list-editorial-team'
        setHeader('Config', 'Editorial Team');
    }else if(target === "config_web"){
        var url="list-config-web";
        setHeader('Config', 'Konfigurasi Web Content')
    }else if(target === "list_artikel_proses"){
        var url="list-artikel-proses";
        setHeader('Artikel', 'Artikel Proses');
    }else if(target === "list_artikel_proses_reviewer"){
        var url="list-artikel-proses-reviewer";
        setHeader('Artikel', 'Artikel Proses  - Reviewer');
    }else if(target === "list_artikel_proses_jm"){
        var url="list-artikel-proses-jm";
        setHeader('Artikel', 'Artikel Proses - Jurnal Manager');
    }else if(target === "checklist_review"){
        var link=$(this).data('token_p');
        var url="list-pertanyaan-review/"+link;
        setHeader('Config', 'Checklist Review');
    }else if(target === "list_artikel_publish_jm"){
        var url="link-artikel-publish-jm";
        setHeader('Artikel', 'Artikel yang Publish');
    }else if(target === "list_artikel_selesai_review"){
        var url="list-artikel-selesai-review";
        setHeader('Artikel', 'Artikel yang Selesai di review');
    }else if(target === "list_artikel_waiting_publish_jm"){
        var url="list-artikel-waiting-publish";
        setHeader('Artikel', 'Artikel yang akan dipublish');
    }else if(target === "list_artikel_publish"){
        var url = "list-artikel-publish";
        setHeader('Artikel', 'List Artikel yang dipublish');
    }else if(target === "list_issue_artikel"){
        var url="list-issue-artikel";
        setHeader('Tema Artikel', 'Daftar Tema Artikel');
    }else if(target === "list_pengumuman"){
        var url="list-pengumuman";
        setHeader("Pengumuman", "Daftar Pengumuman Arunika");
    }else if(target === "draft"){
        var url="list-draft";
        setHeader('Draft', "Daftar Draft Artikel")
    }
    $.ajax({
        beforeSend:function(){
            showLoading();
        },
        url:url,
        type:'GET',
        success:function(data){
            closeLoading();
            $(".container").html(data);
        }
    })
})
$(".search-nip").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var nip=$(".nip_baru").val();
    if(nip === "" || nip === null){
        callSwal('error', 'NIP Harus diisi', false);
        return false;
    }
    $.ajax({
        beforeSend:function(){
            showLoading();
            $(".search-nip").prop('disabled', true).html("Searching ...");
        },
        url:'search-nip',
        type:'POST',
        data:{nip:nip},
        dataType:'JSON',
        success:function(data){
            closeLoading();
            $(".search-nip").prop('disabled', false).html("Cari NIP");
            console.log(data);
            if(data.status){
                $(".nama_hakim").val(data.data.nama);
                $(".pangkat_hakim").val(data.data.pangkat);
                $(".kontak_hakim").val(data.data.no_hp);
                $(".jabatan_hakim").val(data.data.jabatan);
                $(".satker_hakim").val(data.data.satker);
            }else{
                callSwal('error', data.msg, true);
            }
        }
    })
});
$(".foto_hakim").change(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    readURLFile(this, "image", "foto_hakim");  
});
$(".edoc_artikel").change(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();   
    var read = readURLFile(this, 'edoc', 'edoc_artikel');
})
$(".changeDoc").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(".edoc_artikel").trigger('click');
});
$(".edoc_artikel_pub").change(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();   
    readURLFile(this, 'edoc_pub', 'edoc_artikel_pub');
})
$(".changeDocPub").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(".edoc_artikel_pub").trigger('click');
})
$("form").submit(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var validate=validateForm();
    if(validate === false){
        return false;
    }
    var form=$(this);
    var data=new FormData(form[0]);
    var target=$(this).data('target');
    if(target === "artikel"){
        var jlh_keyword=$(".list_keyword").length;
        console.log(jlh_keyword);
        var keyword=$(".list_keyword");
        var exists=$(".exists_keyword");
        var jlh_exists=$(".exists_keyword").length;
        if(jlh_keyword === 0 && jlh_exists === 0){
            callSwal("error", "Keyword Harus diisi", true);
            return false;
        }else{
            var list_keyword=[];
            var deleted_keyword=0;
            for(var x=0;x<jlh_keyword;x++){
                if($(keyword[x]).css('display') === "none"){
                    list_keyword[x]=$(keyword[x]).text()+" removed";
                    deleted_keyword+=1;
                }else{
                    list_keyword[x]=$(keyword[x]).text();
                }
            }
            if(deleted_keyword === jlh_keyword && jlh_exists === 0){
                callSwal("error", "Keyword Harus diisi", true);
                return false;
            }
            data.append('list_keyword', JSON.stringify(list_keyword));
        }
        if($("#textStatement").val() === ""){
            callSwal("error", "Tentang artikel harus diisi", true);
            return false;
        }
    }
    data.append('token_a', $("input[name='token_a']").val());
    $.ajax({
        beforeSend:function(){
            $(".saveArtikel").prop('disabled', true).html("Menyimpan ...");
        },
        url:$(this).attr('action'),
        data:data,
        type:'POST',
        dataType:'JSON',
        cache:false,
        processData:false,
        contentType:false,
        success:function(data){
            $(".saveArtikel").prop('disabled', false).html("Simpan");
            var icon='error';
            if(data.status){
                icon='success';
                if(data.token_id !== null){
                    $(".token_a").val(data.token_id);
                }
                if(typeof data.callForm !== "undefined"){
                    eval(data.callForm);
                }
                if(typeof data.callLink !== "undefined"){
                    eval(data.callLink);
                }
            }
            if(typeof data.closeModal !== "undefined"){
                if(data.closeModal === true){
                    $(".modal").modal('hide');
                }
            }
            callSwal(icon, data.msg, true);
        }
    })
});

$(document).on("click",".tabs", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(".tabs").removeClass('active');
    var target=$(this).data('target');
    if(target === 'data_pribadi'){
        loadDataPribadi('view');
    }else if(target === "artikel"){
        loadDataArtikel('view');
    }else if(target === "confirmation"){
        loadDataConfirmation();
    }else if(target === "finish"){
        loadDataFinish();
    }else if(target === "data_detil_artikel"){
        loadDataDetilArtikel();
    }else if(target === "review"){
        loadDataReview();
    }else if(target === "review-author"){
        loadDataReviewAuthor();
    }else if(target === "publsih"){
        loadDataPublish();
    }
});
$(".remove_keyword").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
    var token=$(this).data('token');
    $.ajax({
        beforeSend:function(){
        },
        url:'remove-keyword',
        type:'POST',
        data:{token:token},
        dataType:'JSON',
        success:function(data){
            var icon="error";
            if(data.status){
                icon="success";
                $(".badge_"+target).hide('slow');
            }
            callSwal(icon, data.msg, true);
        }
    })
});
$(".agreement").change(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    if($(".agreement").is(':checked')){
        $(".btn-send").prop('disabled', false);
    }else{
        $(".btn-send").prop('disabled', true);
    }
});

$(".btn-send").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $.ajax({
        beforeSend:function(){
            $(".btn-send").prop('disabled', true).html('Mengirim ...');
        },
        url:'send-artikel',
        type:'POST',
        data:{token:$("input[name='token_a']").val()},
        dataType:'JSON',
        success:function(data){
            var icon = "error";
            if(data.status){
                icon = "success";
                loadDataFinish();
            }
            callSwal(icon, data.msg, true);
        }
    })
});
$(".detil_artikel").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
    $.ajax({
        beforeSend:function(){
            $(".detil_artikel").prop('disabled', true).html('Waiting ...');
        },
        url:'detil-artikel/'+target,
        type:'GET',
        success:function(data){
            $(".container").html(data);
        }
    })
});
$(".addReviewer").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $.ajax({
        beforeSend:function(){
            $("#modal-data-review").modal('show');
            $(".modal-body").html("Loading ...");
            $(".modal-title").html('Tambah Reviewer');
        },
        url:'form-tambah-reviewer',
        type:'POST',
        data:{token:$("input[name='token_a']").val()},
        success:function(data){
            $(".modal-body").html(data);
        }
    })
});

$(".addTema").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
    $.ajax({
        beforeSend:function(){
            $("#modal-data-review").modal('show');
            $(".modal-body").html("Loading ...");
            $(".modal-title").html('Tema Artikel');
        },
        url:'form-tambah-tema',
        type:'POST',
        data:{token:target},
        success:function(data){
            $(".modal-body").html(data);
        }
    })
})

$(".addReview").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var view="";
    var index=0;
    if(typeof $(this).data('view') !== "undefined"){
        view=$(this).data('view');
    }
    if(typeof $(this).data('index') !== "undefined"){
        index=$(this).data('index');
    }
    var input=$("input[name='token_r[]']");
    $.ajax({
        beforeSend:function(){
            $("#modal-data-review").modal('show');
            $(".modal-body").html("Loading ...");
            $(".modal-title").html('Review Artikel');
        },
        url:'form-tambah-review',
        type:'POST',
        data:{token:$("input[name='token_a']").val(), target:$(input[index]).val(), view:view, index:index},
        success:function(data){
            $(".modal-body").html(data);
        }
    })
});
$(".hasilReview").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var index=$(this).data('index');
    var input=$("input[name='token_r[]']");
    $.ajax({
        beforeSend:function(){
            $("#modal-data-review").modal('show');
            $(".modal-body").html("Loading ...");
            $(".modal-title").html('Review Artikel');
        },
        url:'form-tambah-hasil-review',
        type:'POST',
        data:{token:$("input[name='token_a']").val(), target:$(input[index]).val()},
        success:function(data){
            $(".modal-body").html(data);
        }
    })
});
$(".cancelPublish").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var token_a=$(this).data('token_a');
    var token_r=$(this).data('token_r');
    $.ajax({
        beforeSend:function(){
            $("#modal-data-review").modal('show');
            $(".modal-body").html("Loading ...");
            $(".modal-title").html('Review Artikel');
        },
        url:'form-cancel-publish',
        type:'POST',
        data:{token_a:token_a, token_r:token_r},
        success:function(data){
            $(".modal-body").html(data);
        }
    })

})
$(".tgl_selesai").change(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var tgl_mulai=$(".tgl_mulai").val();
    var tgl_selesai=$(".tgl_selesai").val();
    var date1=new Date(tgl_mulai);
    var date2=new Date(tgl_selesai);
    if(date1>date2){
        callSwal('error', 'Tanggal Selesai harus lebih lama atau sama dengan tanggal estimasi selesai', true);
        $(".tgl_selesai").val("");
        return false;
    }
});
$(".editHasilReview").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target_id=$(this).data('target');
    var index=$(this).data('index');
    var input=$("input[name='token_r[]']");
    $.ajax({
        beforeSend:function(){
            $("#modal-data-review").modal('show');
            $(".modal-body").html("Loading ...");
            $(".modal-title").html('Review Artikel');
        },
        url:'form-tambah-hasil-review',
        type:'POST',
        data:{token:$("input[name='token_a']").val(), target:$(input[index]).val(), 'target_id':target_id},
        success:function(data){
            $(".modal-body").html(data);
        }
    })
});
$(".sendReviewToAuthor").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var attr=$(this).data('link');
    var token=$(this).data('token');
    var target=$(this).data('target');
    swal.fire({
        title: "<span style='color:red'>Perhatian !. Data yang telah dikirim tidak dapat diubah kembali</span> ",
        text: "Apakah anda yakin ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Tidak",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.post(attr, {token:token, target:target}, function(data){
                if(data.status){
                    eval(data.callLink);
                    var icon="success";
                    eval(data.callForm);
                    $(".btn_place").html("Success sent data");
                }else{
                    var icon="error";
                }
                callSwal(icon, data.msg, true);
            })
            // result.dismiss can be "cancel", "overlay",
            // "close", and "timer"
        } else if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelled",
                "Permintaan dibatalkan",
                "error"
            )
        }
    })
})
$(".addNotesToAuthor").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var index=$(this).data('index');
    var input=$("input[name='token_r[]']");
    $.ajax({
        beforeSend:function(){
            $("#modal-data-review").modal('show');
            $(".modal-body").html("Loading ...");
            $(".modal-title").html('Review Artikel');
        },
        url:'form-tambah-catatan',
        type:'POST',
        data:{token:$("input[name='token_a']").val(), target:$(input[index]).val()},
        success:function(data){
            $(".modal-body").html(data);
        }
    })
});
$(".removeHasil").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target_id=$(this).data('target');
    var index=$(this).data('index');
    var input=$("input[name='token_r[]']");
    swal.fire({
        title: "Apakah anda yakin?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Tidak",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.post('remove-hasil-review', {target_id:target_id, token:$("input[name='token_a']").val(), target:$(input[index]).val()}, function(data){
                if(data.status){
                    eval(data.callLink);
                    var icon="success";
                    var label="Dihapus";
                }else{
                    var icon="error";
                    var label="Tidak dapat dihapus";
                }
                swal.fire(
                    label,
                    data.msg,
                    icon
                )
            })
            // result.dismiss can be "cancel", "overlay",
            // "close", and "timer"
        } else if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelled",
                "Data Tidak dihapus",
                "error"
            )
        }
    });
})
$(".hapusEdoc").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target_id=$(this).data('target');
    var token=$(this).data('artikel');
    swal.fire({
        title: "Apakah anda yakin?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Tidak",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.post('remove-edoc-perbaikan', {target_id:target_id, token:token}, function(data){
                if(data.status){
                    eval(data.callForm);
                    var icon="success";
                    var label="Dihapus";
                }else{
                    var icon="error";
                    var label="Tidak dapat dihapus";
                }
                swal.fire(
                    label,
                    data.msg,
                    icon
                )
            })
            // result.dismiss can be "cancel", "overlay",
            // "close", and "timer"
        } else if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelled",
                "Data Tidak dihapus",
                "error"
            )
        }
    });
});
$(".acceptToPublish").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var token_a=$(this).data('token_a');
    var token_r=$(this).data('token_r');

    swal.fire({
        title: "Apakah anda yakin untuk melanjutkan ke proses Publish?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Tidak",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.post('accept-to-publish', {token_a:token_a, token_r:token_r}, function(data){
                if(data.status){
                    eval(data.callForm);
                    var icon="success";
                    var label="Dihapus";
                }else{
                    var icon="error";
                    var label="Terjadi kesalahan sistem";
                }
                swal.fire(
                    label,
                    data.msg,
                    icon
                )
            })
            // result.dismiss can be "cancel", "overlay",
            // "close", and "timer"
        } else if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelled",
                "Dibatalkan",
                "error"
            )
        }
    });
})
$(".directPublish").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
    swal.fire({
        title: "Apakah anda yakin untuk melanjutkan ke proses Publish?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Tidak",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            $.post('direct-to-publish', {target:target}, function(data){
                if(data.status){
                    eval(data.callForm);
                    var icon="success";
                    var label="Dihapus";
                }else{
                    var icon="error";
                    var label="Terjadi kesalahan sistem";
                }
                swal.fire(
                    label,
                    data.msg,
                    icon
                )
            })
            // result.dismiss can be "cancel", "overlay",
            // "close", and "timer"
        } else if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelled",
                "Dibatalkan",
                "error"
            )
        }
    });
})
$(".driven").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
    $(".review_stage").hide('slow');
    var jlh_icon=$(".icon_change_").length;
    for(x=0;x<jlh_icon;x++){
        if(x !== target){
            if($(".icon_change_"+x).hasClass('fa-chevron-down')){
                $(".icon_change_"+x).removeClass('fa-chevron-down');
                $(".icon_change_"+x).addClass('fa-chevron-right');
            }
        }
    }
    $(".text_keterangan_").html("Lihat Detil")
    if($(".icon_change_"+target).hasClass('fa-chevron-right')){
        $('.icon_change_'+target).removeClass('fa-chevron-right');
        $(".icon_change_"+target).addClass('fa-chevron-down');
        $(".text_keterangan_"+target).html("Tutup Detil");
        $(".review_"+target).show('slow');
    }else{
        $('.icon_change_'+target).removeClass('fa-chevron-down');
        $(".icon_change_"+target).addClass('fa-chevron-right');
        $(".text_keterangan_"+target).html("Lihat detil")
        $(".review_"+target).hide('slow');
    }
});
$(".edit").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var pattern=$(this).data('pattern');
    var token_id=$(this).data('token_i');
    if(pattern === "issue_artikel"){
        var url="edit-issue-artikel";
        setHeader('Artikel', 'Edit Issue Artikel');
    }

    $.ajax({
        beforeSend:function(){
            showLoading();
        },
        url:url,
        data:{pattern:pattern, token_id:token_id},
        type:'POST',
        success:function(data){
            if(typeof data.status !== "undefined"){
                callSwal('error', data.msg, true);
                return false;
            }
            $(".container").html(data);
        }
    })
});

