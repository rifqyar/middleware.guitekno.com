<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vanguard\Models\RefServiceType;

class RstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefServiceType::create([
            'rst_id' => '001',
            'rst_name' => 'Get Token Service'
        ]);

        RefServiceType::create([
            'rst_id' => '011',
            'rst_name' => 'Inquiry (SIPD)'
        ]);

        RefServiceType::create([
            'rst_id' => '012',
            'rst_name' => 'Inquiry (Bank)'
        ]);

        RefServiceType::create([
            'rst_id' => '021',
            'rst_name' => 'Overbooking (SIPD)'
        ]);

        RefServiceType::create([
            'rst_id' => '022',
            'rst_name' => 'Overbooking (Bank)'
        ]);
        RefServiceType::create([
            'rst_id' => '031',
            'rst_name' => 'Check Status (SIPD)'
        ]);
        RefServiceType::create([
            'rst_id' => '032',
            'rst_name' => 'Check Status (Bank)'
        ]);
        RefServiceType::create([
            'rst_id' => '041',
            'rst_name' => 'Transaction History (SIPD)'
        ]);

        RefServiceType::create([
            'rst_id' => '042',
            'rst_name' => 'Transaction History (Bank)'
        ]);

        RefServiceType::create([
            'rst_id' => '051',
            'rst_name' => 'Callback (SIPD)'
        ]);

        RefServiceType::create([
            'rst_id' => '052',
            'rst_name' => 'Callback (Bank)'
        ]);
    }
}
