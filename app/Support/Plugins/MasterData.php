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
        $refBank = Item::create(__('Ref Bank'))
            ->route('masterdata.refbank')
            ->active("master-data/bank");

        $bankSecret = Item::create(__('Bank Secret'))
            ->route('masterdata.bankSecret')
            ->active("master-data/bank-secret");

        $bankEndpoint = Item::create(__('Bank Endpoint'))
            ->route('masterdata.bankEndpoint')
            ->active("master-data/bank-endpoint*");

        $refApiStatus = Item::create(__('Ref Api Status'))
            ->route('masterdata.refApiStatus')
            ->active('master-data/api-status');

        return Item::create(__('Master Data'))
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
