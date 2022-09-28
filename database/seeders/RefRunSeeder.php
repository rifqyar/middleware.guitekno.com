<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vanguard\Models\RefRunState;

class RefRunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefRunState::create([
            'rrs_id' => '00',
            'rrs_desc' => 'Staging'
        ]);

        RefRunState::create([
            'rrs_id' => '01',
            'rrs_desc' => 'Production'
        ]);
    }
}
