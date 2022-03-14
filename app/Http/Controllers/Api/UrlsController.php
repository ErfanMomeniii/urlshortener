<?php

namespace App\Http\Controllers\Api;

use App\Models\Url;
use Illuminate\Http\Request;
use App\Http\Resources\UrlResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\UrlCollection;

class UrlsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:255',
        ]);

        $url = new Url();
        $url->url = $request->url;
        $time=time();
        while (Url::where('code', '=', $time)->first()) {
            $time++;
        }
        $url->code=$time;
        $url->save();

        return  response()->json([
            'url' => $url->url,
            'code' => $url->code
        ]);
    }

    public function show($code)
    {
        $url = Url::where('code', '=', $code)->firstOrFail();

        return response()->json($url);
    }
}
