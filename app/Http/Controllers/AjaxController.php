<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function myPost()
    {
        return view('my-post');
    }

    public function submitPost(Request $request)
    {
        // We are collecting all data submitting via Ajax
        $input = $request->all();

        // Sending json response to client
        return response()->json([
            "status" => true,
            "data" => $input
        ]);
    }
}
