$('.iativo').click(function(){
    console.log('log');
    if( $(this).hasClass('fa-toggle-on') ){
      $(this).removeClass('fa-toggle-on');
      $(this).addClass('fa-toggle-off');
      let id = $(this).data("id"); 
      let ativo  = 0;
      altera_status(id,ativo);
      return;
    }
 
    if( $(this).hasClass('fa-toggle-off') ){
      $(this).removeClass('fa-toggle-off');
      $(this).addClass('fa-toggle-on');
      let id = $(this).data("id"); 
      let ativo  = 1;
      altera_status(id,ativo);
      return;
    }
 });

 function esconde(obj){
   //debugger;
   
   let ele = $(obj).attr("id");
   let linha_ref = "linha"+obj.data("id");
   let elefa = obj.children().first();
   if( $('#'+linha_ref).is(':visible') == false  ){
       $(elefa).removeClass("fa-angle-right");
       $(elefa).addClass("fa-angle-down");
       $('#'+linha_ref).slideDown(500);
   } else {
       $(elefa).removeClass("fa-angle-down");
       $(elefa).addClass("fa-angle-right");
       $('#'+linha_ref).slideUp(500);

   }   
 }

 function altera_status(id,ativo){
      debugger;
      var formData = {
          'id': id, 
          'ativo' : ativo
      };
      let host = $(location).attr('hostname');
      let protocolo = $(location).attr('protocol'); 
      let url = null;
      if( host.indexOf('localhost') >= 0 ){
        url = protocolo +'//' + host+'/crud_teste/index.php/produto/inativa';  
      } else {
        url = protocolo +'//' + host+'/neovidas/public/index.php/acolhidos/save';  
      }
      $.post( url, formData)
      .done(function(result) {
          var ret = jQuery.parseJSON(result);
          if( ret.status ){
            if( ativo == 1){
                $('.toast-body').html('Produto Ativado com sucesso!!');   
            } else {
                $('.toast-body').html('Produto Inativado com sucesso!!');   
            }
            
            $('#liveToast').toast({animation: true, delay: 2000});
            $('#liveToast').toast('show');          
            //lert(ret.mensagem);
              // $("#alert-html-success").html(ret.msg)
              // $("#alert-modal-success").css("display","block");
              // $("#alert-modal-success").addClass('show');
              // setTimeout(function(){
              //     $("#alert-modal-success").removeClass('show');
              //     $("#alert-modal-success").css("display","none");
              //     $('#modalAcolhidos').modal('hide');
              //     $('.cl_acolhidos')[0].click();
              // },2500);
          }	
      })                    
      .always(function() {
          return;
      });
 }

function listar_produtos(obj){
    debugger;
    $("#spla").css({"visibility":"visible"});
    let path = $(obj).data("path");
    let path_dest = $(obj).data("path_dest");
    let id_request = $(obj).data("requ");
    let id_response = $(obj).data("resp");
    $("#"+id_response).val('');  
    dados =  $("#"+id_request).val();
    let envio = jQuery.parseJSON(dados);
    var formData = envio;
    let host = $(location).attr('hostname');
    let protocolo = $(location).attr('protocol'); 
    let url = null;
    if( host.indexOf('localhost') >= 0 ){
      url = protocolo +'//' + host+'/crud_teste/index.php'+path;
    } else {
      url = protocolo +'//' + host+'/neovidas/public/index.php/produto/exibir';  
    }
    $.ajax({
          url: url,
          type: 'post',
          data: envio,
          beforeSend: function (request) {
              console.error(request);
              request.setRequestHeader("APIPATH", path_dest);
          },
          success: function (data) {
              var myJsObj = data.replace(/\\/g, "");
              var tam = myJsObj.length;
              var final = myJsObj.substring(1,(tam-1)); 
              teste = jQuery.parseJSON(final);
              let valor =  JSON.stringify(teste, undefined, 4);
              $("#"+id_response).val(valor);   
              $("#spla").css({"visibility":"hidden"});
          },
          error: function(error){
              $("#spla").css({"visibility":"hidden"});
              console.log(error)
          }
      });
} 

function listar_produtos_bk(obj){
  debugger;
  let id_request = $(obj).data("requ");
  let id_response = $(obj).data("resp");
  dados =  $("#"+id_request).val();
  let envio = jQuery.parseJSON(dados);
  var formData = envio;
  // {
  //     'id': id, 
  //     'ativo' : ativo
  // };
  let host = $(location).attr('hostname');
  let protocolo = $(location).attr('protocol'); 
  let url = null;
  if( host.indexOf('localhost') >= 0 ){
    url = protocolo +'//' + host+'/crud_teste/index.php/produto/api/listar_produtos';  
  } else {
    url = protocolo +'//' + host+'/neovidas/public/index.php/produto/exibir';  
  }
  $.post( url, formData)
  .done(function(result) {
       var myJsObj = result.replace(/\\/g, "");
       var tam = myJsObj.length;
       var final = myJsObj.substring(1,(tam-1)); 
       teste = jQuery.parseJSON(final);
       let valor =  JSON.stringify(teste, undefined, 4);
       $("#"+id_response).val(valor);   
       return;
      if( ret.status ){
        var myJsObj1 = {"cabecalho":{"status":200,"mensagem":"Consulta Realizada com Sucesso!!!","page":"2","registros por p\u00e1gina":"6","Total de Registros ":"16"},"retorno":[{"row_id":"7","pro_id":"12","pro_name":"Sandalia Azal\u00e9ia","pro_price":"40.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:18:57","pro_date_update":"2025-02-27 17:18:57","pro_date_delete":null},{"row_id":"8","pro_id":"14","pro_name":"Sapato Cinza","pro_price":"100.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:19:20","pro_date_update":"2025-02-27 17:19:20","pro_date_delete":null},{"row_id":"9","pro_id":"15","pro_name":"Sapato Marron","pro_price":"100.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:19:25","pro_date_update":"2025-02-27 17:19:25","pro_date_delete":null},{"row_id":"10","pro_id":"13","pro_name":"Sapato Petro","pro_price":"100.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:19:13","pro_date_update":"2025-02-27 17:19:13","pro_date_delete":null},{"row_id":"11","pro_id":"7","pro_name":"Sofa","pro_price":"900.30","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:17:10","pro_date_update":"2025-02-27 17:17:10","pro_date_delete":null},{"row_id":"12","pro_id":"5","pro_name":"Televisao 32 pol","pro_price":"2.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:16:45","pro_date_update":"0000-00-00 00:00:00","pro_date_delete":null}]};
        var myJsObj1 =  ret.retorno;
        $("#id_retorno").val(ret.retorno);   
        var myJsObj = myJsObj1.replace(/\\/g, "");
        var pretty = JSON.stringify(myJsObj, undefined, 4);
        //pretty =  pretty.replace(/\\/g, "");
        $("#id_retorno").val('');   
        $("#id_retorno").val(pretty);   
        return;
        if( ativo == 1){
            $("#id_retorno").html('Produto Ativado com sucesso!!');   
        } else {
            $('.toast-body').html('Produto Inativado com sucesso!!');   
        }
        $('#liveToast').toast({animation: true, delay: 2000});
        $('#liveToast').toast('show');          
      }	
  })                    
  .always(function() {
      return;
  });
}