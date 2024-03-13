@extends('layouts.navitems')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">


    <div class="container col-12">
        <div class="bg-light rounded h-100 p-4">
            <h1>Sub Task Handle</h1>
            <a href="{{ route('scTaskMonitor') }}" data-toggle="tooltip" data-bs-placement="left" title="Go Back"><i
                    class="fa-solid fa-circle-arrow-left fa-xl"></i></a>

            <br>
            {{ session('id') }}
            <br>
            {{ session('name') }}
            <br>
            {{ session('start_date') }}
            <br>
            {{ session('end_date') }}
            <br>
            {{ session('description') }}






        </div>
    </div>
@endsection
