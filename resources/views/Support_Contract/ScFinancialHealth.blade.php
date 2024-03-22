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
    </div>
</div>
@endsection
