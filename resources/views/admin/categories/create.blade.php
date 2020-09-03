@extends('layouts.admin.layout')

@section('title','Create Category')
@section('content-header','Create Category')

@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create Category</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="post" class="user">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control @error('name') border border-danger @enderror"
                               placeholder="Category Name" name="name" value="{{ old('name') }}" required autofocus>

                        @error('name')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control @error('slug') border border-danger @enderror"
                               placeholder="Category Slug" name="slug" value="{{ old('slug') }}" required>

                        @error('slug')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <button type="submit" class="btn btn-primary">
                        Create Category
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
