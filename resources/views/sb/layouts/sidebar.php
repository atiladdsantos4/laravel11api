        <?php
          $db = \Config\Database::connect();
          $queryEscopo = $db->query('select * from esc_escopo');
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
              foreach($queryEscopo->getResult() as $rowEscopo){
              $tem_menu = false;  
            ?>                
            <!-- Listando Escopos -->
            <div class="sidebar-heading">
                <?php 
                   //-->procura se tem  menus associados<--//
                   $sql2 =  'select * from men_menu where men_id_esc  ='.$rowEscopo->esc_id_esc.' and men_ativo = 1';
                   $queryTemEscopo = $db->query($sql2);
                   if( $queryTemEscopo->getNumRows() >0 ) {
                      echo $rowEscopo->esc_title; 
                      $tem_menu = true;  
                   }
                ?>
            </div>
            <?php 
               //-->procura os header de menus (pais)<--//
               $sql =  'select * from men_menu where men_id_esc  ='.$rowEscopo->esc_id_esc.' and men_pai = 1 and men_ativo = 1 order by men_position asc';
               $queryMenuPai = $db->query($sql);
               if( $queryMenuPai->getNumRows() >0 ) {
                   //-->para cada menu pai vai peggando os menus filhos <--//
                   foreach($queryMenuPai->getResult() as $rowPai){
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
                        $queryMenuFilho = $db->query($sql1);
                        foreach($queryMenuFilho->getResult() as $rowFilho){
                            $app =  base_url();
                            $link=$app.'index.php/'.$rowFilho->men_route;
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
                        <a class="collapse-item" href="buttons.html">Buttons</a>
                        <a class="collapse-item" href="cards.html">Cards</a>
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
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
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
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
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