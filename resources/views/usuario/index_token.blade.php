
@inject('carbon', 'Carbon\Carbon')
@inject('session', 'Session')
@extends('template')
@section('title', 'Tables')
@section('content')
@php echo 'id:'.isset($id) ? $id : null; @endphp
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tokens dos Usuários </h1>
                    <p class="mb-4">Listagem de Tokens dos Usuários </p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4 border-left-primary">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listagem de Tokens dos Usuários </h6>
                            <div class="float-right">
                                <a href="{{route('usuario.novo')}}" class="btn btn-primary btn-block">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Novo Usuário
                                </a>
                            </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tb-token" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Type</th>
                                            <th>Usuário</th>
                                            <th>Name</th>
                                            <th>Token</th>
                                            <th>Habilidades</th>
                                            <th>Última<br>Utilização</th>
                                            <th>Expira em</th>
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
@include('sb.componentes.modal_password',["rota" => route('usuario.pwd')])
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
    $("#tb-token").css("font-size","12px");
    $(document).on('click','.tol_passwd',function(e){
        if( $(this).hasClass('tol_passwd') ){
            console.log('fired tol_passwd');
            $("#m-email").val('');
            $("#id_token").val('');
            $("#password").val('');
            let valor =  $(this).parent().data("email")
            $("#m-email").val(valor);
            $("#email").val(valor);
            $("#generatePwd").modal('show');
        }    
    });

    function muda(obj){
        if( $(obj).children().hasClass("fa-eye-slash") ){
            $(obj).children().removeClass('fa-eye-slash');
            $(obj).children().addClass('fa-eye');
            $('#password').attr("type","text");
            return;
        } 

        if( $(obj).children().hasClass("fa-eye") ){
            $(obj).children().removeClass('fa-eye');
            $(obj).children().addClass('fa-eye-slash');
            $('#password').attr("type","password");
            return;
        } 
    } 

    function gerar_token(){
        
        const data = { 
                       'email': $("#email").val(),
                       'password': $("#password").val(), 
                     };
        let config = {
            method: "POST",
            maxBodyLength: Infinity,
            url: "{{ route('usuario.pwd') }}",
            headers: { 
            'Content-Type': 'application/json',
            },
            data : data,
        };

        axios.request(config)
        .then((response) => {
            if(response.data.status){
               $("#id_token").val(response.data.token);
            } else {
                $(".invalid-feedback").html(response.data.message)
                $(".invalid-feedback").show();
                setTimeout(() => {
                    $(".invalid-feedback").hide();
                },3000);
            }   
        })
        .catch((error) => {
            null;
        });
    }
</script>       
<script src="{{asset('js/jquery-3.7.1.js')}}"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script> 
@if( $id != null )
console.log('issetid');
<script src="{{ asset('js/script_datatables_simple.js?v=1222')}}"
   table="tb-token" 
   interface="PersonalToken" 
   data_id = "{{$id}}" 
   campo ="{{$campo}}" 
   defs = "{{$defs}}">
</script>
@else
console.log('sem issetid');
<script src="{{ asset('js/script_datatables_simple.js?v=1222')}}"
   table="tb-token" 
   interface="PersonalToken" 
   defs = "{{$defs}}">
</script>
@endif 
@endsection

