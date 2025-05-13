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
                    <h1 class="h3 mb-2 text-gray-800">Menus</h1>
                    <p class="mb-4">Editar Menu</p>
                    <!-- men_id,  ,  , 
                         , , , 
                         , , men_data_folder, 
                         men_classe_js, men_is_href, , 
                         men_ul_id, men_data_criacao -->
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">
                                <i class="fa fa-address-book" aria-hidden="true"></i>&nbsp;Editar Menu
                            </h6>
                        </div>
                        <div class="card-body border-left-primary">
                            <form name="form" class="needs-validation" method="POST" action="{{route('menu.edit',$dados->men_id)}}" novalidate>
                                @csrf 
                                <input type="hidden" name="men_pai" value="{{$dados->men_pai}}">
                                <input type="hidden" name="men_filho" value="{{$dados->men_filho}}">
                                <input type="hidden" id="men_ativo" name="men_ativo" value="{{ $dados->men_ativo == 1 ? 1 : 0}}">
                                <input type="hidden" id="men_ul_id" name="men_ul_id" value="{{$dados->men_ul_id}}">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="exampleFormControlSelect2">Escopo do Menu</label>
                                        <select class="form-control"  id="men_id_esc" name="men_id_esc" required>
                                            <option value="">Selecione o Escopo</option>
                                            @foreach($escopo as $item)
                                             @if( $item->esc_id_esc == $dados->men_id_esc )
                                              <option selected value="{{$item->esc_id_esc}}">{{$item->esc_title}}</option>
                                             @else
                                              <option value="{{$item->esc_id_esc}}">{{$item->esc_title}}</option>
                                             @endif
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Informe o Escopo.</div>    
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="exampleFormControlSelect2">Menu Pai</label>
                                        @php echo 'pai_filho:'.$dados->men_filho_pai; @endphp
                                        <select class="form-control"  id="men_filho_pai" name="men_filho_pai" required>
                                            <option value="">Selecione o Menu Pai</option>    
                                            @if( is_null($dados->men_filho_pai) )
                                               <option value="-1">Será um Menu Pai</option>
                                            @else 
                                               <option selected value="">Selecione o Menu Pai</option>
                                            @endif
                                            @foreach($menu as $item)
                                              @if( $item->men_id == $dados->men_filho_pai )
                                                <option selected value="{{$item->men_id}}">{{$item->men_name}}</option>
                                              @else
                                                <option value="{{$item->men_id}}">{{$item->men_name}}</option> 
                                              @endif  
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Informe o Menu de Referência.</div>    
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="exampleFormControlSelect2">Informe o nome do Menu</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="men_name" name="men_name" aria-describedby="emailHelp"
                                            placeholder="Informe Nome do Menu..." required value="{{$dados->men_name}}">
                                            <div class="invalid-feedback">Informe o nome do Menu.</div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div style="margin-top:43px;">
                                            <div class="form-check form-check-inline">
                                                @if( $dados->men_pai == 1)
                                                 <input class="form-check-input" type="radio" name="tipo_menu" id="inlineRadio1" value="menupai" checked required>
                                                @else 
                                                 <input class="form-check-input" type="radio" name="tipo_menu" id="inlineRadio1" value="menupai" required>
                                                @endif
                                                <label class="form-check-label" for="inlineRadio1">Menu Pai</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                @if( $dados->men_filho == 1)
                                                <input class="form-check-input" type="radio" name="tipo_menu" id="inlineRadio2" value="menufilho" checked required>
                                                @else 
                                                <input class="form-check-input" type="radio" name="tipo_menu" id="inlineRadio2" value="menufilho" required>
                                                @endif
                                                <label class="form-check-label" for="inlineRadio2">Menu Filho</label>
                                            </div>
                                            <div class=" rd_invalid invalid-feedback">Informe se o Menu é pai ou Filho.</div>  
                                        </div>    
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label for="exampleFormControlSelect2">Posição do Menu (Pai)</label>
                                        <input type="number" class="form-control form-control-user"
                                            id="men_position" name="men_position" required value="{{$dados->men_position}}"> 
                                        <div class="invalid-feedback">Informe a posição do Menu(Pai).</div>    
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="exampleFormControlSelect2">Posição do Menu (Filho)</label>
                                        <input type="number" class="form-control form-control-user"
                                            id="men_filho_position" name="men_filho_position" required value="{{$dados->men_filho_position}}">  
                                        <div class="invalid-feedback">Informe a posição do Menu Filho.</div>    
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="exampleFormControlSelect2">Folder Menu</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="men_data_folder" name="men_data_folder" aria-describedby="emailHelp"
                                            placeholder="Informe Folder do Menu..." value="{{$dados->men_data_folder}}">
                                            <div class="invalid-feedback">Informe o Folder Menu</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div style="margin-top:33px;margin-left:18px;">
                                            <input type="checkbox" class="form-control form-check-input"  id="ck_men_ativo" name="ck_men_ativo" checked>
                                            <label style="form-check-label" for="tipo_menu">&nbsp;&nbsp;Ativo</label>&nbsp;
                                            <div class="invalid-feedback">Informar se Esta Ativo.</div>
                                        </div>    
                                    </div>                                
                                    <div class="form-group col-md-3">
                                            <label for="exampleFormControlSelect2">Id de Referência</label>
                                            <input type="text" class="form-control form-control-user"
                                                id="men_data_ref" name="men_data_ref" aria-describedby="emailHelp"
                                                placeholder="Informe Id de Referência..." required value="{{$dados->men_data_ref}}">
                                                <div class="invalid-feedback">Informe o Id de Referência.</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="exampleFormControlSelect2">Rota do Menu</label>
                                        <input type="text" class="form-control form-control-user"
                                            id="men_route" name="men_route" aria-describedby="emailHelp"
                                            placeholder="Informe Id de Referência..." value="{{$dados->men_route}}" required>
                                            <div class="rd_rota invalid-feedback">Informe a Rota do Menu.</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                            <label for="exampleFormControlSelect2">Criação</label>
                                            <input type="text" readonly class="form-control form-control-user"
                                                id="men_data_criacao" name="men_data_criacao" value="{{ $data }}"> 
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
                                        <a href="{{route('menu.index')}}" type="submit" class="btn-list btn btn-info btn-block">
                                          <i class="fa fa-check" aria-hidden="true"></i>
                                          Listar Menus
                                        </a>
                                    </div>
                                    <div class="invalid-feedback">Informe Menu.</div>     
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
                if( $('input[name=tipo_menu]:checked').length == 0 ){
                    $(".rd_invalid").show();
                }    
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
                window.location.href="{{route('menu.index')}}";
            })


        }, "1000");    
    </script>   
