@extends('layouts.admin.layout')

@section('title','All Users')
@section('content-header','All Users')

@push('css')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.checkboxes.css') }}">
@endpush

@section('content')

    @if(session()->has('message'))
        <div class="alert alert-info m-4">
            {{session()->pull('message')}}
        </div>
    @endif


    <div class="card shadow m-4" id="app">
        <div class="card-header d-flex justify-content-between">
            <h6 class="font-weight-bold text-primary">All Users</h6>
            <div class="card-tools ml-auto">
                <a href="{{ route('admin.users.create') }}">
                    <button class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Add User
                    </button>
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <form action="{{ route('admin.users.mass') }}" method="POST">
                    @csrf
                    <div class="d-flex">
                        <select name="mass_option" id="mass_option" class="form-control" style="width: 150px"
                                required="required">
                            <option value>Mass Action</option>
                            <option value="activate">Activate</option>
                            <option value="deactivate">De-Activate</option>
                            <option value="ban">Ban Users</option>
                            <option value="unban">Unban Users</option>
                            <option value="delete">Delete Users</option>
                        </select>
                        <button type="submit" id="massAction" class="mb-2 btn btn-default">Submit</button>
                    </div>

                    <table class="table table-bordered" id="usersTable">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Action</th>
                        </tr>
                        </tfoot>
                        <tbody>

                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.checkboxes.min.js') }}"></script>

    <script>
        let usersTable = $('#usersTable').DataTable({
            processing: true,
            buttons: [
                'selectAll',
                'selectNone'
            ],
            select: true,
            serverSide: true,
            ajax: "{{ route('admin.users.all') }}",

            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'role', name: 'role'},
                {data: 'active', name: 'active'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action'},
            ],
            columnDefs: [
                //Shows Active or Inactive Users stat based on retrieved data
                {
                    targets: [4],
                    render: function (data, type, row) {
                        return data === '1' ? 'Active' : 'In-Active'
                    }
                },

                //Enable Checkbox for Column 0
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                    },
                }
            ],

            //Enables multi select for checkbox
            select: {
                style: 'multi',
            },

            //Set the default order on Column 1, important for enabling Checkbox on Column 0
            'order': [[1, 'asc']]
        });

    </script>
@endpush
