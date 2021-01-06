<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{

    public function uploadImage(Request $request)
    {
        // No file was submitted
        if (!$request->hasFile('image')) return response()->json([]);

        // Handle file upload

    }
}
