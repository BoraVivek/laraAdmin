<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.posts.index');
    }

    public function allPosts()
    {
        $posts = Post::query();

        return DataTables::eloquent($posts)
            ->addColumn('action', function ($posts) {
                return '<div class="action-buttons"><a class="btn btn-primary btn-sm mr-2" href="posts/' . $posts->id . '/edit"><i class="fas fa-edit"></i></a>' . ' ' .
                    '<button onclick="deletePost(' . $posts->id . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></div>';
            })
            ->editColumn('title', function ($posts) {
                return Str::limit($posts->title, 30);
            })
            ->editColumn('category', function ($posts) {
                return "Category";
            })
            ->editColumn('author', function ($posts) {
                return $posts->author ? $posts->author->name : 'Guest';
            })
            ->editColumn('created_at', function ($users) {
                return $users->created_at->diffForHumans();
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.posts.create',[
            'categories' => Category::pluck('name','id')->all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //TODO: Add Posts Store Method
        /*
         * 1. Do form Validations
         * 2. Load DOM of Summernote in HTML Form , and fetch all attached images and store them in local files
         * 3. Update image location in summernote HTML Dom
         * 4. Store the featured image in local file and update file url in db
         * 5. Store all data in database
         */

        $request->validate([
            'category_id' => 'integer|required',
            'title' => 'string|required',
            'slug' =>   'alpha_dash|required',
            'image' =>  'mimes:jpeg,bmp,png',
            'content' => 'string|required',
            'status' => 'integer',
            'meta_title' => 'string|nullable|size:60',
            'meta_description' => 'string|nullable|size:160'
        ]);



        $dom = new \DOMDocument();

        $dom->loadHtml($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $count => $image) {
            $src = $image->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimeType = $groups['mime'];
                $path = 'public/images/uploads/' . uniqid('', true) . '.' . $mimeType;
                Storage::put($path, file_get_contents($src));
                $image->removeAttribute('src');
                $image->setAttribute('src', Storage::url($path));
            }
        }
        $content = $dom->saveHTML();

        $image_path = '';
        if($request->file('image'))
        {
            $image = Storage::put('public/images/uploads/', $request->file('image'));

            $image_path = Storage::url($image);
        }

        Post::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::lower($request->slug),
            'image' => $image_path,
            'content' => $content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.posts.index')->with('message','Post Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Post $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => Category::pluck('name','id')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'category_id' => 'integer|required',
            'title' => 'string|required',
            'slug' =>   'alpha_dash|required',
            'image' =>  'mimes:jpeg,bmp,png',
            'content' => 'string|required',
            'status' => 'integer',
            'meta_title' => 'string|nullable|max:60',
            'meta_description' => 'string|nullable|max:160'
        ]);



        $dom = new \DOMDocument();

        $dom->loadHtml($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $count => $image) {
            $src = $image->getAttribute('src');
            if (preg_match('/data:image/', $src)) {
                preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                $mimeType = $groups['mime'];
                $path = 'public/images/uploads/' . uniqid('', true) . '.' . $mimeType;
                Storage::put($path, file_get_contents($src));
                $image->removeAttribute('src');
                $image->setAttribute('src', Storage::url($path));
            }
        }
        $content = $dom->saveHTML();

        $image_path = '';
        if($request->file('image'))
        {
            $image = Storage::put('public/images/uploads/', $request->file('image'));

            $image_path = Storage::url($image);
        }

        $post->update([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::lower($request->slug),
            'image' => $image_path,
            'content' => $content,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.posts.index')->with('message','Post Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $blog)
    {
        //TODO: Implement Post Delete Method
    }
}
