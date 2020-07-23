<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    public function allRoles()
    {
        // echo "Hello";
        $roles = Role::query();

        return Datatables::eloquent($roles)
            ->addColumn('action', function ($roles) {
                return '<div class="action-buttons"><a class="btn btn-primary btn-sm mr-2" href="roles/' . $roles->id . '/edit"><i class="fas fa-edit"></i></a>' . ' ' .
                    '<button onclick="deleteRole(' . $roles->id . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></div>';
            })
            ->editColumn('created_at', function ($roles) {
                return $roles->created_at->diffForHumans();
            })
            ->editColumn('updated_at', function ($roles) {
                return $roles->updated_at->diffForHumans();
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
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:roles']);

        $newrole = new Role;
        $newrole->name = $request->name;
        $newrole->guard_name = "web";
        $newrole->save();

        $role = Role::findOrFail($newrole->id);

        if (isset($request->permissions)) {
            $permissions = $request->get('permissions', []);

            $role->syncPermissions($permissions);
        }

        return redirect()->route('admin.roles.index')->with('message', 'Role has been Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    public function allpermissionsforajax($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();

        $perm = [];

        foreach ($permissions as $permission) {

            if ($role->hasPermissionTo($permission->name)) {
                $perm = Arr::prepend($perm, $permission->name, "$permission->id");
            }
        }

        return $perm;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $role = Role::findOrFail($role->id);

        return view('admin.roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Role $role
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, ['name' => 'required|unique:roles,name,' . $role->id]);

        $role = Role::findOrFail($role->id);
        $role->name = $request['name'];
        $role->save();

        // if(isset($request->permissions))
        // {
        $permissions = $request->get('permissions', []);

        $role->syncPermissions($permissions);
        // }

        return redirect()->route('admin.roles.index')->with('message', 'Role has been Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        if ($role) {
            $role->delete();

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
        try {
            $this->validate($request, [
                'id' => 'required|array',
                'mass_option' => 'required|string'
            ]);
        } catch (ValidationException $e) {

        }

        switch ($request->mass_option) {
            case 'delete':
                foreach ($request->id as $id) {
                    $role = Role::findOrFail($id);
                    $role->delete();
                }
                break;

            default:
                echo "Mass Action Must be Selected";
                break;
        }

        return redirect()->route('admin.roles.index')->with('message', 'Mass Action Performed Successfully');
    }
}
