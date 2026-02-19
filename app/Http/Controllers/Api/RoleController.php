<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::with('permissions')
            ->whereNotIn('name', ['Super Admin'])
            ->get();

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created role.
     */
    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الدور بنجاح',
            'data' => new RoleResource($role->load('permissions')),
        ], 201);
    }

    /**
     * Display the specified role.
     */
    public function show(Role $role)
    {
        return new RoleResource($role->load('permissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->name,
            'guard_name' => 'api'
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الدور بنجاح',
            'data' => new RoleResource($role->load('permissions')),
        ]);
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        // Prevent deleting system roles
        if (in_array($role->name, ['Super Admin', 'Admin', 'مدير النظام', 'مشرف'])) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن حذف دور أساسي في النظام',
            ], 403);
        }

        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الدور بنجاح',
        ]);
    }

    /**
     * Sync permissions to role.
     */
    public function syncPermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,name'
        ]);

        $role->syncPermissions($request->permissions);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث صلاحيات الدور بنجاح',
            'data' => new RoleResource($role->load('permissions')),
        ]);
    }
}
