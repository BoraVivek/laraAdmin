<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

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
                return $user->roles->pluck('name')->first();
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id');

        return view('admin.users.create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->createValidation($request);

        $input = $request->except('role');

//        var_dump($request->all());
//        die();

        $input['active'] = 0;

        if(isset($request->active))
        {
            $input['active'] = $request->active;
        }

        $input['password'] = Hash::make($request->password);

//        dump($input);
//        die();

        if ($user = User::create($input)) {
            $role = $request->role;
            $user->syncRoles($role);
        }

        return redirect()->route('admin.users.index')->with('message', 'User has been Created Successfully');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'id');

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request,User $user)
    {
        $this->updateValidation($request,$user);

        $request['active'] = isset($request['active']) ? $request['active'] : 0;
        $request['banned'] = isset($request['banned']) ? $request['banned'] : 0;

        // dd($request);

        if ($request->get('password')) {
            $request['password'] = Hash::make($request->password);
            $user->update($request->except('role'));
        } else {
            $user->update($request->except('role', 'password'));
        }


        $role = $request->role;
        $user->syncRoles($role);


        return redirect()->route('admin.users.index')->with('message', 'User Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user) {
            $user->delete();

            return response()->json([
                'message' => 'User has been Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'message' => 'User deletion failed!'
            ]);
        }
    }

    public function mass(Request $request)
    {
        $this->validate($request, [
            'id'            => 'required|array',
            'mass_option'   => 'required|string'
        ]);

        switch ($request->mass_option) {
            case 'activate':
                foreach ($request->id as $id) {
                    $user = User::findOrFail($id);
                    $user->active = 1;
                    $user->save();
                }
                break;
            case 'deactivate':
                foreach ($request->id as $id) {
                    $user = User::findOrFail($id);
                    $user->active = 0;
                    $user->save();
                }
                break;
            case 'ban':
                foreach ($request->id as $id) {
                    $user = User::findOrFail($id);
                    $user->banned = 1;
                    $user->save();
                }
                break;
            case 'unban':
                foreach ($request->id as $id) {
                    $user = User::findOrFail($id);
                    $user->banned = 0;
                    $user->save();
                }
                break;
            case 'delete':
                foreach ($request->id as $id) {
                    $user = User::findOrFail($id);
                    $user->delete();
                }
                break;

            default:
                echo "Mass Action Must be Selected";
                break;
        }

        return redirect()->route('admin.users.index')->with('message', 'Mass Action Performed Successfully');
    }

    public function createValidation(Request $request)
    {
        $request->validate([
            'name'      =>  'required|string|max:191',
            'email'     =>  'required|string|email|max:191|unique:users',
            'password'  =>  'required|string|min:6',
            'role'      =>  'required|integer',
            'active'    => 'boolean',
            'banned'    =>  'boolean'
        ]);
    }

    public function updateValidation(Request $request,User $user)
    {
        $request->validate([
            'name'      =>  'required|string|max:191',

            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id),],
            'password'  =>  'sometimes|nullable|string|min:6',
            'role'      =>  'required|integer',
            'active'    => 'boolean',
            'banned'    =>  'boolean'
        ]);
    }
}
