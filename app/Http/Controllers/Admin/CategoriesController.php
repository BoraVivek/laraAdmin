<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    public function allCategories()
    {
        $categories = Category::query();

        return DataTables::eloquent($categories)
            ->addColumn('action',function($categories){
                return '<div class="action-buttons"><a href="categories/'.$categories->id.'/edit" class="btn btn-primary btn-sm mr-2"><i class="fas fa-edit"></i></a>'.' '.'
                        <button onclick="deleteCategory(' . $categories->id . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></div>';
            })
            ->editColumn('created_at', function ($users) {
                return $users->created_at->diffForHumans();
            })
            ->rawColumns(['action', 'name'])
            ->toJson();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'string',
            'slug'  => 'alpha_dash'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::lower($request->slug);

        $category->save();

        return redirect()->route('admin.categories.index')->with('message','Category Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {

        return view('admin.categories.edit',[
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,Category $category)
    {
        $request->validate([
            'name' => 'string',
            'slug' => 'alpha_dash'
        ]);

        $category->name = $request->name;
        $category->slug = Str::lower($request->slug);

        $category->save();

        return redirect()->route('admin.categories.index')->with('message','Category Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
