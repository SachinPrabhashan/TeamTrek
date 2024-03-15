@extends('layouts.navitems')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>

    </style>

    <script></script>

    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4">

            <h1>Support Contract Instance Tasks</h1>
            <a href="{{ route('scTaskMonitor') }}" data-toggle="tooltip" data-bs-placement="left" title="Go Back"><i
                    class="fa-solid fa-circle-arrow-left fa-xl mb-4"></i></a>
            <br>
            <div>
                <table id="example" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Task Id</th>
                            <th>Task</th>
                            <th>Support Contract</th>
                            <th>Instance year</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->name }}</td>
                                <td>{{ $task->supportContractInstance->supportContract->name }}</td>
                                <!-- Accessing support contract name via relationships -->
                                <td>{{ $task->supportContractInstance->year }}</td>
                                <!-- Accessing instance year via relationship -->
                                <td>{{ $task->start_date }}</td>
                                <td>{{ $task->end_date }}</td>
                                <td>{{ $task->Description }}</td>
                                <td class="text-center">
                                    <div class="d-inline-block mx-1">
                                        <a href="#" data-toggle="tooltip" data-bs-placement="bottom"
                                            title="Delete Admin">
                                            <i class="fa-solid fa-trash" style="color: red;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
