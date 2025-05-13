
 function getToken(obj){
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
            //console.info(data);
        },
        error: function(error){
            console.log(error)
        }
   });
  /*
  $.post( url, formData)
  .done(function(result) {
       var myJsObj = result.replace(/\\/g, "");
       var tam = myJsObj.length;
       var final = myJsObj.substring(1,(tam-1)); 
       teste = jQuery.parseJSON(final);
       let valor =  JSON.stringify(teste, undefined, 4);
       $("#"+id_response).val(valor);   
       return;
    //   if( ret.status ){
    //     var myJsObj1 = {"cabecalho":{"status":200,"mensagem":"Consulta Realizada com Sucesso!!!","page":"2","registros por p\u00e1gina":"6","Total de Registros ":"16"},"retorno":[{"row_id":"7","pro_id":"12","pro_name":"Sandalia Azal\u00e9ia","pro_price":"40.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:18:57","pro_date_update":"2025-02-27 17:18:57","pro_date_delete":null},{"row_id":"8","pro_id":"14","pro_name":"Sapato Cinza","pro_price":"100.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:19:20","pro_date_update":"2025-02-27 17:19:20","pro_date_delete":null},{"row_id":"9","pro_id":"15","pro_name":"Sapato Marron","pro_price":"100.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:19:25","pro_date_update":"2025-02-27 17:19:25","pro_date_delete":null},{"row_id":"10","pro_id":"13","pro_name":"Sapato Petro","pro_price":"100.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:19:13","pro_date_update":"2025-02-27 17:19:13","pro_date_delete":null},{"row_id":"11","pro_id":"7","pro_name":"Sofa","pro_price":"900.30","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:17:10","pro_date_update":"2025-02-27 17:17:10","pro_date_delete":null},{"row_id":"12","pro_id":"5","pro_name":"Televisao 32 pol","pro_price":"2.00","pro_ativo":"1","pro_deleted":"0","pro_date_creation":"2025-02-27 17:16:45","pro_date_update":"0000-00-00 00:00:00","pro_date_delete":null}]};
    //     var myJsObj1 =  ret.retorno;
    //     $("#id_retorno").val(ret.retorno);   
    //     var myJsObj = myJsObj1.replace(/\\/g, "");
    //     var pretty = JSON.stringify(myJsObj, undefined, 4);
    //     //pretty =  pretty.replace(/\\/g, "");
    //     $("#id_retorno").val('');   
    //     $("#id_retorno").val(pretty);   
    //     return;
    //     if( ativo == 1){
    //         $("#id_retorno").html('Produto Ativado com sucesso!!');   
    //     } else {
    //         $('.toast-body').html('Produto Inativado com sucesso!!');   
    //     }
    //     $('#liveToast').toast({animation: true, delay: 2000});
    //     $('#liveToast').toast('show');          
    //   }	
  })                    
  .always(function() {
      return;
  });
  */
}