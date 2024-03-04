@extends('layouts.navitems')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">


<link href="{{ asset('css/modal.css') }}" rel="stylesheet">
<script>
    $(document).ready(function() {
        // Show form when "Create Support Contract Instance" button is clicked
        $('#addSupportContractInstanceBtn').click(function() {
            $('#createSupportContractInstanceForm').toggle();
        });

        // Close form when "Close" button is clicked
        $('#closeFormBtn').click(function() {
            $('#createSupportContractInstanceForm').hide();
            // Optionally, reset form fields here
        });

        
        // Handle form submission
        $('#supportContractInstanceForm').submit(function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '/your-endpoint-url',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Support Contract Instance created successfully!'
                    });

                    $('#createSupportContractInstanceForm').hide();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while creating the Support Contract Instance. Please try again later.'
                    });
                }
            });
        });
    });
</script>

<div class="container col-12">
    <div class="bg-light rounded h-100 p-4">
        <div class="container-fluid">
            <h1>Support Contract Instance Handling</h1>
            <hr>
            <div class="float-end">
                <button class="btn btn-primary" id="addSupportContractInstanceBtn"data-toggle="tooltip"data-bs-placement="bottom" title="Create Support Contract Instance">
                    <i class="fa-solid fa-folder-plus"></i>
                </button>
                <button class="btn btn-info" id="checkSupportContractInstances"data-toggle="tooltip"data-bs-placement="bottom" title="Check Support Contract Instances">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>
            <br>
            <!-- Form for creating support contract instances -->
            <div id="createSupportContractInstanceForm" style="display: none;">
                <h4>Create Support Contract Instance</h4>
                <form id="supportContractInstanceForm">
                    <div class="mb-3">
                        <label for="support_contract" class="form-label">Support Contract:</label>
                        <select class="form-select" id="support_contract" name="support_contract">
                            <option value="">Select Support Contract</option>
                            @foreach($supportcontracts as $contract)
                                <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year:</label>
                        <input type="text" class="form-control" id="year" name="year" value="{{ date('Y') }}">
                    </div>
                    <div class="mb-3">
                        <label for="owner" class="form-label">Owner:</label>
                        <select class="form-select" id="owner" name="owner">
                            <option value="">Select Owner</option>
                            @foreach($users as $user)
                                @if($user->role_id == 3)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dev_hours" class="form-label">Development Hours:</label>
                        <input type="number" class="form-control" id="dev_hours" name="dev_hours" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="eng_hours" class="form-label">Engineering Hours:</label>
                        <input type="number" class="form-control" id="eng_hours" name="eng_hours" value="0">
                    </div>
                    <div class="mb-3">
                        <label for="dev_rate" class="form-label">Development Rate per Hour:</label>
                        <input type="number" step="100" class="form-control" id="dev_rate" name="dev_rate" value="1000">
                    </div>
                    <div class="mb-3">
                        <label for="eng_rate" class="form-label">Engineering Rate per Hour:</label>
                        <input type="number" step="100" class="form-control" id="eng_rate" name="eng_rate" value="2000">
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" id="closeFormBtn">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Create</button>
                </form>
            </div>


        </div>
    </div>
</div>



@endsection
