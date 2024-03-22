@extends('layouts.navitems')

@section('content')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">

    <script>
        $(document).ready(function() {
            //tooltip
            $("body").tooltip({
                selector: '[data-toggle=tooltip]'
            });
        });


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
            $scope.client = {
                role_id: "4"
            };
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


            $scope.submitClient = function() {
                var enteredEmail = $scope.client.email;
                var existingEmails = $('#example tbody td:nth-child(3)').map(function() {
                    return $(this).text();
                }).get();

                if (existingEmails.includes(enteredEmail)) {
                    ModalService.closeModal();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'The email you entered is already in use!'
                    });
                    return;
                }
                $http.post('/add-Client', $scope.client)
                    .then(function(response) {
                        $scope.client = {};
                        ModalService.closeModal();
                        location.reload();
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "A Client Created Successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                    });
            };



            $scope.deleteClient = function(clientId) {
                $http.delete('/delete-Client/' + clientId)
                    .then(function(response) {
                        console.log("User deleted successfully");
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "A Client deleted Successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .catch(function(error) {
                        console.error("Error deleting user:", error);
                    });
            };

            $scope.confirmDelete = function(clientId) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $scope.deleteClient(clientId);
                    }
                });
            };






        });
    </script>
    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="container-fluid" ng-app="clientApp" ng-controller="ClientController">
                <h1>Meet Our Clients</h1>
                <hr>
                <div class="d-inline-block mx-1 float-end">
                    <a href="#" ng-click="openModal('#addClientModal')"><button
                            class="btn btn-primary"data-toggle="tooltip" data-bs-placement="bottom" title="Create Client">
                            <i class="fa-solid fa-user-plus"></i></button>
                    </a>
                </div>
                <br>
                <br>
                <div>
                    <table id="example" class="table table-bordered" width="108%">
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
                                            <a href="#"
                                                ng-click="openEditClientModal('{{ $client->id }}')"data-toggle="tooltip"
                                                data-bs-placement="bottom" title="Edit Client">
                                                <i class="fa-solid fa-pen-to-square" style="color: green;"></i>
                                            </a>
                                        </div>

                                        <div class="d-inline-block mx-1">
                                            <a href="#" ng-click="confirmDelete('{{ $client->id }}')"
                                                data-toggle="tooltip" data-bs-placement="bottom" title="Delete Client">
                                                <i class="fa-solid fa-trash" style="color: red;"></i>
                                            </a>
                                        </div>

                                        <div class="d-inline-block mx-1">
                                            <a href="#"data-toggle="tooltip" data-bs-placement="bottom"
                                                title="Disable Client">
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
                                    <label for="name">Name</label> <span id="Required" style="color:crimson; font-size:12pt; ">*</span>
                                    <input type="text" class="form-control" id="name" ng-model="client.name"
                                        placeholder="Enter name">
                                </div><br>
                                <div class="form-group">
                                    <label for="email">Email address</label> <span id="Required" style="color:crimson; font-size:12pt; ">*</span>
                                    <input type="email" class="form-control" id="email"
                                        ng-model="client.email" placeholder="Enter email">
                                    <small id="emailHelp text-white" class="form-text text-muted">We'll never share
                                        your
                                        email with anyone else.</small>
                                        <p id="emailHelp"></p>
                                </div><br>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address"
                                        ng-model="client.address" placeholder="Enter address">
                                </div><br>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone"
                                        ng-model="client.phone" placeholder="Enter phone number" oninput="validateNumberLength(this)">
                                </div><br>
                                <div class="form-group">
                                    <label for="role">Role ID</label>
                                    <input type="text" class="form-control" id="role"
                                        ng-model="client.role_id" value="4" readonly>
                                </div><br>

                                <div class="form-group">
                                    {{-- <label for="password">Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password" class="form-control" id="password"
                                            ng-model="client.password" placeholder="Enter password">
                                        <div class="input-group-addon">
                                            <a href="">
                                                <span class="input-group-text"><i class="fa fa-eye-slash"
                                                        style="color: #333" aria-hidden="true"></i></span></a>
                                        </div>
                                    </div> --}}

                                    <label for="password">Password</label> <span id="Required" style="color:crimson; font-size:12pt; ">*</span>
                                    <div class="input-group mb-3" id="show_hide_password">
                                        <input type="password" class="form-control"
                                            aria-label="Recipient's username" aria-describedby="basic-addon2"
                                            id="password" ng-model="client.password"
                                            placeholder="Enter password">
                                        <span class="input-group-text" id="basic-addon2">
                                            <a href=""><i class="fa fa-eye-slash" style="color: #333"
                                                    aria-hidden="true"></i></a></span>
                                    </div>
                                    <p id="passwordValidate"></p>

                                    <br>
                                    <div class="float-end">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            ng-click="closeModal()">Close</button>
                                        <button type="submit" class="btn btn-danger btn-sm">Submit</button>
                                    </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
