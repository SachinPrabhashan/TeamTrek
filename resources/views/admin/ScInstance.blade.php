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
        //Form display and toggle functions
        $('#createSupportContractInstanceForm').hide();

        $('#addSupportContractInstanceBtn').click(function() {
            $('#createSupportContractInstanceForm').toggle();
            $('#supportContractInstanceTable').toggle();
            $('#supportContractInstanceForm')[0].reset();

        });

        $('#closeFormBtn').click(function() {
            $('#createSupportContractInstanceForm').hide();
            $('#supportContractInstanceTable').show();
            $('#supportContractInstanceForm')[0].reset();

        });

        // Handle form submission
        $('#supportContractInstanceForm').submit(function(event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: '/support-contract-instances-create',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Support Contract Instance created successfully!'
                    });

                    $('#createSupportContractInstanceForm').hide();
                    $('#supportContractInstanceForm')[0].reset();
                    $('#supportContractInstanceTable').show();
                },
                error: function(xhr, status, error) {
                    $('#createSupportContractInstanceForm').hide();
                    var errorMessage = xhr.responseJSON.error;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage
                    });
                    $('#createSupportContractInstanceForm').hide();
                    $('#supportContractInstanceForm')[0].reset();
                    $('#supportContractInstanceTable').show();
                }

            });
        });

    // Function to load support contract instance data based on the selected contract
    function loadSupportContractInstanceData(contractId) {
    $.ajax({
        type: 'GET',
        url: '/get-support-contract-instances/' + contractId,
        success: function(response) {
            console.log(response); // Log the response to inspect its structure

            // Clear existing table rows and headings
            $('#supportContractInstanceTable thead').empty();
            $('#supportContractInstanceTable tbody').empty();

            // Add table headings
            var tableHeadings = '<tr>' +
                '<th>Support Contract</th>' +
                '<th>Year</th>' +
                '<th>Owner</th>' +
                '<th>Development Hours</th>' +
                '<th>Engineering Hours</th>' +
                '<th>Development Rate per Hour</th>' +
                '<th>Engineering Rate per Hour</th>' +
                '</tr>';
            $('#supportContractInstanceTable thead').append(tableHeadings);

            // Check if instances array is not empty
            if (response.instances.length > 0) {
                // Loop through instances and populate the table
                $.each(response.instances, function(index, instance) {
                    // Get payment details for this instance
                    var paymentDetails = response.paymentDetails[instance.id];

                    // Create table row with instance data and payment details
                    var row = '<tr>' +
                        '<td>' + instance.support_contract_id + '</td>' +
                        '<td>' + instance.year + '</td>' +
                        '<td>' + instance.owner + '</td>' +
                        '<td>' + instance.dev_hours + '</td>' +
                        '<td>' + instance.eng_hours + '</td>' +
                        '<td>' + paymentDetails.devRate + '</td>' +
                        '<td>' + paymentDetails.engRate + '</td>' +
                        '</tr>';
                    $('#supportContractInstanceTable tbody').append(row);
                });
            } else {
                // Display a message if there are no instances
                $('#supportContractInstanceTable tbody').append('<tr><td colspan="7">No data available</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.log(error); // Log the error
            // Handle error
        }
    });
}


// Initial retrieval of support contract instances for the selected contract
var initialContractId = $('#selectSupportContract').val();
console.log("Initial contract ID:", initialContractId); // Log the initial contract ID
loadSupportContractInstanceData(initialContractId);

// Handle dropdown change event
$('#selectSupportContract').change(function() {
    var selectedContractId = $(this).val();
    console.log("Selected contract ID:", selectedContractId); // Log the selected contract ID
    loadSupportContractInstanceData(selectedContractId);
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
            </div>
            <br>
             <!-- Table for displaying support contract instances -->
             <div id="supportContractInstanceTable">
                <div class="rolebtn bg-light rounded h-100 p-4">
                    <!--label for="selectSupportContract" class="form-label">Select Support Contract:</label-->
                    <select class="btn btn-secondary dropdown-toggle" id="selectSupportContract">
                        <!-- Populate dropdown options with existing support contracts -->
                        @foreach($supportcontracts as $contract)
                            <option value="{{ $contract->id }}">{{ $contract->name }}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table table-bordered"  width="108%" id="supportContractInstanceData"><!--table id="example"-->
                    <thead>
                        <tr>
                            <th>Support Contract</th>
                            <th>Year</th>
                            <th>Owner</th>
                            <th>Development Hours</th>
                            <th>Engineering Hours</th>
                            <th>Development Rate per Hour</th>
                            <th>Engineering Rate per Hour</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

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
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dev_hours" class="form-label">Development Hours:</label>
                        <input type="number" class="form-control" id="dev_hours" name="dev_hours" value="10">
                    </div>
                    <div class="mb-3">
                        <label for="eng_hours" class="form-label">Engineering Hours:</label>
                        <input type="number" class="form-control" id="eng_hours" name="eng_hours" value="10">
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
