<?php

namespace Tests\Unit;

use App\Services\UrlService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UrlServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_generate_code_with_specific_length_under_33_for_md5_check(UrlService $urlService)
    {
        $length=rand(0,32);
        $code = $urlService->getCode($length);

        $this->assertTrue(strlen($code) ==$length );
    }

    public function test_generate_code_with_specific_length_upper_32_for_md5_check(UrlService $urlService){
        $length=rand(33,255);
        $code = $urlService->getCode($length);

        $this->assertTrue(strlen($code) == 32 );
    }
}
