<?php

namespace Tests\Unit;

use App\Services\UrlCodeService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UrlCodeServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function test_generate_code_with_specific_length_under_33_for_md5_check()
    {
        $length=rand(0,32);
        $code = UrlCodeService::generate($length);

        $this->assertTrue(strlen($code) ==$length );
    }

    public function test_generate_code_with_specific_length_upper_32_for_md5_check(){
        $length=rand(33,255);
        $code = UrlCodeService::generate($length);

        $this->assertTrue(strlen($code) == 32 );
    }
}
