    <!-- Bootstrap core JavaScript-->
    <script src="{{sb/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{sb/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{sb/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Core plugin JQueryMask-->
    <script src="{{js/jquery.mask.js')}}"></script>
    <script src="{{js/jquery.mask.min.js')}}"></script>
    <script src="{{js/script.js')}}"></script>
    <script src="{{js/axios.min.js')}}"></script>
    <?php
        if(isset($interface)){
            switch($interface){
                case "produto":
                   //echo view('sb/layouts/scripts_produto');
                   //echo view('sb/layouts/scripts_login');
                   //echo view('sb/layouts/scripts_routes');
                   //echo view('sb/layouts/scripts_blogs');
                   break;
                case "menu":
                   //echo view('sb/layouts/scripts_menu');
                   break;
                  break;  
                case "editar":
                   //include ($path_interface.'novo.php');
                   //echo  view('sb/produto/editar');
                   //view($view_cliente_novo);
                   break;    
                case "index_back":
                  //include ($path_interface.'novo.php');
                  //echo view('sb/layouts/scripts_datatables');
                  //view($view_cliente_novo);
                break;       
                case "indexAjax":
                    //include ($path_interface.'novo.php');
                    //echo view('sb/layouts/scripts_datatables_clientapp');
                    //view($view_cliente_novo);
                  break;       
             }
           
        }
    ?>        
    <!-- Custom scripts for all pages-->
    <script src="{{sb/js/sb-admin-2.min.js')}}"></script>

    <!-- Datatables -->
    <!-- Page level plugins -->
    <!-- <script src="{{sb/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{sb/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script> -->

    <!-- Page level custom scripts -->
    <!-- <script src="{{sb/js/demo/datatables-demo.js')}}"></script> -->
    
    
    <!-- Charts -->
    <!-- Page level plugins -->
    <script src="{{sb/vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{sb/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{sb/js/demo/chart-pie-demo.js')}}"></script>
    <script src="{{sb/js/demo/chart-bar-demo.js')}}"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

