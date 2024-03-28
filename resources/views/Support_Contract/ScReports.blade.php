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
                <select class="btn btn-secondary rounded-pill dropdown-toggle m-2" id="selectSupportContract">
                    @foreach ($supportcontracts as $contract)
                        <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                    @endforeach
                </select>
                <label for="">Year</label>
                <select class="btn btn-secondary rounded-pill dropdown-toggle m-2" id="selectSupportContractYear">
                    @foreach ($scInstances->unique('year') as $instance)
                        <option value="{{ $instance->year }}">{{ $instance->year }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary m-2" id="scReportSearchBtn" data-toggle="tooltip"
                    title="Search SC Report">Search
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>


                <!-- Display SC Report -->
                <div id="scReport" style="display: none;">
                    <h2>Support Contract Report</h2>
                    <h4 id="currentDate">Date : </h4>
                    <hr>
                    <div class="scReportarea">
                        <div id="scInfo">
                            <!-- Display SC Name, Year, Owner -->
                            <h3>Support Contract Information</h3>
                            <div class="nameyear">
                                <p class="me-3" id="scName"></p>
                                <p class="ms-5" id="scYear"></p>
                            </div>

                            <p id="scOwner"></p>
                            <p class="mb-0">Task Handle by:</p>
                            <ul>
                                <p id="scAccess"></p>
                            </ul>
                        </div>

                        <!-- Display Tasks (ongoing and completed) -->
                        <div id="taskInfo">
                            <h3>Tasks</h3>
                            <ol>
                                <h4>Ongoing Tasks</h4>
                                <ul id="ongoingTasks">
                                </ul>
                                <h4>Completed Tasks</h4>
                                <ul id="completedTasks">
                                </ul>
                            </ol>
                        </div>

                        <!-- Display Dev and Eng Hours -->
                        <div id="hoursInfo">
                            <h3>Developer and Engineer Hours</h3>
                            <ol>
                                <div class="d-flex">
                                    <div>
                                        <h4>Initial Support Hours</h4>
                                        <ul>
                                            <p id="devHours"></p>
                                            <p id="engHours"></p>
                                        </ul>
                                    </div>
                                    <div class="ms-5">
                                        <h4>Remaining Support Hours</h4>
                                        <ul>
                                            <p id="remainingDevHours"></p>
                                            <p id="remainingEngHours"></p>
                                        </ul>
                                    </div>

                                </div>

                                <h4>Charging Support Hours</h4>
                                <ul>
                                    <p id="chargingDevHours"></p>
                                    <p id="chargingEngHours"></p>
                                </ul>
                            </ol>
                        </div>
                    </div>
                    <div class="mb-5">
                        <button class="btn btn-success float-end" id="downloadPdfBtn">Download PDF
                            <i class="fa-solid fa-download"></i>
                        </button>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        $('#scReportSearchBtn').click(function() {
            var supportContractId = $('#selectSupportContract').val();
            var year = $('#selectSupportContractYear').val();

            // Hide the scReport div before making the AJAX call
            $('#scReport').hide();

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
                    $('#scName').text('Name: ' + response.supportContract.name);
                    $('#scYear').text('Year: ' + response.supportContractInstance.year);
                    $('#scOwner').text('Owner: ' + response.supportContractInstance.owner);

                    // Populate task Access
                    var taskAccessHtml = '';
                    if (response.taskAccess && response.taskAccess.length > 0) {
                        $.each(response.taskAccess, function(index, taskAccess) {
                            taskAccessHtml += '<li class="mt-1">' + taskAccess.emp_name +
                                '</li>';
                        });
                    } else {
                        taskAccessHtml += '<p><b>No Access Granted Yet</b></p>';
                    }
                    $('#scAccess').html(taskAccessHtml);

                    // Populate ongoing tasks
                    var ongoingTasksHtml = '';
                    if (response.ongoingTasks && response.ongoingTasks.length > 0) {
                        $.each(response.ongoingTasks, function(index, task) {
                            ongoingTasksHtml += '<li>' + task.name + '</li>';
                        });
                    } else {
                        ongoingTasksHtml = '<p><b>No ongoing tasks</b></p>';
                    }
                    $('#ongoingTasks').html(ongoingTasksHtml);

                    // Populate completed tasks
                    var completedTasksHtml = '';
                    if (response.completedTasks && response.completedTasks.length > 0) {
                        $.each(response.completedTasks, function(index, task) {
                            completedTasksHtml += '<li>' + task.name + '</li>';
                        });
                    } else {
                        completedTasksHtml = '<p><b>No completed tasks yet</b><p>';
                    }
                    $('#completedTasks').html(completedTasksHtml);

                    // Populate hours information
                    var devHours = response.supportContractInstance.dev_hours || 0;
                    var engHours = response.supportContractInstance.eng_hours || 0;

                    var remainingDevHours = response.remainingHours ? (response.remainingHours.rem_dev_hours !== null ? response.remainingHours.rem_dev_hours : devHours) : devHours;
                    var remainingEngHours = response.remainingHours ? (response.remainingHours.rem_eng_hours !== null ? response.remainingHours.rem_eng_hours : engHours) : engHours;

                    var chargingDevHours = response.extraChargers ? (response.extraChargers.charging_dev_hours || 0) : 0;
                    var chargingEngHours = response.extraChargers ? (response.extraChargers.charging_eng_hours || 0) : 0;

                    $('#devHours').text('Dev Hours: ' + devHours);
                    $('#engHours').text('Eng Hours: ' + engHours);
                    $('#remainingDevHours').text('Remaining Dev Hours: ' + remainingDevHours);
                    $('#remainingEngHours').text('Remaining Eng Hours: ' + remainingEngHours);
                    $('#chargingDevHours').text('Charging Dev Hours: ' + chargingDevHours);
                    $('#chargingEngHours').text('Charging Eng Hours: ' + chargingEngHours);

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

            var currentDate = new Date();
            var formattedDate = currentDate.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            $('#currentDate').text('Date: ' + formattedDate);

            // $('#downloadPdfBtn').click(function() {
            //     // Get the content of the SC Report div
            //     var scReportContent = $('#scReport').html();

            //     // Create a new window with the SC Report content
            //     var pdfWindow = window.open('', '_blank');
            //     pdfWindow.document.open();
            //     pdfWindow.document.write('<html><head><title>Support Contract Report</title></head><body>' +
            //         scReportContent + '</body></html>');
            //     pdfWindow.document.close();

            //     // Call the print() function to trigger the print dialog
            //     pdfWindow.print();
            // });


        });

        // JavaScript for print preview button
        document.getElementById('downloadPdfBtn').addEventListener('click', function() {
            window.print();
        });
    </script>
@endsection
