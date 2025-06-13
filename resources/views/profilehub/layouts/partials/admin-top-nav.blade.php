@if (Auth::check())

    <div class="ms-auto dropdown">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="profileDropdown"
            data-bs-toggle="dropdown">
            <img src="images/avatar-blue.png" class="profile-avatar me-2" alt="profile" class="rounded-circle me-2"> 
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <span class="align-middle"><h6 class="mb-0 small dropdown-item">{{ Auth::user()->name }}</h6></span>
                <div class="dropdown-divider"></div>
            </li> 
            <li>
                <div class="d-grid px-4 pt-2 pb-1">
                    <a class="btn btn-danger d-flex" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <small class="align-middle">{{ __('Logout') }}</small>
                        <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </li>
        </ul>
    </div> 
     
@endif