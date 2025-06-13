<ul class="list-unstyled">
    <!-- Dashboards -->
    <li class="menu-item active open">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ri-home-gear-line"></i>
            <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Admin Menus">
                <span>ProfileHub Menus</span>
            </div>
        </a>

        <ul class="menu-sub">
            <li class="menu-item">
                <a href="{{ route('profilehub.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons ri-home-smile-line"></i>
                    <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Dashboard">
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>


            <li class="menu-item">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ri-group-3-fill"></i>
                    <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="User Groups">
                        <span>User Groups</span>
                        <i class="ri-arrow-down-s-line toggle-icon"></i>
                    </div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('profilehub.admin.users.groups') }}" class="menu-link">
                            <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Groups">
                                Groups</div>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="menu-item">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ri-group-line"></i>
                    <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="User Groups">
                        <span>Users</span>
                        <i class="ri-arrow-down-s-line toggle-icon"></i>
                    </div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('profilehub.admin.users') }}" class="menu-link">
                            <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Groups">All
                                Users</div>
                        </a>
                    </li>

                </ul>
            </li>


            <li class="menu-item">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ri-user-settings-fill"></i>
                    <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="User Groups">
                        <span>Profile Fields</span>
                        <i class="ri-arrow-down-s-line toggle-icon"></i>
                    </div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('profilehub.admin.users.profile.groups') }}" class="menu-link">
                            <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Groups">
                                Groups</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('profilehub.admin.users.groups.children.all') }}" class="menu-link">
                            <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Groups">
                                Additional Fields</div>
                        </a>
                    </li>
                </ul>
            </li>

             


            <li class="menu-item">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ri-pages-fill"></i>
                    <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="User Groups">
                        <span>Pages</span>
                        <i class="ri-arrow-down-s-line toggle-icon"></i>
                    </div>
                </a>
                <ul class="menu-sub">

                    <li class="menu-item">
                        <a href="{{ route('profilehub.admin.layout.pages') }}" class="menu-link">
                            <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Modules">
                                Pages</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('profilehub.admin.layout.widgets') }}" class="menu-link">
                            <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Modules">
                                Widgets</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a class="menu-link" href="#"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="menu-icon tf-icons ri-logout-box-r-line"></i>
                    <div class="d-flex justify-content-between w-100 align-items-center" data-i18n="Modules">
                        <span>{{ __('Logout') }} </span>
                        
                    </div>

                </a>
            </li>

        </ul>
    </li>
    <li class="menu-item">
        <div class="float-left">
            <a class="menu-link menu-toggle" id="toggleSidebar"><i class="ri-collapse-horizontal-fill"></i></a>
        </div>
    </li>
</ul>
<form id="logout-form" action="{{ route('logout') }}" id="logout-form" method="POST" class="d-none">
    @csrf 
    
</form>