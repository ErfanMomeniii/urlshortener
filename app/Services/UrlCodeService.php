<?php

namespace App\Services;

use App\Models\Url;

/**
 * Class UrlCodeService
 * @package App\Services
 */
class UrlCodeService
{
    public static function generate($length = 5): string
    {
        do {
            $code = substr(md5(rand()), 0, $length);
        } while (Url::where('code', '=', $code)->first());

        return $code;
    }
}
