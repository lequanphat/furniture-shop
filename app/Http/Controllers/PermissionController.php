<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRole;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Permissions',
            'permissions' => Permission::all(),
            'roles' => Role::all(),
        ];
        return view('admin.permissions.index', $data);
    }

    public function create(CreateRole $request)
    {
        $role = Role::create([
            'name' => $request->role_name,
        ]);
        $permissions = $request->input('permissions');
        foreach ($permissions as $permission) {
            $role->givePermissionTo($permission);
        }
        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role,
        ]);
    }

    public function update(Request $request)
    {
        $role_id = request()->route('role_id');
        $role = Role::find($role_id);
        $role->name = $request->role_name;
        $role->save();
        $permissions = $request->input('permissions');
        $role->syncPermissions($permissions);
        return response()->json([
            'message' => 'Role updated successfully',
            'role' => $role,
        ]);
    }
    public function get_role()
    {
        $role_id = request()->route('role_id');
        $role = Role::find($role_id);
        $permissions = $role->permissions;

        return response()->json([
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }
    public function authorization_ui()
    {
        $employee = User::where('is_staff', 1)->get();
        $roles = Role::all();
        $data = [
            'title' => 'Authorization',
            'employees' => $employee,
            'roles' => $roles,
        ];
        return view('admin.permissions.authorization', $data);
    }


    public function assign_role(Request $request)
    {
        $user = User::where('user_id', $request->input('user_id'))->first();
        $role_name = $request->input('role_name');
        $user->syncRoles($role_name);
        return response()->json([
            'message' => 'Role assigned successfully',
            'user' => $user,
        ]);
    }
}
