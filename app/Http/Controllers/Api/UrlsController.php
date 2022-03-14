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
            'url' => 'required|max:255',
        ]);

        $url = new Url();
        $url->url = $request->url;
        $url->code = time();
        $url->save();

        return  response()->json([
            'url' => $url->url,
            'code' => $url->code
        ]);
    }

    public function show($code)
    {
        $url = Url::where('code', '=', $code)->first();

        if (!$url) {
            return response()->json()
                ->setStatusCode(404);
        }
        return response()->json([
            'url' => $url->url,
            'code' => $url->code
        ])
            ->setStatusCode(200);
    }
}
