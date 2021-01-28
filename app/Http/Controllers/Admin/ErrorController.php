<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Error;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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


    /**
     * @param $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function show($id)
    {
        // Get error from database
        $error = Error::find($id);

        // Check if error exists
        if (!$error) {
            toast('Failed to find requested error', 'error');
            return redirect()->back();
        }

        // Success
        return view('admin.errors.show', [
            'error' => $error
        ]);
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        Error::destroy($id);

        toast('Error was successfully deleted!', 'success');
        return redirect()->route('admin.errors.index');
    }
}
