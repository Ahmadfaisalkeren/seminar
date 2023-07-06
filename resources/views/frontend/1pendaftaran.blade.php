@foreach ($seminar as $item)
    <div class="modal fade" id="pendaftaranModal-{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pendaftaran Seminar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('client/pendaftaran') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="phone" class="mb-2">Phone</label><br>
                                    <input type="text" class="form-control" name="phone">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="seminar_name">Seminar Name</label>
                                    <input type="text" class="form-control" name="seminar_name"
                                        value="{{ $item->seminar_name }}" readonly>
                                    <input type="hidden" name="id_seminar" value="{{ $item->id }}">
                                </div>
                                <div class="form-group">
                                    <label for="seminar_date">Seminar Date</label>
                                    <input type="text" class="form-control" name="seminar_date"
                                        value="{{ $item->seminar_date }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" class="form-control" name="price"
                                        value="{{ $item->price }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Daftar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endforeach
