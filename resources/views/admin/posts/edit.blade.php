@extends('layouts.admin.layout')

@section('title','Create User - LaraShort : Premium URL Generator')

@push('css')
    <link href="{{ asset('vendor/summernote/css/summernote.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/summernote/css/summernote-bs4.min.css') }}">
@endpush

@section('content')
    <div class="card shadow m-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Post</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.posts.update',$post->id) }}" method="post" id="postForm" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-sm-10 mb-3 mb-sm-0">
                        <input type="text" class="form-control @error('title') border border-danger @enderror"
                               placeholder="Post Title" name="title" value="{{ $post->title }}" required autofocus>

                        @error('title')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('slug') border border-danger @enderror"
                               placeholder="Post Slug" name="slug" value="{{ $post->slug }}" readonly>

                        @error('slug')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select a Category</option>
                            @foreach($categories as $key=>$category)
                                <option value="{{ $key }}"  @if($key == $post->category_id) selected @endif>{{ $category }}</option>
                            @endforeach
                        </select>

                        @error('category_id')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="file" class="form-control @error('image') border border-danger @enderror"
                               name="image" required accept="image/png, image/jpeg">

                        @error('image')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <textarea id="content" name="content">{{ $post->content }}</textarea>

                        @error('content')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <input type="checkbox" class="status-checkbox" id="status" value="1" name="status" @if($post->status) checked @endif>
                        <label for="status">Active</label>
                        @error('status')
                        <div class="text-red">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{--                SEO Accordion Starts --}}

                <div class="form-group row">
                    <div class="col-sm-10">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4 class="card-title">
                                    <a data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseOne">
                                        SEO Options
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="collapse" style="">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <input type="text" class="form-control @error('meta_title') border border-danger @enderror"
                                                   placeholder="Meta Title" name="meta_title" value="{{ $post->meta_title }}">

                                            @error('meta_title')
                                            <div class="text-red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-12 mb-3 mb-sm-0">
                                            <textarea name="meta_description" id="meta_description" cols="30" rows="5" class="form-control" placeholder="Meta Description">{{ $post->meta_description }}</textarea>

                                            @error('meta_description')
                                            <div class="text-red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                {{--                SEO Accordion Ends--}}

                <div class="form-group row">
                    <button type="submit" class="btn btn-primary">
                        Update Post
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('scripts')

    <script src="{{ asset('vendor/summernote/js/summernote.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/js/summernote-bs4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#content').summernote({
                placeholder: 'Post Content Goes Here',
                tabsize: 2,
                height: 300
            });
        });

    </script>

@endpush
