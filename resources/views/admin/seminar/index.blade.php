@extends('admin.template.master')

@section('title', 'Seminar')

@section('content')
    <div class="container">
        <h1>Seminar Lists</h1>
        <a class="btn btn-sm btn-ungu mb-2" href="javascript:void(0)" id="createNewSeminar"> Create New Seminar</a>
        <table class="table table-striped table-bordered data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Seminar Name</th>
                    <th>Organizer</th>
                    <th>Speaker</th>
                    <th>Contact</th>
                    <th>Place</th>
                    <th>Seminar Date</th>
                    <th>Quota</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @includeIf('admin.seminar.form')
    @includeIf('admin.seminar.users')
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
                ajax: "{{ route('seminar.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'seminar_name',
                        name: 'seminar_name'
                    },
                    {
                        data: 'organizer',
                        name: 'organizer'
                    },
                    {
                        data: 'speaker',
                        name: 'speaker'
                    },
                    {
                        data: 'contact',
                        name: 'contact'
                    },
                    {
                        data: 'place',
                        name: 'place'
                    },
                    {
                        data: 'seminar_date',
                        name: 'seminar_date'
                    },
                    {
                        data: 'quota',
                        name: 'quota'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return '<img src="' + '{{ url('/') }}/' + data +
                                '" height="100px"/>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('#createNewSeminar').click(function() {
                $('#saveBtnNew').show();
                $('#saveBtnEdit').hide();
                $('#saveBtnNew').val("create-seminar");
                $('#seminar_id').val('');
                $('#seminarForm').trigger("reset");
                $('#modelHeading').html("Create New Seminar");
                // Set the modal size to modal-xl
                $('#ajaxModel .modal-dialog').removeClass('modal-lg').addClass('modal-xl');

                $('#ajaxModel').modal('show');
            });

            $('#saveBtnNew').click(function(e) {
                e.preventDefault();

                var formData = new FormData($("#seminarForm")[0]);
                // console.log(formData.get('image'));

                var url = "{{ route('seminar.store') }}";
                var method = 'POST';

                // Add validation checks here

                $.ajax({
                    data: formData,
                    processData: false,
                    contentType: false,
                    url: url,
                    type: method,
                    dataType: 'json',
                    success: function(data) {
                        $('#seminarForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: "Success!",
                            text: "The seminar has been saved successfully.",
                            icon: "success",
                            timer: 3000
                        });
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtnNew').html('Save Changes');
                    }
                });
            });


            $('body').on('click', '.editSeminar', function() {
                var seminar_id = $(this).data('id');
                $.get("{{ route('seminar.index') }}" + '/' + seminar_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Seminar");
                    $('#saveBtnNew').hide();
                    $('#saveBtnEdit').show();
                    $('#saveBtnEdit').val("edit-seminar");
                    // Set the modal size to modal-xl
                    $('#ajaxModel .modal-dialog').removeClass('modal-lg').addClass('modal-xl');
                    $('#ajaxModel').modal('show');
                    $('#seminar_id').val(data.id);
                    $('#seminar_name').val(data.seminar_name);
                    $('#organizer').val(data.organizer);
                    $('#contact').val(data.contact);
                    $('#place').val(data.place);
                    $('#speaker').val(data.speaker);
                    $('#seminar_date').val(data.seminar_date);
                    $('#price').val(data.price);
                    $('#quota').val(data.quota);
                    $('#description').val(data.description);
                    $('#image').val(data.image);
                });
            });

            $(document).ready(function() {
                var currentImage = $('#current-image');
                var imageInput = $('#image');

                // When the user selects a new image, show a preview of it
                imageInput.on('change', function() {
                    var file = this.files[0];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        currentImage.attr('src', e.target.result);
                        currentImage.show();
                    };

                    reader.readAsDataURL(file);
                });

                // When the page loads, show the current image if there is one
                if (currentImage.attr('src') !== '') {
                    currentImage.show();
                }
            });

            $('#saveBtnEdit').click(function(e) {
                e.preventDefault();

                var seminar_id = $('#seminar_id').val();
                var url = "{{ route('seminar.update', ':id') }}".replace(':id', seminar_id);
                var method = 'PUT';

                // Add validation checks here

                var formData = new FormData($('#seminarForm')[0]);
                formData.append('_method', method);

                $.ajax({
                    data: formData,
                    url: url,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        $('#seminarForm').trigger("reset");
                        $('#ajaxModel').modal('hide');
                        table.draw();
                        Swal.fire({
                            title: "Success!",
                            text: "The seminar has been updated successfully.",
                            icon: "success",
                            timer: 3000
                        });
                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#saveBtnEdit').html('Save Changes');
                    }
                });
            });

            // Accept and Reject Payment Seminar

            $(document).on('click', '.acceptBtn', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('seminar.approve', ':id') }}".replace(':id', id),
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'The seminar payment has been approved.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 4000
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(data) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to approve the seminar.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Reject Button

            $(document).on('click', '.rejectBtn', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('seminar.reject', ':id') }}".replace(':id', id),
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        Swal.fire({
                            title: 'Failed!',
                            text: 'The seminar payment has been Rejected.',
                            icon: 'error',
                            showConfirmButton: false,
                            timer: 4000
                        }).then(function() {
                            location.reload();
                        });
                    },
                    error: function(data) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to reject the seminar.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // $(document).on('click', '.rejectBtn', function(e) {
            //     e.preventDefault();
            //     var pendaftaran_id = $(this).data('id');
            //     swal({
            //             title: "Are you sure?",
            //             text: "You are about to reject this registration.",
            //             icon: "warning",
            //             buttons: ["Cancel", "Yes, reject it!"],
            //             dangerMode: true,
            //         })
            //         .then(function(willReject) {
            //             if (willReject) {
            //                 $.ajax({
            //                     url: "{{ route('seminar.reject', ['id' => ':id']) }}".replace(
            //                         ':id', pendaftaran_id),
            //                     type: 'POST',
            //                     data: {
            //                         _token: "{{ csrf_token() }}",
            //                         pendaftaran_id: pendaftaran_id
            //                     },
            //                     success: function(response) {
            //                         swal({
            //                                 title: "Registration Rejected!",
            //                                 text: "The registration has been rejected.",
            //                                 icon: "success",
            //                                 button: "Close",
            //                             })
            //                             .then(function() {
            //                                 location.reload();
            //                             });
            //                     },
            //                     error: function(response) {
            //                         swal({
            //                             title: "Error",
            //                             text: "An error occurred while processing the request.",
            //                             icon: "error",
            //                             button: "Close",
            //                         });
            //                     }
            //                 });
            //             }
            //         });
            // });

            // Detail Peserta Seminar Table
            $('body').on('click', '.daftarPeserta', function() {
                var seminar_id = $(this).data('id');
                $('#modelHeading').html("Daftar Peserta Seminar");
                $('#detailModal').modal('show');

                // destroy existing DataTable instance
                if ($.fn.DataTable.isDataTable('.detail-table')) {
                    $('.detail-table').DataTable().clear().destroy();
                }

                // configure the attendeeTable DataTable
                var attendeeTable = $('.detail-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('seminar.data', ':seminar_id') }}".replace(':seminar_id',
                        seminar_id),
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
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
                            data: 'imageButton',
                            name: 'imageButton'
                        },
                    ],

                });
            });

            $('body').on('click', '.deleteSeminar', function() {
                var seminar_id = $(this).data("id");

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
                            url: "{{ route('seminar.destroy', ':id') }}".replace(':id',
                                seminar_id),
                            success: function(data) {
                                table.draw();
                                Swal.fire(
                                    'Deleted!',
                                    'Your seminar has been deleted.',
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
