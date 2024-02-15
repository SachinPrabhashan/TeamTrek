@extends('layouts.navitems')

@section('content')
    <div class="container mt-4">
        <div class="rolebtn">
            <select class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton">
                <option value="#">Select Role Here</option>
                <option value="root">ROOT</option>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
                <option value="client">Client</option>
            </select>
        </div>
        <div class="mt-3">
            <h3>Module Permission</h3>
            <hr>
            <table id="example" class="ui celled table" style="width:150%">
                <thead>
                    <tr>
                        <th>Modules/Permissions</th>
                        @foreach ($permissions as $permission)
                            <th>{{ $permission->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($modules as $module)
                        <tr>
                            <td>{{ $module->name }}</td>
                            @foreach ($permissions as $permission)
                                <td>
                                    <input class="ms-2 module-permission-checkbox" type="checkbox" data-module-id="{{ $module->id }}" data-permission-id="{{ $permission->id }}" {{ isset($modulePermissions[$module->id][$permission->id]) ? 'checked' : '' }}>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.module-permission-checkbox').on('change', function() {
                var moduleId = $(this).data('module-id');
                var permissionId = $(this).data('permission-id');
                var isChecked = $(this).prop('checked');

                $.ajax({
                    url: '/save-module-permission',
                    method: 'POST',
                    data: {
                        moduleId: moduleId,
                        permissionId: permissionId,
                        isChecked: isChecked,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // Function to check checkboxes based on existing module permissions
            function checkExistingPermissions(existingPermissions) {
                $('.module-permission-checkbox').each(function() {
                    var moduleId = $(this).data('module-id');
                    var permissionId = $(this).data('permission-id');
                    if (existingPermissions[moduleId] && existingPermissions[moduleId].includes(permissionId)) {
                        $(this).prop('checked', true);
                    }
                });
            }

            // Retrieve existing module permissions from the server
            $.ajax({
                url: '/get-existing-module-permissions',
                method: 'GET',
                success: function(response) {
                    // Check checkboxes based on existing module permissions
                    checkExistingPermissions(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

            // Handle deselection of checkboxes
            $('.module-permission-checkbox').on('change', function() {
                if (!$(this).prop('checked')) {
                    var moduleId = $(this).data('module-id');
                    var permissionId = $(this).data('permission-id');

                    $.ajax({
                        url: '/delete-module-permission',
                        method: 'POST',
                        data: {
                            moduleId: moduleId,
                            permissionId: permissionId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
