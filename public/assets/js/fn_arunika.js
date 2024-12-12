// const { before } = require("lodash");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token-dashboard"]').attr('content')
    }
});
function showLoading(){
    $("#exampleModal").modal('show');
    $(".modal-dialog").html("<center><img src='assets/image/loading.gif' width='50%'></center>");
}
function closeLoading(){
    setTimeout(function(){
        $("#exampleModal").modal('hide');
    },1500);
}
function setHeader(main, submain){
    $(".main_page").html(main);
    $(".submain_page").html(submain);
}
function loadText(classText){
    $("."+classText).html("<center><h5>Loading</h5></center>");
}
function loadDataPribadi(view){
    //alert($("input[name='token_a']").val());
    $.ajax({
        beforeSend:function(){
            $(".data_pribadi").addClass('active');
            loadText("tab-content-artikel");
        },
        url:'form-data-pribadi',
        type:'POST',
        data:{token:$("input[name='token_a']").val(), view:view},
        success:function(data){
            $(".tab-content-artikel").html(data);
        }
    })
}
function loadDataArtikel(view){
    $.ajax({
        beforeSend:function(){
            loadText("tab-content-artikel");
        },
        url:'form-data-artikel',
        type:'POST',
        data:{token:$("input[name='token_a']").val(), view:view},
        success:function(data){
            if(typeof data.status !== "undefined"){
                callSwal('error', data.msg, true);
                loadDataPribadi('view');
            }else{
                $(".tab-content-artikel").html(data);
                $(".artikel").addClass('active');
            }
        }
    })
}
function callSwal(icon, msg, confirmation){
    Swal.fire({
        title: String(icon).charAt(0).toUpperCase()+String(icon).slice(1),
        html:msg,
        icon : icon,
        showConfirmButton: confirmation,
    })
}
function readURLFile(input, type, className){
    if(input.files && input.files[0]){
        var reader=new FileReader();
        if(type === "image"){
            var allowedType=["image/png", "image/jpeg", "image/jpg"];
            if(allowedType.includes(input.files[0].type) && input.files[0].size <= 3145728 ){
                reader.onload = function(f){
                    $(".imagePreview").html("<center><img src='"+f.target.result+"' width='50%'></center>");
                }
            }else{
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    html: 'Tipe data harus Gambar JPG / PNG dan Maximum File Size 3mb',
                    showConfirmButton: true,
                    // timer: 3000,
                });
                $("."+className).val("");
                //$(".imagePreview").html("");
                return false;
            }
        }else if(type === "edoc_pengumuman"){
            var allowedType=["application/pdf"];
            if(allowedType.includes(input.files[0].type) && input.files[0].size <= 6291456){
                reader.onload = function(f){
                    $(".filename_baru").html("File Baru : <span style='color:red;'>"+input.files[0].name+"</span>");
                }
            }else{
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    html: 'Tipe data PDF dan harus lebih kecil dari 6mb',
                    showConfirmButton: true,
                    // timer: 3000,
                });
                $("."+className).val("");
                //$(".imagePreview").html("");
                return false;
            }

        }else if(type === "edoc_pub"){
            // 'doc' => 'application/msword',
            // 'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            // 'rtf' => 'application/msword',
            // 'odt' => 'application/vnd.oasis.opendocument.text',
            // 'txt' => 'text/plain',
            // 'pdf' => 'application/pdf',
            var allowedType=["application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf"];
            if(allowedType.includes(input.files[0].type) && input.files[0].size <= 6291456){
                swal.fire({
                    title: "Apakah anda yakin mengganti file ini dengan : "+input.files[0].name+" ?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "Tidak",
                    reverseButtons: true
                }).then(function(result) {
                    if (result.value) {
                        var form=$("form")[2];
                        var data=new FormData(form);
                        $.ajax({
                            beforeSend:function(){
                                
                            },
                            url:'update-edoc-pub',
                            type:'POST',
                            dataType:'JSON',
                            data:data,
                            cache:false,
                            processData:false,
                            contentType:false,
                            success:function(data){
                                if(data.status){
                                    eval(data.callForm);
                                    var icon="success";
                                    var label="Diganti";
                                }else{
                                    var icon="error";
                                    var label="Tidak dapat diganti";
                                }
                                swal.fire(
                                    label,
                                    data.msg,
                                    icon
                                )
                            }
                        })
                    } else if (result.dismiss === "cancel") {
                        swal.fire(
                            "Cancelled",
                            "Data Tidak diubah",
                            "error"
                        )
                    }
                });
            }else{
                callSwal("error", "Tipe data harus *.doc / *.docx / *.pdf dan Maximum Ukuran File 6mb", true);
                $("."+className).val("");
                return false;
            }
        }else if(type === "edoc"){
            $(".filename_baru").html("");
            // 'doc' => 'application/msword',
            // 'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            // 'rtf' => 'application/msword',
            // 'odt' => 'application/vnd.oasis.opendocument.text',
            // 'txt' => 'text/plain',
            // 'pdf' => 'application/pdf',
            var allowedType=["application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf"];
            if(allowedType.includes(input.files[0].type) && input.files[0].size <= 6291456){
                $(".filename_baru").html("<br />File baru : "+input.files[0].name);
                return true;
            }else{
                callSwal("error", "Tipe data harus *.doc / *.docx / *.pdf dan Maximum Ukuran File 6mb", true);
                $("."+className).val("");
                return false;
            }
        }else{
            alert("Undefined type");
            return false;
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
}
function readURLFileSize(input, type, className){
    if(input.files && input.files[0]){
        var reader=new FileReader();
    }
    var allowedType=["application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/pdf", "image/png", "image/jpeg", "image/jpg", "image/webp", "image/gif"];
    if(allowedType.includes(input.files[0].type) && input.files[0].size <= 6291456){
        $(".filename_baru").html("<br />File baru : "+input.files[0].name);
        reader.onload = function(f){
            $(".img_preview").html("<center><img src='"+f.target.result+"' width='50%'></center>");
        }
    }else{
        callSwal("error", "Tipe data harus *.doc / *.docx / *.pdf / *.jpg / *.png / *.gif dan Maximum Ukuran File 6mb", true);
        $("."+className).val("");
    }
    reader.readAsDataURL(input.files[0]); // convert to base64 string
}
function readImageFile(input, className){
    if(input.files && input.files[0]){
        var reader=new FileReader();
    }
    var allowedType=["image/png", "image/jpeg", "image/jpg", "image/webp"];
    if(allowedType.includes(input.files[0].type) && input.files[0].size <= 6291456){
        $(".filename_baru").html("<br />File baru : "+input.files[0].name);
        reader.onload = function(f){
            $(".img_flyer").html("<center><img src='"+f.target.result+"' width='50%'></center>");
        }
    }else{
        callSwal("error", "Tipe data harus *.jpg / *.png dan Maximum Ukuran File 6mb", true);
        $("."+className).val("");
    }
    reader.readAsDataURL(input.files[0]); // convert to base64 string
}
function validateForm(){
    var not_fix=0;
    var required=$(".required_field");
    var jlh=$(".required_field").length;
    $(".required_field").css({'border':'1px solid black'});
    for(var x=0;x<jlh;x++){
        if($(required[x]).val() ==="" || $(required[x]).val() ===""){
            not_fix++;
            $(required[x]).css({'border':'1px solid red'});
        }
    }
    if(not_fix > 0){
        callSwal('error', 'Pastikan semua field diisi', true);
        return false;
    }
    return true;
}
function loadDataConfirmation(){
    $.ajax({
        beforeSend:function(){
            loadText("tab-content-artikel");
        },
        url:'view-data-konfirmasi',
        type:'POST',
        data:{token:$("input[name='token_a']").val()},
        success:function(data){
            if(typeof data.status !== "undefined"){
                callSwal('error', data.msg, true);
                loadDataPribadi('view');
            }else{
                $(".tab-content-artikel").html(data);
                $(".confirmation_form").addClass('active');
            }
        }
    })
}
function callLink(url){
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
}

