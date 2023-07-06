<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Native CSS --}}
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
</head>

<body>

    @includeIf('frontend.navbar')

    <div class="container">
        <h2>My Seminar</h2>
        <p>Berikut ini adalah data seminar yang anda ikuti</p>
        <div class="row">
            <div class="col-12">
                <h3>Upcoming Seminar</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Seminar Name</th>
                            <th>Seminar Date</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @if (count($pendaftaran) > 0) --}}
                            @foreach ($pendaftaran as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->seminars->seminar_name }}</td>
                                    <td>{{ $item->seminars->seminar_date }}</td>
                                    <td>{{ $item->seminars->price }}</td>
                                    <td>
                                        <a href="#" class="btn btn-ungu btn-sm">Upload Pembayaran</a>
                                        <a href="#" class="btn btn-danger btn-sm">Request Cancel</a>
                                    </td>
                                </tr>
                            @endforeach
                        {{-- @else
                        <tr>
                            <td colspan="5">No Data Available</td>
                        </tr>
                        @endif --}}
                    </tbody>
                </table>
                {{-- <h3>Past Seminar</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Seminar Name</th>
                            <th>Organizer</th>
                            <th>Seminar Date</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Seminar Kuliner Untuk Negri</td>
                            <td>Kuliner Indonesia</td>
                            <td>03 February 2024</td>
                            <td>IDR 100.000</td>
                            <td>
                                <a href="#" class="btn btn-ungu btn-sm">Download Sertifikat</a>
                            </td>
                        </tr>
                    </tbody>
                </table> --}}
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
</body>

</html>
