@extends('layouts.admin.layout')

@section('title','Create Role - LaraShort : Premium URL Generator')

@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create Role</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.roles.store')}}" method="post" class="role">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-8 mb-3 mb-sm-0">
                        <input type="text" class="form-control @error('name') border border-danger @enderror"
                               placeholder="Enter Role Name e.g :- admin" name="name" value="{{ old('name') }}" required
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

                <x-admin.roles.permission name="users" title="Users"></x-admin.roles.permission>
                <x-admin.roles.permission name="roles" title="Roles"></x-admin.roles.permission>
                <x-admin.roles.permission name="urls" title="Urls"></x-admin.roles.permission>
                <x-admin.roles.permission name="posts" title="Posts"></x-admin.roles.permission>

                <div class="form-group row">
                    <button type="submit" class="btn btn-primary">
                        Create Role
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
