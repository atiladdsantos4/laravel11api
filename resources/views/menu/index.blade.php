@inject('carbon', 'Carbon\Carbon')
@inject('session', 'Session')
@extends('template')
@section('title', 'Tables')
@section('content')
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Menus</h1>
                    <p--class="mb-4">Listagem de Menus</p--class=>
 
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listagem de Dados</h6>
                            <div class="float-right">
                                <a href="{{route('menu.novo')}}" class="btn btn-primary btn-block">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Novo Menu
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tb-menu" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nome Menu</th>
                                            <th>Menu Pai</th>
                                            <th>Escopo</th>
                                            <th>Criação</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <!-- <tr>
                                            <th>Id</th>
                                            <th>Nome Menu</th>
                                            <th>Menu Pai</th>
                                            <th>Escopo</th>
                                            <th>Criação</th>
                                            <th>Ação</th>
                                        </tr> -->
                                    </tfoot>
                                    <tbody>
                                        <?php foreach( $lista as $item ){
                                        //var_dump($lista);    
                                        echo '<tr>';
                                        echo '<td>'.$item->men_id.'</td>';
                                        echo '<td>'.$item->men_name.'</td>';
                                        // $item->getMenuPai();
                                        // $item->getEscopo();
                                        // $menu_pai = $item->menu_nome_pai !== null ? $item->menu_nome_pai->men_name : null;
                                        echo '<td>'.$item->menu_nome_pai.'</td>';
                                        //$escopo = isset($item->menu_escopo) ? $item->menu_escopo["esc_title"]: null;
                                        echo '<td>'.$item->menu_escopo.'</td>';
                                        echo '<td class="ct">'.$carbon::createFromFormat('Y-m-d H:i:s', $item->men_data_criacao)->format('d/m/Y H:i:s').'</td>';
                                        echo '<td class="td_ce tol_menu_edit"><a href="'. route('menu.novo') .' "><i class="fas fa-pen-square text-gray-400 pt" aria-hidden="false"></i></a></td>';
                                        echo '</tr>';
                                        } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
@include('sb.componentes.modal_exclui',["field_pk" => 'men_id', "rota" => route('menu.delete')])
@php
    $columnDefs=[];
    $classe = new \stdClass;//passando o objeto inteligível pelo script js
    $classe->targets = 2;
    $classe->className = 'dt-body-center dt-head-center';
    array_push($columnDefs,$classe);
    
    $classe = new \stdClass;
    $classe->targets = 5;//numeero da cunoa
    $classe->className = 'dt-body-center dt-head-center';
    array_push($columnDefs,$classe);
    //$columnDefs=[]; informar um array vazio se naço quiser custonizar ainhamento das colunas
    $defs = json_encode( $columnDefs);
@endphp
<!--
   table     = "tb-oauth" id do objeto html <table>
   interface = "index_back" -> define qual ajax sera invocado na controler AjaxController 
   defs      =  array de objetos de definção das colunas
-->
@include('sb.layouts.scripts_datatables_index')
<script>
    $(document).on('click','.tol_escopo_delete',function(e){
        if( $(this).hasClass('tol_escopo_delete') ){
            console.log('fired tol_escopo_delete');
            let valor =  $(this).parent().data("id")
            $("#men_id").val(valor);
            $("#excluiModal").modal('show');
        }    
    });
</script>       
<script src="{{asset('js/jquery-3.7.1.js')}}"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> -->
<script src="{{ asset('js/script_datatables_simple.js')}}"
   table="tb-menu" 
   interface="Menu" 
   defs = "{{$defs}}">
</script>
@endsection

