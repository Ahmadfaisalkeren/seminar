<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Seminar</title>
    <link rel="icon" href="{{ asset('images/s_icon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    {{-- Native CSS --}}
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">

    @stack('css')
</head>

<body>
    {{-- Navbar --}}
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
                                <a href="{{ route('pendaftaran.index') }}" class="nav-link nav-style">
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

    {{-- Header --}}
    <header class="py-5">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-8">
                    <div class="my-5">
                        <h1>Welcome To Seminar Website</h1>
                        <p>Dengan Seminar Hidup Lebih Bersinar</p>
                        <a href="#content" class="btn btn-ungu">Explore Seminar</a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <img class="img-fluid rounded-3 my-5" src="{{ asset('images/1.png') }}" alt="..." />
                </div>
            </div>
        </div>
        </div>
    </header>

    {{-- Content Card --}}
    <section id="content">
        <div class="container mt-5 mb-5">
            <div class="m-5">
                <h2 class="text-center">Upcoming Seminar</h2>
                <p class="text-center">Here are some upcoming schedule of Seminar in 2023</p>
            </div>
            <div class="row">

                @foreach ($seminar as $item)
                    <div class="col-md-4 mb-3 d-flex justify-content-center">
                        <div class="card h-100 shadow" style="width: 18rem;">
                            <img class="card-img-top" src="{{ asset($item->image) }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->seminar_name }}</h5>
                                <p class="card-text">Organized by : {{ $item->organizer }}</p>
                                <a href="#" data-toggle="modal" data-target="#detailModal-{{ $item->id }}"
                                    class="btn btn-putih">Detail</a>
                                @if (Auth::check())
                                    <a href="#" data-target="#pendaftaranModal-{{ $item->id }}"
                                        data-toggle="modal" class="btn btn-ungu">Daftar Seminar</a>
                                @else
                                    <a href="#" data-target="#loginModal" data-toggle="modal"
                                        class="btn btn-ungu">Daftar Seminar</a>
                                @endif

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @includeIf('client.pendaftaran.pendaftaran')
        @includeIf('frontend.login')
    </section>


    @foreach ($seminar as $item)
        <div class="modal fade" id="detailModal-{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Detail Seminar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="seminar_name">Seminar Name :</label>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $item->seminar_name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="organizer">Organizer :</label>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $item->organizer }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="phone">Contact Person :</label>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $item->contact }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="place">Place :</label>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ $item->place }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="price">Price :</label>
                            </div>
                            <div class="col-sm-8">
                                <p>IDR {{ format_uang($item->price) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="seminar_date">Date :</label>
                            </div>
                            <div class="col-sm-8">
                                <p>{{ tanggal_indonesia($item->seminar_date) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-putih" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    {{-- footer --}}
    <footer class="py-3">
        <div class="container">
            <p class="text-center mt-2">Copyright &copy; Ahmad Faisal 2023</p>
        </div>
    </footer>

    {{-- login modal  --}}
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login to your account</h5>
                    <button type="button" class="close close-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <img class="card-img-top"
                                        src="https://img.freepik.com/free-vector/welcome-word-flat-cartoon-people-characters_81522-4207.jpg?w=740&t=st=1676167059~exp=1676167659~hmac=6186ba25509f0a6f5e4798c05310a2100903b87afcc60e93f492cc771dff6c70"
                                        alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-ungu">Login</button>
                            <button type="button" class="btn btn-putih" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- register modal --}}
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Register account</h5>
                    <button type="button" class="close close-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <img class="card-img-top"
                                        src="https://img.freepik.com/free-vector/welcome-word-flat-cartoon-people-characters_81522-4207.jpg?w=740&t=st=1676167059~exp=1676167659~hmac=6186ba25509f0a6f5e4798c05310a2100903b87afcc60e93f492cc771dff6c70"
                                        alt="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-ungu">Register</button>
                            <button type="button" class="btn btn-putih" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    @stack('scripts')
</body>

</html>
