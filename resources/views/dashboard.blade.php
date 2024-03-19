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
                                <p class="mb-2">Admins</p>
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
                                <p class="mb-2">Employees</p>
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
                                <p class="mb-2">Support Contracts</p>
                                <h6 class="mb-0">{{ DB::table('support_contracts')->COUNT() }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="dash-widget bg-light rounded d-flex align-items-center justify-content-between p-4">
                        <img width="48" height="48"
                            src="https://img.icons8.com/fluency/48/checked-radio-button--v1.png"
                            alt="checked-radio-button--v1" />
                        <div class="ms-3">
                            <p class="mb-2">Completed Tasks</p>
                            <h6 class="mb-0">{{ DB::table('tasks')->where('isCompleted', 1)->COUNT() }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6 col-xl-4 pt-4 px-4">
            <div class="dash-widget h-100 bg-light rounded p-4">
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
        </div>
    </div>
@endsection
