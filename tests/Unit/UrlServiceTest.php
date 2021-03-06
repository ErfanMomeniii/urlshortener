<?php

namespace Tests\Unit;

use App\Services\UrlService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @throws BindingResolutionException
     */
    public function test_generate_code_with_specific_length_under_33_for_md5_check()
    {
        $length = rand(0, 32);
        $code = (app()->make(UrlService::class))->generateCode($length);

        $this->assertTrue(strlen($code) == $length);
    }

    /**
     * @throws BindingResolutionException
     */
    public function test_generate_code_with_specific_length_upper_32_for_md5_check()
    {
        $length = rand(33, 255);
        $code = (app()->make(UrlService::class))->generateCode($length);

        $this->assertTrue(strlen($code) == 32);
    }
}
