<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('user.dashboard') }}">
    <div class="sidebar-brand-text mx-3"><img src="{{ asset('public/storage/'.config('settings.site_logo')) }}" alt="!" height="50"></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link {{ Route::currentRouteName() == 'user.dashboard' ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">
<!-- Heading -->
<div class="sidebar-heading">
    User
</div>
<li class="nav-item @if(Route::currentRouteName() == 'users.profile' || Route::currentRouteName() == 'user.payment.history') active @endif">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#admins"
        aria-expanded="true" aria-controls="admins">
        <i class="fas fa-fw fa-user"></i>
        <span>Profile</span>
    </a>
    <div id="admins" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item @if(Route::currentRouteName() == 'users.profile') active @endif" href="{{ route('users.profile') }}">Profile</a>
            <a class="collapse-item @if(Route::currentRouteName() == 'user.payment.history') active @endif" href="{{ route('user.payment.history') }}">Course Fee History</a>
            @if(isset($students->IsRegister) && $students->IsRegister == 2)
            <a class="collapse-item @if(Route::currentRouteName() == 'user.reg.payment') active @endif" href="{{ route('user.reg.payment') }}">Registration Fee History</a>
            @endif
        </div>
    </div>
</li> 
<!-- Divider -->
<hr class="sidebar-divider">
<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>
</ul>
<!-- End of Sidebar -->