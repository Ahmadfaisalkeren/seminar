@extends('client.template.master')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="container">
                    <div class="row col-12">
                        <div class="col-md-6">
                            <form action="{{ route('profile.update', Auth::user()->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ Auth::user()->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        value="{{ Auth::user()->email }}">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" name="address" id="address" class="form-control"
                                        value="{{ Auth::user()->address }}">
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control"
                                        value="{{ Auth::user()->phone }}">
                                </div>
                                <div class="form-group">
                                    <label for="password">Change Password</label>
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-sm btn-ungu">Update Profile</button>
                            </form>
                        </div>
                        <div class="col-md-6 img-profile mt-2">
                            <img src="{{ asset('images/profile.png') }}" alt="" width="285px" height="456px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
@endsection
