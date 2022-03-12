<?php

namespace App\Http\Controllers\Api;

use App\Models\Url;
use App\Services\UrlService;
use Illuminate\Http\Request;
use App\Http\Resources\UrlResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\UrlCollection;

class UrlShortenerController extends Controller
{

    public function store(Request $request)
    {
        $url = Url::where('url', '=', $request->url)->first();

        if (!$url) {
            $url = Url::create([
                'url' => $request->url,
                'code' => time()
            ]);
        }

        return new UrlResource($url);
    }

    public function show($url)
    {
        $code = $url;

        return new UrlResource(Url::where('code', '=', $code)->first());
    }
}
