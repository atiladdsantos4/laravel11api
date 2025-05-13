function blogs_api(obj){//oficial//
  debugger;
  $("#spla").css({"visibility":"visible"});
  let path = $(obj).data("path");
  let path_dest = $(obj).data("path_dest");
  let id_request = $(obj).data("requ");
  let id_response = $(obj).data("resp");
  let method = $(obj).data("dest_method");
  $("#"+id_response).val('');  
  dados =  $("#"+id_request).val();
  let envio = jQuery.parseJSON(dados);
  //envio.method = method;
  var formData = envio;
  let host = $(location).attr('hostname');
  let protocolo = $(location).attr('protocol'); 
  let url = null;
  if( host.indexOf('localhost') >= 0 ){
      url = protocolo +'//' + host+'/crud_teste/index.php'+path_dest;
  } else {
      url = protocolo +'//' + host+'/neovidas/public/index.php/produto/exibir';  
  }
  //const axios = require('axios');
  let data = envio;
  /*JSON.stringify({
    "rou_id_tab": "17",
    "rou_desc": "Editar Rota",
    "rou_method": "PUT",
    "rou_path": "/routes/listar_routesapi",
    "rou_path_dest": "/routes_api/update/$1",
    "rou_params": "{}",
    "rou_request": "{}",
    "rou_js_script": "listar_routes($(this))",
    "rou_date_creation": "",
    "rou_date_update": ""
  });*/

  let config = {
    method: method,
    maxBodyLength: Infinity,
    //url: 'localhost/crud_teste/index.php/routes/new',
    url: url,
    headers: { 
      'Content-Type': 'application/json',
      'Authorization': document.getElementsByName('oauth_token')[0].getAttribute('content')
    },
    data : data
  };

  axios.request(config)
  .then((response) => {
    console.log(JSON.stringify(response.data));
    teste = response.data; 
    let valor =  JSON.stringify(teste, undefined, 4);
    $("#"+id_response).val(valor);   
    $("#spla").css({"visibility":"hidden"});
  })
  .catch((error) => {
    console.log(error);
  });
}

function GerarTokenOauth2(obj){
    //atender a geração do token//
    debugger;
    let path = '/user/hash';
    let id =  $(obj).data("id");
    let host = $(location).attr('hostname');
    let protocolo = $(location).attr('protocol'); 
    url = protocolo +'//' + host+'/crud_teste/index.php'+path; 
    let user = $("#param"+id+'1').val(); 
    let pass = $("#param"+id+'2').val(); 
    let dados = { 
                  username : user,
                  password : pass 
                };
    let config = {
        method: 'POST',
        maxBodyLength: Infinity,
        url: url,
        headers: { 
          'Content-Type': 'application/json',
          'Authorization': 'Bearer 2f075f8715327cf17da420ac47ce5e12e7138d17'
        },
        data : dados
    };
    axios.request(config)
    .then((response) => {
        let auth = response.data;
        let path =  $(obj).data("path_dest");
        let id =  $(obj).data("id");
        let id_request = $(obj).data("requ");
        let id_response = $(obj).data("resp");
        dados =  $("#"+id_request).val();
        let envio = jQuery.parseJSON(dados);
        url = protocolo +'//' + host+'/crud_teste/index.php'+path;
        let config = {
            method: 'POST',
            maxBodyLength: Infinity,
            url: url,
            headers: { 
              'Content-Type': 'application/x-www-form-urlencoded',
              'Authorization': auth
            },
            data : envio
        }          
        axios.request(config)
            .then((response) => {
                console.log(JSON.stringify(response.data));
                // teste = response.data; 
                let valor =  JSON.stringify(response.data, undefined, 4);
                $("#"+id_response).val(valor);   
                let auth_token = "Bearer "+response.data.access_token;
                document.getElementsByName('oauth_token')[0].setAttribute('content',auth_token);
                $("#spla").css({"visibility":"hidden"});
            })
            .catch((error) => {
                console.log(error.response);
                let valor =  JSON.stringify(error.response.data, undefined, 4);
                $("#"+id_response).val(valor);   
            });
    })
    .catch((error) => {
       console.log(error);
    });
    return;
}

function listar_routes_api1(obj){
    debugger;
    $("#spla").css({"visibility":"visible"});
    let indice = $(obj).data("id");
    let path = $(obj).data("path");
    let path_dest = $(obj).data("path_dest");
    let id_request = $(obj).data("requ");
    let id_response = $(obj).data("resp");
    let method = $(obj).data("dest_method");
    let parametros = $(obj).data("params");
    let path_params = '';
    if( parametros > 0 ){
       for(i=0; i < parametros; i++){
            if( i == 1){
               path_params = i; 
            } else {
               path_params +=','+i;  
            } 
        }
        let valor = $("#param"+indice).val(); 
        let caminho = path_dest;
        path_dest = caminho.replace(/[$1]+/g, valor);
        path_dest = path_dest;
    } 
    $("#"+id_response).val('');  
    dados =  $("#"+id_request).val();
    let envio = jQuery.parseJSON(dados);
    let teste = encodeURIComponent(envio);
    
    //envio.method = method;
    var formData = envio;
    let host = $(location).attr('hostname');
    let protocolo = $(location).attr('protocol'); 
    let url = null;
    if( host.indexOf('localhost') >= 0 ){
      if( method == "GET" ){
        url = protocolo +'//' + host+'/crud_teste/index.php'+path_dest+'?parameters='+JSON.stringify(dados);
      } else {
        url = protocolo +'//' + host+'/crud_teste/index.php'+ path_dest;
      } 
      url = protocolo +'//' + host+'/crud_teste/index.php'+ path_dest;
    } else {
      url = protocolo +'//' + host+'/neovidas/public/index.php/routes/exibir';  
    }
    $.ajax({
          url: url,
          type: method,
          data: envio,
          dataType: 'json',
          contentType: "application/json; charset=utf-8",
          beforeSend: function (request) {
              console.error(request);
              request.setRequestHeader("APIPATH", path_dest);
              request.setRequestHeader("APIMETHOD", method);
              request.setRequestHeader("APIPARAMS", path_params);
          },
          success: function (data) {
             /* 
             var myJsObj = data.replace(/\\n/g, "");
              myJsObj = data.replace(/\\/g, "");
              var tam = myJsObj.length;
              var final = myJsObj.substring(1,(tam-1)); 
              console.log(final);
              teste = jQuery.parseJSON(final);//final
              */
              let valor =  JSON.stringify(data, undefined, 4);
              $("#"+id_response).val(valor);   
              $("#spla").css({"visibility":"hidden"});
          },
          error: function(error){
              let valor =  JSON.stringify(error, undefined, 4);
              $("#"+id_response).val(valor);   
              $("#spla").css({"visibility":"hidden"});
              $("#spla").css({"visibility":"hidden"});
              console.log(error)
          }
      })
}

