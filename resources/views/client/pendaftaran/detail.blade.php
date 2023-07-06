@foreach ($currentSeminars as $item)
    <div class="modal fade" id="detailModal-{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Seminar Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="name">Name :</label>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ $item->yuser->name }}</p>
                        </div>
                        <div class="col-sm-4">
                            <label for="email">Email :</label>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ $item->yuser->email }}</p>
                        </div>
                        <div class="col-sm-4">
                            <label for="phone">Phone :</label>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ $item->yuser->phone }}</p>
                        </div>
                        <div class="col-sm-4">
                            <label for="seminar_name">Seminar Name :</label>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ $item->seminars->seminar_name }}</p>
                        </div>
                        <div class="col-sm-4">
                            <label for="seminar_date">Seminar Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <p>{{ tanggal_indonesia($item->seminars->seminar_date) }}</p>
                        </div>
                        <div class="col-sm-4">
                            <label for="price">Price :</label>
                        </div>
                        <div class="col-sm-8">
                            <p>IDR {{ format_uang($item->seminars->price) }}</p>
                        </div>
                        <div class="col-sm-4">
                            <label for="image">Bukti Pembayaran :</label>
                        </div>
                        <div class="col-sm-8">
                            <img src="{{ asset($item->image) }}" style="width: 100px" alt="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
