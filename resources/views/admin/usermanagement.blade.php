@extends('layouts.navitems')

@section('content')

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script> <!-- Include AngularJS library -->

<div class="container-fluid pt-4 px-4" ng-app="userApp" ng-controller="UserController">
    <h1>User Management</h1>
    <hr>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
      Add Users
    </button>

    <!--Add Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="card text-dark bg-light">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLabel">Add Users</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form ng-submit="submitUser()">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" ng-model="user.name" placeholder="Enter name">
                            </div><br>
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" ng-model="user.email" placeholder="Enter email">
                                <small id="emailHelp text-white" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div><br>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" ng-model="user.dob">
                            </div><br>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" ng-model="user.address" placeholder="Enter address">
                            </div><br>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" ng-model="user.phone" placeholder="Enter phone number">
                            </div><br>
                            <div class="form-group">
                                <label for="role">Role ID</label>
                                <select class="form-control" id="role" ng-model="user.role_id">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label for="user_type">User Type</label>
                                <select class="form-control" id="user_type" ng-model="user.user_type">
                                    <option value="developer">Developer</option>
                                    <option value="engineer">Engineer</option>
                                    <option value="client">Client</option>
                                </select>
                            </div><br>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" ng-model="user.password" placeholder="Enter password">
                            </div>
                            <br>
                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
