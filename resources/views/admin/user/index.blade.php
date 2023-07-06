@extends('admin.template.master')

@section('title', 'User')

@section('content')
    <div class="container">
        <h1>User Lists</h1>
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @includeIf('admin.user.form')
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#createNewUser').click(function() {
                $('#saveBtn').val("create-user");
                $('#user_id').val('');
                $('#userForm').trigger("reset");
                $('#modelHeading').html("Create New User");
                $('#ajaxModel').modal('show');
            });

            $('body').on('click', '.editUser', function() {
                var user_id = $(this).data('id');
                $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit User");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                });
            });

            $('#saveBtn').click(function(e) {
                e.preventDefault();

                var user_id = $('#user_id').val();
                var url = user_id ? "{{ route('users.update', ':id') }}".replace(':id', user_id) :
                    "{{ route('users.store') }}";

                var method = user_id ? 'PUT' : 'POST';

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: url,
                    type: method,
                    dataType: 'json',
                    success: function(data) {
                        $('#userForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtn').html('Save Changes');
                    }
                });
            });


            // $('body').on('click', '.deleteUser', function() {

            //     var user_id = $(this).data("id");
            //     confirm("Are You sure want to delete !");

            //     $.ajax({
            //         type: "DELETE",
            //         url: "{{ route('users.store') }}" + '/' + user_id,
            //         success: function(data) {
            //             table.draw();
            //         },
            //         error: function(data) {
            //             console.log('Error:', data);
            //         }
            //     });
            // });

            $('body').on('click', '.deleteUser', function() {
                var user_id = $(this).data("id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('users.destroy', ':id') }}".replace(':id',
                                user_id),
                            success: function(data) {
                                table.draw();
                                Swal.fire(
                                    'Deleted!',
                                    'Your user has been deleted.',
                                    'success'
                                );
                            },
                            error: function(data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
