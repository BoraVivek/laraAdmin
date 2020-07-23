@extends('layouts.admin.layout')

@section('title','Create User')
@section('content-header','Create User')

@section('content')
    <div class="card shadow m-4" id="app">
        <div class="card-header d-flex justify-content-between">
            <h6 class="font-weight-bold text-primary">Create Users</h6>
        </div>

        <div class="card-body">
            <div class="users__create__form">
                <form action="{{ route('admin.users.store') }}" method="post" class="user">
                    @csrf
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control @error('name') border border-danger @enderror"
                                   placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>

                            @error('name')
                            <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <input type="email" class="form-control @error('email') border border-danger @enderror"
                                   placeholder="Email" name="email" value="{{ old('email') }}" autocomplete="email"
                            >

                            @error('email')
                            <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="password"
                                   class="form-control @error('password') border border-danger @enderror"
                                   placeholder="Password" name="password" autocomplete="password">

                            @error('password')
                            <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <select name="role" class="form-control @error('role') border border-danger @enderror">
                                <option value="">Select Role</option>
                                @foreach($roles as $key=>$role)
                                    <option value="{{$key}}">{{$role}}</option>
                                @endforeach
                            </select>

                            @error('role')
                            <div class="text-red">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <div class="custom-control custom-checkbox large">
                                <input type="checkbox" class="form-control custom-control-input" id="active" value="1"
                                       name="active">
                                <label class="custom-control-label" for="active">Active</label>

                                @error('active')
                                <div class="text-red">{{ $message }}</div>
                                @enderror
                            </div>
{{--                            <div class="custom-control custom-checkbox large">--}}
{{--                                <input type="checkbox" class="form-control custom-control-input" id="banned" value="1"--}}
{{--                                       name="banned">--}}
{{--                                <label class="custom-control-label" for="banned">Banned?</label>--}}

{{--                                @error('banned')--}}
{{--                                <div class="text-red">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="btn btn-primary">
                            Create Account
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
