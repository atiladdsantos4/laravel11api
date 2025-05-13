debugger;
var interface = document.currentScript.getAttribute('interface');
var table = document.currentScript.getAttribute('table');
var defs = document.currentScript.getAttribute('defs');
var campo = document.currentScript.getAttribute('campo');
var id = document.currentScript.getAttribute('data_id');
var definicao =  envio = jQuery.parseJSON(defs);
let host = $(location).attr('hostname');
      let protocolo = $(location).attr('protocol'); 
      let url = null;
if( host.indexOf('localhost') >= 0 ||  host.indexOf('192') >= 0 ){
      if( id == null){
          url = protocolo +'//' + host+'/projetos/laravel11/public/index.php/ajax/listaAjax/'+interface;
      } else {
          url = protocolo +'//' + host+'/projetos/laravel11/public/index.php/ajax/listaAjax/'+interface+'/'+campo+'/'+id;
      }     
}
new DataTable('#'+table, {
    ajax: url,
    columnDefs:definicao,
    /*columnDefs:[
        {
            targets: 1,
            className: "dt-body-center dt-head-center"
        }
    ],*/
    processing: true,
    serverSide: true
});
