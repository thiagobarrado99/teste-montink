
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <button class="btn sidebar-toggle" id="mobileToggle">
            <i class="fas fa-bars"></i>
        </button>
        <a class="navbar-brand desktop-only" href="{{ route('dashboard') }}">
            <i class="fas fa-tachometer-alt"></i> Montink Dashboard
        </a>
        
        <div class="d-flex align-items-center">           
            <!-- User Dropdown -->
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-avatar me-2">
                        <i class="fas fa-user"></i>
                    </div>
                    <span>{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" id="logout_button" href="#"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>