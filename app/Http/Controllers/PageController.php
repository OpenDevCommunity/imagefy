<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App;
use Illuminate\Http\RedirectResponse;

class PageController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * @param $lang
     * @return RedirectResponse
     */
    public function setLanguage($lang)
    {
        App::setlocale($lang);
        return redirect()->back();
    }
}
