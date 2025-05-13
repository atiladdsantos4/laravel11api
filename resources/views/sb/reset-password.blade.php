@inject('session', 'Session')
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Forgot Password</title>

    <!-- Custom fonts for this template-->
    <script src="{{asset('js/jquery-3.7.1.js')}}"></script>
    <link href="{{asset('sb/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('sb/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    @include('sb.layouts.scripts_bootstrap5')

    <!-- <link href="css/sb-admin-2.min.css" rel="stylesheet"> -->

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                               <img style="height:100%;width:100%;" src="{{ asset('sb/img/background_login.png')}}">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Redefinição de senha </h1>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('password.change') }}">
                                        @csrf 
                                        <input type="hidden" name="email" value="{{ $email }}"> 
                                        <input type="hidden" name="token" value="{{ $token }}"> 
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <input type="password" class="form-control form-control-user"
                                                        id="password" name="password" aria-describedby="emailHelp"
                                                        placeholder="Informe a  nova senha...">
                                                        
                                                </div>
                                                <div class="col-md-1">
                                                <i style="margin-top:17px;" id="eye1" onclick="muda($(this));" class="pointer fa fa-eye-slash" aria-hidden="true"></i>
                                                </div>    
                                            </div>
                                        </div>
                                        <div class="form-group">
                                               <div class="row">
                                                    <div class="col-md-11">
                                                        <input type="password" class="form-control form-control-user"
                                                            id="password_confirmation" name="password_confirmation" aria-describedby="emailHelp"
                                                            placeholder="Confirme  a nova senha...">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <i style="margin-top:17px;" id="eye2" onclick="muda($(this));" class="pointer fa fa-eye-slash" aria-hidden="true"></i>
                                                    </div> 
                                               </div>
                                         </div>       
                                        <button class="btn btn-primary btn-user btn-block" type="submit">
                                            Reset Password
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{route('index.login')}}"">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    
</body>
@if( session::has('message') )  
    @include('sb.componentes.toast',["mes" => session::get('message'),"bg"=>'bg-gradient-success' ]);        
    <script>
        setTimeout(() => {
            
            $('#liveToast').toast({animation: true, delay: 2000});
            $('#liveToast').toast('show');

            $('#liveToast').on('hidden.bs.toast', function () {
                window.location.href="{{ route('index.login')}}"
            })


        }, "1000");    
    </script>   
@endif

@if ($errors->any())
   @include('sb.componentes.toast_validation',["mes" => $errors,"bg"=>'bg-gradient-danger' ]);        
   <script>
        setTimeout(() => {
            
            $('#liveToast').toast({animation: true, delay: 3000});
            $('#liveToast').toast('show');

            $('#liveToast').on('hidden.bs.toast', function () {
                $("#email").focus();
                //window.location.href='index';
            })


        }, "1000");    
    </script>   
@endif
<script>
    $("#eye1").on('click',function(){
        if( $(this).hasClass("fa-eye-slash") ){
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
            $('#password').attr("type","text");
            return;
        } 

        if( $(this).hasClass("fa-eye") ){
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');
            $('#password').attr("type","password");
            return;
        }  
    });

    $("#eye2").on('click',function(){ 
        if( $(this).hasClass("fa-eye-slash") ){
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
            $('#password_confirmation').attr("type","text");
            return;
        } 

        if( $(this).hasClass("fa-eye") ){
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');
            $('#password_confirmation').attr("type","password");
            return;
        } 
    }); 
</script>
</html>