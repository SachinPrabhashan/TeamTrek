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
                        <th></th>
                        <th>Add</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>View</th>
                        <th>Access Granting</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Dashboard</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>User Management</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>SC Handling</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>SC Instance Handling</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>SC Access Granting</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>SC Reports</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>SC Task Monitor</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>SC Analysis View</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>Employee Performance</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>Financial Health</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>Resource Utilization</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>Roles</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>Permissions</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>Module</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                    <tr>
                        <th>Module-Permission</th>
                        <td><input class="ms-2" type="checkbox" name="add" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="edit" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="delete" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="view" id=""></td>
                        <td><input class="ms-2" type="checkbox" name="accessgranting" id=""></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
