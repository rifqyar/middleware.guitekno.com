<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(\Database\Seeders\CountriesSeeder::class);
        $this->call(\Database\Seeders\RolesSeeder::class);
        $this->call(\Database\Seeders\PermissionsSeeder::class);
        $this->call(\Database\Seeders\UserSeeder::class);
        $this->call(\Database\Seeders\RstSeeder::class);
        $this->call(\Database\Seeders\RasSeeder::class);
        $this->call(\Database\Seeders\RefRunSeeder::class);
        $this->call(\Database\Seeders\RefBankSeeder::class);
        $this->call(\Database\Seeders\DbsSeeder::class);
        $this->call(\Database\Seeders\RetSeeder::class);
        $this->call(\Database\Seeders\EndpointSeeder::class);

        Model::reguard();
    }
}
