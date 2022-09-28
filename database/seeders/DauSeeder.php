<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vanguard\Models\DatApiUser;

class DauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatApiUser::create([
            'bank_id' => '000',
            'dau_username' => 'admin',
            'dau_password' => bcrypt('admin123')
        ]);
    }
}
