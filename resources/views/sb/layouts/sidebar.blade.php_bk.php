@inject('men', 'App\Models\Menu')
@inject('esc', 'App\Models\Escopo')
<?php
  $escopo = $esc::where('esc_id_esc','>',0)->orderBy('esc_posicao', 'asc')->get();
  echo count($escopo);
?>
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <!-- <img style="" src="{{ asset('sb/img/logo.png') }}"> -->
                <div class="sidebar-brand-text mx-3">JemoSistemas</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            @for($i = 0 ;$i < count($escopo); $i++)            
            <!-- Listando Escopos -->
            <hr class="sidebar-divider">  
            <div class="sidebar-heading">
                {{ $escopo[$i]["esc_title"] }}
            </div>
                @php
                   $men_header = $men::getMenuPai($escopo[$i]["esc_id_esc"]);  
                   echo 'qtde:'.count($men_header);
                @endphp
                @if(count($men_header)>0 ) 
                    @for($j = 0 ;$j < count($men_header); $j++)            
                    @phpecho 'tetete;' @endphp
                    <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{$men_header[$j]['men_ul_id']}}"
                                aria-expanded="true" aria-controls="collapseTwo">
                                <i class="fas fa-fw fa-cog"></i>
                                <span>{{ $men_header[$j]["men_name"] }}</span>
                            </a>
                            <div id="{{$men_header[$j]['men_ul_id']}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <h6 class="collapse-header">Custom {{$men_header[$j]["men_name"]}}</h6>
                                    @php
                                      $men_filho = $men->getMenuFilho($men_header[$j]["men_id"]);  
                                    @endphp
                                    @for($t = 0 ;$t < count($men_filho); $t++)                                            
                                    @php
                                        $app =  '/'.config('app.name_server');
                                        $link=$app.'/public/index.php/'.$men_filho[$t]["men_route"];
                                        echo "<a class='collapse-item' href='".$link."'>".$men_filho[$t]["men_name"]."</a>";
                                    @endphp
                                    @endfor
                                </div>
                            </div>
                    </li>    
                    @endfor
                @endif
            @endfor
          
            <!-- Divider -->
            <hr class="sidebar-divider">

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
                        <a class="collapse-item" href="{{route('main.other')}}"">Other</a>
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