function listar_routes(obj){
    debugger;
    $("#spla").css({"visibility":"visible"});
    let indice = $(obj).data("id");
    let path = $(obj).data("path");
    let path_dest = $(obj).data("path_dest");
    let id_request = $(obj).data("requ");
    let id_response = $(obj).data("resp");
    let method = $(obj).data("dest_method");
    let parametros = $(obj).data("params");
    let path_params = '';
    if( parametros > 0 ){
       for(i=0; i < parametros; i++){
            if( i == 1){
               path_params = i; 
            } else {
               path_params +=','+i;  
            } 
        }
        let valor = $("#param"+indice).val(); 
        let caminho = path_dest;
        path_dest = caminho.replace(/[$1]+/g, valor);
        path_dest = path_dest;
    } 
    $("#"+id_response).val('');  
    dados =  $("#"+id_request).val();
    let envio = jQuery.parseJSON(dados);
    //envio.method = method;
    var formData = envio;
    let host = $(location).attr('hostname');
    let protocolo = $(location).attr('protocol'); 
    let url = null;
    if( host.indexOf('localhost') >= 0 ){
      url = protocolo +'//' + host+'/crud_teste/index.php'+path;
    } else {
      url = protocolo +'//' + host+'/neovidas/public/index.php/routes/exibir';  
    }
    $.ajax({
          url: url,
          type: 'POST',
          data: envio,
          beforeSend: function (request) {
              console.error(request);
              request.setRequestHeader("APIPATH", path_dest);
              request.setRequestHeader("APIMETHOD", method);
              request.setRequestHeader("APIPARAMS", path_params);
          },
          success: function (data) {
              var myJsObj = data.replace(/\\n/g, "");
              myJsObj = data.replace(/\\/g, "");
              var tam = myJsObj.length;
              var final = myJsObj.substring(1,(tam-1)); 
              console.log(final);
              //Teste ={"cabecalho":{"status":200,"mesagem":"Cosulta Realizada com Sucesso!!!","page":"todas","registros por págia":"4","Total de Registros ":"4"},"retoro":[{"rou_id":"1","rou_id_tab":"8","rou_desc":"Pesquisa de Produtos","rou_method":"POST","rou_path":"/produto/api/listar_produtos","rou_path_dest":"/produto/exibir","rou_params":"{"status": 1,"todos" : "false","limit" : "6","page" : "2"}","rou_request":"{"status": 1,   "todos" : "false",   "limit" : "6",   "page" : "2"}","rou_js_script":"listar_produtos($(this))","rou_date_creatio":"2025-03-10 14:51:41","rou_date_update":ull,"tabela_referecia":"pro_produto"},{"rou_id":"2","rou_id_tab":"3","rou_desc":"Geração de Toke","rou_method":"POST","rou_path":"/logi/api/get_toke","rou_path_dest":"/logi/auth","rou_params":"{  "cpf":"54543304500",  "email":"atiladdsatos4@gmail.com",  "seha":"123456"     }","rou_request":"{  "cpf":"54543304500",  "email":"atiladdsatos4@gmail.com",  "seha":"123456"     }","rou_js_script":"getToke($(this))","rou_date_creatio":"2025-03-11 12:22:27","rou_date_update":ull,"tabela_referecia":"log_logi"},{"rou_id":"3","rou_id_tab":"17","rou_desc":"Cotroles de Rotas","rou_method":"GET","rou_path":"/routes/listar_routesapi","rou_path_dest":"/routes_api","rou_params":" {   "cpf":"54543304500",   "email":"atiladdsatos4@gmail.com",   "seha":"123456"      }","rou_request":" {   "cpf":"54543304500",   "email":"atiladdsatos4@gmail.com",   "seha":"123456"      }","rou_js_script":"listar_routes($(this))","rou_date_creatio":ull,"rou_date_update":ull,"tabela_referecia":"rou_routes_api"},{"rou_id":"4","rou_id_tab":"17","rou_desc":"Nova Rota","rou_method":"GET","rou_path":"/routes/listar_routesapi","rou_path_dest":"/routes_api/ew","rou_params":" {   "cpf":"54543304500",   "email":"atiladdsatos4@gmail.com",   "seha":"123456"      }","rou_request":" {   "cpf":"54543304500",   "email":"atiladdsatos4@gmail.com",   "seha":"123456"      }","rou_js_script":"listar_routes($(this))","rou_date_creatio":ull,"rou_date_update":ull,"tabela_referecia":"rou_routes_api"}]};
              teste = jQuery.parseJSON(final);//final
              
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