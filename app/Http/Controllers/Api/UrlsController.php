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
        do {
            $url->code = substr(md5(rand()), 0, 5);
        } while (Url::where('code', '=', $url->code)->first());
        $url->save();

        return  response()->json($url);
    }

    public function show($code)
    {
        $url = Url::where('code', '=', $code)->firstOrFail();

        return response()->json($url);
    }
}
