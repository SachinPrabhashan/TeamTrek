@extends('layouts.navitems')
@section('content')
    <div class="container col-12">
        {{-- <div class="bg-light rounded h-100 p-4 d-flex">
            <div class="indworks notstart card col-3 me-4">
                <div class="d-flex justify-content-center">
                    <p class="widgetheader">Not Started</p>
                </div>
                <div  class="d-flex justify-content-center">
                    <p class="widgetdesc">25</p>
                </div>
            </div>

            <div class="indworks processing card col-3 me-4">
                <div class="d-flex justify-content-center">
                    <p class="widgetheader">Processing</p>
                </div>
                <div  class="d-flex justify-content-center">
                    <p class="widgetdesc">10</p>
                </div>
            </div>

            <div class="indworks completed card col-3 me-4">
                <div class="d-flex justify-content-center">
                    <p class="widgetheader">Completed</p>
                </div>
                <div  class="d-flex justify-content-center">
                    <p class="widgetdesc">16</p>
                </div>
            </div>
        </div> --}}

        <div class="bg-light rounded h-100 p-4">

            {{-- task service level widget --}}
            <div class="indworks card col-6">
                <div class="m-3">
                    <div class="d-flex">
                        <h3 class="m-2">Tasks Service Level</h3>
                        <div class="p-0 me-1 ms-auto m-2">
                            <select class="form-control outline-secondary btn-custom rounded-pill" name=""
                                id="">
                                <option value="">Last 7 Days </option>
                                <option value="">Last 30 Days</option>
                                <option value="">Year</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="set01">
                            <p class="m-0">Not Started</p>
                            <p>20</p>
                        </div>
                        <div class="set02">
                            <p class="m-0">Processing</p>
                            <p>5</p>
                        </div>
                        <div class="set03">
                            <p class="m-0">Completed</p>
                            <p>30</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- task service level widget end --}}

            <div class="indworks card col-6 mt-3">
text
            </div>
        </div>
    </div>
@endsection
