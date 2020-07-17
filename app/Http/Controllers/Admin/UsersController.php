<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use function MongoDB\BSON\toJSON;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function allUsers()
    {
        $users = User::query();

        return DataTables::eloquent($users)
            ->addColumn('action',function($user){
                return '<div class="action-buttons"><a class="btn btn-primary btn-sm mr-2" href="users/' . $user->id . '/edit"><i class="fas fa-edit"></i></a>' . ' ' .
                    '<button onclick="deleteUser(' . $user->id . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></div>';
            })
            ->editColumn('created_at',function($user){
                return $user->created_at->diffForHumans();
            })
            ->editColumn('role',function($user){
//                return $user->roles->pluck('name')->first();
                return "Admin";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
