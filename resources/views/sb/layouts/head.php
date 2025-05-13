<?php
  $session = session();
  try {
    $token = $session->get("dados_sessao")["token"];
  } catch(\Exception $ex){ 
       $session->setFlashdata('message', 'Sessão expirada. Efetue seu login Novamente'); 
       $session->setFlashdata('bg', 'bg-gradient-danger');
       throw new \CodeIgniter\HTTP\Exceptions\RedirectException('index.php/login');
  }   
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="token" content="<?php echo $session->get("dados_sessao")["token"]; ?>">
    <meta name="oauth_token" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <script src="{{asset('js/jquery-3.7.1.js')}}"></script> 
    <link href="<?php echo base_url('assets/sb/vendor/fontawesome-free/css/all.css');?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url('assets/sb/css/sb-admin-2.min.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/sb/css/style_custom.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/sb/css/style_custom.css');?>" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" rel="stylesheet"> 

</head>
<?php echo view('sb/splash/splash01.php'); ?>