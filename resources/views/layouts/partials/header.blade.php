<header class="app-header fixed-top">	   	            
    <div class="app-header-inner">  
        <div class="container-fluid py-2">
            <div class="app-header-content"> 
                <div class="row justify-content-between align-items-center">
                
                <div class="col-auto">
                    <a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img"><title>Menu</title><path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path></svg>
                    </a>
                </div><!--//col-->
                <div class="search-mobile-trigger d-sm-none col">
                    <i class="search-mobile-trigger-icon fa-solid fa-magnifying-glass"></i>
                </div><!--//col-->
                
                <div class="app-utilities col-auto">
                    <div class="app-utility-item app-notifications-dropdown dropdown">    
                        <a class="dropdown-toggle no-toggle-arrow" id="notifications-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" title="Notifications">
                            <i class="app-icon fas fa-bell fa-lg text-primary"></i>
                            <span class="icon-badge">3</span>
                        </a><!--//dropdown-toggle-->
                        
                        <div class="dropdown-menu p-0" aria-labelledby="notifications-dropdown-toggle">
                            <div class="dropdown-menu-header p-3">
                                <h5 class="dropdown-menu-title mb-0">Notifications</h5>
                            </div><!--//dropdown-menu-title-->
                            <div class="dropdown-menu-content">
                               
                                <div class="item p-3">
                                    <div class="row gx-2 justify-content-between align-items-center">
                                        <div class="col-auto">
                                           <img class="profile-image" src="assets/images/profiles/profile-1.png" alt="">
                                        </div><!--//col-->
                                        <div class="col">
                                            <div class="info"> 
                                                <div class="desc">Amy shared a file with you. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </div>
                                                <div class="meta"> 2 hrs ago</div>
                                            </div>
                                        </div><!--//col--> 
                                    </div><!--//row-->
                                    <a class="link-mask" href="notifications.html"></a>
                               </div><!--//item-->

                               <div class="item p-3">
                                    <div class="row gx-2 justify-content-between align-items-center">
                                        <div class="col-auto">
                                            <div class="app-icon-holder icon-holder-mono">
                                                <i class="app-icon fas fa-envelope-open-text fa-lg"></i>
                                            </div>
                                        </div><!--//col-->
                                        <div class="col">
                                            <div class="info"> 
                                                <div class="desc">Your report is ready. Proin venenatis interdum est.</div>
                                                <div class="meta"> 3 days ago</div>
                                            </div>
                                        </div><!--//col-->
                                    </div><!--//row-->
                                    <a class="link-mask" href="notifications.html"></a>
                               </div><!--//item-->

                            </div><!--//dropdown-menu-content-->
                            
                            <div class="dropdown-menu-footer p-2 text-center">
                                <a href="notifications.html">View all</a>
                            </div>
                                                        
                        </div><!--//dropdown-menu-->					        
                    </div>

                    <div class="app-utility-item app-user-dropdown dropdown">
                        <a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="assets/images/user.png" alt="user profile"></a>
                        <ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
                            <li><a class="dropdown-item" href="/settings">Configurações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </div><!--//app-user-dropdown--> 
                </div><!--//app-utilities-->
            </div><!--//row-->
            </div><!--//app-header-content-->
        </div><!--//container-fluid-->
    </div><!--//app-header-inner-->

    @include('layouts.partials.sidebar')
    
</header><!--//app-header-->