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
        //tooltip
        $("body").tooltip({ selector: '[data-toggle=tooltip]' });

        $(".modal").each(function() {
        $(this).on("show.bs.modal", function() {
            var easeIn = $(this).data("easein");
            console.log("EaseIn value:", easeIn); // Log the value of easeIn variable
            if (easeIn) {
                console.log("Adding animation class:", easeIn); // Log that animation class is being added
                $(this).find(".modal-dialog").addClass(" animated " + easeIn);
            }
        });
    });
        //Open the Add modal
        $('#addSupportContractBtn').click(function() {
            $('#addSupportContractModal').modal('show');
        });

        //Drop down menu change event
        $('#company_name').change(function() {
            var selectedCompany = $(this).val();
            $('#name').val(selectedCompany + ' Support Contract');
        });

        // Handle form submission
        $('#submitSupportContract').click(function() {
            var formData = {
                company_name: $('#company_name').val(),
                name: $('#name').val()
            };
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Check if the name already exists in the table
            var existingNames = $('#example tbody td:nth-child(2)').map(function() {
                return $(this).text();
            }).get();

            if (existingNames.includes(formData.name)) {
                $('#addSupportContractModal').modal('hide');

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Support contract with the same name already exists!',
                }).then((result) => {

                });
                return;
            }

            $.ajax({
                url: '{{ route("support-contracts.add") }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: formData,
                success: function(response) {
                    console.log('Support contract saved successfully:', response);
                    $('#addSupportContractModal').modal('hide');
                    Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "A new support contract created successfully!",
                    showConfirmButton: false,
                    timer: 1500
                    });

                    // Append a new row to the table with the received data
                    var newRow = '<tr>' +
                        '<td>' + response.support_contract.user_id + '</td>' +
                        '<td>' + response.support_contract.name + '</td>' +
                        '<td>' + response.support_contract.company_name + '</td>' +
                        '<td class="text-center">' +
                        '<div class="d-inline-block mx-1">' +
                        '<a href="#"><i class="fa-solid fa-pen-to-square" style="color: green;"></i></a>' +
                        '</div>' +
                        '<div class="d-inline-block mx-1">' +
                        '<a href="#"><i class="fa-solid fa-trash" style="color: red;"></i></a>' +
                        '</div>' +
                        '<div class="d-inline-block mx-1">' +
                        '<a href="#"><i class="fa-solid fa-circle-info" style="color: black;"></i></a>' +
                        '</div>' +
                        '</td>' +
                        '</tr>';
                    $('#example tbody').append(newRow);
                },
                error: function(xhr, status, error) {
                    console.error('Error saving support contract:', error);
                }
            });
        });
    });
</script>


<div class="container col-12">
        <div class="bg-light rounded h-100 p-4">
            <div class="container-fluid">
                <h1>Support Contract Handling</h1>
                <hr>
                <div class="float-end">
                    @RootOrAdmin
                    <button class="btn btn-primary" id="addSupportContractBtn"data-toggle="tooltip"data-bs-placement="bottom" title="Create Support Contract">
                        <i class="fa-solid fa-folder-plus"></i>
                    </button>
                    @endRootOrAdmin
                </div>
                <br>
                <br>
                <div>
                    <table id="example" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Company Name</th>
                                @RootOrAdmin
                                <th>Action</th>
                                @endRootOrAdmin
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supportcontracts as $supportcontract)
                                <tr>
                                    <td>{{ $supportcontract->user_id }}</td>
                                    <td>{{ $supportcontract->name }}</td>
                                    <td>{{ $supportcontract->company_name }}</td>
                                    @RootOrAdmin
                                    <td class="text-center">
                                        <div class="d-inline-block mx-1">
                                            <a href="#">
                                                <i class="fa-solid fa-pen-to-square" style="color: green;"data-toggle="tooltip"data-bs-placement="bottom" title="Edit Support Contract"></i>
                                            </a>
                                        </div>

                                        <div class="d-inline-block mx-1">
                                            <a href="#">
                                                <i class="fa-solid fa-trash" style="color: red;"data-toggle="tooltip"data-bs-placement="bottom" title="Delete Support Contract"></i>
                                            </a>
                                        </div>
                                        <div class="d-inline-block mx-1">
                                            <a href="#">
                                                <i class="fa-solid fa-circle-info" style="color: black;"data-toggle="tooltip"data-bs-placement="bottom" title="Disable Support Contract"></i>
                                            </a>
                                        </div>
                                    </td>
                                    @endRootOrAdmin
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal -->
    <div class="modal fade" id="addSupportContractModal" data-easein="flipYin" tabindex="-1" aria-labelledby="addSupportContractModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupportContractModalLabel">Create Support Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSupportContractForm">
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <select class="form-select" id="company_name" name="company_name">
                                <option value="">Select Company</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" readonly>
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
@endsection
