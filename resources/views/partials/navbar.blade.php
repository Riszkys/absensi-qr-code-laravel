<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-lg-0 mb-2 me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('panitia') ? 'active' : '' }}" href="/panitia">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('panitia/department') ? 'active' : '' }}"
                        href="/panitia/department">Manajemen Departemen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('panitia/training') ? 'active' : '' }}"
                        href="/panitia/training">Manajemen Training</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('panitia/test') ? 'active' : '' }}" href="/panitia/test">Manajemen
                        Test</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">Log Out</a>
                </li>
            </ul>

        </div>
    </div>
</nav>
