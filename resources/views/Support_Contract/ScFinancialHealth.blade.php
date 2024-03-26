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
        display: none; /* Initially hide the FinancialData div */
    }
</style>

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
            <button class="btn btn-primary m-2" id="scFinancialSearchBtn" data-toggle="tooltip" title="Search SC Report">Search
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>

        <!-- Displaying charges in dual bar chart -->
        <div class="FinancialData">
            <canvas id="financialChart" width="200" height="100"></canvas>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
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
                    renderDualBarChart(response.devChargers, response.totalDevCharger, response.engChargers, response.totalEngCharger);
                    $('.FinancialData').show();

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
                },
            });
        });
        function renderDualBarChart(devChargers, totalDevCharger, engChargers, totalEngCharger) {
        var ctx = document.getElementById('financialChart').getContext('2d');
        var financialChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Chargers For Dev Hours', 'Payments For Dev Hours', 'Chargers For Eng Hours', 'Payments For Eng Hours'],
                datasets: [{
                    label: 'Developer Charges and Payments',
                    backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                    borderColor: ['rgba(255, 99, 132, 1)', 'rgba(255, 99, 132, 1)'],
                    borderWidth: 1,
                    data: [devChargers, totalDevCharger, null, null]
                }, {
                    label: 'Engineer Charges and Payments',
                    backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(54, 162, 235, 0.5)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(54, 162, 235, 1)'],
                    borderWidth: 1,
                    data: [null, null, engChargers, totalEngCharger] 
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});



</script>
@endsection
