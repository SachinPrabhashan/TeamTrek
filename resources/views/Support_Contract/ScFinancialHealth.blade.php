@extends('layouts.navitems')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        .FinancialData {
            display: none;
            /* Initially hide the FinancialData div */
        }

        .chart-container {
            width: 45%;
            /* Adjust width as needed */
            margin-right: 5px;
            /* Add margin between charts */
            display: inline-block;
            /* Display charts inline */
            width: 100%;
            /* Adjust width as needed */
            margin-right: 5px;
            /* Add margin between charts */
            display: inline-block;
            /* Display charts inline */
        }

        #devHoursChart,
        #engHoursChart {
            margin-left: 100px;
            margin-right: 100px
        }

        div .chart-buttons {
            display: flex;
            justify-content: center;
        }
    </style>
    <script>
        $(document).ready(function() {
            // Define chart variables globally
            var devHoursChart, engHoursChart;

            $('#scFinancialSearchBtn').click(function() {
                var supportContractId = $('#selectSupportContract').val();
                var year = $('#selectSupportContractYear').val();

                $.ajax({
                    url: '/getSupportContract-FinancialData',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        supportContractId: supportContractId,
                        year: year
                    },
                    success: function(response) {
                        $('.FinancialData').show();

                        // Destroy previous charts before creating new ones
                        destroyCharts();

                        var months = ['January', 'February', 'March', 'April', 'May', 'June',
                            'July', 'August', 'September', 'October', 'November', 'December'
                        ];

                        // Initialize arrays to store data for each month
                        var devChargersData = new Array(12).fill(0);
                        var totalDevChargerData = new Array(12).fill(0);
                        var engChargersData = new Array(12).fill(0);
                        var totalEngChargerData = new Array(12).fill(0);

                        // Loop through response data and update corresponding arrays
                        for (var monthKey in response) {
                            var monthData = response[monthKey];
                            var monthIndex = parseInt(monthKey) -
                            1; // Convert month key to zero-based index
                            devChargersData[monthIndex] = monthData.devChargers;
                            totalDevChargerData[monthIndex] = monthData.totalDevCharger;
                            engChargersData[monthIndex] = monthData.engChargers;
                            totalEngChargerData[monthIndex] = monthData.totalEngCharger;
                        }

                        // Create developer hours chart
                        var ctxDev = document.getElementById('devHoursChart').getContext('2d');
                        devHoursChart = new Chart(ctxDev, {
                            type: 'bar',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: 'Developer Hours Chargers',
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1,
                                    data: devChargersData
                                }, {
                                    label: 'Total Developer Charger',
                                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1,
                                    data: totalDevChargerData
                                }]
                            },
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

                        // Create engineer hours chart
                        var ctxEng = document.getElementById('engHoursChart').getContext('2d');
                        engHoursChart = new Chart(ctxEng, {
                            type: 'bar',
                            data: {
                                labels: months,
                                datasets: [{
                                    label: 'Engineer Hours Chargers',
                                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1,
                                    data: engChargersData
                                }, {
                                    label: 'Total Engineer Charger',
                                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1,
                                    data: totalEngChargerData
                                }]
                            },
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
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr
                            .responseJSON.message : 'An error occurred while fetching data.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            // Hide FinancialData div initially
            $('.FinancialData').hide();

            // Function to destroy previous charts
            function destroyCharts() {
                if (devHoursChart) {
                    devHoursChart.destroy();
                }
                if (engHoursChart) {
                    engHoursChart.destroy();
                }
            }
        });
    </script>
    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4">
            <h1>Support Contract Financial Report</h1>
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
                <button class="btn btn-primary m-2" id="scFinancialSearchBtn" data-toggle="tooltip"
                    title="Search SC Report">Search
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <!-- Displaying charges in dual bar chart -->
            <div class="FinancialData">
                <div class="chart-container">
                    <canvas id="devHoursChart" width="400" height="200"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="engHoursChart" width="400" height="200"></canvas>
                </div>
                <div class="chart-buttons">
                    <img class="m-2" onclick="showDevChart()" role="button" width="30" height="30"
                        src="https://img.icons8.com/fluency/48/circled-left-2--v1.png" data-toggle="tooltip"
                        data-bs-placement="top" title="Developer Hour Chart" alt="circled-left-2--v1" />
                    <img class="m-2" onclick="showEngChart()" role="button" width="30" height="30"
                        src="https://img.icons8.com/fluency/48/circled-right-2.png" data-toggle="tooltip"
                        data-bs-placement="top" title="Engineer Hour Chart" alt="circled-right-2" />
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get references to the canvas elements
        const devHoursChart = document.getElementById('devHoursChart');
        const engHoursChart = document.getElementById('engHoursChart');
        // Hide both charts initially
        devHoursChart.style.display = 'default';
        engHoursChart.style.display = 'none';
        // Function to show the Development Hours Chart
        function showDevChart() {
            devHoursChart.style.display = 'block';
            engHoursChart.style.display = 'none';
        }
        // Function to show the Engineering Hours Chart
        function showEngChart() {
            devHoursChart.style.display = 'none';
            engHoursChart.style.display = 'block';
        }
    </script>
@endsection
