@extends('layouts.navitems')

@section('content')
    <!-- Add this in your HTML head section -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="container col-12">

        <div class="bg-light rounded h-100 p-4 ">
            <h2>Module Manager</h2>
            <hr>
            <div class="d-flex justify-content-center">
                <div class="w-50 justify-content-center">
                    <h3>Exisiting Modules</h3>
                    <table>
                        <td>
                            <ul id="moduleList">
                                @foreach ($modules as $module)
                                    <li>{{ $module->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td id="moduleCheckBoxes">
                            <ul type="none">
                                @foreach ($modules as $module)
                                    <li><input type="checkbox" name="" id="{{ $module->id }}"></li>
                                @endforeach
                            </ul>
                        </td>
                        <div>
                            <button class="btn btn-danger float-end" id="modelDeleteBtn" data-toggle="tooltip" data-bs-placement="bottom" title="Delete Modules"><i id="deleteBtn"
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
                <h3>Deploy New Module</h3>
                <div id="permissionForm">
                    <input class="form-control" type="text" name="name" id="moduleName" placeholder="Module Name">
                    <div class="mt-2 float-end">
                        <button class="btn btn-secondary" id="clearBtn">Clear</button>
                        <button class="btn btn-danger" id="saveModule">Save</button>
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
                $('#moduleName').val('');
            });

            //input box empty check & if not success alert
            $(document).ready(function() {
                $('#saveModule').click(function() {
                    var inputValue = $('#moduleName').val();

                    if (inputValue.trim() === '') {
                        alert('Input is required!');
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'New Module Deployed!',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });

            $('#saveModule').on('click', function() {
                // Get the permission name from the input field
                var moduleName = $('#moduleName').val();

                // Ajax request to save the permission
                $.ajax({
                    type: 'POST',
                    url: '/save-module', // Replace with the actual URL to handle the permission save
                    data: {
                        name: moduleName
                    },
                    success: function(data) {
                        // Update the permission list without refreshing the page
                        $('#moduleList').append('<li>' + moduleName + '</li>');
                        $('#moduleName').val('');
                        // Reload the page
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
    {{-- //Delete Module --}}
    <script>
        //To Show Check Boxes
        $('#moduleCheckBoxes').hide();


        $(document).ready(function() {
            $('#modelDeleteBtn').click(function() {
                // Toggle visibility of checkboxes
                $('#moduleCheckBoxes').toggle();
            });
        });

        $(document).ready(function() {
            $('#modelDeleteBtn').click(function() {
                // Get the checked checkboxes
                var checkedModules = $('input[type="checkbox"]:checked');

                // Iterate over each checked checkbox
                checkedModules.each(function() {
                    var moduleId = $(this).attr('id');

                    // Make an AJAX request to delete the module
                    $.ajax({
                        type: 'POST',
                        url: '/delete-module', // Replace with your actual delete module endpoint
                        data: {
                            id: moduleId
                        },
                        success: function(response) {
                            // Handle success, e.g., remove the deleted module from the UI
                            $('#moduleList li:has(input[id="' + moduleId + '"])')
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