function loadDataFinish(){
    $.ajax({
        beforeSend:function(){
            loadText("tab-content-artikel");
        },
        url:'finish-page-artikel',
        type:'POST',
        data:{token:$("input[name='token_a']").val()},
        success:function(data){
            if(typeof data.status !== "undefined"){
                console.log('sini');
                callSwal('error', data.msg, true);
                loadDataPribadi('view');
            }else{
                $(".tab-content-artikel").html(data);
                $(".tabs").removeClass('active');
                $(".finish").addClass('active');
            }
        }
    })
}

function loadDataDetilArtikel(){
    $.ajax({
        beforeSend:function(){
            loadText('tab-content-detil-artikel');
        },
        url:'data-umum-artikel',
        type:'POST',
        data:{token:$("input[name='token_a']").val()},
        success:function(data){
            $(".tab-content-detil-artikel").html(data);
            $('.data_detil_artikel').addClass('active');
        }
    })
}
function loadDataReview(){
    $.ajax({
        beforeSend:function(){
            loadText('tab-content-detil-artikel');
        },
        url:'data-review',
        type:'POST',
        data:{token:$("input[name='token_a']").val()},
        success:function(data){
            $(".tab-content-detil-artikel").html(data);
            $('.review').addClass('active');
        }
    })
}
function loadDataPublish(){
    $.ajax({
        beforeSend:function(){
            loadText('tab-content-detil-artikel');
        },
        url:'data-publish',
        type:'POST',
        data:{token:$("input[name='token_a']").val()},
        success:function(data){
            $('.tabs').removeClass('active');
            $(".tab-content-detil-artikel").html(data);
            $(".append").html("<li class='nav-item' role='presentation'><button class='nav-link tabs active publsih' data-target='publsih' id='contact-tab' data-bs-toggle='tab' data-bs-target='#bordered-contact' type='button' role='tab' aria-controls='contact' aria-selected='false'>Publsih</button></li>");
            $('.publish').addClass('active');
        }
    })
}
function loadDataReviewAuthor(){
    $.ajax({
        beforeSend:function(){
            loadText('tab-content-artikel');
        },
        url:'data-review-author',
        type:'POST',
        data:{token:$("input[name='token_a']").val()},
        success:function(data){
            $(".tab-content-artikel").html(data);
            $('.review').addClass('active');
        }
    })
}
function onlyCheckOne(checkbox){
    var name=$(checkbox).attr('name');
    $("input[name='"+name+"']").prop('checked', false);
    $(checkbox).prop('checked', true);
}

