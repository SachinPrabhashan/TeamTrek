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
            <h1>Support Contract Analysis View</h1>
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
                <button class="btn btn-primary m-2" id="scAnalysisSearchBtn" data-toggle="tooltip"
                    title="Search SC Analysis">Search
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <div class="container mt-4" id="dashboard">
                <h2 class="mb-4">Profit and Loss Dashboard</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title">Total Revenue</h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text-success total-revenue"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title">Total Expenses</h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text-danger total-expense"></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="card-title">Net Profit</h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text net-profit"></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title">First Five Finished Tasks</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Task</th>
                                                <th>Dev Hours</th>
                                                <th>Eng Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody id="firstFiveTasks">
                                            <!-- Tasks will be appended here dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title">First Five Ongoing Tasks</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Task</th>
                                                    <th>Dev Hours</th>
                                                    <th>Eng Hours</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ongoingfirstFiveTasks">
                                                <!-- Tasks will be appended here dynamically -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        $(document).ready(function() {
            $('#scAnalysisSearchBtn').click(function() {
                var supportContractId = $('#selectSupportContract').val();
                var year = $('#selectSupportContractYear').val();

                $.ajax({
                    url: '/getSupportContract-AnalysisData',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        supportContractId: supportContractId,
                        year: year
                    },
                    success: function(response) {
                        console.log("The response is",response);
                        // Update total revenue and total expense
                        $('.total-revenue').text(response.totalRevenue +'Lkr' );
                        $('.total-expense').text(response.totalExpense +'Lkr' );

                        // Calculate net profit
                        var netProfit = response.totalRevenue - response.totalExpense;

                        // Update net profit on the webpage
                        var $netProfitElement = $('.net-profit');
                        $netProfitElement.text(netProfit +'Lkr' );

                        // Apply red color if net profit is negative
                        if (netProfit < 0) {
                            $netProfitElement.css('color', 'red');
                        } else {
                            $netProfitElement.css('color', ''); // Reset color if positive or zero
                        }

                         // Display first five tasks with dev_hours and eng_hours
                        var tasksHtml = '';
                        response.tasksfirstfive.forEach(function(tasksfirstfive, index) {
                            tasksHtml += '<tr>' +
                                '<td>' + tasksfirstfive.name + '</td>' +
                                '<td>' + tasksfirstfive.dev_hours + '</td>' +
                                '<td>' + tasksfirstfive.eng_hours + '</td>' +
                                '</tr>';
                        });
                        $('#firstFiveTasks').html(tasksHtml);

                        var ongoingtasksHtml = '';
                        response.ongoingtasksfirstfive.forEach(function(ongoingtasksfirstfive, index) {
                            ongoingtasksHtml += '<tr>' +
                                '<td>' + ongoingtasksfirstfive.name + '</td>' +
                                '<td>' + ongoingtasksfirstfive.dev_hours + '</td>' +
                                '<td>' + ongoingtasksfirstfive.eng_hours + '</td>' +
                                '</tr>';
                        });
                        $('#ongoingfirstFiveTasks').html(ongoingtasksHtml);
                    }
                });
            });
        });
    </script>


@endsection
