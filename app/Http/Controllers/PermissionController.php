<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRole;
use App\Http\Requests\UpdateRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $sort = request()->query('sort');
        $search = request()->query('search');
        $rolesQuery = Role::withCount('permissions as count')->where('name', 'LIKE', '%' . $search . '%');
        if ($sort == 'asc' || $sort == 'desc') {
            $rolesQuery = $rolesQuery->orderBy('count', $sort);
        }
        $roles = $rolesQuery->paginate(8);
        $data = [
            'title' => 'Permissions',
            'permissions' => Permission::all(),
            'roles' => $roles,
            'sort' => $sort,
            'search' => $search
        ];
        return view('admin.permissions.index', $data);
    }

    public function roles_pagination()
    {
        $search = request()->query('search');
        $sort = request()->query('sort');
        $rolesQuery = Role::withCount('permissions as count')->where('name', 'LIKE', '%' . $search . '%');

        if ($sort == 'asc' || $sort == 'desc') {
            $rolesQuery = $rolesQuery->orderBy('count', $sort);
        }
        $roles = $rolesQuery->paginate(8);
        foreach ($roles as $role) {
            if ($role->created_at->diffInDays() < 7) {
                $role->new = true;
            }
        }
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'roles' => $roles,
            'can_update' => $admin->can('update role'),
            'can_delete' => $admin->can('delete role'),
        ];
        return response()->json($data);
    }

    public function create(CreateRole $request)
    {
        $role = Role::create([
            'name' => $request->role_name,
        ]);
        $permissions = $request->input('permissions');
        if ($permissions != null) {
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
            $role->count = count($permissions);
        } else {
            $role->count = 0;
        }

        $admin = User::where('user_id', Auth::id())->first();
        return response()->json([
            'message' => 'Role created successfully',
            'role' => $role,
            'can_update' => $admin->can('update role'),
            'can_delete' => $admin->can('delete role'),
        ]);
    }

    public function update(UpdateRole $request)
    {
        $role_id = request()->route('role_id');
        // check name existed
        $role_name_existed = Role::where('name', $request->role_name)->where('id', '!=', $role_id)->first();
        if (!$role_name_existed) {
            $role = Role::find($role_id);
            $role->name = $request->role_name;
            $role->save();
            $permissions = $request->input('permissions');
            $role->syncPermissions($permissions);
            if ($role->created_at->diffInDays() < 7) {
                $role->new = true;
            }
            if ($permissions != null) {
                $role->count = count($permissions);
            } else {
                $role->count = 0;
            }
            $admin = User::where('user_id', Auth::id())->first();
            return response()->json([
                'message' => 'Role updated successfully',
                'role' => $role,
                'can_update' => $admin->can('update role'),
                'can_delete' => $admin->can('delete role'),
            ]);
        }
        return response()->json(['errors' => ['message' => ['The tag name have already existed.']]], 400);
    }
    public function delete()
    {
        $role_id = request()->route('role_id');
        $role = Role::find($role_id);
        if ($role) {
            if ($role->users()->count() > 0) {
                return response()->json(['errors' => ['message' => ['This role is currently assigned to one or more users.']]], 400);
            }
            $role->syncPermissions([]);
            $role->delete();
            return response()->json([
                'message' => 'Role deleted successfully',
            ]);
        }
        return response()->json(['errors' => ['message' => ['Can not find this role.']]], 400);
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
        $search = request()->query('search');
        $type = request()->query('type');
        $employeesQuery = User::where('is_staff', 1)->whereNotIn('user_id', [Auth::user()->user_id])
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })->with('default_address');

        if ($type != 'all' && $type != null) {
            $employeesQuery = $employeesQuery->whereHas('roles', function ($query) use ($type) {
                $query->where('name', $type);
            });
        }
        $employees = $employeesQuery->paginate(6);
        $roles = Role::all();
        $data = [
            'title' => 'Authorization',
            'employees' => $employees,
            'roles' => $roles,
            'search' => $search,
            'type' => $type,
        ];
        return view('admin.permissions.authorization', $data);
    }
    public function authorization_pagination()
    {
        $search = request()->query('search');
        $type = request()->query('type');
        $employeesQuery = User::where('is_staff', 1)->whereNotIn('user_id', [Auth::user()->user_id])
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })->with('default_address');

        if ($type != 'all') {
            $employeesQuery = $employeesQuery->whereHas('roles', function ($query) use ($type) {
                $query->where('name', $type);
            });
        }

        $employees = $employeesQuery->paginate(6);
        $roles = Role::all();

        foreach ($employees as $employee) {
            $employee->role = $employee->getRoleNames()->first();
        }
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'employees' => $employees,
            'roles' => $roles,
            'can_authorize' => $admin->can('create role') && $admin->can('update role') && $admin->can('delete role'),
        ];
        return response()->json($data);
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