function checkuncheck(checkbox){
    if($(checkbox).is(':checked')){
        $('.ya').prop('checked', true);
        return false;
    }
    $('.ya').prop('checked', false);
}
function confirmPublsih(){
    var data=$(".confirmPublish").data('target');
    swal.fire({
        title: "<span style='color:red;'>Data yang dipublish tidak dapat diunpublish kemudian</span>",
        text: "Apakah anda yakin untuk Publish Artikel ini ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Tidak",
        reverseButtons: true,
        allowOutsideClick: false
    }).then(function(result) {
        if (result.value) {
            checkingDataPersonal(data);   
        }else if (result.dismiss === "cancel") {
            swal.fire(
                "Cancelled",
                "Data Tidak dipublish",
                "error"
            )
        }
    });
}
function checkingDataPersonal(token_a){
    $.ajax({
        beforeSend:function(){
            swal.fire({
                title: "<span class='fl'><span class='msg_check' style='color:black;text-align:left;font-size:1rem;'><li>Checking Data Pribadi ...<span class='data_pribadi'></span></li><li>Checking Data Artikel ...<span class='data_artikel'></span></li><li>Checking Data Review ...<span class='data_review'></span></li><li>Checking Data Publish ...<span class='data_publish'></span></li></span></span>",
                text: "Please wait ...",
                type: "warning",
                allowOutsideClick: false,
                onOpen: function() {
                    swal.showLoading()
                }
            });
        },
        url:'check-data-personal',
        type:'POST',
        dataType:'JSON',
        data:{token_a:token_a},
        success:function(data){
            //alert(token_a);
            if(data.status){
                $(".data_pribadi").append("<span style='color:green;'>Valid</span>");
                checkDataArtikel(token_a);
            }else{
                checkStop("data_pribadi");  
            }
        }
    })
}
function checkDataArtikel(token_a){
    $.ajax({
        url:'check-data-artikel',
        type:'POST',
        dataType:'JSON',
        data:{token_a:token_a},
        success:function(data){
            if(data.status){
                $(".data_artikel").append("<span style='color:green;'>Valid</span>");
                checkDataReview(token_a);
            }else{
                checkStop("data_artikel", data.msg);  
            }
        }
    })
}
function checkDataReview(token_a){
    $.ajax({
        url:'check-data-review',
        type:'POST',
        dataType:'JSON',
        data:{token_a:token_a},
        success:function(data){
            if(data.status){    
                if(data.warning !== null){
                    $(".data_review").append("<br /><span style='color:orange;'>"+data.warning+"</span>");
                }else{
                    $(".data_review").append("<span style='color:green;'>Valid</span>");
                }
                checkDataPublish(token_a);
            }else{
                checkStop("data_review", data.msg);  
            }
        }
    })
}
function publish(token_a){
    $.ajax({
        url:'publish-artikel',
        type:'POST',
        dataType:'JSON',
        data:{token_a:token_a},
        success:function(data){
            if(data.status){
                callSwal("success", data.msg, true);
                eval(data.callForm);
            }else{
                checkStop("data_publish", data.msg);  
            }
        }
    })
}
function checkDataPublish(token_a){
    $.ajax({
        url:'check-data-publish',
        type:'POST',
        dataType:'JSON',
        data:{token_a:token_a},
        success:function(data){
            if(data.status){
                $(".data_publish").append("<span style='color:green;'>Valid</span>");
                $(".msg_check").append("<br /> Publishing ...");
                publish(token_a);
            }else{
                checkStop("data_publish", data.msg);  
            }
        }
    })
}
function checkStop(step, msg_stop){
    $("."+step).append("<span style='color:red;'>Tidak Valid</span><br /><span style='color:red;font-size:1rem;font-weight:bold;'><ul><li>Tidak lengkap : "+msg_stop+"</li></ul></span>");
    var msg=$(".fl").html();
    swal.fire(
        'Operasi Terhenti',
        msg,
        'error'
    )
    return false;
}