@extends('layouts.navitems')

@section('content')
    <!-- Add this in your HTML head section -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <div class="container mt-4 col-12">

        <div class="bg-light rounded h-100 p-4 ">
            <h2>Module Manager</h2>
            <hr>
            <div class="d-flex justify-content-center">
                <div class="w-50 justify-content-center">
                    <h3>Exisiting Modules</h3>
                    <ul id="moduleList">
                        @foreach ($modules as $module)
                            <li>{{ $module->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>


        </div>
    </div>

    <div class="container mt-4 col-12">
        <div class="bg-light rounded h-100 p-4 d-flex justify-content-center">
            <div class="w-50 justify-content-center">
                <h3>Deploy New Module</h3>
                <div id="permissionForm">
                    <input class="form-control" type="text" name="name" id="moduleName"
                        placeholder="Module Name">
                    <div class="mt-2 float-end">
                        <button class="btn btn-secondary" id="saveModule">Save</button>
                        <button class="btn btn-danger" id="clearBtn">Clear</button>
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
                $('#moduleName').val('');
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
@endsection