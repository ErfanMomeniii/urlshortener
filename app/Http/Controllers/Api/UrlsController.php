<?php

namespace App\Http\Controllers\Api;

use App\Models\Url;
use Illuminate\Http\Request;
use App\Http\Resources\UrlResource;
use App\Http\Controllers\Controller;

class UrlsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:255',
        ]);

        $url = new Url();
        $url->url = $request->input('url');
        $time = time();
        while (Url::where('code', '=', $time)->first()) {
            $time++;
        }
        $url->code = $time;
        $url->save();

        return  response()->json($url);
    }

    public function show($code)
    {
        $url = Url::where('code', '=', $code)->firstOrFail();

        return response()->json($url);
    }
}
