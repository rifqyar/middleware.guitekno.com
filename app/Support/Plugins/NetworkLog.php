<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class NetworkLog extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Network Log Middleware'))
            ->route('network-log')
            ->icon('fas fa-history')
            ->active("network-log*")
            ->permissions("network-log");
    }
}
