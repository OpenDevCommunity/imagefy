<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Toaster;
use Validator;

class UsersController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }


    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();

        return view('admin.users.edit', [
           'user' => $user,
           'roles' => $roles
        ]);
    }

    /**
     * @param $userid
     * @return Application|RedirectResponse|mixed|Toaster
     */
    public function assignRoles($userid)
    {
       $validator = Validator::make(request()->all(), [
          'roles' => 'required|array'
       ]);

       if ($validator->fails()) {
           return toast('Invalid roles data was submitted! Please check at least one role!', 'error');
       }

       $user = User::find($userid);

       $user->syncRoles(request()->get('roles'));

       toast('User roles have been synced successfully!', 'success');

       return redirect()->back();
    }


    public function updateInformation($userid)
    {
        $validator = Validator::make(request()->all(), [
           'name' => 'required',
           'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return alert($validator->errors()->first(), 'error');
        }

        User::where('id', $userid)->update(['name' => request()->get('name'), 'email' => request()->get('email')]);

        toast('User information has been updated successfully!', 'success');

        return redirect()->back();
    }


    public function show($userid)
    {
        $user = User::where('id', $userid)->with('images')->first();

        return view('admin.users.show', [
            'user' => $user
        ]);
    }
}
