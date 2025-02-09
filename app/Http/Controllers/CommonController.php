<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Storage;
// use Symfony\Component\HttpFoundation\Response;

class CommonController extends Controller
{
    public function link() {
        return view('link');
    }

    public function audiofile() {
        return view('audiofile');
    }



    // public function openFile(Request $request) {
    //     $filename = $request->query('filename');
    //     $path = "common/{$filename}";

    //     // if (!Storage::disk('local')->exists($path)) {
    //     //     abort(Response::HTTP_NOT_FOUND);    
    //     // }

    //     // $path = "sample.mp3";
    //     return response()->file(storage_path("app/{$path}"));
    //     // return view('fileStrage');
    // }
}
