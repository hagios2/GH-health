<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([

            'name' => 'Martek Admin',

            'email' => 'admin@martek.com',

            'password' => Hash::make('123456'),

            'phone' => '0203665258'
        ]);
    }
}
