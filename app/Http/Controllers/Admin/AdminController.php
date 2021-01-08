<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 */
class AdminController extends Controller
{
    /**
     * Render Administrator dashboard
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}
