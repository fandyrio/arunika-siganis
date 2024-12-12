function callImage(index) {
  console.log("callImage");
    var nextIndex=index+1;
    var slides=$(".mySlides");
    var dots=$(".dot");
    var numSlides=$(".mySlides").length;
    if(nextIndex>numSlides-1){
      nextIndex=0;
    }
    $(".dot").removeClass('active');
    $(".mySlides").css('display', 'none');
    $(slides[index]).css('display', 'block');
    $(dots[index]).addClass('active');
  setTimeout(function()
  {
    callImage(nextIndex);
  }, 15000)
}
callImage(0);