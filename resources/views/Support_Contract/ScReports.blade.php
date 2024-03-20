@extends('layouts.navitems')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<style></style>

<div class="container col-12">
    <div class="bg-light rounded h-100 p-4">
        <h1>Support Contract Reports</h1>
        <div class="rolebtn bg-light rounded h-100 p-4">
            <!-- Support Contract and Year selection -->
            <label for="">Support Contract</label>
            <select class="btn btn-secondary dropdown-toggle m-2" id="selectSupportContract">
                @foreach ($supportcontracts as $contract)
                    <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                @endforeach
            </select>
            <label for="">Year</label>
            <select class="btn btn-secondary dropdown-toggle m-2" id="selectSupportContractYear">
                @foreach ($scInstances->unique('year') as $instance)
                    <option value="{{ $instance->year }}">{{ $instance->year }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary m-2" id="scReportSearchBtn" data-toggle="tooltip" title="Search SC Report">Search
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>

            <!-- Display SC Report -->
            <div id="scReport" style="display: none;">
                <h2>Support Contract Report</h2>
                <div id="scInfo">
                    <!-- Display SC Name, Year, Owner -->
                    <h3>Support Contract Information</h3>
                    <p id="scName"></p>
                    <p id="scYear"></p>
                    <p id="scOwner"></p>
                </div>

                <!-- Display Tasks (ongoing and completed) -->
                <div id="taskInfo">
                    <h3>Tasks</h3>
                    <h4>Ongoing Tasks</h4>
                    <ul id="ongoingTasks">
                    </ul>
                    <h4>Completed Tasks</h4>
                    <ul id="completedTasks">
                    </ul>
                </div>

                <!-- Display Dev and Eng Hours -->
                <div id="hoursInfo">
                    <h3>Developer and Engineer Hours</h3>
                    <p id="devHours"></p>
                    <p id="engHours"></p>
                    <p id="remainingDevHours"></p>
                    <p id="remainingEngHours"></p>
                    <p id="chargingDevHours"></p>
                    <p id="chargingEngHours"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#scReportSearchBtn').click(function() {
        var supportContractId = $('#selectSupportContract').val();
        var year = $('#selectSupportContractYear').val();

        $.ajax({
            url: '/getSupportContract-ReportData',
            type: 'GET',
            dataType: 'json',
            data: {
                supportContractId: supportContractId,
                year: year
            },
            success: function(response) {
                // Populate the SC Report section with data from the response
                $('#scName').text('SC Name: ' + response.supportContract.name);
                $('#scYear').text('Year: ' + response.supportContract.year);
                $('#scOwner').text('Owner: ' + response.supportContract.owner);

                // Populate ongoing tasks
                var ongoingTasksHtml = '';
                $.each(response.ongoingTasks, function(index, task) {
                    ongoingTasksHtml += '<li>' + task.name + ' - ' + task.assigned_person + '</li>';
                });
                $('#ongoingTasks').html(ongoingTasksHtml);

                // Populate completed tasks
                var completedTasksHtml = '';
                $.each(response.completedTasks, function(index, task) {
                    completedTasksHtml += '<li>' + task.name + ' - ' + task.assigned_person + '</li>';
                });
                $('#completedTasks').html(completedTasksHtml);

                // Populate hours information
                $('#devHours').text('Dev Hours: ' + response.devHours);
                $('#engHours').text('Eng Hours: ' + response.engHours);
                $('#remainingDevHours').text('Remaining Dev Hours: ' + response.remainingDevHours);
                $('#remainingEngHours').text('Remaining Eng Hours: ' + response.remainingEngHours);
                $('#chargingDevHours').text('Charging Dev Hours: ' + response.chargingDevHours);
                $('#chargingEngHours').text('Charging Eng Hours: ' + response.chargingEngHours);

                // Show the SC Report section
                $('#scReport').show();
            },
            error: function(xhr, status, error) {
                console.error(error);
                if (xhr.status === 404) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Support Contract Instance Not Found',
                        text: 'There is no support contract instance for the selected values.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
</script>

@endsection
