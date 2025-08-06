$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token-web"]').attr('content')
    }
});
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
})
setTimeout(function(){
        var skleton=$(".skleton_loading");
        var jumlah_skleton=$(".skleton_loading").length;
        runImg(jumlah_skleton, skleton);
    },1000)
async function runImg(jumlah_skleton, skleton){
    for(var x=0;x<jumlah_skleton;x++){
        // console.log(x);
        var target=$(skleton[x]).data('target');
        var width=450;
        var height=250;
        // var width=$(skleton[x]).width();
        // var height=$(skleton[x]).height();
        var prefix=$(skleton[x]).data('prefix');
        var type="artikel-img";
        //alert(width+"x"+height);
        let printFoto=await setPhoto(width, height, target, type, x, prefix, skleton);
    }
}
async function setPhoto(width, height, target, type, x, prefix, skleton){
    const baseURL = window.location.pathname;
    if(baseURL.includes('issue') || baseURL.includes('category') || baseURL.includes('tags')){
        var url="../img";
    }else{
        var url="img";
    }
    $.ajax({
        url:url+'/'+target+'?w='+width+'&h='+height+'&q=90',
        data:{width:width, height:height, target:target, type:type, prefix:prefix},
        dataType:'JSON',
        type:'GET',
        success:function(data){
        // console.log(x);
        $(".skleton_loading[data-target='"+target+"']").addClass('foto_penulis');
        $(".skleton_loading[data-target='"+target+"']").removeClass('skleton_loading');
        // console.log("background-image:url('img/20241210031407-ari.jpg')");
        $(skleton[x]).css({"background-image":"url('"+data.background+"')"});
        }
    })
}

$(".yearRunning").html(new Date().getFullYear());
    var loadingScreen = document.querySelector(".loadingScreen");
    window.addEventListener('load', function() {
      loadingScreen.style.display = 'none';
    });
    
// var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
// var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
//     return new bootstrap.Tooltip(tooltipTriggerEl)
// })