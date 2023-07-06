<section id="content">
    <div class="container mt-5 mb-5">
        <div class="m-5">
            <h2 class="text-center">Upcoming Seminar</h2>
            <p class="text-center">Here are some upcoming schedule of Seminar in 2023</p>
        </div>
        <div class="row">
            @foreach ($seminar as $item)
                @php
                    $seminarDate = \Carbon\Carbon::parse($item->seminar_date);
                    $now = \Carbon\Carbon::now();
                @endphp
                @if ($now->lt($seminarDate->addDay()))
                    <div class="col-md-4 mb-3 d-flex justify-content-center">
                        <div class="card h-100 shadow" style="width: 18rem;">
                            <img class="card-img-top" src="{{ asset($item->image) }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->seminar_name }}</h5>
                                <p class="card-text">Organized by : {{ $item->organizer }}</p>
                                <a href="#" data-toggle="modal" data-target="#detailModal-{{ $item->id }}"
                                    class="btn btn-putih">Detail</a>
                                @if (Auth::check())
                                    @if ($item->pendaftarans()->where('id_user', Auth::user()->id)->exists())
                                        <button class="btn btn-success" disabled>Joined</button>
                                    @else
                                        <a href="#" data-target="#pendaftaranModal-{{ $item->id }}"
                                            data-toggle="modal" class="btn btn-ungu register-btn"
                                            data-seminar-id="{{ $item->id }}">Daftar Seminar</a>
                                    @endif
                                @else
                                    <a href="#" data-target="#loginModal" data-toggle="modal"
                                        class="btn btn-ungu">Daftar Seminar</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
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
