@extends('layouts.navitems')

@section('content')

<div class="container col-12">
    <div class="bg-light rounded h-100 p-4">
        <div class="container-fluid">
            <h1>Support Contract Handling</h1>
            <hr>
            <div class="float-end">
                <button class="btn btn-primary">
                    <i class="fa-solid fa-folder-plus"></i>Add SC
                </button>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($supportcontracts as $supportcontract)
                            <tr>
                                <td>{{ $supportcontract->user_id }}</td>
                                <td>{{ $supportcontract->name }}</td>
                                <td>{{ $supportcontract->company_name }}</td>
                                <td class="text-center">
                                    <div class="d-inline-block mx-1">
                                        <button class="btn btn-success">
                                            <i class="fa-solid fa-pen-to-square" style="color: green;"></i>
                                        </button>
                                    </div>

                                    <div class="d-inline-block mx-1">
                                        <button class="btn btn-danger">
                                            <i class="fa-solid fa-trash" style="color: red;"></i>
                                        </button>
                                    </div>
                                    <div class="d-inline-block mx-1">
                                        <button class="btn btn-dark">
                                            <i class="fa-solid fa-circle-info" style="color: black;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</div>
@endsection
