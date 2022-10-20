<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class TransaksiOverbooking extends Plugin
{
    /**
     * A sidebar item for the plugin.
     * @return Item|null
     */
    public function sidebar()
    {

        return Item::create(__('Transaksi'))
            ->route('transaksi-overbooking')
            ->active("transaksi*")
            ->icon('fa fa-exchange')
            ->permissions('transaksi_overbooking');
    }
}
