<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/19/2021
 * Time: 10:22 PM
 */

namespace App\Services;


use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RoleService
{
    /**
     * @param Request $request
     * @return Role|Model
     */
    public function createRole(Request $request)
    {
        return Role::create([
            'name' => request()->get('name'),
            'display_name' => request()->get('pname'),
            'description' => request()->get('description')
        ]);
    }

    /**
     * @param Request $request
     * @param $roleId
     * @return Role|Role[]|Collection|Model|null
     */
    public function updateRole(Request $request, $roleId)
    {
        $role = Role::find($roleId);

        Role::where('id', $roleId)->update([
            'display_name' => $request->get('pname'),
            'description' => $request->get('description')
        ]);

        return $role;
    }
}
