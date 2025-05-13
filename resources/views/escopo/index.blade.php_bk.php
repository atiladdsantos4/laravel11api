
@inject('carbon', 'Carbon\Carbon')
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
                                    <tbody>
                                        @foreach( $lista as $item )
                                        <tr>
                                            <td>{{ $item["esc_id_esc"] }}</td>
                                            <td>{{ $item["esc_title"] }}</td>
                                            <td>{{ $item["esc_posicao"] }}</td>
                                            <td class="ct">{{$carbon::createFromFormat('Y-m-d H:i:s', $item["created_at"])->format('d/m/Y H:i:s')}}</td>
                                            <td class="ct">{{$carbon::createFromFormat('Y-m-d H:i:s', $item["updated_at"])->format('d/m/Y H:i:s')}}</td>
                                            <td class="td_ce tol_escopo_edit"><a href="{{ route('escopo.editar', $item) }}"><i class="fas fa-pen-square text-gray-400 pt" aria-hidden="false"></i></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
@endsection
<script>
  setTimeout(() => { 
        $('.tol_escopo_edit').attr("data-toggle","tooltip"); 
        $('.tol_escopo_edit').attr("data-placement","top");
        $('.tol_escopo_edit').attr("title","Editar Resgistro");
  }, "1000");      
</script>
@php
    $columnDefs=[];
    $classe = new \stdClass;//passando o objeto inteligível pelo script js
    $classe->targets = 1;
    $classe->className = 'dt-body-center dt-head-center';
    array_push($columnDefs,$classe);
    
    $classe = new \stdClass;
    $classe->targets = 2;//numeero da cunoa
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
<script src="{{asset('js/jquery-3.7.1.js')}}"></script>
<link href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" rel="stylesheet">
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="{{ asset('js/script_datatables_simple.js')}}"
   table="tb-escopo" 
   interface="esc_escopo" 
   defs = "{{$defs}}">
</script>

