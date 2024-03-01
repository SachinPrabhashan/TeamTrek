@extends('layouts.navitems')

@section('content')
    <!-- Add this in your HTML head section -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="container col-12">

        <div class="bg-light rounded h-100 p-4 ">
            <h2>Permission Manager</h2>
            <hr>
            <div class="d-flex justify-content-center">
                <div class="w-50 justify-content-center">
                    <h3>Exisiting Permissions</h3>
                    <table>
                        <td>
                            <ul id="permissionList">
                                @foreach ($permissions as $permission)
                                    <li>{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td id="permissionCheckBoxes">
                            <ul type="none">
                                @foreach ($permissions as $permission)
                                    <li><input type="checkbox" name="" id="{{ $permission->id }}"></li>
                                @endforeach
                            </ul>
                        </td>
                        <div>
                            <button class="btn btn-danger float-end" id="permissionDeleteBtn" data-toggle="tooltip"
                                data-bs-placement="bottom" title="Delete Permissions"><i
                                    class="fa-solid fa-trash"></i></button>
                        </div>
                    </table>

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

            $('#clearBtn').on('click', function() {
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
                        location.reload();
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

    {{-- //Delete Permssion --}}
    <script>
        //To Show Check Boxes
        $('#permissionCheckBoxes').hide();


        $(document).ready(function() {
            $('#permissionDeleteBtn').click(function() {
                // Toggle visibility of checkboxes
                $('#permissionCheckBoxes').toggle();
            });
        });

        $(document).ready(function() {
            $('#permissionDeleteBtn').click(function() {
                // Get the checked checkboxes
                var checkedPermission = $('input[type="checkbox"]:checked');

                // Iterate over each checked checkbox
                checkedPermission.each(function() {
                    var permissionId = $(this).attr('id');

                    // Make an AJAX request to delete the module
                    $.ajax({
                        type: 'POST',
                        url: '/delete-permission', // Replace with your actual delete module endpoint
                        data: {
                            id: permissionId
                        },
                        success: function(response) {
                            // Handle success, e.g., remove the deleted module from the UI
                            $('#permissionList li:has(input[id="' + permissionId +
                                    '"])')
                                .remove();

                            // Reload the page
                            location.reload();
                        },
                        error: function(error) {
                            // Handle error
                            console.error('Error deleting module: ', error);
                        }
                    });
                });
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
@endsection
