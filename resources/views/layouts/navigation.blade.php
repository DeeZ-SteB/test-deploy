<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('page.main') }}">Salary Parser</a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page.recruiting') }}">For Recruiter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page.people-partner') }}">For People Partner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('page.analytics') }}">Analytics</a>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                @auth
                    {{-- For Auth user --}}
                    <li class="nav-item dropdown">
                        <a
                            class="btn btn-secondary"
                            href="#"
                            id="signin-dropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="signin-dropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <li>
                                    <a
                                        class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault();this.closest('form').submit();">
                                        Log Out
                                    </a>
                                </li>
                            </form>
                        </ul>
                    </li>
                @else
                    {{-- For Guests --}}
                    <li class="nav-item dropdown">
                        <a
                            class="btn btn-outline-primary"
                            href="#"
                            id="signin-dropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >Login/Sign up</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="signin-dropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('login') }}">Login</a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('register') }}">Sign Up</a>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
