<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vanguard\Models\DatBankSecret;
use Illuminate\Support\Str;

class DbsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatBankSecret::create([
            'id' => Str::random(15),
            'code_bank' => '113',
            'client_id' => 'JtgClientID',
            'client_secret' => 'c22ea77bacf6436193d08c9318e659acc6c29e9325fe4588b834b15359a1a7ca',
            'username' => 'SIPDDEV',
            'password' => 'J@t3ngD3v'
        ]);

        DatBankSecret::create([
            'id' => Str::random(15),
            'code_bank' => '124',
            'client_id' => 'tester',
            'client_secret' => 'tester',
            'username' => 'tester',
            'password' => 'tester'
        ]);

        DatBankSecret::create([
            'id' => Str::random(15),
            'code_bank' => '000',
            'client_id' => '82d41c9feb784cb98f6fe1ad27d2b260',
            'client_secret' => 'WDT',
            'username' => 'wdt_id_client_test',
            'password' => 'wdt_key_client_test'
        ]);
    }
}
