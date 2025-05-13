debugger;
var interface = document.currentScript.getAttribute('interface');
var tb = document.currentScript.getAttribute('table');
var defs = document.currentScript.getAttribute('defs');
var cols =  document.currentScript.getAttribute('cols');
var detalhes =  document.currentScript.getAttribute('scriptjs');
var definicao =  envio = jQuery.parseJSON(defs);
var colunas =  envio = jQuery.parseJSON(cols);

let host = $(location).attr('hostname');
      let protocolo = $(location).attr('protocol'); 
      let url = null;

      if( host.indexOf('localhost') >= 0 ){
         url = protocolo +'//' + host+'/crud_teste/index.php/clientapp/listaAjax/'+interface;
}

const table = new DataTable('#'+tb, {
    ajax: url,
    columnDefs:definicao,
    columns:colunas,
    /*columns: [
        {
             class: 'dt-control',
             orderable: false,
             data: null,
             className: "dt-body-center dt-head-center",  
             defaultContent: ''
        },
        { data: 'client_id' },
        { data: 'user_id' },
        { data: 'access_token' },
        { data: 'scope' },
        { data: 'expires' },
        { data: 'acao' },
    ],
    */
    processing: true,
    serverSide: true
});

function format(d) { //--> Drilldown
    //let saida  = detalhes;
    let saida  = '<span style="width:121px;" class="badge bg-secondary">Criação</span>' + d.cli_date_creation + '<br>';
        saida += '<span style="width:121px;" class="badge bg-info">Última Atualização</span>' + d.cli_date_update + '<br>';
        saida += '<span style="width:121px;" class="badge bg-warning">Tipo</span>' + (d.cli_type == 1 ? 'Pessoa Físicia' : 'Pessoa Jurídica') + '<br>';
        //saida += 'The child row can contain any data you wish, including links, images, inner tables etc.'
    return (
        saida 
    );
}

/*
const table = new DataTable('#tb-clientes', {
    ajax: url,
    columnDefs: [
        {
            targets: -1,
            className: 'dt-body-center dt-head-center'
        },
        {
            targets: 0,
            className: 'dt-body-center dt-head-center'
        },
        {
            targets: 1,
            className: 'dt-body-center dt-head-center'
        },
        {
            targets: 3,
            className: 'dt-body-center dt-head-center'
        }

    ],   
     columns: [
         {
              class: 'dt-control',
              orderable: false,
              data: null,
              defaultContent: ''
         },
         { data: 'cli_type' },
         { data: 'cli_name' },
         { data: 'cli_cpf_cnpj' },
         { data: 'cli_ativo' }
     ],
    order: [[1, 'asc']],
    processing: true,
    serverSide: true
});

*/
// Array to track the ids of the details displayed rows
const detailRows = [];
 
table.on('click', 'tbody td.dt-control', function () {
    let tr = event.target.closest('tr');
    let row = table.row(tr);
    let idx = detailRows.indexOf(tr.id);
 
    if (row.child.isShown()) {
        tr.classList.remove('details');
        row.child.hide();
 
        // Remove from the 'open' array
        detailRows.splice(idx, 1);
    }
    else {
        tr.classList.add('details');
        row.child(format(row.data())).show();
 
        // Add to the 'open' array
        if (idx === -1) {
            detailRows.push(tr.id);
        }
    }
});

// On each draw, loop over the `detailRows` array and show any child rows
table.on('draw', () => {
    detailRows.forEach((id, i) => {
        let el = document.querySelector('#' + id + ' td.dt-control');
 
        if (el) {
            el.dispatchEvent(new Event('click', { bubbles: true }));
        }
    });
});



/*
Example
const table = new DataTable('#tb-clientes', {
    ajax: url,
    columnDefs: [
        {
            targets: -1,
            className: 'dt-body-center dt-head-center'
        },
        {
            targets: 0,
            className: 'dt-body-center dt-head-center'
        },
        {
            targets: 1,
            className: 'dt-body-center dt-head-center'
        },
        {
            targets: 3,
            className: 'dt-body-center dt-head-center'
        }

    ],   
     columns: [
         {
              class: 'dt-control',
              orderable: false,
              data: null,
              defaultContent: ''
         },
         { data: 'cli_type' },
         { data: 'cli_name' },
         { data: 'cli_cpf_cnpj' },
         { data: 'cli_ativo' }
     ],
    order: [[1, 'asc']],
    processing: true,
    serverSide: true
});
*/