@extends('layouts.navitems')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">


    <link href="{{ asset('css/modal.css') }}" rel="stylesheet">

    <style>
        div #createSupportContractInstanceForm {
            width: 50%;
            margin-left: auto;
            margin-right: auto;
            justify-items: center;
        }

        .card {
            border: 0;
            box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
            border-radius: 10px;
            padding: 0;
        }

        .card:hover {
            cursor: pointer;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            transition: 0.5s;
        }

        .canvas-container {
            max-width: 400px;
            max-height: 300px;
            display: inline-block;
            overflow: hidden;

        }

        .instanceOption {
            margin-right: auto;
            margin-left: 220px;

        }
    </style>
    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4 mb-4" style="overflow: hidden;">
            <div class="container-fluid">
                <h1>Support Contract Instance Handling</h1>
                <hr>
                <div class="float-end">
                    <button class="btn btn-primary" id="addSupportContractInstanceBtn"data-toggle="tooltip"
                        data-bs-placement="bottom" title="Create Support Contract Instance">
                        <i class="fa-solid fa-folder-plus"></i>
                    </button>
                </div>
                <br>
                <!-- Table for displaying support contract instances -->
                <div id="supportContractInstanceTable">
                    <div class="rolebtn bg-light rounded h-100 p-4">
                        <!--label for="selectSupportContract" class="form-label">Select Support Contract:</label-->
                        <select class="btn btn-secondary rounded-pill dropdown-toggle" id="selectSupportContract">
                            <!-- Populate dropdown options with existing support contracts -->
                            {{-- <option disabled selected>Select Support Contract</option> --}}
                            @foreach ($supportcontracts as $contract)
                                <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>





                <div class="scroll-container mt-2" id="instancewidgets" style="width: 100%; overflow-x: auto;">

                    <table class="instancetableorder">
                        <tr>
                            <div class="row ms-4" style="width: 400%;">

                                @foreach ($instances as $instance)
                                    <td>
                                        <div class="card me-3 mb-2" style="width: 420px;"
                                            data-contract-id="{{ $instance->supportContract->id }}">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <h5 class="card-title">{{ $instance->supportContract->name }}</h5>
                                                    <h6 role="button"
                                                        class="instanceOption btn btn-primary btn-sm rounded-pill"
                                                        type="button" data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{ $instance->id }}">Edit
                                                    </h6>
                                                </div>
                                                <h1 class="m-1">{{ $instance->year }} Year</h1>
                                                <div class="d-flex">
                                                    <div class="me-3 d-flex" data-toggle="tooltip"
                                                        data-bs-placement="bottom" title="Support Hours">
                                                        <div class="mt-2">
                                                            <img width="24" height="24"
                                                                src="https://img.icons8.com/windows/32/meeting-time.png"
                                                                alt="meeting-time" /> |
                                                        </div>
                                                        {{-- {{ $instance->dev_hours + $instance->eng_hours }}H --}}
                                                        <div class="ms-1" style="font-size: 9pt;">
                                                            Dev {{ $instance->dev_hours }}H
                                                            <br>
                                                            Eng {{ $instance->eng_hours }}H
                                                        </div>
                                                    </div>
                                                    <div class="me-3 mt-2"data-toggle="tooltip" data-bs-placement="bottom"
                                                        title="Owner">
                                                        <img width="24" height="24"
                                                            src="https://img.icons8.com/windows/32/landlord.png"
                                                            alt="landlord" /> |
                                                        {{ $instance->owner }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- Instance Edit Button --}}

                                        <!-- Modal -->
                                        <div class="modal fade" id="staticBackdrop{{ $instance->id }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header m-0 pb-1">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                            {{ $instance->supportContract->name }} | {{ $instance->year }}
                                                        </h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="mt-3 mb-1">Support Contract Hours</p>
                                                        <label for="devhour">
                                                            Developer Hour :
                                                        </label>
                                                        <input class="form-control w-50" id="devhour" type="text"
                                                            value="{{ $instance->dev_hours }}">
                                                        <label for="enghour">
                                                            Engineer Hour :
                                                        </label>
                                                        <input class="form-control w-50" id="enghour" type="text"
                                                            value="{{ $instance->eng_hours }}">
                                                        <p class="mt-3 mb-1">Support Contract Charges</p>
                                                        <label for="devhourcharge">
                                                            Developer wage Per/Hr :
                                                        </label>
                                                        <input class="form-control w-50" id="devhourcharge" type="text"
                                                            value="{{ $instance->supportPayment->dev_rate_per_hour }}">
                                                        <label for="enghourcharge">
                                                            Engineer wage Per/Hr :
                                                        </label>
                                                        <input class="form-control w-50" id="enghourcharge" type="text"
                                                            value="{{ $instance->supportPayment->eng_rate_per_hour }}">

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button id="instanceupdate" type="button"
                                                            class="btn btn-danger btn-sm">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @endforeach
                            </div>
                        </tr>
                        <tr>
                            <div class=" d-flex" style="width: 400%;">
                                @foreach ($instances as $instance)
                                    <td>
                                        <div class="container mt-4" id="chartContainer">
                                            <canvas id="chart-{{ $instance->year }}" class="canvas-container"
                                                style="height: 300px"></canvas>
                                        </div>
                                    </td>
                                @endforeach
                            </div>
                        </tr>
                    </table>

                </div>







                <!-- Form for creating support contract instances -->
                <div id="createSupportContractInstanceForm" style="display: none;">
                    <h4>Create Support Contract Instance</h4>
                    <form id="supportContractInstanceForm">
                        <div class="mb-3">
                            <label for="support_contract" class="form-label">Support Contract:</label>
                            <select class="form-select" id="support_contract" name="support_contract">
                                <option disabled selected>Select Support Contract</option>
                                @foreach ($supportcontracts as $contract)
                                    <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Year:</label>
                            <input type="text" class="form-control" id="year" name="year"
                                value="{{ date('Y') }}">
                        </div>
                        <div class="mb-3">
                            <label for="owner" class="form-label">Owner:</label>
                            <select class="form-select" id="owner" name="owner">
                                <option disabled selected>Select Owner</option>
                                @foreach ($users as $user)
                                    @if ($user->role_id == 3)
                                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="dev_hours" class="form-label">Development Hours:</label>
                            <input type="number" class="form-control" id="dev_hours" name="dev_hours" value="10">
                        </div>
                        <div class="mb-3">
                            <label for="eng_hours" class="form-label">Engineering Hours:</label>
                            <input type="number" class="form-control" id="eng_hours" name="eng_hours" value="10">
                        </div>
                        <div class="mb-3">
                            <label for="dev_rate" class="form-label">Development Rate per Hour:</label>
                            <input type="number" step="100" class="form-control" id="dev_rate" name="dev_rate"
                                value="1000">
                        </div>
                        <div class="mb-3">
                            <label for="eng_rate" class="form-label">Engineering Rate per Hour:</label>
                            <input type="number" step="100" class="form-control" id="eng_rate" name="eng_rate"
                                value="2000">
                        </div>
                        <div class="float-end">
                            <button type="button" class="btn btn-secondary btn-sm" id="closeFormBtn">Close</button>
                            <button type="submit" class="btn btn-danger btn-sm">Create</button>
                        </div>
                    </form>
                </div>



            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            //Form display and toggle functions
            $('#createSupportContractInstanceForm').hide();
            $('#instancewidgets').show();

            $('#addSupportContractInstanceBtn').click(function() {
                $('#createSupportContractInstanceForm').toggle(100);
                $('#supportContractInstanceTable').toggle();
                $('#instancewidgets').toggle();
                $('#supportContractInstanceForm')[0].reset();
                $('#chartContainer').hide();
            });

            $('#closeFormBtn').click(function() {
                $('#createSupportContractInstanceForm').hide();
                $('#supportContractInstanceTable').show();
                $('#instancewidgets').show();
                $('#supportContractInstanceForm')[0].reset();
                $('#chartContainer').show();
            });

            // Handle form submission
            $('#supportContractInstanceForm').submit(function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: '/support-contract-instances-create',
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Support Contract Instance created successfully!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                                //fetchAndRenderCharts($("#selectSupportContract").val()); // Refresh charts after creating instance
                            }
                        });


                        //$('#createSupportContractInstanceForm').hide();
                        //$('#nstancewidgets').show();
                        //$('#chartContainer').show();
                        $('#supportContractInstanceForm')[0].reset();

                        //location.reload();
                        fetchAndRenderCharts($("#selectSupportContract")
                            .val()); // Refresh charts after creating instance
                    },
                    error: function(xhr, status, error) {
                        $('#createSupportContractInstanceForm').hide();
                        var errorMessage = xhr.responseJSON.error;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#supportContractInstanceForm')[0].reset();
                            }
                        });
                        //$('#createSupportContractInstanceForm').hide();
                        $('#supportContractInstanceForm')[0].reset();

                    }
                });
            });

            // Function to render charts based on the instances data
            function renderCharts(instances) {
                // Loop through instances and render charts
                instances.forEach(function(instance) {
                    var chartData = {
                        labels: [instance.year.toString()],
                        datasets: [{
                                label: 'Given Dev Hours',
                                data: [instance.instance.dev_hours],
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Given Eng Hours',
                                data: [instance.instance.eng_hours],
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Remaining Dev Hours',
                                data: [instance.total_rem_dev_hours],
                                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Remaining Eng Hours',
                                data: [instance.total_rem_eng_hours],
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }
                        ]
                    };

                    var ctx = document.getElementById('chart-' + instance.year).getContext('2d');

                    // Check if a Chart instance already exists on the canvas
                    /*if (window.myCharts && window.myCharts['chart-' + instance.year]) {
                        window.myCharts['chart-' + instance.year].destroy();
                    }*/

                    // Create a new Chart instance
                    window.myCharts = window.myCharts || {};
                    window.myCharts['chart-' + instance.year] = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                });
            }



            // Initial load: fetch data and render charts for the default selected support contract instance and display instances related to the first support contract
            var defaultSelectedContractId = $("#selectSupportContract").val();
            fetchAndRenderCharts(defaultSelectedContractId);
            filterInstances(defaultSelectedContractId);

            // Event listener for dropdown change
            $("#selectSupportContract").change(function() {
                var selectedContractId = $(this).val();
                fetchAndRenderCharts(selectedContractId);
                filterInstances(selectedContractId);
                destroyCharts();
            });

            function fetchAndRenderCharts(selectedContractId) {
                $.ajax({
                    type: 'GET',
                    url: '/get-support-contract-instance-data/' + selectedContractId,
                    success: function(response) {
                        renderCharts(response.instances);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            // Function to filter and display instances based on the selected support contract
            function filterInstances(contractId) {
                // Hide all instances
                $(".card").hide();

                // Show instances related to the selected support contract
                $(".card[data-contract-id='" + contractId + "']").show();
            }

            function destroyCharts() {
                // Define an array to store all chart instances
                var allChartInstances = Object.values(window.myCharts || {});
                // Loop through the array and destroy each chart instance
                allChartInstances.forEach(function(chart) {
                    if (chart) {
                        chart.destroy();
                    }
                });
            }

        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#instanceupdate').on('click', function() {
                var devhour = $('#devhour').val();
                var enghour = $('#enghour').val();
                var devhourcharge = $('#devhourcharge').val();
                var enghourcharge = $('#enghourcharge').val();

                // AJAX request
                $.ajax({
                    url: '/support-contract/editinstance',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        devhour: devhour,
                        enghour: enghour,
                        devhourcharge: devhourcharge,
                        enghourcharge: enghourcharge
                    },
                    success: function(response) {
                        // Handle success response
                        console.log(response);
                        // You can close modal or do any other action on success
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        console.error(error);
                    }
                });
            });
        });
    </script>
@endsection
