<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class PageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function setLanguage($lang)
    {
        App::setlocale($lang);
        return redirect()->back();
    }
}
