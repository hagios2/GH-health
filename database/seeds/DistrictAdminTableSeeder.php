<?php

namespace Database\Seeders;

use App\Models\DistrictAdmin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DistrictAdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DistrictAdmin::create([
            'name' => 'Joshua Ansong',
            'email' => 'josh.ansong@gmail.com',
            'district_id' => 1,
            'must_change_password' => false,
            'password' => Hash::make('123456'),
        ]);
    }
}
