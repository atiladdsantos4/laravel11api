@php
  $data = date('d/m/Y H:i:s');
@endphp
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
                    <h1 class="h3 mb-2 text-gray-800">Usuários </h1>
                    <p class="mb-4">Novo Usuário</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-address-book" aria-hidden="true"></i>&nbsp;Criar Novo Usuário
                            </h6>
                        </div>
                        @if ($errors->any())
                            @include('sb.componentes.alert_erro',["errors" => $errors])
                        @endif

                        <div class="card-body border-left-primary">
                            <form name="form" class="needs-validation" method="POST" action="{{route('usuario.save')}}" novalidate>
                                @csrf 
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="exampleFormControlSelect2">Nome</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="name" name="name" aria-describedby="emailHelp"
                                            value="{{ old('title')}}"
                                            placeholder="Informe Nome do Usuário..." required>
                                            <div class="invalid-feedback">Informe o nome do Usuário.</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                    <label for="exampleFormControlSelect2">Email</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="email" name="email" required> 
                                        <div class="invalid-feedback">Informe o email do Usuário.</div>    
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="exampleFormControlSelect2">Password</label>
                                        <div class="input-group mb-3">
                                            <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" required>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text pt" id="basic-addon1" onclick="muda($(this));" ><i class="fa fa-eye-slash" aria-hidden="true"></i>
                                                </span>
                                            </div>
                                            <div class="invalid-feedback">Informe a senha do Usuário.</div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div style="margin-top:33px;margin-left:18px;">
                                            <input type="checkbox" class="form-control form-check-input"  id="ck_men_ativo" name="ck_men_ativo" checked>
                                            <label style="form-check-label"Zfor="tipo_menu">&nbsp;&nbsp;Usuário Ativo</label>&nbsp;
                                            <div class="invalid-feedback">Informar se Esta Ativo.</div>
                                        </div>    
                                    </div>  
                                    <div class="form-group col-md-2">
                                        <label for="exampleFormControlSelect2">Data de Criação</label>
                                        <input type="text" readonly class="form-control form-control-user"
                                            id="created_at" name="created_at" value="{{ $data }}"> 
                                    </div>
                                </div>  
                                <!-- Divider -->
                                <hr class="sidebar-divider my-0">
                                <br>
                                <div class="row">
                                    <div class="form-group col-md-1">
                                        <button type="submit" class="btn-submit btn btn-primary btn-block">
                                          <i class="fa fa-check" aria-hidden="true"></i>
                                          Salvar
                                        </button>
                                    </div>    
                                    <div class="form-group col-md-2">    
                                        <a href="{{route('usuario.index')}}" type="submit" class="btn-list btn btn-info btn-block">
                                          <i class="fa fa-check" aria-hidden="true"></i>
                                          Listar Usuários 
                                        </a>
                                    </div>    
                                </div>
                            </form>       
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
 <!-- Script Toast -->   

 <!-- Script Validator -->      
 <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
        });
    }, false);
    })();
    
  </script>

 
 {{--@include('sb.componentes.toast',["mes" => 'teste',"bg"=>'bg-gradient-success']);--}}        
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
<!-- tolltips -->
<script>
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
  setTimeout(() => { 
        $('.btn-list,btn_submit').attr("data-toggle","tooltip"); 
        $('.btn-list,btn_submit').attr("data-placement","top");
        $('.btn-list').attr("title","Clique aqui para Listar Usuários ");
        $('.btn-submit').attr("title","Clique aqui para Salvar os Dados");
  }, "1000");      
</script>
<!-- fim tooltips --> 
 
@endsection

