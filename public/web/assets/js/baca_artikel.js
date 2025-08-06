
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token-web"]').attr('content')
      }
    });
    var x=0;
    setTimeout(function(e){
      $.post('{!! url("validate-reader") !!}', {token:"{!! Crypt::encrypt($artikel['id']) !!}"}, function(data)
      {
          //console.log('validate');
      });
    }, 90000);

    var jumlah_skleton=$(".skleton_loading").length;
    var skleton=$(".skleton_loading");
    runImg(jumlah_skleton, skleton);
    async function runImg(jumlah_skleton, skleton){
      for(var x=0;x<jumlah_skleton;x++){
        //console.log(x);
        var target=$(skleton[x]).data('target');
        var width=$(skleton[x]).width();
        var height=width-20;
        $(skleton[x]).css({'height':height});
        var prefix=$(skleton[x]).data('prefix');
        var type="artikel-img";
        //console.log(width+"x"+height);
        let printFoto=await setPhoto(width, height, target, type, x, prefix);
      }
    }
    async function setPhoto(width, height, target, type, x, prefix){
        var base_url=window.location.pathname;
        if(base_url.includes('baca-artikel')){
            var url="../../img";
        }else{
            var url="img";
        }
      $.ajax({
          url:url+"/"+target+"?w="+width+"&h="+height+"&q=90",
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
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    if (isMobile) {
      //alert('mobile');
      $(".text_mob").show();
      $(".text_desktop").hide();
      $(".navbar-brand").hide();
      $(".navbar-brand-mob").show();
      $(".foto_besar").attr({width:'100%'});
    }else{
      $(".text_mob").hide();
      $(".text_desktop").show();
      $(".navbar-brand-mob").hide();
      $(".navbar-brand").show();
      $(".foto_besar").attr({width:'100%'});
    }
    // console.log($(".all_div").width());
    function copyClipboard() {
      // Get the text field
      var copyText = document.getElementById("webURL");

      // Select the text field
      copyText.select();
      copyText.setSelectionRange(0, 99999); // For mobile devices

      // Copy the text inside the text field
      navigator.clipboard.writeText(copyText.value);

      // Alert the copied text
      swal.fire({
        position: "bottom-end",
        text: "Link Copied",
        showConfirmButton: false,
        timer:1500,
      })
    }
  $(".copyClipBoard").click(function(e){
    e.preventDefault();
    copyClipboard();
  })