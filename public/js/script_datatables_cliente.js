let host = $(location).attr('hostname');
      let protocolo = $(location).attr('protocol'); 
      let url = null;
if( host.indexOf('localhost') >= 0 ){
         url = protocolo +'//' + host+'/crud_teste/index.php/cliente/listaClienteAjax';
}
new DataTable('#tb-cliente', {
    ajax: url,
    processing: true,
    serverSide: true
});