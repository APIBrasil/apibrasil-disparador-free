<div id="app-sidepanel" class="app-sidepanel"> 

    <div id="sidepanel-drop" class="sidepanel-drop"></div>

    <div class="sidepanel-inner d-flex flex-column">

        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
        
        <div class="app-branding">
            <a class="app-logo" href="/">
                <span class="logo-text">Disparador</span>
                <i class="fab fa-whatsapp fa-lg"></i>
            </a>
        </div>
        
        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
            <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                
                <li class="nav-item">
                    
                    <a class="nav-link @if(request()->is('/')) active @endif" href="/">
                        <span class="nav-icon">
                            <i class="fas fa-home fa-lg"></i>
                         </span>
                         <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link @if(request()->is('contatos')) active @endif" href="/contatos">
                        <span class="nav-icon">
                            <i class="fas fa-users fa-lg"></i>
                        </span>
                         <span class="nav-link-text">Tags/Contatos</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link @if(request()->is('dispositivos')) active @endif" href="/dispositivos">
                        <span class="nav-icon">
                            <i class="fas fa-mobile-alt fa-lg"></i>
                        </span>
                         <span class="nav-link-text">Dispositivos</span>
                    </a>
                </li>
                
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle @if(request()->is('disparador')) active @elseif(request()->is('templates')) active @endif" href="/disparador" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-1" aria-expanded="false" aria-controls="submenu-1">
                        <span class="nav-icon">
                            <i class="fab fa-whatsapp fa-lg"></i>
                         </span>
                         <span class="nav-link-text"> Disparador</span>
                         <span class="submenu-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </span>
                    </a>
                    <div id="submenu-1" class="@if(request()->is('disparos')) show @elseif(request()->is('templates')) show @endif submenu submenu-1 collapse" data-bs-parent="#menu-accordion">
                        <ul class="submenu-list list-unstyled">
                            <li class="submenu-item"><a class="submenu-link @if(request()->is('templates')) active @endif" href="/templates">Templates</a></li>
                            <li class="submenu-item"><a class="submenu-link @if(request()->is('disparos')) active @endif" href="/disparos">Disparos</a></li>
                            
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link @if(request()->is('historico')) active @endif" href="/historico">
                        <span class="nav-icon">
                            <i class="fas fa-chart-line fa-lg"></i>
                        </span>
                         <span class="nav-link-text">Histórico</span>
                    </a>
                </li>
                				    
            </ul>
            
        </nav>

        <div class="app-sidepanel-footer">
            <nav class="app-nav app-nav-footer">
                <ul class="app-menu footer-menu list-unstyled">
                   
                    <li class="nav-item">
                        
                        <a class="nav-link" href="#">
                            <span class="nav-icon">
                                <i class="fas fa-cog fa-lg"></i>
                            </span>
                            <span class="nav-link-text">Conifigurações</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        
                        <a class="nav-link" href="#">
                            <span class="nav-icon">
                               <i class="fas fa-book fa-lg"></i>
                            </span>
                            <span class="nav-link-text">Documentação</span>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
       
    </div>
</div>