<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/">Koperasi</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            @auth
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.members.index') }}">Anggota</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.loans.index') }}">Pinjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.loan-types.index') }}">Jenis Pinjaman</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('member.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('member.savings.index') }}">Simpanan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('member.loans.index') }}">Pinjaman</a>
                        </li>
                    @endif
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>