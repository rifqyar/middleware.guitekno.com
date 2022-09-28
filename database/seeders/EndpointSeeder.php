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
use Illuminate\Support\Str;

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
            'http://36.66.184.26:5897/bjtg/api/v1/inquiryAccountTrx',
            'checkStatus' => 'http://36.66.184.26:5897/bjtg/api/v1/checkStatusTrx',
            'getHistory' => 'http://36.66.184.26:5897/bjtg/api/v1/getHistoryTrx',
        ];

        $endpointKaltim = [
            'getToken' =>
            'https://sipd-test.bankaltimtara.co.id/getToken',
            'overBooking' =>
            'https://sipd-test.bankaltimtara.co.id/overBooking',
            'inquiry' =>
            'https://sipd-test.bankaltimtara.co.id/inquiry',
            'checkStatus' => 'https://sipd-test.bankaltimtara.co.id/checkTrx',
            'getHistory' => '',
        ];

        $kaltim = DatBankSecret::where('code_bank', '124')->first();
        $sipd = DatBankSecret::where('code_bank', '000')->first();

        foreach ($ref as $r) {
            if ($r->name == 'getToken') {
                EndPointModel::insert([
                    'dbs_id' => $sipd->id,
                    'dbe_endpoint' => 'https://sipkd-staging.digitalservice.id/ib/get-token',
                    'ret_id' => $r->id,
                    'rrs_id' => '00',
                ]);
            }
            EndPointModel::insert([
                'dbs_id' => $dat->id,
                'dbe_endpoint' => $endpointJateng[$r->name],
                'ret_id' => $r->id,
                'rrs_id' => '00',
            ]);

            EndPointModel::insert([
                'dbs_id' => $kaltim->id,
                'dbe_endpoint' => $endpointKaltim[$r->name],
                'ret_id' => $r->id,
                'rrs_id' => '00',
            ]);
        }
        $ref = RefEndpointType::create([
            'id' => Str::random(15),
            'name' => 'callbackSipd'
        ]);
        // $ref = RefEndpointType::where('name', 'callbackSipd')->first();
        EndPointModel::insert([
            'dbs_id' => $sipd->id,
            'dbe_endpoint' => 'https://sipkd-staging.digitalservice.id/ib/callback',
            'ret_id' => $ref->id,
            'rrs_id' => '00',
        ]);
    }
}
