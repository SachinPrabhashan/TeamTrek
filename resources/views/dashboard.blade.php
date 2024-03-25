@extends('layouts.navitems')

@section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <hr>
        <!-- Sale & Revenue Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-sm-6 col-xl-3">
                    <a href="{{ route('new.admins') }}">
                        <div class="dash-widget bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <img width="48" height="48"
                                src="https://img.icons8.com/fluency/48/000000/administrator-male.png"
                                alt="administrator-male" />
                            <div class="ms-3">
                                <p class="mb-2  fs-6">Admins</p>
                                <h6 class="mb-0">{{ DB::table('users')->where('role_id', 2)->COUNT() }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a href="{{ route('new.employee') }}">
                        <div class="dash-widget bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <img width="48" height="48" src="https://img.icons8.com/fluency/48/manager.png"
                                alt="manager" />
                            <div class="ms-3">
                                <p class="mb-2  fs-6">Employees</p>
                                <h6 class="mb-0">{{ DB::table('users')->where('role_id', 3)->COUNT() }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a href="{{ route('admin.ScHandling') }}">
                        <div class="dash-widget bg-light rounded d-flex align-items-center justify-content-between p-4">
                            <img width="48" height="48" src="https://img.icons8.com/fluency/48/customer-support.png"
                                alt="customer-support" />
                            <div class="ms-3">
                                <p class="mb-2 fs-6">Support Contracts</p>
                                <h6 class="mb-0">{{ DB::table('support_contracts')->COUNT() }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <a href="{{ route('scAllTaskMonitor') }}">
                    <div class="dash-widget bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <img width="48" height="48"
                            src="https://img.icons8.com/fluency/48/checked-radio-button--v1.png"
                            alt="checked-radio-button--v1" />
                        <div class="ms-3">
                            <p class="mb-2  fs-6">Completed Tasks</p>
                            <h6 class="mb-0">{{ DB::table('tasks')->where('isCompleted', 1)->COUNT() }}</h6>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- To Do Widget --}}
        <div class="col-12 pt-4 px-4 d-flex">
            <div class="dash-widget h-100 bg-light rounded p-4 col-4 me-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">To Do List <a href="" data-toggle="tooltip" data-bs-placement="top"
                            title="Refresh"><i class="mx-3 fa-solid fa-rotate-right"></i></a></h6>
                    <a href="{{ route('scTaskMonitor') }}" data-toggle="tooltip" data-bs-placement="top"
                        title="On Going Tasks">Show All</a>
                </div>
                {{-- <div class="d-flex mb-2">
                    <input class="form-control bg-transparent" type="text" placeholder="Enter task">
                    <button type="button" class="btn btn-primary ms-2">Add</button>
                </div> --}}
                @foreach ($todotasks->sortByDesc('created_at') as $index => $todotask)
                    @if ($index < 5)
                        <div class="d-flex align-items-center border-bottom py-2">
                            {{-- <input class="form-check-input m-0" type="checkbox"> --}}
                            <span>•</span>
                            <div class="w-100 ms-3">
                                <div class="d-flex w-100 align-items-center justify-content-between">
                                    <span>{{ $todotask->name }}</span>
                                    {{-- <button class="btn btn-sm"><i class="fa fa-times"></i></button> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="col-8 pe-4">
                <div class="dash-widget h-100 bg-light rounded p-4">
                    <h4>Teams</h4>
                    <div>
                        <table class="w-100 table">
                            <tr>
                                <th>Name</th>
                                {{-- <th>Role</th> --}}
                                <th>Last Activity</th>
                                <th></th>
                            </tr>
                            @foreach ($teams as $team)
                                <tr>
                                    <td>{{ $team->name }} <br> <span>{{ $team->email }}</span></td>
                                    {{-- <td>Not work</td> --}}
                                    <td>3 May, 2023</td>
                                    <td><a href="{{ route('new.employee') }}"><img data-toggle="tooltip"
                                                data-bs-placement="top" title="More" width="24" height="24"
                                                src="https://img.icons8.com/material-outlined/24/more.png"
                                                alt="more" /></a></td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
            </div>
        </div> {{-- end To Do Widget --}}


    </div>
@endsection