@endif
<!-- tolltips -->
<script>
  setTimeout(() => { 
        $('.btn-list,btn_submit').attr("data-toggle","tooltip"); 
        $('.btn-list,btn_submit').attr("data-placement","top");
        $('.btn-list').attr("title","Clique aqui para Listar Menus");
        $('.btn-submit').attr("title","Clique aqui para Salvar os Dados");
        $('input[name=ck_men_ativo]').click(function(){
            if( $(this).is(':checked') ) {
               $("input[name=men_ativo]").val(1);
            } else {
               $("input[name=men_ativo]").val(0);  
            }   
        });

        $('input[name=tipo_menu]').click(function(){
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
  }, "1000");      
</script>
<!-- fim tooltips --> 

<!--
  <div class="custom-control custom-radio">
    <input type="radio" class="custom-control-input" id="customControlValidation2" name="radio-stacked" required>
    <label class="custom-control-label" for="customControlValidation2">Toggle this custom radio</label>
  </div>
  <div class="custom-control custom-radio mb-3">
    <input type="radio" class="custom-control-input" id="customControlValidation3" name="radio-stacked" required>
    <label class="custom-control-label" for="customControlValidation3">Or toggle this other custom radio</label>
    <div class="invalid-feedback">More example invalid feedback text</div>
  </div>
-->

<!-- <style>
    input[type="checkbox"] {
        width: 20px;
        height: 20px;
    }
</style>  -->
 
@endsection

