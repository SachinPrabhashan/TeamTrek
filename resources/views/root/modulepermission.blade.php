@extends('layouts.navitems')

@section('content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {

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

            // Function to handle saving or deleting module permissions
            function saveOrDeleteModulePermission(moduleId, permissionId, isChecked, roleId) {
                if (isChecked) {
                    saveModulePermission(moduleId, permissionId, isChecked, roleId);
                } else {
                    deleteModulePermission(moduleId, permissionId, roleId);
                }
            }

            // Change event handler for module permission checkboxes
            $('.module-permission-checkbox').on('change', function() {
                var moduleId = $(this).data('module-id');
                var permissionId = $(this).data('permission-id');
                var isChecked = $(this).prop('checked');
                var roleId = $('#roleDropdown').val(); // Get the currently selected role ID

                // Call the function to save or delete module permission based on checkbox state
                saveOrDeleteModulePermission(moduleId, permissionId, isChecked, roleId);
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

            // Function to retrieve existing module permissions for the selected role
            function retrieveModulePermissions(roleId) {
                $.ajax({
                    url: '/get-module-permissions',
                    method: 'GET',
                    data: {
                        roleId: roleId
                    },
                    success: function(response) {
                        // Uncheck all checkboxes
                        $('.module-permission-checkbox').prop('checked', false);

                        // Check checkboxes based on existing module permissions for the selected role
                        $.each(response, function(moduleId, permissionIds) {
                            $.each(permissionIds, function(index, permissionId) {
                                var checkbox = $('input[data-module-id="' + moduleId +
                                    '"][data-permission-id="' + permissionId + '"]');
                                checkbox.prop('checked', true);
                            });
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Change event handler for role dropdown
            $('#roleDropdown').on('change', function() {
                var roleId = $(this).val();
                retrieveModulePermissions(roleId);
            });

            // Initial retrieval of module permissions for the selected role
            var initialRoleId = $('#roleDropdown').val();
            retrieveModulePermissions(initialRoleId);
        });
    </script>

    <div class="container col-12">
        <div class="rolebtn bg-light rounded h-100 p-4">
            <select class="btn btn-secondary dropdown-toggle" id="roleDropdown" type="button">
                <option value="1" {{ $roleId == 1 ? 'selected' : '' }}>ROOT</option>
                <option value="2" {{ $roleId == 2 ? 'selected' : '' }}>Admin</option>
                <option value="3" {{ $roleId == 3 ? 'selected' : '' }}>Employee</option>
                <option value="4" {{ $roleId == 4 ? 'selected' : '' }}>Client</option>
            </select>

            <div class="float-end">
                <a href="{{ route('root.modules') }}"><button class="btn btn-primary"><i class="fa-solid fa-plus"></i>
                        Module</button></a>
                <a href="{{ route('root.permissions') }}"><button class="btn btn-primary"><i class="fa-solid fa-plus"></i>
                        Permission</button></a>

            </div>
            <h3>Module Permissions</h3>
            <hr>
            <table class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Modules/Permissions</th>
                        @foreach ($permissions as $permission)
                            <th>{{ $permission->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="example-tbody">
                    @foreach ($modules as $module)
                        <tr>
                            <td>{{ $module->name }}</td>
                            @foreach ($permissions as $permission)
                                <td>
                                    <div class="checkbox-wrapper-46">
                                        <input class="ms-2 module-permission-checkbox inp-cbx" id="{{ $module->id }} {{ $permission->id }}"
                                            type="checkbox" data-module-id="{{ $module->id }}"
                                            data-permission-id="{{ $permission->id }}" data-role-id="{{ $roleId }}"
                                            {{ isset($existingModulePermissions[$module->id]) && in_array($permission->id, $existingModulePermissions[$module->id]) ? 'checked="checked"' : '' }}>

                                        <label class="cbx" for="{{ $module->id }} {{ $permission->id }}" ><span>
                                                <svg width="12px" height="10px" viewbox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </svg></span><span></span>
                                        </label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- <div class="checkbox-wrapper-46">
                <input class="inp-cbx" id="cbx-46" type="checkbox" />
                <label class="cbx" for="cbx-46"><span>
                        <svg width="12px" height="10px" viewbox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg></span><span></span>
                </label>
            </div> --}}

        </div>
    </div>
@endsection
