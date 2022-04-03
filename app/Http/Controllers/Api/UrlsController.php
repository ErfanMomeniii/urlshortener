<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Url;
use App\Services\UrlService;
use Illuminate\Http\Request;

class UrlsController extends Controller
{
    public function store(Request $request, UrlService $urlService): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'path' => 'required|url|max:255',
        ]);

        $url = new Url();
        $url->path = $request->input('path');
        $url->code = $urlService->generateCode();
        $url->save();

        return response()->json($url);
    }

    public function showByCode($code): \Illuminate\Http\JsonResponse
    {
        $url = Url::where('code', '=', $code)->firstOrFail();

        return response()->json($url);
    }
}
