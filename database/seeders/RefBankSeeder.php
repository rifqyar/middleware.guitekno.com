<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Vanguard\Models\RefBank;

class RefBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefBank::create([
            'bank_id' => '000',
            'bank_name' => 'SIPD',
            'rrs_id' => '00'
        ]);
        $response = Http::get('https://raw.githubusercontent.com/mul14/gudang-data/master/bank/bank.json');
        foreach (json_decode($response) as $value) {
            try {
                RefBank::create([
                    'bank_id' => $value->code,
                    'bank_name' => $value->name,
                    'rrs_id' => '00'
                ]);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}
