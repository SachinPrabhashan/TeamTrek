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
        var app = angular.module('clientApp', []);
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

        app.controller('ClientController', function($scope, $http, ModalService) {
            $scope.client = {};
            $scope.clients = [];

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
                    url: '/fetch/Clients',
                    method: 'GET',
                    success: function(data) {
                        $('#example tbody').empty();
                        data.forEach(function(client) {
                            var row = $('<tr>');
                            row.append('<td>' + client.role_id + '</td>');
                            row.append('<td>' + client.name + '</td>');
                            row.append('<td>' + client.email + '</td>');
                            row.append('<td>' + client.phone + '</td>');
                            row.append('<td>' + client.address + '</td>');


                            var actions = $('<td class="text-center">');
                            actions.append(
                                '<div class="d-inline-block mx-1"><a href="#" ng-click="openEditUserTypeModal(' +
                                client.id +
                                ')"><i class="fa-solid fa-pen-to-square" style="color: green;"></i></a></div>'
                                );
                            actions.append(
                                '<div class="d-inline-block mx-1"><a href="#" ng-click="openDeleteModal(' +
                                client.id +
                                ')"><i class="fa-solid fa-trash" style="color: red;"></i></a></div>'
                                );
                            actions.append(
                                '<div class="d-inline-block mx-1"><a href="#"><i class="fa-solid fa-circle-info" style="color: black;"></i></a></div>'
                                );

                            row.append(actions);

                            $('#example tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            //Adding Client-------------------------------------------------------------------------------
            $scope.submitClient = function() {
                $http.post('/add-Client', $scope.client)
                    .then(function(response) {
                        $scope.client = {};
                        ModalService.closeModal();
                        fetchUsers();
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                    });
            };

            //Delete Client functions------------------------------------------------------------------
            $scope.openDeleteModal = function(clientId) {
                $scope.clientToDeleteId = clientId;
                $scope.openModal('#deleteClientModal');
            };
            //delete client
            $scope.deleteAdmin = function() {
                $http.delete('/delete-Client/' + $scope.clientToDeleteId)
                    .then(function(response) {
                        console.log("User deleted successfully");
                        ModalService.closeModal();
                        fetchUsers();
                    })
                    .catch(function(error) {
                        console.error("Error deleting user:", error);
                    });
            };

            //Edit Client functions---------------------------------------------------------------------
            // Function to open the edit modal
            $scope.openEditClientModal = function(clientId) {
                $http.get('/get-Client/' + clientId)
                    .then(function(response) {
                        $scope.editedClient = response.data;
                        ModalService.openModal('#editClientModal');
                    })
                    .catch(function(error) {
                        console.error('Error fetching user details:', error);
                    });
            };

            // Function to submit edited user details
            $scope.submitEditClient = function() {
                $http.put('/update-Client/' + $scope.editedClient.id, $scope.editedClient)
                    .then(function(response) {
                        console.log('User details updated successfully');
                        ModalService.closeModal();
                        fetchUsers();
                    })
                    .catch(function(error) {
                        console.error('Error updating user details:', error);
                    });
            };
        });
    </script>
    <div class="container-fluid pt-4 px-4" ng-app="clientApp" ng-controller="ClientController">
        <h1>Client Management</h1>
        <hr>
        <div class="d-inline-block mx-1">
            <a href="#" ng-click="openModal('#addClientModal')" class="btn btn-outline-primary"
                style="border-color:  #008CBA;">
                <i class="fa-solid fa-plus" style="color: #008CBA; font-size: 24px;"></i>
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
                        <th>phone</th>
                        <th>Address</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->role_id }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>{{ $client->address }}</td>

                            <td class="text-center">
                                <div class="d-inline-block mx-1">
                                    <a href="#" ng-click="openEditClientModal('{{ $client->id }}')">
                                        <i class="fa-solid fa-pen-to-square" style="color: green;"></i>
                                    </a>
                                </div>
                                <div class="d-inline-block mx-1">
                                    <a href="#" ng-click="openDeleteModal('{{ $client->id }}')">
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
        <div class="modal fade" id="addClientModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel"aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="card text-dark bg-light">
                        <div class="modal-header">
                            <h5 class="modal-title text-dark" id="exampleModalLabel">Add Clients</h5>
                            <button type="button" class="btn-close" aria-label="Close" ng-click="closeModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form ng-submit="submitClient()">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" ng-model="client.name"
                                        placeholder="Enter name">
                                </div><br>
                                <div class="form-group">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" ng-model="client.email"
                                        placeholder="Enter email">
                                    <small id="emailHelp text-white" class="form-text text-muted">We'll never share your
                                        email with anyone else.</small>
                                </div><br>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" ng-model="client.address"
                                        placeholder="Enter address">
                                </div><br>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" ng-model="client.phone"
                                        placeholder="Enter phone number">
                                </div><br>
                                <div class="form-group">
                                    <label for="role">Role ID</label>
                                    <select class="form-control" id="role" ng-model="client.role_id">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select>
                                </div><br>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" ng-model="client.password"
                                        placeholder="Enter password">
                                </div>
                                <br>
                                <div class="float-end">
                                    <button type="button" class="btn btn-secondary btn-sm" ng-click="closeModal()">Close</button>
                                    <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Delete Confirmation Modal-->
        <div class="modal fade" id="deleteClientModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" ng-click="closeModal()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this Client?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" ng-click="closeModal()">Close</button>
                        <button type="button" class="btn btn-danger btn-sm" ng-click="deleteAdmin()">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Client</h5>
                        <button type="button" class="close" ng-click="closeModal()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form ng-submit="submitEditClient()">
                            <div class="form-group">
                                <label for="editName">Name</label>
                                <input type="text" class="form-control" id="editName" ng-model="editedClient.name"
                                    placeholder="Enter name">
                            </div><br>
                            <div class="form-group">
                                <label for="editEmail">Email</label>
                                <input type="email" class="form-control" id="editEmail" ng-model="editedClient.email"
                                    placeholder="Enter email">
                            </div><br>
                            <div class="form-group">
                                <label for="editEmail">Phone</label>
                                <input type="phone" class="form-control" id="editPhone" ng-model="editedClient.phone"
                                    placeholder="Enter Phone">
                            </div><br>
                            <div class="form-group">
                                <label for="editEmail">Address</label>
                                <input type="address" class="form-control" id="editAddress"
                                    ng-model="editedClient.address" placeholder="Enter Address">
                            </div><br>
                            <div class="form-group">
                                <label for="editRoleId">Role ID</label>
                                <input type="text" class="form-control" id="editRoleId"
                                    ng-model="editedClient.role_id" placeholder="Role ID" readonly>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                            <button type="button" class="btn btn-secondary btn-sm"
                                ng-click="closeModal()">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection