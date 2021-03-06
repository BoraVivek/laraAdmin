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
{{--                            <option value="ban">Ban Users</option>--}}
{{--                            <option value="unban">Unban Users</option>--}}
                            <option value="delete">Delete Users</option>
                        </select>
                        <button type="submit" id="massAction" class="mb-2 btn btn-default">Submit</button>
                    </div>


                    <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
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
                            <th>Actions</th>
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
            processing:true,
            buttons: [
                'selectAll',
                'selectNone'
            ],
            select: true,
            serverSide:true,
            ajax: "{{ route('admin.users.all') }}",
            columns:[
                {data: 'id', name: 'id' },
                {data:'name',name:'name'},
                {data:'email',name:'email'},
                {data:'role',name:'role',searchable:false,orderable:false},
                {data:'active',name:'active'},
                {data:'created_at',name:'created_at',searchable: false},
                {data:'action', name:'action', orderable: false, searchable: false}
            ],
            columnDefs : [
                { targets : [4],
                    render : function (data, type, row) {
                        return data === 1 ? '<span class="alert alert-success p-1">Active</span>' : '<span class="alert alert-danger p-1">In-Active</span>'
                    }
                },
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                    },

                }
            ],
            select: {
                style: 'multi',

            },

            'order': [[1, 'asc']]
        });




        // Handle form submission event
        $("#massAction").click(function(e){

            var form = this;


            var rows_selected = usersTable.column(0).checkboxes.selected();

            if((rows_selected).length < 1)
            {
                alert('You must select atleast one column to perform Mass Action');

                e.preventDefault();


            }else{
                //Iterate over all selected checkboxes
                $.each(rows_selected, function(index, rowId){
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                            .attr('type', 'hidden')
                            .attr('name', 'id[]')
                            .val(rowId)
                    );
                });
            }
        });



        // Delete Function using ajax
        function deleteUser(id)
        {
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            Swal.fire({
                title: "Are you sure?",
                text: "You want to delete this user, you wont' be able to recover this",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
                .then((willDelete)=>{
                    if(willDelete.value)
                    {
                        $.ajax({
                            url: "{{ url('admin/users').'/' }}"+id,
                            type: "POST",
                            data: {'_method':'DELETE', '_token' : csrf_token},
                            success: function(data){
                                usersTable.ajax.reload();
                                Swal.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                );
                            },
                            error: function() {
                                Swal.fire({
                                    title:"Oops!",
                                    text: "User Deletion Failed",
                                    icon: "error"
                                });
                            }

                        });
                    }
                });
        }

    </script>

@endpush
