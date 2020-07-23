@extends('layouts.admin.layout')

@section('title','Edit User')
@section('content-header','Edit User')

@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit User : {{ $user->name }}</h6>
        </div>
        <div class="card-body">
            <form class="bg-white rounded px-8 pt-6 pb-8 mb-4" action="{{ route('admin.users.update',$user->id) }}"
                  method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control  @error('name') border border-danger @enderror"
                               placeholder="Name" name="name" value="{{ $user->name }}" required autofocus>

                        @error('name')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6">
                        <input type="email" class="form-control  @error('email') border border-danger @enderror"
                               placeholder="Email" name="email" value="{{ $user->email }}" autocomplete="email" required>

                        @error('email')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="password" class="form-control  @error('password') border border-danger @enderror"
                               placeholder="Password" name="password" autocomplete="password">

                        @error('password')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <select name="role" class="form-control  @error('role') border border-danger @enderror">
                            <option value="">Select Role</option>
                            @foreach($roles as $key=>$role)
                                <option value="{{$key}}" @if($user->hasRole($role)) selected @endif>{{$role}}</option>
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
                                   name="active" @if($user->active) checked @endif>
                            <label class="custom-control-label" for="active">Active</label>
                        </div>
{{--                        <div class="custom-control custom-checkbox large">--}}
{{--                            <input type="checkbox" class="form-control custom-control-input" id="banned" value="1"--}}
{{--                                   name="banned" @if($user->banned) checked @endif>--}}
{{--                            <label class="custom-control-label" for="banned">Banned?</label>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="form-group row">
                    <button type="submit" class="btn btn-primary">
                        Edit User
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
