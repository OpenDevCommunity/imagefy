<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
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
     * @return RedirectResponse
     */
    public function storePermission()
    {
        $validator = Validator::make(request()->all(), [
           'name' => 'required|unique:permissions',
           'pname' => 'required',
           'description' => 'required'
        ]);

        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }

        Permission::create([
           'name' => request()->get('name'),
           'display_name' => request()->get('pname'),
           'description' => request()->get('description')
        ]);

        toast('Permission ' . request()->get('name') . ' has been created', 'success');
        return redirect()->back();
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
     * @return RedirectResponse
     */
    public function storeRole()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required|unique:permissions',
            'pname' => 'required',
            'description' => 'required',
            'permissions' => 'required|array'
        ]);

        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }

        $role = Role::create([
            'name' => request()->get('name'),
            'display_name' => request()->get('pname'),
            'description' => request()->get('description')
        ]);

        $role->syncPermissions(request()->get('permissions'));

        toast('Role has successfully been created!', 'success');
        return redirect()->back();
    }


    public function editRole($roleId)
    {
        $role = Role::find($roleId);
        $permissions = Permission::all();

        return view('admin.acl.roles.edit', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }

    public function updateRole($roleId)
    {
        $validator = Validator::make(request()->all(), [
            'pname' => 'required',
            'description' => 'required',
            'permissions' => 'required|array'
        ]);

        if ($validator->fails()) {
            toast($validator->errors()->first(), 'error');
            return redirect()->back();
        }

        $role = Role::find($roleId);

        Role::where('id', $roleId)->update([
            'display_name' => request()->get('pname'),
            'description' => request()->get('description')
        ]);

        $role->syncPermissions(request()->get('permissions'));

        toast($role->display_name . ' has been updated successfully', 'success');
        return redirect()->back();
    }
}
