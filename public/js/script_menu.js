$('input[name=ck_men_ativo]').click(function(){
    if( $(this).is(':checked') ) {
       $("input[name=men_ativo]").val(1);
    } else {
       $("input[name=men_ativo]").val(0);  
    }   
});

/*
$(document).on('click','input[name=tipo_menu]',function(){
    console.log('entrofired'); 
});
*/

$('input[name=tipo_menu]').click(function(){
    debugger;
    $(".rd_invalid").hide();
    //rules para o tip de menu: pai / filho
    let valor =  $('input[name=tipo_menu]:checked').val();
    if( valor == 'menupai'){
       $("input[name=men_pai]").val(1);
       $("input[name=men_filho]").val(0);    
       $("#men_route").removeAttr("required");
       $("#men_filho_pai").val(-1).change();   
    } else {
        //console.log('teste');
        $("input[name=men_pai]").val(0);
        $("input[name=men_filho]").val(1);    
        var attr = $("#men_route").attr('required');
        console.log('attr: '+attr);
        if(  attr !== 'undefined'){
           $("#men_route").attr("required","");
        }  
        if( $("#men_filho_pai").val() == '-1' ){
            $('#men_filho_pai option:eq(0)').prop('selected', true);
        }
    }    
});

$(document).ready(function() {
    console.log('pega aqui');
    $('#dataTable').DataTable( {
        order: false
        // order: [[ 3, 'desc' ], [ 0, 'asc' ]]
    } );
} );

