<?php

namespace Database\Seeders;

use App\Models\Url;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Url::create(['url' => 'https://facebook.com', 'code' => '2'])->save();

        return;
    }
}
