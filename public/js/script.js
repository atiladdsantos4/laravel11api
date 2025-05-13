$('.money2').mask("#.##0,00", {reverse: true});

function msg(){
   alert('oi');
}


$( window ).resize(function() {
   let w = $(window).width();
   if( w <= 450 ){
       $(".scroll-topw").attr("href","https://api.whatsapp.com/send/?phone=5571999872426&text&type=phone_number&app_absent=0");
    } else {
        $(".scroll-topw").attr("target","_blank");
        $(".scroll-topw").attr("href","https://web.whatsapp.com/send?phone=+5571999872426&text=Olá");
    }
 });