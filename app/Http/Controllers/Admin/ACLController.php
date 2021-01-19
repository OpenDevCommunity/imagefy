<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Validator;

class ACLController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function listPermissions()
    {
        $permissions = Permission::all();

        return view('admin.acl.permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storePermission(Request $request)
    {
        // Validate request data
        $validator = Validator::make(request()->all(), [
           'name' => 'required|unique:permissions',
           'pname' => 'required',
           'description' => 'required'
        ]);

        // Check if validator failed
        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }

        // Store new permission in databse
        $permission = (new PermissionService())->createPermission($request);

        // Check if permission was created
        if (!$permission) {
            toast('Failed to create permission!', 'error');
            return redirect()->back();
        }

        // Success
        toast('Permission ' . request()->get('name') . ' has been created', 'success');
        return redirect()->back();
    }

    /**
     * @param $id
     */
    public function editPermission($id)
    {
        // TODO
    }


    /**
     * @param $id
     */
    public function updatePermission($id)
    {
        // TODO
    }

    /**
     * @return Application|Factory|View
     */
    public function listRoles()
    {
        $roles = Role::all();
        $permissions= Permission::all();

        return view('admin.acl.roles.index', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeRole(Request $request)
    {
        // Validate request data
        $validator = Validator::make(request()->all(), [
            'name' => 'required|unique:permissions',
            'pname' => 'required',
            'description' => 'required',
            'permissions' => 'required|array'
        ]);

        // Check if validator failed
        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }

        // Store role to database
        $role = (new RoleService())->createRole($request);

        // Check if role was created
        if (!$role) {
            toast('Failed to create new role!', 'error');
            return redirect()->back();
        }

        // Sync role permissions
        $role->syncPermissions(request()->get('permissions'));

        // Success
        toast('Role has successfully been created!', 'success');
        return redirect()->back();
    }

    /**
     * @param $roleId
     * @return Application|Factory|View
     */
    public function editRole($roleId)
    {
        $role = Role::find($roleId);
        $permissions = Permission::all();

        return view('admin.acl.roles.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     * @param $roleId
     * @return RedirectResponse
     */
    public function updateRole(Request $request ,$roleId)
    {
        // Validate request data
        $validator = Validator::make(request()->all(), [
            'pname' => 'required',
            'description' => 'required',
            'permissions' => 'required|array'
        ]);

        // Check if validator failed
        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }

        // Update role information
        $role = (new RoleService())->updateRole($request, $roleId);

        // Check if role was updated
        if (!$role) {
            toast('Failed to update role: ' . $request->get('pname'));
            return redirect()->back();
        }

        // Sync role permissions
        $role->syncPermissions(request()->get('permissions'));

        // Success
        toast($role->display_name . ' has been updated successfully', 'success');
        return redirect()->back();
    }
}
