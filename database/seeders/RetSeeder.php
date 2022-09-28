<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vanguard\Models\RefEndpointType;
use Illuminate\Support\Str;

class RetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefEndpointType::create([
            'id' => Str::random(15),
            'name' => 'getToken'
        ]);

        RefEndpointType::create([
            'id' => Str::random(15),
            'name' => 'inquiry'
        ]);
        RefEndpointType::create([
            'id' => Str::random(15),
            'name' => 'overBooking'
        ]);
        RefEndpointType::create([
            'id' => Str::random(15),
            'name' => 'checkStatus'
        ]);
        RefEndpointType::create([
            'id' => Str::random(15),
            'name' => 'getHistory'
        ]);
    }
}
