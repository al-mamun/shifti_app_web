<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [
            ['title'=> 'Top Banner', 'link' =>'hello.com', 'banner_photo'=>'demo.jpg', 'status'=>1, 'location'=>'top_banner'],
            ['title'=> 'Global Shopping Banner', 'link' =>'hello.com', 'banner_photo'=>'demo.jpg', 'status'=>1, 'location'=>'global_shopping_banner'],
            ['title'=> 'Global Shopping Banner', 'link' =>'hello.com', 'banner_photo'=>'demo.jpg', 'status'=>1, 'location'=>'global_shopping_banner'],
            ['title'=> 'Grocery Zone Banner', 'link' =>'hello.com', 'banner_photo'=>'demo.jpg', 'status'=>1, 'location'=>'grocery_zone_banner'],
            ['title'=> 'Best Selling Banner', 'link' =>'hello.com', 'banner_photo'=>'demo.jpg', 'status'=>1, 'location'=>'best_selling_banner'],
            ['title'=> 'Hot Category Banner', 'link' =>'hello.com', 'banner_photo'=>'demo.jpg', 'status'=>1, 'location'=>'hot_category_banner'],
        ];

        Banner::truncate();
        foreach($banners as $banner){
            Banner::create($banner);
        }

    }
}
