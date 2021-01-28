<?php
/**
 *
 * Created by PhpStorm.
 * User: Marek Dev ( marek@marekdev.me )
 * Date: 1/19/2021
 * Time: 10:22 PM
 */

namespace App\Services;


use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PermissionService
{
    /**
     * @param Request $request
     * @return Permission|Model
     */
    public function createPermission(Request $request)
    {
       return Permission::create([
            'name' => $request->get('name'),
            'display_name' => $request->get('pname'),
            'description' => $request->get('description')
        ]);
    }
}
