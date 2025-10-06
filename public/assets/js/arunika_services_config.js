$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token-dashboard"]').attr('content')
    }
});

$(document).on('click', ".add-new", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
    // alert(target);
    if(target === "editorial-team"){
        var url="add-new-editor";
        setHeader('Editorial Team', 'Tambah Baru')
    }else if(target === "new-konfigurasi"){
        var url="add-new-config";
        setHeader('Web Content', 'Tambah Baru');
    }else if(target === "checklist-pertanyaan"){
        var url="add-new-pertanyaan";
        setHeader('Checklist Review', 'Tambah Baru');
    }else if(target === "issue-artikel"){
        var url="add-issue-artikel";
        setHeader('Issue Artikel', 'Tambah Baru');
    }else if(target === "pengumuman-arunika"){
        var url="add-pengumuman-arunika";
        setHeader("Pengumuman", "Tambah Baru");
    }

    $.ajax({
        beforeSend:function(){
            showLoading();
        },
        url:url,
        type:'POST',
        success:function(data){
            closeLoading();
            $(".container").html(data);
        }
    })
});
$(document).on('click', ".search-nip-editorial", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var nip=$(".nip").val();
    if(nip === "" || nip === null){
        callSwal('error', 'NIP Harus diisi', false);
        return false;
    }
    $.ajax({
        beforeSend:function(){
            showLoading();
            $(".search-nip").prop('disabled', true).html("Searching ...");
        },
        url:'search-nip-editorial',
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
                $(".token").val(data.data.token);
            }else{
                callSwal('error', data.msg, true);
            }
        }
    })
});
$(document).on("submit", "form", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var validate=validateForm();
    if(validate === false){
        return false;
    }
    var form=$(this);
    var data=new FormData(form[0]);
    $.ajax({
        beforeSend:function(){
            $(".saveArtikel").prop('disabled', true).html('Menyimpan ...');
        },
        url:$(this).attr('action'),
        type:'POST',
        data:data,
        dataType:'JSON',
        cache:false,
        contentType:false,
        processData:false,
        success:function(data){
            $(".saveArtikel").prop('disabled', false).html('Simpan');
            var icon='error';
            if(data.status){
                icon="success";
                if(typeof data.callLink !== "undefined"){
                    callLink(data.callLink);
                }else if(typeof data.btnBack !== "undefined"){
                    console.log(data.btnBack);
                    $("."+data.btnBack).trigger('click');
                }
            }
            callSwal(icon, data.msg, true);
        }
    })
});

$(document).on("click", ".remove_config", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
    var pattern=$(this).data('pattern');
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
            $.post(pattern, {target:target}, function(data){
                if(data.status){
                    // eval(data.callLink);
                    if (data.function && typeof window[data.function] === 'function') {
                        const args = Array.isArray(data.args) ? data.args : [data.args];
                        window[data.function](...args);
                    } else {
                        console.warn("Fungsi tidak ditemukan:", data.function);
                    }
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
$(document).on("change", ".value_file", function(e){
    readURLFileSize(this, 'free', 'value_file')
})
$(document).on("click", ".changeFlyer", function(e){
    $(".file_input").trigger('click');
});
$(document).on("click", ".changeFile", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(".value_file").trigger('click');
})
$(document).on("change", ".file_input", function(e){
    readImageFile(this, 'file_input');
});
$(document).on("change", ".file_pdf", function(e){
    readURLFile(this, "edoc_pengumuman", "file_pdf");
});
$(document).on("click", ".changeEdocPengumuman", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(".file_pdf").trigger('click');
})
$(document).on("click", ".edit", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var pattern=$(this).data('pattern');
    var token_id=$(this).data('token_i');
    // alert(pattern +" "+token_id);
    if(pattern === "issue_artikel"){
        var url="edit-issue-artikel";
        setHeader('Artikel', 'Edit Issue Artikel');
    }else if(pattern === "config"){
        var url="edit-config";
        setHeader("Konfigurasi", "Edit Konfigurasi")
    }else if(pattern === "pengumuman_arunika"){
        var url="edit-pengumuman";
        setHeader("Pengumuman", "Edit Pengumuman");
    }else if(pattern === "issue_artikel"){
        var url="edit-issue-artikel";
        setHeader('Artikel', 'Edit Issue Artikel');
    }else if(pattern === "pertanyaan"){
        var url="edit-pertanyaan";
        setHeader('Config', 'Edit Pertanyaan Artikel');
    }

    $.ajax({
        beforeSend:function(){
            showLoading();
        },
        url:url,
        data:{pattern:pattern, token_id:token_id},
        type:'POST',
        success:function(data){
            closeLoading();
            if(typeof data.status !== "undefined"){
                callSwal('error', data.msg, true);
                return false;
            }
            $(".container").html(data);
        },error:function(data){
            console.log(data);
            closeLoading();
        }
    })
});
$(document).on("click", ".delete", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var pattern=$(this).data('pattern');
    var token_i=$(this).data('token_i');
    if(pattern === "issue_artikel"){
        var url="delete-issue-artikel";
    }else if(pattern === "pengumuman_arunika"){
        var url="delete-pengumuman";
    }else if(pattern === "config"){
        var url="delete-config";
    }
    swal.fire({
        title: "Apakah anda yakin menghapus data ini?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Tidak",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            sweatLoading();
            $.post(url, {token_i:token_i}, function(data){
                if(data.status){
                    if(typeof data.btnBack !== "undefined"){
                        $("."+data.btnBack).trigger('click');
                    }
                    if(typeof data.callLink !== "undefined"){
                        callLink(data.callLink);
                    }
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
$(document).on("click", ".removePegawai", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
    swal.fire({
        title: "<span style='color:red'>Perhatian !. Data yang telah dihapus tidak dapat dikembalikan lagi</span> ",
        text: "Apakah anda yakin ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Tidak",
        reverseButtons: true
    }).then(function(result) {
        if (result.value) {
            sweatLoading();
            $.post('remove-pengguna', {target:target}, function(data){
                if(data.status){
                    // eval(data.callLink);
                    var icon="success";
                    $(".list_menu[data-target='pengguna']").trigger('click');
                    // eval(data.callForm);
                    //$(".btn_place").html("Success sent data");
                }else{
                    var icon="error";
                }
                callSwal(icon, data.msg, true);
                $(".index_"+data.index).remove();
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
});
$(document).on("click", ".backToList", function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var fn=$(this).data('fn');
    var dst=$(this).data('dst');
    window[fn](dst);
})