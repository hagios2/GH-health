<?php

use Illuminate\Database\Seeder;

use App\ShopType; 

class ShopTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShopType::create([

            'shop_type' => 'mini shop',

            'max_no_of_product' => 50
        ]);



        ShopType::create([

            'shop_type' => 'mini shop',

            'max_no_of_product' => 50
        ]);
    }
}
