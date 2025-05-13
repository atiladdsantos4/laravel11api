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
    <script type = 'text/javascript' src ="{{asset('js/script.js')}}"></script> 
    <link href="{{asset('sb/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('sb/css/sb-admin-2.min.css')}}" rel="stylesheet">
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
                                        <h1 class="h4 text-gray-900 mb-2">Esqueceu a senha?</h1>
                                        <p class="mb-4">Entendemos, erros acontecem!. Apenas Informe seu  
                                            e-mail e iremos lhe enviar um link para resetar sua senha!</p>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('password.notify') }}">
                                        @csrf 
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="email" name="email" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
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
                //window.location.href='index';
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

</html>