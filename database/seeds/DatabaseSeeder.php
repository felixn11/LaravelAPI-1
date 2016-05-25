<?php

use App\Blog;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Blog::truncate();
        \Eloquent::unguard();
        $this->call(BlogsTableSeeder::class);
    }
}
