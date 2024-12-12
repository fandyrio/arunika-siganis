$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token-dashboard"]').attr('content')
    }
});

function validateForm(){
    var not_fix=0;
    var required=$(".required");
    var jlh=$(".required").length;
    $(".required").css({'border':'1px solid black'});
    for(var x=0;x<jlh;x++){
        if($(required[x]).val() ==="" || $(required[x]).val() ===""){
            not_fix++;
            $(required[x]).css({'border':'1px solid red'});
        }
    }
    if(not_fix > 0){
        return false;
    }
    return true;
}
function callSwal(icon, msg, confirmation){
    Swal.fire({
        title: String(icon).charAt(0).toUpperCase()+String(icon).slice(1),
        html:msg,
        icon : icon,
        showConfirmButton: confirmation,
    })
}
$("form").submit(function(e){
    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();
    var validate=validateForm();
    if(validate === false){
        callSwal('error', 'Seluruh Field Harus diisi', true);
        return false;
    }
    var form=$(this);
    var data=new FormData(form[0]);
    $.ajax({
        beforeSend:function(){
            $(".submit_nip").prop('disabled', true).html('Please wait ... ');
        },
        url:$(this).attr('action'),
        type:'POST',
        data:data,
        dataType:'JSON',
        cache:false,
        contentType:false,
        processData:false,
        success:function(data){
            console.log(data);
            $(".submit_nip").prop('disabled', false).html('Submit ');
            var icon="error";
            if(data.status){
                icon="success";
            }
            callSwal(icon, data.msg, true);
            if(data.redir !== ""){
                window.location.href=data.redir;
            }
        }
    })
})