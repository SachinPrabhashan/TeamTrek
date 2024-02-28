@extends('layouts.navitems')

@section('content')
    <!-- Add this in your HTML head section -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="container mt-4 col-12">

        <div class="bg-light rounded h-100 p-4 ">
            <h2>Permission Manager</h2>
            <hr>
            <div class="d-flex justify-content-center">
                <div class="w-50 justify-content-center">
                    <h3>Exisiting Permissions</h3>
                    <ul id="permissionList">
                        @foreach ($permissions as $permission)
                            <li>{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>


        </div>
    </div>

    <div class="container mt-4 col-12">
        <div class="bg-light rounded h-100 p-4 d-flex justify-content-center">
            <div class="w-50 justify-content-center">
                <h3>Deploy New Permission</h3>
                <div id="permissionForm">
                    <input class="form-control" type="text" name="name" id="permissionName"
                        placeholder="Permission Name">
                    <div class="mt-2 float-end">
                        <button class="btn btn-secondary" id="clearBtn">Clear</button>
                        <button class="btn btn-danger" id="savePermission">Save</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#clearBtn').on('click', function(){
                $('#permissionName').val('');
            });

            //input box empty check & if not success alert
            $(document).ready(function() {
                $('#savePermission').click(function() {
                    var inputValue = $('#permissionName').val();

                    if (inputValue.trim() === '') {
                        alert('Input is required!');
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'New Permission Deployed!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });

            $('#savePermission').on('click', function() {
                // Get the permission name from the input field
                var permissionName = $('#permissionName').val();

                // Ajax request to save the permission
                $.ajax({
                    type: 'POST',
                    url: '/save-permission', // Replace with the actual URL to handle the permission save
                    data: {
                        name: permissionName
                    },
                    success: function(data) {
                        // Update the permission list without refreshing the page
                        $('#permissionList').append('<li>' + permissionName + '</li>');
                        $('#permissionName').val('');
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        // Handle validation errors, e.g., display them to the user
                        console.log(errors);
                    }
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection
