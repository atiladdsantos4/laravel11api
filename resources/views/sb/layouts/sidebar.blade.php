@inject('men', 'App\Models\Menu')
@inject('esc', 'App\Models\Escopo')

<?php
   $queryEscopo = $esc::all();
?>
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- rotina de menu dinamico -->
            <!-- Divider -->
            <?php
              //foreach($queryEscopo->getResult() as $rowEscopo){
              foreach($queryEscopo as $rowEscopo){ 
              //echo     'dddd:'.$rowEscopo->esc_id_esc; 
              $tem_menu = false;  
            ?>                
            <!-- Listando Escopos -->
            <div class="sidebar-heading">
                <?php 
                   //-->procura se tem  menus associados<--//
                   $queryTemEscopo = $men::where('men_id_esc','=',$rowEscopo->esc_id_esc)->where('men_ativo','=',"1")->get();

                   if(count($queryTemEscopo) > 0 ) {
                      echo $rowEscopo->esc_title; 
                      $tem_menu = true;  
                   }
                ?>
            </div>
            <?php 
               //-->procura os header de menus (pais)<--//
               $sql =  'select * from men_menu where men_id_esc  ='.$rowEscopo->esc_id_esc.' and men_pai = 1 and men_ativo = 1 order by men_position asc';
               $queryMenuPai = $men::where('men_id_esc','=',$rowEscopo->esc_id_esc)
                   ->where('men_pai','=',"1")
                   ->where('men_ativo','=',"1")
                   ->orderBy('men_position', 'asc')->get();
               if( count($queryMenuPai) >0 ) { 
                   //-->para cada menu pai vai peggando os menus filhos <--//
                   //foreach($queryMenuPai->getResult() as $rowPai){
                   foreach($queryMenuPai as $rowPai){ 
                        $li ='<li class="nav-item">';
                        $li .=' <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target=#'.$rowPai->men_ul_id;
                        $li .=' aria-expanded="true" aria-controls="collapseTwo">';
                        $li .='<i class="fas fa-fw fa-cog"></i>';
                        $li .='<span>'.$rowPai->men_name.'</span>';
                        $li .='</a>';
                        //--> imprime o menu filho <--//
                        $li .='<div id="'.$rowPai->men_ul_id.'" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">';
                        $li .='<div class="bg-white py-2 collapse-inner rounded">';
                        $li .='<h6 class="collapse-header">Custom '.$rowPai->men_name.'</h6>';
                        $sql1 ='select * from men_menu where men_pai = 0 and men_filho_pai='.$rowPai->men_id.' and men_ativo = 1 order by men_filho_position asc';
                        $queryMenuFilho = $men::where('men_pai','=',0)->where('men_filho_pai','=',$rowPai->men_id)
                        ->where('men_ativo','=',1)->orderBy('men_filho_position', 'asc')->get();
                        foreach($queryMenuFilho as $rowFilho){    
                            //$rowFilho->men_route;
                            $url = $rowFilho->men_route;
                            $link = URL::to($url);
                            $li .='<a class="collapse-item" href="'.$link.'">'.$rowFilho->men_name.'</a>';
                        }   
                        $li .='</div>';
                        $li .='</div>';
                        //--> end imprime o menu filho <--//
                        $li .='</li>';
                        echo $li;
                   }
                }
                if($tem_menu){
                   echo '<hr class="sidebar-divider">';
                }
             } //end escopo//     

            ?>
            <!-- fim da rotina de menu dinamico --> 


            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Components:</h6>
                        <a class="collapse-item" href="{{route('main.buttons')}}">Buttons</a>
                        <a class="collapse-item" href="{{route('main.cards')}}">Cards</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="{{route('main.color')}}">Colors</a>
                        <a class="collapse-item" href="{{route('main.border')}}">Borders</a>
                        <a class="collapse-item" href="{{route('main.animation')}}">Animations</a>
                        <a class="collapse-item" href="{{route('main.other')}}">Other</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="{{route('main.page_login')}}">Login</a>
                        <a class="collapse-item" href="{{route('main.page_register')}}">Register</a>
                        <a class="collapse-item" href="{{route('main.forgot_password')}}">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="{{route('main.page_404')}}">404 Page</a>
                        <a class="collapse-item" href="{{route('main.blank')}}">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('main.chart')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="{{route('main.table')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

            <!-- Sidebar Message -->
            <div class="sidebar-card d-none d-lg-flex">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div>

        </ul>
        <!-- End of Sidebar -->