<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class MasterData extends Plugin
{
    /**
     * A sidebar item for the plugin.
     * @return Item|null
     */
    public function sidebar()
    {
        $refBank = Item::create(__('Bank'))
            ->route('masterdata.refbank')
            ->active("master-data/bank");

        $bankSecret = Item::create(__('Koneksi'))
            ->route('masterdata.bankSecret')
            ->active("master-data/bank-secret");

        $bankEndpoint = Item::create(__('Endpoint'))
            ->route('masterdata.bankEndpoint')
            ->active("master-data/bank-endpoint*");

        $refApiStatus = Item::create(__('Kode Api Status'))
            ->route('masterdata.refApiStatus')
            ->active('master-data/api-status');

        return Item::create(__('Data Integrasi'))
            ->href('#masterData-dropdown')
            ->icon('fas fa-database')
            ->addChildren([
                $refBank,
                $bankSecret,
                $bankEndpoint,
                $refApiStatus,
            ])
            ->permissions('master.data');
    }
}
