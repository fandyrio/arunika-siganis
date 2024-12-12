$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token-dashboard"]').attr('content')
    }
});

$(".add-new").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var target=$(this).data('target');
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
$(".search-nip").click(function(e){
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
                    $("."+data.btnBack).trigger('click');
                }
            }
            callSwal(icon, data.msg, true);
        }
    })
});

$(".remove_config").click(function(e){
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
});
$(".value_file").change(function(e){
    readURLFileSize(this, 'free', 'value_file')
})
$(".changeFlyer").click(function(e){
    $(".file_input").trigger('click');
});
$(".changeFile").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(".value_file").trigger('click');
})
$(".file_input").change(function(e){
    readImageFile(this, 'file_input');
});
$(".file_pdf").change(function(e){
    readURLFile(this, "edoc_pengumuman", "file_pdf");
});
$(".changeEdocPengumuman").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    $(".file_pdf").trigger('click');
})
$(".edit").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var pattern=$(this).data('pattern');
    var token_id=$(this).data('token_i');
    //alert(pattern +" "+token_id);
    if(pattern === "issue_artikel"){
        var url="edit-issue-artikel";
        setHeader('Artikel', 'Edit Issue Artikel');
    }else if(pattern === "config"){
        var url="edit-config";
        setHeader("Konfigurasi", "Edit Konfigurasi")
    }else if(pattern === "pengumuman_arunika"){
        var url="edit-pengumuman";
        setHeader("Pengumuman", "Edit Pengumuman");
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
        }
    })
});
$(".delete").click(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var pattern=$(this).data('pattern');
    var token_i=$(this).data('token_i');
    if(pattern === "issue_artikel"){
        var url="delete-issue-artikel";
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
})