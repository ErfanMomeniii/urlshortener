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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $urls = Url::all();
        return new UrlCollection($urls);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = $request->url;
        $newShortUrl = UrlService::createShortUrl($url);
        return new UrlResource(new Url(['url' => $url, 'short_url' => $newShortUrl]));
    }
}
