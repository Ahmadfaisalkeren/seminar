<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand nav-brand" href="#">
            Seminar
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-6"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbar-list-6">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    <ul class="navbar-nav">
                        @auth
                            <a href="{{ url('/') }}" class="nav-link nav-style">Home</a>
                            <a href="{{ route('myseminar.index') }}" class="nav-link nav-style">
                                My Seminar
                            </a>
                            <div class="dropdown">
                                <a href="{{ route('profile.index') }}" class="nav-link nav-style dropdown-toggle"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Hello, {{ auth()->user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ route('profile.index') }}" class="dropdown-item nav-link nav-style"><i
                                            class="fas fa-user-alt"></i>
                                        My Profile
                                    </a>
                                    <a href="#" data-toggle="modal" data-target="#logoutModal"
                                        class="dropdown-item nav-link nav-style"><i class="fas fa-sign-out-alt"></i>
                                        Sign Out
                                    </a>
                                </div>
                            </div>
                        @else
                            <li class="nav-item">
                                <a class="nav-link nav-style" href="#" data-toggle="modal"
                                    data-target="#loginModal">Login</a>
                            </li>

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link nav-style" href="#" data-toggle="modal"
                                        data-target="#registerModal">Register</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            @endif
        </div>
    </div>
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">You are sure want to Logout?</div>
            <div class="modal-footer">
                <button class="btn btn-putih" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-ungu" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
