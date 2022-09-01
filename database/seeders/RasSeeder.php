<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vanguard\Models\RefApiStatus;

class RasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RefApiStatus::create([
            'ras_id' => '000',
            'ras_message' => 'Success',
            'ras_description' => 'Success transaction'
        ]);

        RefApiStatus::create([
            'ras_id' => '100',
            'ras_message' => 'Processed Transaction',
            'ras_description' => 'BPD have process the transaction'
        ]);

        RefApiStatus::create([
            'ras_id' => '200',
            'ras_message' => 'Failed to create transaction',
            'ras_description' => 'Failed to create transaction'
        ]);

        RefApiStatus::create([
            'ras_id' => '201',
            'ras_message' => 'Bank sender account is not valid',
            'ras_description' => 'Bank sender account is not valid'
        ]);

        RefApiStatus::create([
            'ras_id' => '202',
            'ras_message' => 'Bank recipient account is not valid',
            'ras_description' => 'Bank recipient account is not valid'
        ]);

        RefApiStatus::create([
            'ras_id' => '203',
            'ras_message' => 'Balance sender is not enough',
            'ras_description' => 'Balance sender is not enough'
        ]);

        RefApiStatus::create([
            'ras_id' => '270',
            'ras_message' => 'Invalid payload request',
            'ras_description' => 'Invalid payload request'
        ]);

        RefApiStatus::create([
            'ras_id' => '299',
            'ras_message' => 'Auth is invalid',
            'ras_description' => 'Auth is invalid'
        ]);

        RefApiStatus::create([
            'ras_id' => '300',
            'ras_message' => 'Pending transaction',
            'ras_description' => 'Pending transaction'
        ]);

        RefApiStatus::create([
            'ras_id' => '400',
            'ras_message' => 'Transaction id is not valid',
            'ras_description' => 'Transaction id is not valid'
        ]);
        RefApiStatus::create([
            'ras_id' => '401',
            'ras_message' => 'Transaction id is not unique',
            'ras_description' => 'Transaction id is not unique'
        ]);
        RefApiStatus::create([
            'ras_id' => '900',
            'ras_message' => 'Inquiry sucess',
            'ras_description' => 'Inquiry sucess'
        ]);
        RefApiStatus::create([
            'ras_id' => '901',
            'ras_message' => 'Bank code is not valid',
            'ras_description' => 'Bank code is not valid'
        ]);
        RefApiStatus::create([
            'ras_id' => '902',
            'ras_message' => 'Bank account is not found',
            'ras_description' => 'Bank account is not found'
        ]);

        RefApiStatus::create([
            'ras_id' => '303',
            'ras_message' => 'Invalid npwp',
            'ras_description' => 'Invalid npwp'
        ]);
    }
}
