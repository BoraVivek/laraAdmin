@extends('layouts.admin.layout')

@section('title','Edit Role - LaraShort : Premium URL Generator')

@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Role - {{ $role->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.roles.update',$role->id)}}" method="post" class="role">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-sm-8 mb-3 mb-sm-0">
                        <input type="text" class="form-control @error('name') border border-danger @enderror"
                               placeholder="Enter Role Name e.g :- admin" name="name" value="{{ $role->name }}" required
                               autofocus>

                        @error('name')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-4">

                    </div>
                </div>
                <div><b>Select Permissions</b>
                    <hr>
                </div>

                <x-admin.roles.permission-edit name="users" title="Users" :role="$role"></x-admin.roles.permission-edit>
                <x-admin.roles.permission-edit name="roles" title="Roles" :role="$role"></x-admin.roles.permission-edit>
                <x-admin.roles.permission-edit name="urls" title="Urls" :role="$role"></x-admin.roles.permission-edit>
                <x-admin.roles.permission-edit name="posts" title="Posts" :role="$role"></x-admin.roles.permission-edit>

                <div class="form-group row">
                    <button type="submit" class="btn btn-primary">
                        Edit Role
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
