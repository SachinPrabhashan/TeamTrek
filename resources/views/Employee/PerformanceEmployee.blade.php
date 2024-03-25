@extends('layouts.navitems')
@section('content')
    <div class="container col-12">
        {{-- <div class="bg-light rounded h-100 p-4 d-flex">
            <div class="indworks notstart card col-3 me-4">
                <div class="d-flex justify-content-center">
                    <p class="widgetheader">Not Started</p>
                </div>
                <div  class="d-flex justify-content-center">
                    <p class="widgetdesc">25</p>
                </div>
            </div>

            <div class="indworks processing card col-3 me-4">
                <div class="d-flex justify-content-center">
                    <p class="widgetheader">Processing</p>
                </div>
                <div  class="d-flex justify-content-center">
                    <p class="widgetdesc">10</p>
                </div>
            </div>

            <div class="indworks completed card col-3 me-4">
                <div class="d-flex justify-content-center">
                    <p class="widgetheader">Completed</p>
                </div>
                <div  class="d-flex justify-content-center">
                    <p class="widgetdesc">16</p>
                </div>
            </div>
        </div> --}}

        <div class="bg-light rounded h-100 p-4">

            {{-- task service level widget --}}
            <div class="indworks card col-6">
                <div class="m-3">
                    <div class="d-flex">
                        <h3 class="m-2">Tasks Service Level</h3>
                        <div class="p-0 me-1 ms-auto m-2">
                            <select class="btn btn-outline-secondary btn-custom rounded-pill" name="" id="">
                                <option value="">Last 7 Days </option>
                                <option value="">Last 30 Days</option>
                                <option value="">Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="set01">
                            <p class="m-0">Not Started</p>
                            <p>20</p>
                        </div>
                        <div class="set02">
                            <p class="m-0">Processing</p>
                            <p>5</p>
                        </div>
                        <div class="set03">
                            <p class="m-0">Completed</p>
                            <p>30</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end task service level widget --}}
            <div class="d-flex">
                <div class="indworks card col-8 mt-3 me-3">
                    <div class="m-3">
                        <div class="d-flex">
                            <h3 class="m-2">SubTask History<a href="" data-toggle="tooltip"
                                    data-bs-placement="top" title="Refresh"><i
                                        class="mx-3 fa-solid fa-rotate-right fa-sm"></i></a></h3>
                            @Admin
                                <div class="p-0 me-1 ms-auto m-2">
                                    <select class="btn btn-secondary rounded-pill dropdown-toggle" id="selectEmployeeName">
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            @endAdmin
                        </div>

                        <table class="table" id="subtaskHistoryTable">
                            <tr>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Subtask</th>
                                <th>Support Hours</th>
                            </tr>
                            @foreach ($subtaskhistorys as $subtaskhistory)
                             {{-- @foreach ($subtaskhistorys->filter(function ($subtaskhistory) {
                                return $subtaskhistory->user_id == auth()->id() || auth()->user()->role_id == 2 || auth()->user()->role_id == 1;
                            }) as $subtaskhistory) --}}
                                <tr class="subtaskhistoryRow">
                                    <td>{{ $subtaskhistory->date }}</td>
                                    <td>NULL</td>
                                    <td>{{ $subtaskhistory->name }}</td>
                                    <td>{{ $subtaskhistory->dev_hours + $subtaskhistory->eng_hours }}</td>
                                </tr>
                            @endforeach

                        </table>
                    </div>
                </div>
                {{-- end Subtask View Table widget --}}
                {{-- Support Hours widget --}}
                <div class="indworks card mt-3">
                    <div class="m-3">
                        <div class="d-flex">
                            <h3 class="m-2">Support Hours</h3>
                            <div class="p-0 me-1 ms-auto m-2">
                                <select class="btn btn-outline-secondary btn-custom rounded-pill" name=""
                                    id="">
                                    <option value="">Last 7 Days </option>
                                    <option value="">Last 30 Days</option>
                                    <option value="">Year</option>
                                </select>
                            </div>
                        </div>
                        <div class="ms-2">
                            <div>
                                <table>
                                    <tr>
                                        <td>
                                            <h1>Developer <br>Hours</h1>
                                        </td>
                                        <td>
                                            <h1 class="ms-5">25H</h1>
                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                            </div>
                            <tr>
                                <td>
                                    <hr>
                                </td>
                            </tr>
                            <div>
                                <tr>
                                    <td>
                                        <h1>Engineer <br>Hours</h1>
                                    </td>
                                    <td>
                                        <h1 class="ms-5">25H</h1>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </div>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- end Support Hours widget --}}

                {{-- Subtask View Table widget --}}

            </div>
        </div>

    </div>

    <script>
        document.getElementById('selectEmployeeName').addEventListener('change', function() {
            var userId = this.value;
            filterTableData(userId);
            updateTable(response);
        });

        function filterTableData(userId) {
            $.ajax({
                url: '/performance/employee-performance',
                type: 'GET',
                data: {
                    userId: userId
                },
                success: function(response) {
                    updateTable(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function updateTable(data) {
            var tableBody = $('#subtaskHistoryTable tbody');
            tableBody.empty();
            data.forEach(function(row) {
                tableBody.append('<tr><td>' + row.date + '</td><td>NULL</td><td>' + row.name + '</td><td>' + (row.dev_hours + row.eng_hours) + '</td></tr>');
            });
        }
    </script>
@endsection
