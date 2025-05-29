<!--start header -->
<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand gap-3">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>

            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center gap-1">
                    
                    <li class="nav-item dark-mode d-none d-sm-flex">
                        <a class="nav-link dark-mode-icon" href="javascript:;"><i class='bx bx-moon'></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown dropdown-app">
                        
                        <div class="dropdown-menu dropdown-menu-end p-0">
                            <div class="app-container p-2 my-2">
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-large">
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="header-notifications-list">
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown dropdown-large">
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="header-message-list">
                            </div>
                        </div>
                    </li>
                    
                </ul>
            </div>
            
            <div class="user-box dropdown px-3">
                <a class="d-flex align-items-center nav-link dropdown-toggle gap-3 dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) :  asset('assets/images/avatars/avatar-2.png') }}"
                    class="user-img" alt="user avatar">
                    <div class="user-info">
                        <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                        <p class="designattion mb-0">{{ Auth::user()->role }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item d-flex align-items-center" href="{{ route('profil.admin', Auth::user()->id) }}"><i
                                class="bx bx-user fs-5"></i><span>Profil</span></a>
                    </li>
                    <li><a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                class="bx bx-cog fs-5"></i><span>Pengaturan</span></a>
                    </li>
                    
                   
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <li><button class="dropdown-item d-flex align-items-center" type="submit" href=""><i
                                    class="bx bx-log-out-circle"></i><span>Logout</span></button>
                        </li>
                    </form>
                </ul>
            </div>
        </nav>
    </div>
</header>
<!--end header -->