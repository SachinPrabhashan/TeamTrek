@extends('layouts.navitems')
@section('content')
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

    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4">

            <h1>Support Contract Task Monitor</h1>
            <hr>
            <div class="float-end">
                @RootOrAdmin
                    <button class="btn btn-primary" id="addSupportContractTaskBtn" data-toggle="tooltip" data-bs-placement="bottom"
                        title="Create SC Tasks">
                        <i class="fa-solid fa-folder-plus"></i>
                    </button>
                @endRootOrAdmin
            </div>

            <div class="rolebtn bg-light rounded h-100 p-4">
                <label for="">Choose Support Contract Instance:</label>
                    <select class="btn btn-secondary dropdown-toggle m-2" id="selectSupportContract">
                        @foreach ($supportcontracts as $contract)
                            <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                        @endforeach
                    </select>
                    <select class="btn btn-secondary dropdown-toggle" id="selectSupportContract">
                        @foreach ($supportcontractinstances->unique('year') as $instance)
                            <option value="{{ $instance->year }}">{{ $instance->year }}</option>
                        @endforeach
                    </select>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-margin">
                        <div class="card-header no-border">
                            <h5 class="card-title">SPC Support Contact</h5>
                            <hr>
                        </div>
                        <div class="card-body pt-0">
                            <div class="widget-49">
                                <div class="widget-49-title-wrapper">
                                    <div class="widget-49-date-primary">
                                        <span class="widget-49-date-day">01</span>
                                        <span class="widget-49-date-month">apr</span>
                                    </div>
                                    <div class="widget-49-meeting-info">
                                        <span class="widget-49-pro-title">New Year Banner</span>
                                        <span class="widget-49-meeting-time">12:00 to 12.15 Hrs</span>
                                    </div>
                                </div>
                                <ol class="widget-49-meeting-points">
                                    <li class="widget-49-meeting-item"><span>Update Banner on Home Page</span></li>
                                    <li class="widget-49-meeting-item"><span>Background Overlay Update</span></li>
                                    </li>
                                </ol>
                                <div class="widget-49-meeting-action">
                                    <a href="#" class="btn btn-sm btn-flash-border-primary" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">View All</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Task View All Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="width: 100%;">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Task Overview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="taskviewtb">
                                <tr>
                                    <td><label for=""><b>Client :</b></label></td>
                                    <td>
                                        <p>SPC</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for=""><b>Contract :</b></label></td>
                                    <td>
                                        <p>SPC Support Contact</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for=""><b>Description :</b></label></td>
                                    <td>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam aperiam dolores
                                            vel, sunt nam, fuga ab rerum reprehenderit illum animi labore, quis assumenda
                                            nihil quia laborum veritatis officiis expedita libero!</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for=""><b>Handle by :</b></label></td>
                                    <td>
                                        <p>Emp 01</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for=""><b>Created on :</b></label></td>
                                    <td>
                                        <p>1st April 2024</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for=""><b>Created by :</b></label></td>
                                    <td>
                                        <p>Admin 01</p>
                                    </td>
                                </tr>
                            </table>


                        </div>
                        <div class="modal-body">
                            <button type="button" class="btn btn-danger btn-sm float-end"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addSupportContractTaskModal" data-easein="flipYin" tabindex="-1"
                aria-labelledby="addSupportContractModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSupportContractModalLabel">Create Support Contract</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addSupportContractForm">
                                <div class="mb-3">
                                    <label for="company_name" class="form-label"><b>Company Name</b></label>
                                    <select class="form-select" id="company_name" name="company_name">
                                        <option value="">Select Company</option>

                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label"><b>Support Contract</b></label>
                                    <select class="form-select" id="company_name" name="company_name">
                                        <option value="">Select Support Contract</option>

                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label"><b>Task</b></label>
                                    <input type="text" class="form-control" id="task" name="task" >
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label"><b>Description</b></label>
                                    <input type="text" class="form-control" id="description" name="description" >
                                </div>
                                <div class="mb-3">
                                    <label for="name" class="form-label"><b>Start Date</b></label>
                                    <input type="date" class="form-control" id="startdate" name="startdate" >
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success btn-sm" id="submitSupportContract">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //Open the Task Create modal
        $('#addSupportContractTaskBtn').click(function() {
            $('#addSupportContractTaskModal').modal('show');
        });
    </script>
@endsection
