@extends('layouts.navitems')

@section('content')
    <!-- Add this in your HTML head section -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        use Carbon\Carbon;

        // Convert date of birth to Carbon instance
        $dob = Carbon::parse(Auth::user()->dob);

        // Calculate the age
        $age = $dob->age;
    @endphp


    <section class="section about-section" id="about">
        <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-lg-6">
                        <div class="about-text go-to">
                            <h3 class="dark-color">About Me</h3>
                            <div class="row about-list">
                                <div class="col-md-6">

                                    <div class="media">
                                        <label>Name</label>
                                        <p>{{ Auth::user()->name }}</p>
                                    </div>
                                    @AdminOrEmployee
                                        <div class="media">
                                            <label>Birthday</label>
                                            <p>{{ Auth::user()->dob }}</p>
                                        </div>

                                        <div class="media">
                                            <label>Age</label>
                                            <p>{{ $age }}</p>
                                        </div>
                                    @endAdminOrEmployee
                                </div>
                                <div class="col-md-6">
                                    <div class="media">
                                        <label>E-mail</label>
                                        <p>{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="media">
                                        <label>Phone</label>
                                        <p>{{ Auth::user()->phone }}</p>
                                    </div>
                                    <div class="media">
                                        <label>Address</label>
                                        <p>{{ Auth::user()->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-avatar ms-5 mt-5">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" title="" alt="">
                        </div>
                    </div>
                    @Employee
                        <div class="col-lg-6 row me-3 mb-4">
                            <div class="col-sm-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="d-flex align-items-center mb-3">Project Status</h5>
                                        <p>Web Design</p>
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 80%"
                                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <p>Website Markup</p>
                                        <div class="progress mb-3" style="height: 5px">
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 72%"
                                                aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endEmployee
                    <div class="col-lg-6">
                        @AdminOrEmployee
                            <button class="btn btn-primary" data-bs-target="#profileeditmodal" data-bs-toggle="modal"
                                data-bs-dismiss="modal">Edit</button>
                        @endAdminOrEmployee
                        <button class="btn btn-primary" data-bs-target="#passwordresetmodal" data-bs-toggle="modal"
                            data-bs-dismiss="modal">Change Password</button>
                    </div>

                </div>

            </div>
        </div>
    </section>



    {{-- Profile Details Change Modal --}}
    <div class="modal fade" id="profileeditmodal" aria-hidden="true" aria-labelledby="profileeditmodal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="profileeditmodal"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Full Name</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="name"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="email"
                                            value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Phone</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ Auth::user()->phone }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Date of Birth</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="dob"
                                            value="{{ Auth::user()->dob }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Address</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" class="form-control" name="address"
                                            value="{{ Auth::user()->address }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                        <button class="btn btn-danger" id="saveProfileEdit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Password Reset Modal --}}
    <div class="modal fade" id="passwordresetmodal" aria-hidden="true" aria-labelledby="passwordresetmodal"
        tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordresetmodal"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">New Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="password" class="form-control">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Confirm Password</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="password" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="" class="btn btn-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                        <button class="btn btn-danger">Update Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#saveProfileEdit').on('click', function(){
                //get input field data
                var newName = $('#name').val();
                var newEmail = $('#email').val();
                var newPhone = $('#phone').val();
                var newDob = $('#dob').val();
                var newAddress = $('#address').val();

                $.ajax({
                    type: 'POST',
                    url: '/myprofile/save-profile-details',
                    data: {
                        name: newName,
                        email: newEmail,
                        phone: newPhone,
                        dob: newDob,
                        address: newAddress
                    },
                    error: function(xhr, status, error) {
                        var errors = xhr.responseJSON.errors;
                        // Handle validation errors, e.g., display them to the user
                        console.log(errors);
                    }
                });
            });
        });
    </script>
@endsection
