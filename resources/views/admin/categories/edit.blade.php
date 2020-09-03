@extends('layouts.admin.layout')

@section('title','Edit Category - LaraShort : Premium URL Generator')

@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Category - {{ $category->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{route('admin.categories.update',$category->id)}}" method="post" id="categoryForm">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <input type="text" class="form-control @error('name') border border-danger @enderror"
                               placeholder="Category Name" name="name" value="{{ $category->name }}" required autofocus>

                        @error('name')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <input type="text" class="form-control @error('slug') border border-danger @enderror"
                               placeholder="Category Slug" name="slug" value="{{ $category->slug }}" required>

                        @error('slug')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <button type="submit" class="btn btn-primary">
                        Edit Category
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
