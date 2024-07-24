<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class WebsiteSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Website::factory(20)->create()->each(function ($website) {
            $categories = \App\Models\Category::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $website->categories()->attach($categories);
        });
    }
}
