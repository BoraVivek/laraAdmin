@extends('layouts.admin.layout')

@section('title','All Categories - LaraShort : Premium URL Generator')

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
        <h6 class="font-weight-bold text-primary">All Categories</h6>
        <div class="card-tools ml-auto">
            <a href="{{ route('admin.categories.create') }}">
                <button class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Add Categories
                </button>
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <form action="{{ route('admin.categories.mass') }}" method="POST">
                @csrf
                <div class="d-flex">
                    <select name="mass_option" id="mass_option" class="form-control" style="width: 150px"
                        required="required">
                        <option value>Mass Action</option>
                        <option value="activate">Delete Categories</option>
                    </select>
                    <button type="submit" id="massAction" class="mb-2 btn btn-default">Submit</button>
                </div>


                <table class="table table-bordered" id="categoriesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Created</th>
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
    let postsTable = $('#categoriesTable').DataTable({
        processing:true,
        buttons: [
            'selectAll',
            'selectNone'
            ],
        select: true,
        serverSide:true,
        ajax: "{{ route('admin.categories.all') }}",
        columns:[
                {data: 'id', name: 'id' },
                {data:'name',name:'name'},
                {data:'slug',name:'slug'},
                {data:'created_at',name:'created_at',searchable: false},
                {data:'action', name:'action', orderable: false, searchable: false}
            ],
        columnDefs : [
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


            var rows_selected = postsTable.column(0).checkboxes.selected();

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
                        url: "{{ url('admin/blog/posts').'/' }}"+id,
                        type: "POST",
                        data: {'_method':'DELETE', '_token' : csrf_token},
                        success: function(data){
                            postsTable.ajax.reload();
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
