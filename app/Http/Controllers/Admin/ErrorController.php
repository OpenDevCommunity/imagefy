<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Error;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $errors = Error::orderBy('created_at', 'desc')->get();

        return view('admin.errors.index', [
            'errors' => $errors
        ]);
    }


    public function show($id)
    {
        $error = Error::find($id);

        if (!$error) {
            return redirect()->back();
        }

        return view('admin.errors.show', [
            'error' => $error
        ]);
    }


    public function delete($id)
    {
        Error::destroy($id);

        return redirect()->route('admin.errors.index');
    }
}
