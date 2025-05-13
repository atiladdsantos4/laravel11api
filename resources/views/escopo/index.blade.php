
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
                    <h1 class="h3 mb-2 text-gray-800">Escopos</h1>
                    <p class="mb-4">Listagem de Escopos</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4 border-left-primary">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listagem de Dados</h6>
                            <div class="float-right">
                                <a href="{{route('escopo.novo')}}" class="btn btn-primary btn-block">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Novo Escopo
                                </a>
                            </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tb-escopo" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nome Escopo</th>
                                            <th>Posição Menu</th>
                                            <th>Criação</th>
                                            <th>Modificação</th>
                                            <th class="td_ce">Ação</th>
                                        </tr>
                                    </thead>
                                    <!-- <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nome Escopo</th>
                                            <th>Posição Menu</th>
                                            <th>Criação</th>
                                            <th>Modificação</th>

                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper Atila -->
@include('sb.componentes.modal_exclui',["field_pk" => 'esc_id_esc', "rota" => route('escopo.delete')])
@if( session::has('message') )  
    @include('sb.componentes.toast',["mes" => session::get('message'),"bg"=>'bg-gradient-success' ]);        
    <script>
        setTimeout(() => {
            
            $('#liveToast').toast({animation: true, delay: 2000});
            $('#liveToast').toast('show');

            $('#liveToast').on('hidden.bs.toast', function () {
                window.location.href='index';
            })


        }, "1000");    
    </script>   
@endif        
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
            $("#esc_id_esc").val(valor);
            $("#excluiModal").modal('show');
        }    
    });
</script>       
<script src="{{asset('js/jquery-3.7.1.js')}}"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> 
<script src="{{ asset('js/script_datatables_simple.js')}}"
   table="tb-escopo" 
   interface="Escopo" 
   defs = "{{$defs}}">
</script>
@endsection

