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
                <button class="btn btn-primary m-2" id="scReportSearchBtn" data-toggle="tooltip"
                    title="Search SC Report">Search
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
            <div class="container mt-4">
                <h2 class="mb-4">Profit and Loss Dashboard</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h5 class="card-title">Total Revenue</h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text-success">$ 15,000</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title">Total Expenses</h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text-danger">$ 7,000</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="card-title">Net Profit</h5>
                            </div>
                            <div class="card-body">
                                <h3 class="text-success">$ 8,000</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title">Top Selling Products</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Product A - $2,000</li>
                                    <li class="list-group-item">Product B - $1,500</li>
                                    <li class="list-group-item">Product C - $1,200</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="card-title">Recent Orders</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">Order #001 - $500</li>
                                    <li class="list-group-item">Order #002 - $700</li>
                                    <li class="list-group-item">Order #003 - $900</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Losses and Profits Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>2024-03-29</td>
                                                <td>Product purchase</td>
                                                <td class="text-danger">-$500</td>
                                                <td>Expense</td>
                                            </tr>
                                            <tr>
                                                <td>2024-03-28</td>
                                                <td>Product sale</td>
                                                <td class="text-success">$1000</td>
                                                <td>Revenue</td>
                                            </tr>
                                            <!-- Add more rows as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Profit and Loss Overview</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="profitLossChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dummy data for Chart.js -->
            @php
                $revenue = 15000;
                $expenses = 7000;
            @endphp

            <script>
                // Include Chart.js library
                document.addEventListener("DOMContentLoaded", function() {
                    var ctx = document.getElementById('profitLossChart').getContext('2d');
                    var profitLossChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Revenue', 'Expenses'],
                            datasets: [{
                                label: 'Profit vs Expenses',
                                data: [{{ $revenue }}, {{ $expenses }}],
                                backgroundColor: ['#28a745', '#dc3545']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        }
                    });
                });
            </script>
        </div>
    </div>


@endsection
