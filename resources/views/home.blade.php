@extends('layouts.navitems')

@section('content')
@extends('layouts.navitems')

@section('content')
    <style>

    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <script>
        var app = angular.module('userApp', []);

        // Define your service for managing modals
        app.service('ModalService', function($q) {
            this.modalInstance = null;

            this.openModal = function(modalId) {
                this.modalInstance = $(modalId).modal('show');
            };

            this.closeModal = function() {
                var deferred = $q.defer();

                if (this.modalInstance) {
                    this.modalInstance.on('hidden.bs.modal', function() {
                        deferred.resolve();
                    });

                    this.modalInstance.modal('hide');
                } else {
                    deferred.resolve();
                }

                return deferred.promise;
            };
        });

        // Define your controller
        app.controller('UserController', function($scope, $http, ModalService) {
            $scope.user = {};


            $scope.submitUser = function() {
                var dob = moment($scope.user.dob, 'YYYY-MM-DD').format('YYYY-MM-DD');
                $scope.user.dob = dob;

                $http.post('/add-user', $scope.user)
                    .then(function(response) {
                        console.log(response.data);
                        $scope.user = {};
                        ModalService.closeModal();
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            };

            $scope.openModal = function(modalId) {
                ModalService.openModal(modalId);
            };

            // Function to open the modal
            $scope.openModal = function(modalId) {
                ModalService.openModal(modalId);
            };

        // Function to close the modal
        $scope.closeModal = function() {
            ModalService.closeModal();
        };
    });
</script>

<div class="container-fluid pt-4 px-4" ng-app="userApp" ng-controller="UserController">
    <h1>Employee Management</h1>
    <hr>
    <button type="button" class="btn btn-primary" ng-click="openModal('#addUserModal')">Add Users</button>
    <br>
<br>
<div>
    <table id="example" class="table table-bordered" >
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Role ID</th>
                <th>User Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->dob }}</td>
                <td>{{ $user->address }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->role_id }}</td>
                <td>{{ $user->user_type }}</td>
                <td class="text-center">
                    <div class="d-inline-block mx-1">
                        <a href="#">
                            <i class="fa-solid fa-pen-to-square"style="color: green;"></i>
                        </a>
                    </div>
                    <div class="d-inline-block mx-1">
                        <a href="#">
                            <i class="fa-solid fa-trash"style="color: red;"></i>
                        </a>
                    </div>
                    <div class="d-inline-block mx-1">
                        <a href="#">
                            <i class="fa-solid fa-circle-info"style="color: black;"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

        <!--Add Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="card text-dark bg-light">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="exampleModalLabel">Add Users</h5>
                            <button type="button" class="close" aria-label="Close" ng-click="closeModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form ng-submit="submitUser()">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" ng-model="user.name"
                                        placeholder="Enter name">
                                </div><br>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" ng-model="user.email"
                                        placeholder="Enter email">
                                    <small id="emailHelp text-white" class="form-text text-muted">We'll never share your
                                        email with anyone else.</small>
                                </div><br>
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <!--input type="date" class="form-control" id="dob" ng-model="user.dob"-->
                                    <input type="date" class="form-control" id="dob" ng-model="user.dob"
                                        ng-model-options="{timezone: null, updateOn: 'blur'}">
                                </div><br>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" ng-model="user.address"
                                        placeholder="Enter address">
                                </div><br>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" ng-model="user.phone"
                                        placeholder="Enter phone number">
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
                                    <input type="password" class="form-control" id="password" ng-model="user.password"
                                        placeholder="Enter password">
                                </div>
                                <br>
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                <button type="button" class="btn btn-danger btn-sm"
                                    ng-click="closeModal()">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@endsection
