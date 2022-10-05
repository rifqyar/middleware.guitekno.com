<?php

namespace Database\Seeders;

use Vanguard\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Admin',
            'display_name' => 'Admin',
            'description' => 'System administrator.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'User',
            'display_name' => 'User',
            'description' => 'Default system user.',
            'removable' => false
        ]);

        Role::create([
            'name' => 'Nasional',
            'display_name' => 'Nasional',
            'description' => 'Menampilkan Data Nasional',
            'removable' => false
        ]);

        Role::create([
            'name' => 'Provinsi',
            'display_name' => 'Provinsi',
            'description' => 'Menampilkan Data Provinsi',
            'removable' => false
        ]);

        Role::create([
            'name' => 'Kabupaten',
            'display_name' => 'Kabupaten/Kota',
            'description' => 'Menampilkan Data Kabupaten/Kota',
            'removable' => false
        ]);


    }
}
