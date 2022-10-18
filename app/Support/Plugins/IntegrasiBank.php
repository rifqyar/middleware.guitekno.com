<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class IntegrasiBank extends Plugin
{
    /**
     * A sidebar item for the plugin.
     * @return Item|null
     */
    public function sidebar()
    {

        return Item::create(__('Tambah integrasi Bank'))
            ->route('integrasi-bank')
            ->active("integrasi-bank")
            ->icon('fas fa-link')
            ->permissions('add_integrasi');
    }
}
