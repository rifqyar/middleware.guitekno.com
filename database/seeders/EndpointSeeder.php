<?php

namespace Database\Seeders;

use App\Models\DatBankEndpoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Vanguard\Models\{
    RefEndpointType,
    DatBankSecret,
    EndPointModel
};

class EndpointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dat = DatBankSecret::where('code_bank', '113')->first();
        $ref = RefEndpointType::all();
        $endpointJateng = [
            'getToken' =>
            'http://36.66.184.26:5897/bjtg/api/v1/getTokenTrx',
            'overBooking' =>
            'http://36.66.184.26:5897/bjtg/api/v1/overBookingTrx',
            'inquiry' =>
            'http://36.66.184.26:5897/bjtg/api/v1/inquiryAccountTrx'
        ];

        foreach ($ref as $r) {
            EndPointModel::insert([
                'dbs_id' => $dat->id,
                'dbe_endpoint' => $endpointJateng[$r->name],
                'ret_id' => $r->id,
                'rrs_id' => '00',
            ]);
        }

        $dat = DatBankSecret::where('code_bank', '124')->first();
        $ref = RefEndpointType::where('name', '<>', 'getHistory')->get();
        foreach ($ref as $r) {
            EndPointModel::insert([
                'dbs_id' => $dat->id,
                'dbe_endpoint' => 'http',
                'ret_id' => $r->id,
                'rrs_id' => '00',
            ]);
        }
    }
}
