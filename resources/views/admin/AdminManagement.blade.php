
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

var app = angular.module('adminApp', []);
//Handling modals-------------------------------------------------
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

app.controller('AdminController', function($scope, $http, ModalService) {
    $scope.admin = {};
    $scope.admins = [];

            // Function to open the modal
            $scope.openModal = function(modalId) {
                ModalService.openModal(modalId);
            };

            // Function to close the modal
            $scope.closeModal = function() {
                ModalService.closeModal();
            };

//Updating the table--------------------------------------------------------
        function fetchUsers() {
            $.ajax({
                url: '/fetch/Admins',
                method: 'GET',
                success: function(data) {
                    $('#example tbody').empty();
                    data.forEach(function(admin) {
                        var row = $('<tr>');
                        row.append('<td>' + admin.role_id + '</td>');
                        row.append('<td>' + admin.name + '</td>');
                        row.append('<td>' + admin.email + '</td>');

                        var actions = $('<td class="text-center">');
                            actions.append('<div class="d-inline-block mx-1"><a href="#" ng-click="openEditUserTypeModal(' + admin.id + ')"><i class="fa-solid fa-pen-to-square" style="color: green;"></i></a></div>');
                            actions.append('<div class="d-inline-block mx-1"><a href="#" ng-click="openDeleteModal(' + admin.id + ')"><i class="fa-solid fa-trash" style="color: red;"></i></a></div>');
                            actions.append('<div class="d-inline-block mx-1"><a href="#"><i class="fa-solid fa-circle-info" style="color: black;"></i></a></div>');

                        row.append(actions);

                        $('#example tbody').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

            //Adding Admin-------------------------------------------------------------------------------
        $scope.submitAdmin = function() {
            $http.post('/add-Admin', $scope.admin)
                .then(function(response) {
                    $scope.admin = {};
                    ModalService.closeModal();
                    fetchUsers();
                })
                .catch(function(error) {
                    console.error('Error:', error);
                });
            };





});

</script>

<div class="container-fluid pt-4 px-4" ng-app="adminApp" ng-controller="AdminController">
    <h1>Admin Management</h1>
    <hr>
    <div class="d-inline-block mx-1">
        <a href="#" ng-click="openModal('#addAdminModal')" class="btn btn-outline-primary" style="border-color: blue;">
            <i class="fa-solid fa-plus" style="color: blue; font-size: 24px;"></i>
        </a>
    </div>
    <br>
<br>
<div>
    <table id="example" class="table table-bordered">
        <thead>
            <tr>
                <th>Role ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->role_id }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td class="text-center">
                    <div class="d-inline-block mx-1">
                        <a href="#" ng-click="openEditUserTypeModal('{{ $admin->id }}')">
                            <i class="fa-solid fa-pen-to-square" style="color: green;"></i>
                        </a>
                    </div>

                    <div class="d-inline-block mx-1">
                        <a href="#" ng-click="openDeleteModal('{{ $admin->id }}')">
                            <i class="fa-solid fa-trash" style="color: red;"></i>
                        </a>
                    </div>
                    <div class="d-inline-block mx-1">
                        <a href="#">
                            <i class="fa-solid fa-circle-info" style="color: black;"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

        <!--Add Modal -->
        <div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="card text-dark bg-light">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="exampleModalLabel">Add Admins</h5>
                            <button type="button" class="close" aria-label="Close" ng-click="closeModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form ng-submit="submitAdmin()">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" ng-model="admin.name"
                                        placeholder="Enter name">
                                </div><br>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" ng-model="admin.email"
                                        placeholder="Enter email">
                                    <small id="emailHelp text-white" class="form-text text-muted">We'll never share your
                                        email with anyone else.</small>
                                </div><br>
                                <div class="form-group">
                                    <label for="role">Role ID</label>
                                    <select class="form-control" id="role" ng-model="admin.role_id">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div><br>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" ng-model="admin.password"
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

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteAdminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" ng-click="closeModal()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Employee?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" ng-click="closeModal()">Close</button>
                        <button type="button" class="btn btn-danger btn-sm" ng-click="deleteAdmin()">Delete</button>
                    </div>
                </div>
            </div>
        </div>

</div>

@endsection