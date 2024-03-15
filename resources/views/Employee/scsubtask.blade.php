@extends('layouts.navitems')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">

    <style>
        .card {
            border: none;
        }

        div.tasksel {
            margin-left: 100px;

        }

        div #createTaskForm,
        #finishTaskForm {
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            justify-items: center;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('input[type=radio][name=taskType]').change(function() {
                if (this.value === 'create') {
                    $('#createTaskForm').fadeIn(1000);
                    $('#finishTaskForm').hide();
                } else if (this.value === 'finish') {
                    $('#createTaskForm').hide();
                    $('#finishTaskForm').fadeIn(1000);
                }
            });

            $('#closeFormBtn').click(function() {
                $('#createTaskForm').hide();
            });

            $('#closeFinishFormBtn').click(function() {
                $('#finishTaskForm').hide();
            });

            // Submit form via AJAX
            $('#submitFormBtn').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        // Display SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'SubTask created successfully!',
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to another page
                                window.location.href = '{{ route('scTaskMonitor') }}';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred! Please try again.',
                        });
                    }
                });
            });

            // Submit finishTaskForm via AJAX
            $('#submitFinishFormBtn').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                $.ajax({
                    type: form.attr('method'),
                    url: form.attr('action'),
                    data: form.serialize(),
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Task Finished successfully!',
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('scTaskMonitor') }}';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred! Please try again.',
                        });
                    }
                });
            });
        });
    </script>

    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4">
            <h1>Sub Task Handle</h1>
            <a href="{{ route('scTaskMonitor') }}" data-toggle="tooltip" data-bs-placement="left" title="Go Back"><i
                    class="fa-solid fa-circle-arrow-left fa-xl mb-4"></i></a>
            <br>
            <div class="row mb-3">

                <div class="col-6 mb-2">
                    <div class="card" id="taskNameCard">
                        <div class="card-body">
                            <h5 class="card-title">Task Name</h5>
                            <p class="card-text">{{ session('name') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="card" id="startDateCard">
                        <div class="card-body">
                            <h5 class="card-title">Start Date</h5>
                            <p class="card-text">{{ session('start_date') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-3 mb-2">
                    <div class="card" id="endDateCard">
                        <div class="card-body">
                            <h5 class="card-title">End Date</h5>
                            <p class="card-text">{{ session('end_date') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-2">
                    <div class="card" id="descriptionCard">
                        <div class="card-body">
                            <h5 class="card-title">Description</h5>
                            <p class="card-text">{{ session('description') }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Radio buttons -->
            <div class="row">
                <div class="col-12 tasksel">
                    <label class="mb-2" for="taskType"><b>Select Task Type:</b></label><br>
                    <input class="mb-2" type="radio" id="createTaskRadio" name="taskType" value="create">
                    <label class="mb-2" for="createTaskRadio">Create A Daily Task:</label><br>
                    <input type="radio" id="finishTaskRadio" name="taskType" value="finish">
                    <label for="finishTaskRadio">Finish Task:</label><br><br>
                </div>
            </div>

            <div class="pb-5" id="createTaskForm" style="display: none;">
                <form action="{{ route('create.subtask') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="taskName" class="form-label">What part you complete today?</label>
                        <input type="text" class="form-control" id="taskName" name="taskName">
                    </div>
                    <div class="mb-3">
                        <label for="taskDate" class="form-label ">Task Date</label>
                        <input type="date" class="form-control w-25" id="taskDate" name="taskDate">
                    </div>
                    <div class="mb-3">
                        <label for="developerHours" class="form-label">Developer Hours</label>
                        <input type="number" class="form-control" id="developerHours" name="developerHours">
                    </div>
                    <div class="mb-3">
                        <label for="engineerHours" class="form-label">Engineer Hours</label>
                        <input type="number" class="form-control" id="engineerHours" name="engineerHours">
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="isLastTask" name="isLastTask">
                        <label class="form-check-label" for="isLastTask">Is this the last daily task under this
                            task?</label>
                    </div>
                    <div class="mt-0 float-end">
                        <button type="button" class="btn btn-secondary btn-sm" id="closeFormBtn">Close</button>
                        <button type="submit" class="btn btn-danger btn-sm" id="submitFormBtn">Submit</button>
                    </div>

                </form>
            </div>


            <div class="pb-5" id="finishTaskForm" style="display: none;">
                <form action="{{ route('finish.task') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="finishDate" class="form-label">Finish Date</label>
                        <input type="date" class="form-control w-25" id="finishDate" name="finishDate">
                    </div>
                    <div class="mb-3">
                        <label for="developerHoursFinish" class="form-label">Developer Hours</label>
                        <input type="number" class="form-control" id="developerHoursFinish"
                            name="developerHoursFinish">
                    </div>
                    <div class="mb-3">
                        <label for="engineerHoursFinish" class="form-label">Engineer Hours</label>
                        <input type="number" class="form-control" id="engineerHoursFinish" name="engineerHoursFinish">
                    </div>
                    <div class="float-end">
                        <button type="button" class="btn btn-secondary btn-sm" id="closeFinishFormBtn">Close</button>
                        <button type="submit" class="btn btn-danger btn-sm" id="submitFinishFormBtn">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
