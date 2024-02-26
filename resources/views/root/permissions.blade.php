@extends('layouts.navitems')

@section('content')
    <div class="container mt-4 col-12">

        <div class="bg-light rounded h-100 p-4 ">
            <h2>Permission Manager</h2>
            <hr>
            <div class="d-flex justify-content-center">
                <div class="w-50 justify-content-center">
                    <h3>Exisiting Permissions</h3>
                    <ul>
                        @foreach ($permissions as $permission)
                        <li>{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>


        </div>
    </div>

    <div class="container mt-4 col-12">
        <div class="bg-light rounded h-100 p-4 d-flex justify-content-center">
            <div class="w-50 justify-content-center">
                <h3>Deploy New Permission</h3>
                <form action="">
                    <input class="form-control" type="text" name="" id="" placeholder="Permission Name">
                    <div class="mt-2 float-end">
                        <button type="button" class="btn btn-secondary">Save</button>
                        <button type="reset" class="btn btn-danger">Clear</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
@endsection
