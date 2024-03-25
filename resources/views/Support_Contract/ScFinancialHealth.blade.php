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

        <!-- Displaying charges in tiles -->
        <div class="FinancialData">
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Client Payments</h5>
                            <p class="card-text">Developer Charges: <span id="devChargers"></span></p>
                            <p class="card-text">Engineer Charges: <span id="engChargers"></span></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Employee Chargers</h5>
                            <p class="card-text">Developer Charges: <span id="devUserCharge"></span></p>
                            <p class="card-text">Engineer Charges: <span id="engUserCharge"></span></p>
                        </div>
                    </div>
                </div>
            </div>
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
                    // Populate charges without hourly rate
                    $('#devChargers').text(response.devChargers);
                    $('#engChargers').text(response.engChargers);

                    // Calculate charges with hourly rate
                    //var devUserCharge = response.supportContract.dev_rate_per_hour * (response.extraChargers.charging_dev_hours ?? 0) * response.devHourlyRate;
                    //var engUserCharge = response.supportContract.eng_rate_per_hour * (response.extraChargers.charging_eng_hours ?? 0) * response.engHourlyRate;

                    // Populate charges with hourly rate
                    $('#devUserCharge').text(response.totalDevCharger);
                    $('#engUserCharge').text(response.totalEngCharger);

                    // Show the FinancialData div
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
    });
</script>
@endsection
