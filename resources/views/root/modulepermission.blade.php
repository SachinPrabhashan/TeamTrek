@extends('layouts.navitems')

@section('content')
<div class="container mt-4 col-12">
    <div class="rolebtn bg-light rounded h-100 p-4">
        <select class="btn btn-secondary dropdown-toggle" id="roleDropdown" type="button">
            <!--option value="#">Select Role Here</option-->
            <option value="1">ROOT</option>
            <option value="2">Admin</option>
            <option value="3">Employee</option>
            <option value="4">Client</option>
        </select>


        <h3>Module Permission New</h3>
        <hr>
        <table id="example" class="ui celled table" style="width:100%">
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
                                <input class="ms-2 module-permission-checkbox"
                                       type="checkbox"
                                       data-module-id="{{ $module->id }}"
                                       data-permission-id="{{ $permission->id }}"
                                       data-role-id="{{ $roleId }}"
                                       {{ isset($existingModulePermissions[$module->id]) && in_array($permission->id, $existingModulePermissions[$module->id]) ? 'checked' : '' }}>
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
            // Default role ID
            var defaultRoleId = 1;

            // Retrieve existing module permissions from the server based on default role ID
            retrieveModulePermissions(defaultRoleId);

            // Function to retrieve existing module permissions
            function retrieveModulePermissions(roleId) {
                $.ajax({
                    url: '/get-module-permissions',
                    method: 'GET',
                    data: {
                        roleId: roleId
                    },
                    success: function(response) {
                        // Check checkboxes based on existing module permissions
                        checkExistingPermissions(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

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

            // Change event handler for role dropdown
            $('#roleDropdown').on('change', function() {
                var roleId = $(this).val();
                retrieveModulePermissions(roleId);
            });

            // Function to handle saving module permissions
            function saveModulePermission(moduleId, permissionId, isChecked, roleId) {
                $.ajax({
                    url: '/save-module-permission',
                    method: 'POST',
                    data: {
                        moduleId: moduleId,
                        permissionId: permissionId,
                        isChecked: isChecked,
                        roleId: roleId,
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

            // Change event handler for module permission checkboxes
            $('.module-permission-checkbox').on('change', function() {
                var moduleId = $(this).data('module-id');
                var permissionId = $(this).data('permission-id');
                var isChecked = $(this).prop('checked');
                var roleId = $('#roleDropdown').val(); // Get the currently selected role ID

                saveModulePermission(moduleId, permissionId, isChecked, roleId);
            });

            // Function to handle deleting module permissions
            function deleteModulePermission(moduleId, permissionId, roleId) {
                $.ajax({
                    url: '/delete-module-permission',
                    method: 'POST',
                    data: {
                        moduleId: moduleId,
                        permissionId: permissionId,
                        roleId: roleId,
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

            // Change event handler for module permission checkboxes (to handle deletion)
            $('.module-permission-checkbox').on('change', function() {
                var moduleId = $(this).data('module-id');
                var permissionId = $(this).data('permission-id');
                var roleId = $('#roleDropdown').val(); // Get the currently selected role ID

                if (!$(this).prop('checked')) {
                    deleteModulePermission(moduleId, permissionId, roleId);
                }
            });
        });
    </script>
@endsection
