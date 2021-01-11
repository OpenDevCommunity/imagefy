<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();

        return view('admin.users.index', [
            'users' => $users
        ]);
    }


    public function edit()
    {

    }
}
