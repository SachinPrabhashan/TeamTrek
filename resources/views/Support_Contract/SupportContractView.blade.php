@extends('layouts.navitems')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

<style>
    .warning {
        border-top: 5px solid #dc3545;
    }

    .warning .invoice-charge {
        color: #dc3545;
        font-weight: bold;
        font-size: 12pt;
        position: relative;
    }

    .warning .invoice-charge::after {
        content: " (You are getting charged for this)";
        color: #dc3545;
        font-weight: bold;
        font-size: 10pt;
        position: absolute;
        bottom: -1.2em;
        left: 0;
    }
    .chart {
        display: inline-block;
        width: 45%;
        height: auto;
        margin-right: 5px;
    }
    .card {
        display: inline-block;
        width: 45%;
        margin-right: 10px;

    }

    .chart {
        width: 100% !important;
        height: auto !important;
    }

    div #devCard p , #engCard p{
        margin-bottom: 0;
    }

    div #engCard , #devCard{
        height: 150px;
    }

</style>

<script>
$(document).ready(function() {
    $('#taskViewSearchBtn').click(function() {
        var supportContractId = $('#selectSupportContract').val();
        var year = $('#selectSupportContractYear').val();

        $.ajax({
            url: '/getSupportContract-ChartData',
            type: 'GET',
            dataType: 'json',
            data: {
                supportContractId: supportContractId,
                year: year
            },
            success: function(response) {
                var chartData = response.chartData;
                var additionalData = response.additionalData;
                displayChart(chartData);

                $('#loadingAnimation').hide();
                if (chartData.datasets[0].data[2] !== null) {
                    $('#developerHourChargers').text(chartData.datasets[0].data[2]);
                } else {
                    $('#developerHourChargers').text('0');
                }
                if (chartData.datasets[1].data[2] !== null) {
                    $('#engineerHourChargers').text(chartData.datasets[1].data[2]);
                } else {
                    $('#engineerHourChargers').text('0');
                }

                $('#devRatePerHour').text(additionalData.dev_rate_per_hour);
                $('#engRatePerHour').text(additionalData.eng_rate_per_hour);
                $('#devChargers').text(additionalData.dev_chargers);
                $('#engChargers').text(additionalData.eng_chargers);
                $('#chargersInfo').show();
                $('.Graphs').show();

                // Check if devChargers or engChargers are not equal to 0 and apply warning
                if (additionalData.dev_chargers !== 0) {
                    $('#devCard').addClass('warning');
                } else {
                    $('#devCard').removeClass('warning');
                }

                if (additionalData.eng_chargers !== 0) {
                    $('#engCard').addClass('warning');
                } else {
                    $('#engCard').removeClass('warning');
                }

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

                    clearChart();
                    $('#loadingAnimation').show();
                    $('#chargersInfo').hide();
                    $('.Graphs').hide();
                }
            },
        });
    });

    // Initialize myChart variables for two pie charts
    var devChart = null;
    var engChart = null;

    function displayChart(chartData) {
        var ctxDev = document.getElementById('devChart');
        var ctxEng = document.getElementById('engChart');

        // If chart instances exist, destroy them before rendering the new ones
        if (devChart !== null) {
            devChart.destroy();
        }
        if (engChart !== null) {
            engChart.destroy();
        }

        // Calculate the difference between the two data points for developer hours
        var SupportdevHours = chartData.datasets[0].data[0];
        var devHoursRemaining = chartData.datasets[0].data[1];
        var devHoursDifference = SupportdevHours - devHoursRemaining;

        // Calculate the difference between the two data points for engineer hours
        var SupportengHours = chartData.datasets[1].data[0];
        var engHoursRemaining = chartData.datasets[1].data[1];
        var engHoursDifference = SupportengHours - engHoursRemaining;

        // Render the new developer hours chart
        devChart = new Chart(ctxDev, {
            type: 'doughnut',
            data: {
                labels: [devHoursRemaining !== null ? (devHoursRemaining === SupportdevHours ? 'Dev Hours Used' : 'Remaining Dev Hours') : 'Remaining Dev Hours', 'Used Dev Hours'],
                datasets: [{
                    label: 'Developer Hours',
                    data: [devHoursRemaining !== null ? devHoursRemaining : SupportdevHours, devHoursRemaining !== null ? devHoursDifference : 0],
                    backgroundColor: ['#6F8BA4', '#55a7da'], // Blue for Used, Green for Remaining
                }]
            }
        });

        // Render the new engineer hours chart
        engChart = new Chart(ctxEng, {
            type: 'doughnut',
            data: {
                labels: [engHoursRemaining !== null ? (engHoursRemaining === SupportengHours ? 'Eng Hours Used' : 'Remaining Eng Hours') : 'Remaining Eng Hours', 'Used Eng Hours'],
                datasets: [{
                    label: 'Engineer Hours',
                    data: [engHoursRemaining !== null ? engHoursRemaining : SupportengHours, engHoursRemaining !== null ? engHoursDifference : 0],
                    backgroundColor: ['#6F8BA4', '#55a7da'], // Red for Used, Yellow for Remaining
                }]
            }
        });
    }



    function clearChart() {
        if (devChart !== null) {
            devChart.destroy();
        }
        if (engChart !== null) {
            engChart.destroy();
        }
    }

    /*$('#downloadPdfBtn').click(function() {
        // Initialize jsPDF instance
        var doc = new jsPDF();

        // Define the content to be added to the PDF
        var content = $('#downloadView').html();

        // Add content to the PDF
        doc.html(content, {
            callback: function(doc) {
                // Save the PDF
                doc.save('support_contract_report.pdf');
            }
        });
    });*/
});
</script>
<div class="container col-12">
    <div class="bg-light rounded h-100 p-4">
        <h1>Support Hours Usage</h1><hr>
        <div class="rolebtn bg-light rounded h-100 p-4">
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
            <button class="btn btn-primary m-2" id="taskViewSearchBtn" data-toggle="tooltip" title="Search SC View">Search
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>

        <!-- Loading animation -->
        <div id="loadingAnimation" class="mt-4 text-center">
            <img src="{{ asset('img/Graph01Animation.gif') }}" alt="Loading Animation" style="width: 150px; height: 150px;">
        </div>

        <!-- Displaying Graphs -->
        <div id="downloadView">
        <div class="Graphs"style="display: none;">
            <div class="card col-6">
                <div class="card-header bg-primary text-dark">Support Developer Hours Usage</div>
                <!--h5 class="card-header">Support Developer Hours Usage</h5-->
                <div class="card-body">
                    <canvas id="devChart"></canvas>
                </div>
            </div>
            <div class="card col-6">
                <div class="card-header bg-primary text-dark">Support Engineer Hours Usage</div>
                <!--h5 class="card-header">Support Engineer Hours Usage</h5-->
                <div class="card-body">
                    <canvas id="engChart"></canvas>
                </div>
            </div>
        </div>



        <!-- Tiles for developer and engineer hour chargers -->
        <div id="chargersInfo" class="row mt-4 col-12" style="display: none;">
                <div class="card col-6 ms-3" id="devCard">
                    <div class="card-body">
                        <h5 class="card-title">Charging Details for Developer Hours</h5>
                        <div class="invoice-details">
                            <p>Charging Dev Hours: <span id="developerHourChargers"></span></p>
                            <p>Dev Rate Per Hour: Rs: <span id="devRatePerHour"></span></p>
                            <p class="invoice-charge">Charge For Dev Hours: Rs: <span id="devChargers"></span></p>
                        </div>
                    </div>
                </div>


                <div class="card warning" id="engCard">
                    <div class="card-body">
                        <h5 class="card-title">Charging Details for Engineer Hours</h5>
                        <div class="invoice-details">
                            <p>Charging Eng Hours: <span id="engineerHourChargers"></span></p>
                            <p>Eng Rate Per Hour: Rs: <span id="engRatePerHour"></span></p>
                            <p class="invoice-charge">Charge For Eng Hours: Rs: <span id="engChargers"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
