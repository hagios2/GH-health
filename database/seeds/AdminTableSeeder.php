<?php

use App\Models\Admin;
use Illuminate\Database\Seeder;
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

            'name' => 'Chris ',

            'email' => 'hagiosewilson@gmail..com',

            'password' => Hash::make('123456'),

            'role' => 'super_admin',

            'phone' => '0203665258',

            'must_change_password' => true,

            'isActive' => true
        ]);
    }
}
