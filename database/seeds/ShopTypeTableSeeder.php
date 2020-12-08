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

            'shop_type' => 'Mini Shop',

            'max_no_of_product' => 50
        ]);



        ShopType::create([

            'shop_type' => 'Max Shop',

            'max_no_of_product' => 100
        ]);


        ShopType::create([

            'shop_type' => 'Non-student shop',

        ]);
    }
}
