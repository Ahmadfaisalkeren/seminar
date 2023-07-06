<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Seminar</title>
    <link rel="icon" href="{{ asset('images/s_icon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Native CSS --}}
    <link rel="stylesheet" href="{{ asset('styles/style.css') }}">
</head>

<body>

    @include('sweetalert::alert')

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
                            <th width="120px">Action</th>
                            <th width="200px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($currentSeminars->isEmpty())
                            <tr>
                                <td class="text-center" colspan="6">
                                    No Data Available
                                </td>
                            </tr>
                        @else
                            @foreach ($currentSeminars as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->seminars->seminar_name }}</td>
                                    <td>{{ tanggal_indonesia($item->seminars->seminar_date) }}</td>
                                    <td>IDR {{ format_uang($item->seminars->price) }}</td>
                                    <td>
                                        @if ($item->id_status == 3)
                                            @php
                                                $seminarDate = Carbon\Carbon::parse($item->seminars->seminar_date);
                                                $certificateDate = $seminarDate->addDays(1);
                                                $now = Carbon\Carbon::now();
                                            @endphp
                                            @if ($now->gte($certificateDate))
                                                <a href="{{ route('certificate', $item->id) }}" target="_blank"
                                                    class="btn btn-success btn-sm">Certificate</a>
                                                <a href="#" data-toggle="modal"
                                                    data-target="#imageModal-{{ $item->id }}"
                                                    class="btn btn-secondary btn-sm mt-1 disabled">Ticket & Invoice</a>
                                            @else
                                                <a href="{{ route('invoice', $item->id) }}" target="_blank"
                                                    class="btn btn-success btn-sm">Ticket & Invoice</a>
                                            @endif
                                        @elseif ($item->id_status == 2)
                                            <a href="#" data-toggle="modal"
                                                data-target="#imageModal-{{ $item->id }}"
                                                class="btn btn-secondary btn-sm disabled">Upload Pembayaran</a>
                                        @elseif ($item->id_status == 1)
                                            <a href="#" data-toggle="modal"
                                                data-target="#imageModal-{{ $item->id }}"
                                                class="btn btn-success btn-sm">Upload Pembayaran</a>
                                        @endif
                                        <a href="#" data-toggle="modal"
                                            data-target="#detailModal-{{ $item->id }}"
                                            class="btn btn-info btn-sm mt-1">Detail</a>
                                        {{-- <a href="#" class="btn btn-danger btn-sm mt-1">Request Cancel</a> --}}
                                    </td>
                                    <td>
                                        @if ($item->image != null && $item->id_status == 1)
                                            <p class="btn btn-sm btn-danger disabled">Pembayaran Ditolak</p>
                                        @else
                                            <p class="btn btn-sm btn-ungu disabled">{{ $item->statuses->status }}</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <h3>Past Seminar</h3>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Seminar Name</th>
                            <th>Organizer</th>
                            <th>Seminar Date</th>
                            <th>Price</th>
                            <th>Speaker</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pastSeminars as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->seminars->seminar_name }}</td>
                                <td>{{ $item->seminars->organizer }}</td>
                                <td>{{ tanggal_indonesia($item->seminars->seminar_date) }}</td>
                                <td>IDR {{ format_uang($item->seminars->price) }}</td>
                                <td>{{ $item->seminars->speaker }}</td>
                                <td>
                                    <a href="{{ route('certificate', $item->id) }}" target="_blank"
                                        class="btn btn-success btn-sm">Certificate</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @includeIf('client.pendaftaran.image_upload')
    @includeIf('client.pendaftaran.detail')

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
