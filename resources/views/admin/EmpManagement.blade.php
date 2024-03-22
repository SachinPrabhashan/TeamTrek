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


    <script>
        $(document).ready(function() {
            //tooltip
            $("body").tooltip({
                selector: '[data-toggle=tooltip]'
            });
        });

        var app = angular.module('userApp', []);
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

        // Define your controller
        app.controller('UserController', function($scope, $http, ModalService) {
            $scope.user = {
                role_id: "3"
            };
            $scope.users = [];

            //Updating the table--------------------------------------------------------
            function fetchUsers() {
                $.ajax({
                    url: '/fetch/Employees',
                    method: 'GET',
                    success: function(data) {
                        $('#example tbody').empty();
                        data.forEach(function(user) {
                            // Create a row for each user
                            var row = $('<tr>');
                            row.append('<td>' + user.name + '</td>');
                            row.append('<td>' + user.email + '</td>');
                            row.append('<td>' + user.dob + '</td>');
                            row.append('<td>' + user.address + '</td>');
                            row.append('<td>' + user.phone + '</td>');
                            row.append('<td>' + user.role_id + '</td>');
                            row.append('<td>' + user.user_type + '</td>');

                            var actions = $('<td class="text-center">');
                            actions.append(
                                '<div class="d-inline-block mx-1"><a href="#" ng-click="openEditUserTypeModal(' +
                                user.id +
                                ')"><i class="fa-solid fa-pen-to-square" style="color: green;"></i></a></div>'
                            );
                            actions.append(
                                '<div class="d-inline-block mx-1"><a href="#" ng-click="openDeleteModal(' +
                                user.id +
                                ')"><i class="fa-solid fa-trash" style="color: red;"></i></a></div>'
                            );
                            actions.append(
                                '<div class="d-inline-block mx-1"><a href="#"><i class="fa-solid fa-circle-info" style="color: black;"></i></a></div>'
                            );

                            row.append(actions);

                            // Append the row to the table body
                            $('#example tbody').append(row);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            //Adding user-------------------------------------------------------------------------------
            $scope.submitUser = function() {
                var enteredEmail = $scope.user.email;
                var existingEmails = $('#example tbody td:nth-child(2)').map(function() {
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

                var dob = moment($scope.user.dob, 'YYYY-MM-DD').format('YYYY-MM-DD');
                $scope.user.dob = dob;

                $http.post('/add-Emp', $scope.user)
                    .then(function(response) {
                        console.log(response.data);
                        $scope.user = {};
                        ModalService.closeModal();
                        location.reload();
                        Swal.fire({
                            position: "top-middle",
                            icon: "success",
                            title: "An Employee Created Successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            };


            // Function to open the modal
            $scope.openModal = function(modalId) {
                ModalService.openModal(modalId);
            };

            // Function to close the modal
            $scope.closeModal = function() {
                ModalService.closeModal();
            };


            $scope.deleteUser = function(userId) {
                $http.delete('/delete-Emp/' + userId)
                    .then(function(response) {
                        console.log("User deleted successfully");
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "A User deleted Successfully!",
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

            $scope.confirmDelete = function(userId) {
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
                        $scope.deleteUser(userId);
                    }
                });
            };

            //Edit Employee functions---------------------------------------------------------------
            $scope.openEditUserTypeModal = function(userId) {
                $scope.userToEditId = userId;
                // Fetch user details including hourly rate from the backend
                $http.get('/emp-rates/' + userId)
                    .then(function(response) {
                        // Assuming response.data contains user details including hourly rate
                        $scope.editedUser = response.data;
                        $scope.openModal('#editUserTypeModal');
                    })
                    .catch(function(error) {
                        console.error("Error fetching user details:", error);
                    });
            };

            $scope.updateUserType = function() {
                var userType = $scope.editedUser.user_type;
                var hourlyRate = $scope.editedUser.hourly_rate;
                var userId = $scope.userToEditId;

                $http.put('/update-Emp-type/' + userId, {
                        user_type: userType,
                        hourly_rate: hourlyRate
                    })
                    .then(function(response) {
                        Swal.fire({
                            position: "top-middle",
                            icon: "success",
                            title: "An Employee Updated Successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        ModalService.closeModal();
                        location.reload();
                    })
                    .catch(function(error) {
                        console.error("Error updating user type and hourly rate:", error);
                    });
            };



        });
    </script>
    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="container-fluid" ng-app="userApp" ng-controller="UserController">
                <h1>Meet Our Team</h1>
                <!--p>Without clarity, you send a very garbled message
                             out to the Universe. We know that the Law of Attraction says that we will attract what we focus on, so if we don’t have clarity, we will attract confusion.</p-->
                <hr>
                <div class="d-inline-block mx-1 float-end">
                    <a href="#" ng-click="openModal('#addUserModal')"><button
                            class="btn btn-primary"data-toggle="tooltip" data-bs-placement="bottom" title="Add Employee"><i
                                class="fa-solid fa-user-plus"></i></button>
                    </a>
                </div>
                <br>
                <br>
                <div>
                    <table id="example" class="table table-bordered" width="108%">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Emp Type</th>
                                <th>DOB</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->user_type }}</td>
                                    <td>{{ $user->dob }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->address }}</td>


                                    <td class="text-center">
                                        <div class="d-inline-block mx-1">
                                            <a href="#"
                                                ng-click="openEditUserTypeModal('{{ $user->id }}')"data-toggle="tooltip"
                                                data-bs-placement="bottom" title="Edit Employee">
                                                <i class="fa-solid fa-pen-to-square" style="color: green;"></i>
                                            </a>
                                        </div>
                                        <div class="d-inline-block mx-1">
                                            <a href="#" ng-click="confirmDelete('{{ $user->id }}')"
                                                data-toggle="tooltip" data-bs-placement="bottom" title="Delete Admin">
                                                <i class="fa-solid fa-trash" style="color: red;"></i>
                                            </a>
                                        </div>
                                        <div class="d-inline-block mx-1">
                                            <a href="#">
                                                <i class="fa-solid fa-circle-info"style="color: black;"
                                                    data-toggle="tooltip"
                                                    data-bs-placement="bottom"title="Disable Employee"></i>
                                            </a>
                                        </div>
                </div>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>
            </div>



            <!--Add Modal -->
            <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel"aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="card text-dark bg-light">
                            <div class="modal-header">
                                <h5 class="modal-title text-dark" id="exampleModalLabel">Add Employees</h5>
                                <button type="button" class="btn-close" aria-label="Close" ng-click="closeModal()">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <form ng-submit="submitUser()">
                                    <div class="form-group">
                                        <label for="name">Name</label> <span id="Required"
                                            style="color:crimson; font-size:12pt; ">*</span>
                                        <input type="text" class="form-control" id="name" ng-model="user.name"
                                            placeholder="Enter name">
                                    </div><br>
                                    <div class="form-group">
                                        <label for="email">Email address</label> <span id="Required"
                                            style="color:crimson; font-size:12pt; ">*</span>
                                        <input type="email" class="form-control" id="email" ng-model="user.email"
                                            placeholder="Enter email">
                                        <small id="emailHelp text-white" class="form-text text-muted">We'll never share
                                            your
                                            email with anyone else.</small>
                                        <p id="emailHelp"></p>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="dob">Date of Birth</label>
                                        <!--input type="date" class="form-control" id="dob" ng-model="user.dob"-->
                                        <input type="date" class="form-control" id="dob" ng-model="user.dob"
                                            ng-model-options="{timezone: null, updateOn: 'blur'}">
                                    </div><br>
                                    <div class="form-group">
                                        <label for="year">Year</label>
                                        <input type="number" class="form-control" id="year" ng-model="user.year"
                                            placeholder="Enter year">
                                    </div><br>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address"
                                            ng-model="user.address" placeholder="Enter address">
                                    </div><br>
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control" id="phone" ng-model="user.phone"
                                            placeholder="Enter phone number" oninput="validateNumberLength(this)">
                                    </div><br>
                                    <div class="form-group">
                                        <label for="role">Role ID</label>
                                        <input type="text" class="form-control" id="role"
                                            ng-model="user.role_id" value="3" readonly>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="user_type">User Type</label>
                                        <select class="form-control" id="user_type" ng-model="user.user_type">
                                            <option value="developer">Developer</option>
                                            <option value="engineer">Engineer</option>
                                            <!--option value="client">Client</option-->
                                        </select>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="hourly_charge">Hourly Charge</label>
                                        <input type="number" step="100" class="form-control" id="hourly_charge"
                                            ng-model="user.hourly_charge" placeholder="Enter hourly charge">
                                    </div><br>
                                    <div class="form-group">
                                        <label for="password">Password</label> <span id="Required"
                                            style="color:crimson; font-size:12pt; ">*</span>
                                        <div class="input-group mb-3" id="show_hide_password">
                                            <input type="password" class="form-control" id="password"
                                                ng-model="user.password" placeholder="Enter password">
                                            <span class="input-group-text" id="basic-addon2">
                                                <a href=""><i class="fa fa-eye-slash" style="color: #333"
                                                        aria-hidden="true"></i></a></span>
                                        </div>
                                        <p id="passwordValidate"></p>
                                    </div>
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

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                            <button type="button" class="btn-close" ng-click="closeModal()" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this Employee?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                ng-click="closeModal()">Close</button>
                            <button type="button" class="btn btn-danger btn-sm" ng-click="deleteUser()">Delete</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Edit user type modal -->
            <div class="modal fade" id="editUserTypeModal" tabindex="-1" role="dialog"
                aria-labelledby="editUserTypeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserTypeModalLabel">Edit Employee Type and Hourly Rate
                            </h5>
                            <button type="button" class="btn-close" ng-click="closeModal()" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="userName">Name:</label>
                                    <input type="text" class="form-control" id="userName" ng-model="editedUser.name"
                                        readonly>
                                </div><br>
                                <div class="form-group">
                                    <label for="userType">Employee Type:</label>
                                    <select class="form-control" id="userType" ng-model="editedUser.user_type">
                                        <option value="developer" ng-selected="editedUser.user_type === 'developer'">
                                            Developer</option>
                                        <option value="engineer" ng-selected="editedUser.user_type === 'engineer'">
                                            Engineer</option>
                                    </select>
                                </div><br>
                                <div class="form-group">
                                    <label for="hourlyRate">Hourly Rate:</label>
                                    <input type="number" class="form-control" id="hourlyRate"
                                        ng-model="editedUser.hourly_rate" placeholder="Enter hourly rate">
                                </div>
                            </form>
                        </div><br>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary btn-sm"
                                ng-click="closeModal()">Close</button>
                            <button type="button" class="btn btn-danger btn-sm"
                                ng-click="updateUserType()">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
