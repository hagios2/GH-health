<?php

use Illuminate\Database\Seeder;
use App\Campus;

class CampusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campus::create(['campus' => 'Tech']);

        Campus::create(['campus' => 'UCC']);

        Campus::create(['campus' => 'UENR']);

        Campus::create(['campus' => 'UMAT']);

        Campus::create(['campus' => 'Legon']);
    }
}
