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
            <h3>Module Permission New</h3>
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
                                    <input class="ms-2" type="checkbox" name="permissions[{{ $permission->id }}][{{ $module->id }}]" id="">
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
