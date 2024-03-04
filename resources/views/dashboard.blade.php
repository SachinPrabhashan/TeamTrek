@extends('layouts.navitems')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <hr>
        <!-- Sale & Revenue Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <img width="48" height="48" src="https://img.icons8.com/fluency/48/000000/administrator-male.png" alt="administrator-male"/>
                        <div class="ms-3">
                            <p class="mb-2">Admins</p>
                            <h6 class="mb-0">{{ DB::table('users')->where('role_id', 2)->COUNT(); }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <img width="48" height="48" src="https://img.icons8.com/fluency/48/manager.png" alt="manager"/>
                        <div class="ms-3">
                            <p class="mb-2">Employees</p>
                            <h6 class="mb-0">{{ DB::table('users')->where('role_id', 3)->COUNT(); }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <img width="48" height="48" src="https://img.icons8.com/fluency/48/customer-support.png" alt="customer-support"/>
                        <div class="ms-3">
                            <p class="mb-2">Support Contracts</p>
                            <h6 class="mb-0">{{ DB::table('support_contracts')->COUNT(); }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <img width="48" height="48" src="https://img.icons8.com/fluency/48/hourglass--v2.png" alt="hourglass--v2"/>
                        <div class="ms-3">
                            <p class="mb-2">Pending Tasks</p>
                            <h6 class="mb-0">5</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sale & Revenue End -->


        <!-- Sales Chart Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-light text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Worldwide Sales</h6>
                            <a href="">Show All</a>
                        </div>
                        <canvas id="worldwide-sales"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-6">
                    <div class="bg-light text-center rounded p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="mb-0">Salse & Revenue</h6>
                            <a href="">Show All</a>
                        </div>
                        <canvas id="salse-revenue"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sales Chart End -->

        {{-- <button type="button" class="btn btn-secondary"  data-bs-toggle="tooltip" data-bs-placement="bottom"
            title="Tooltip on top">
            Tooltip on top
        </button>

        <script>
            $(document).ready(function() {
                $("body").tooltip({
                    selector: '[data-bs-toggle=tooltip]'
                });
            });
        </script> --}}

    </div>
@endsection
