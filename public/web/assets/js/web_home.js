$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token-web"]').attr('content')
    }
});
  if (document.getElementById('state1')) {
    const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));
    if (!countUp.error) {
      countUp.start();
    } else {
      //console.error(countUp.error);
    }
  }
  if (document.getElementById('state2')) {
    const countUp1 = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));
    if (!countUp1.error) {
      countUp1.start();
    } else {
      //console.error(countUp1.error);
    }
  }
  if (document.getElementById('state3')) {
    const countUp2 = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));
    if (!countUp2.error) {
      countUp2.start();
    } else {
      //console.error(countUp2.error);
    };
  }
  var loadingScreen = document.querySelector(".loadingScreen");
  window.addEventListener('load', function() {
    loadingScreen.style.display = 'none';
    setTimeout(function(){
      
    }, 2000)
    
  });
  var jumlah_skleton=$(".skleton_loading").length;
  var skleton=$(".skleton_loading");
  runImg(jumlah_skleton, skleton);
  async function runImg(jumlah_skleton, skleton){
    for(var x=0;x<jumlah_skleton;x++){
      //console.log(x);
      var target=$(skleton[x]).data('target');
      var width=$(skleton[x]).width();
      var height=$(skleton[x]).height();
      var prefix=$(skleton[x]).data('prefix');
      var type="artikel-img";
      // alert(width+"x"+height);
      let printFoto=await setPhoto(width, height, target, type, x, prefix);
    }
  }
  async function setPhoto(width, height, target, type, x, prefix){
    $.ajax({
        url:'img/'+target+'?w='+width+'&h='+height+'&q=90',
        type:'GET',
        dataType:'json',
        success:function(data){
          // console.log(data);
          $(".skleton_loading[data-target='"+target+"']").addClass('foto_penulis');
          $(".skleton_loading[data-target='"+target+"']").removeClass('skleton_loading');
          //console.log("background-image:url('"+data.background+"')");
          $(skleton[x]).css({"background-image":"url('"+data.background+"')"});
        },error:function(data){
          console.log("err");
        }
      })
  }
$(".text-hover").mouseenter(function(e){
  e.preventDefault();
  e.stopPropagation();
  var target=$(this).data('target');
  var index=$(this).data('idx');
  var classSelector=target+"_"+index;
  if($("."+classSelector).hasClass('img_kecil')){
    $("."+target+"_"+index).css({'transform':'scale(1.1)'});
  }else{
    $("."+target+"_"+index).css({'transform':'scale(1.02)'});
  }
})
$(".text-hover").mouseleave(function(e){
  e.preventDefault();
  e.stopPropagation();
  var target=$(this).data('target');
  var index=$(this).data('idx');
  $("."+target+"_"+index).css({'transform':'scale(1)'});
  $("."+target+"_"+index).css({'transform':''});
});

function earlyView(){
  swal.fire({
    title: "<span>Perhatian !. Artikel ini sedang dalam proses persiapan publish.</span> ",
    text: "Artikel ini belum dapat dibaca",
    icon: "warning",
    showConfirmButton: true,
  })
}
const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
  if (isMobile) {
    //alert('mobile');
    $(".arunika_top").addClass('arunika_top_mob');
    $(".arunika_top_mob").removeClass('arunika_top');
    $(".btn-wb").addClass('btn-mob-100');
    $(".f_lat_ar_img").addClass('f_lat_ar_img_mob');
    $(".f_lat_ar_txt").addClass('f_lat_ar_txt_mob');
    $(".lat_ar_img").addClass('lat_ar_img_mob');
    $(".lat_ar_txt").addClass('lat_ar_txt_mob');
    $(".h_lat_ar").addClass('h_lat_ar_mob');
    $(".padding_lat_ar").addClass('padding_lat_ar_mob');
    $(".artikel_title").addClass('artikel_title_mob');
    $(".sisi2_").hide();
    $(".sisi2_mob").show();
  }else{
    $(".foto_besar").attr({width:'100%'});
    $(".sisi2_mob").hide();
    $(".sisi2_").show();
  }

$("#earlyView").click(function(e){
    e.preventDefault();
    earlyView();
})
$(".yearRunning").html(new Date().getFullYear());