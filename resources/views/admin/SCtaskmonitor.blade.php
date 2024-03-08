@extends('layouts.navitems')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .card-margin {
            margin-bottom: 1.875rem;
        }

        .card {
            border: 0;
            box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #ffffff;
            background-clip: border-box;
            border: 1px solid #e6e4e9;
            border-radius: 8px;
        }

        .card .card-header.no-border {
            border: 0;
        }

        .card .card-header {
            background: none;
            padding: 0 0.9375rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            min-height: 50px;
        }

        .card-header:first-child {
            border-radius: calc(8px - 1px) calc(8px - 1px) 0 0;
        }

        .widget-49 .widget-49-title-wrapper {
            display: flex;
            align-items: center;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #edf1fc;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-day {
            color: #4e73e5;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
            color: #4e73e5;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #fcfcfd;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-day {
            color: #dde1e9;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-month {
            color: #dde1e9;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-success {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #e8faf8;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-day {
            color: #17d1bd;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-month {
            color: #17d1bd;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-info {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #ebf7ff;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-day {
            color: #36afff;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-month {
            color: #36afff;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-warning {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: floralwhite;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-day {
            color: #FFC868;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-month {
            color: #FFC868;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-danger {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #feeeef;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-day {
            color: #F95062;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-month {
            color: #F95062;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-light {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #fefeff;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-day {
            color: #f7f9fa;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-month {
            color: #f7f9fa;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-dark {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #ebedee;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-day {
            color: #394856;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-month {
            color: #394856;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-base {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background-color: #f0fafb;
            width: 4rem;
            height: 4rem;
            border-radius: 50%;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-day {
            color: #68CBD7;
            font-weight: 500;
            font-size: 1.5rem;
            line-height: 1;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-month {
            color: #68CBD7;
            line-height: 1;
            font-size: 1rem;
            text-transform: uppercase;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-meeting-info {
            display: flex;
            flex-direction: column;
            margin-left: 1rem;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-pro-title {
            color: #3c4142;
            font-size: 14px;
        }

        .widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-meeting-time {
            color: #B1BAC5;
            font-size: 13px;
        }

        .widget-49 .widget-49-meeting-points {
            font-weight: 400;
            font-size: 13px;
            margin-top: .5rem;
        }

        .widget-49 .widget-49-meeting-points .widget-49-meeting-item {
            display: list-item;
            color: #727686;
        }

        .widget-49 .widget-49-meeting-points .widget-49-meeting-item span {
            margin-left: .5rem;
        }

        .widget-49 .widget-49-meeting-action {
            text-align: right;
        }

        .widget-49 .widget-49-meeting-action a {
            text-transform: uppercase;
        }
</style>

<script>
    $(document).ready(function(){

        /*$("#addSupportContractTaskBtn").click(function(){
            $("#Addmodal").modal("show");
        });
        $("#closeBtn").click(function(){
            $("#Addmodal").modal("hide");
        });
        $("#closeHeadBtn").click(function(){
            $("#Addmodal").modal("hide");
        });*/

//Adding Tasks using swal---------------------------------------------
        $(document).on('click', '#openCreateTaskModalBtn', function() {
            Swal.fire({
                title: 'Create Task',
                html: `
                    <div class="form-group">
                        <label for="SupportContractDropInModal">Support Contract:</label><br>
                        <select class="form-control" id="SupportContractDropInModal">
                            @foreach ($supportcontracts as $contract)
                                <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="form-group">
                        <label for="SupportContractYearDropInModal">Year:</label><br>
                        <select class="form-control" id="SupportContractYearDropInModal">
                            @foreach ($scInstances->unique('year') as $instance)
                                <option value="{{ $instance->year }}">{{ $instance->year }}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="form-group">
                        <label for="taskName">Name:</label><br>
                        <input type="text" class="form-control" id="taskName">
                    </div><br>
                    <div class="form-group">
                        <label for="taskDescription">Description:</label><br>
                        <textarea class="form-control" id="taskDescription"></textarea>
                    </div><br>
                    <div class="form-group">
                        <label for="startDate">Start Date:</label><br>
                        <input type="date" class="form-control" id="startDate">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Close',
                focusConfirm: false,
                preConfirm: () => {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var taskName = $("#taskName").val();
                    var taskDescription = $("#taskDescription").val();
                    var startDate = $("#startDate").val();
                    var supportContractId = $("#SupportContractDropInModal").val();
                    var supportContractInstance = $("#SupportContractYearDropInModal").val();

                    var formData = {
                        taskName: taskName,
                        taskDescription: taskDescription,
                        startDate: startDate,
                        supportContractId: supportContractId,
                        supportContractInstance: supportContractInstance
                    };

                    return $.ajax({
                        type: "POST",
                        url: "/support-contract/tasks",
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    }).then(response => {
                        if (response && response.message) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });
                        }
                    }).catch(error => {
                        var errorMessage = error.responseJSON.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
                }
            });
        });

// Function to handle searchTasks button click---------------------------------------------------------
    $("#taskSearchBtn").click(function(){

        var supportContractId = $("#selectSupportContract").val();
        var year = $("#selectSupportContractYear").val();

        $.ajax({
            type: "GET",
            url: "/fetch-support-contract/tasks",
            data: {
                supportContractId: supportContractId,
                year: year
            },
            success: function(response) {
                renderTasks(response);
            },
            error: function(xhr, status, error) {
                //console.error("Error fetching tasks:", error);
                var errorMessage = xhr.responseJSON.error;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                    $(".row").empty();
            }
        });
    });

// Function to render tasks in the HTML-----------------------------------------------------
    function renderTasks(tasks) {
    var taskHtml = '';
    tasks.forEach(function(task) {
        taskHtml += '<div class="col-lg-4">';
        taskHtml += '<div class="card card-margin">';
        taskHtml += '<div class="card-header no-border">';
        taskHtml += '<h5 class="card-title">Task :- ' + task.name + '</h5>';
        taskHtml += '<hr></div>';
        taskHtml += '<div class="card-body pt-0">';
        taskHtml += '<div class="widget-49">';
        taskHtml += '<div class="widget-49-title-wrapper">';
        taskHtml += '<div class="widget-49-date-primary">';
        taskHtml += '<span class="widget-49-date-day">' + task.id + '</span>';
        taskHtml += '</div>';
        taskHtml += '<div class="widget-49-meeting-info">';
        taskHtml += '<span class="widget-49-pro-title">' + task.start_date + '</span>';
        taskHtml += '<span class="widget-49-meeting-time">';
        if (task.end_date) {
            taskHtml += 'End Date: ' + task.end_date;
        } else {
            taskHtml += '<span style="color: red;">Ongoing</span>';
        }
        taskHtml += '</span></div></div>';
        taskHtml += '<ol class="widget-49-meeting-points">';
        taskHtml += '<li class="widget-49-meeting-item"><span>' + task.Description + '</span></li>';
        taskHtml += '</ol>';
        taskHtml += '<div class="widget-49-meeting-action">';
        taskHtml += '<span style="margin-right: 5px;"><i class="fa-solid fa-users"style="color: green;"></i></span>'; // Add the users icon
        taskHtml += '<span style="margin-right: 5px;"><i class="fa-solid fa-trash delete-task" style="color: red;" data-task-id="' + task.id + '"></i></span>';
        taskHtml += '<span><i class="fa-solid fa-eye"style="color: blue;"></i></span>'; // Add the eye icon
        taskHtml += '</div></div></div></div></div>';
    });

    $(".row").html(taskHtml);

    // Event listener for showing access granting modal
    $(document).on('click', '.fa-users', function() {
        // Get the task ID from the data-task-id attribute of the clicked element
        var taskId = $(this).closest('.card').find('.widget-49-date-day').text().trim();
        showAccessGrantingModal(taskId);
    });

}


// Function to delete task-------------------------------------------------------------------------
function deleteTask(taskId) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/delete-task/' + taskId,
        type: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            console.log("Task deleted successfully");
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Task deleted Successfully!",
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        },
        error: function(error) {
            console.error("Error deleting task:", error);
        }
    });
}


// Function to confirm delete---------------------------------------------------------------------
    function confirmDelete(taskId) {
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
                deleteTask(taskId);
            }
        });
    }

// Event listener for confirming delete---------------------------------------------------------
    $(document).on('click', '.delete-task', function() {
        var taskId = $(this).data('task-id');
        confirmDelete(taskId);
    });

// Set up global AJAX setup to include CSRF token in all requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function showAccessGrantingModal(taskId) {
    console.log('Task ID:', taskId);
    $.ajax({
        url: '/emp-for-tasks',
        type: 'GET',
        success: function(users) {
            var optionsHtml = '';
            users.forEach(function(user) {
                optionsHtml += '<label><input type="checkbox" name="user" value="' + user.id + '"> ' + user.name + '</label><br>';
            });

            Swal.fire({
                title: 'Grant Access To Users',
                html: optionsHtml,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Close'
            }).then((result) => {
                if (result.isConfirmed) {
                    var selectedUsers = [];
                    $('input[name="user"]:checked').each(function() {
                        selectedUsers.push($(this).val());
                    });

                    // Send selected users and task ID to backend
                    $.ajax({
                        url: '/grant-access-tasks',
                        type: 'POST',
                        data: {
                            task_id: taskId,
                            selected_users: selectedUsers
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(error) {
                            console.error('Error granting access:', error);
                        }
                    });
                }
            });
        },
        error: function(error) {
            console.error("Error fetching users:", error);
        }
    });
}



});
</script>

    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4">

            <h1>On Going Tasks</h1>



            <div class="float-end">
                @RootOrAdmin
                <button class="btn btn-primary" id="openCreateTaskModalBtn" data-toggle="tooltip" data-bs-placement="bottom" title="Create SC Tasks">
                    <i class="fa-solid fa-folder-plus"></i>
                </button>
                <a href="{{ route('scAllTaskMonitor') }}">
                    <button class="btn btn-info" id="seeAllTaskBtn" data-toggle="tooltip" data-bs-placement="bottom" title="See All Tasks">
                        <i class="fa-solid fa-folder-open"></i>
                    </button>
                </a>


                @endRootOrAdmin
            </div>

            <div class="rolebtn bg-light rounded h-100 p-4">
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
                    <button class="btn btn-primary m-2" id="taskSearchBtn" data-toggle="tooltip" title="Search SC Tasks">Search
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
            </div>
            <!--div id="TaskView">Available Tasks Will Display Here</div-->
            <div class="row">

            </div>



    </div>
</div>





@endsection
