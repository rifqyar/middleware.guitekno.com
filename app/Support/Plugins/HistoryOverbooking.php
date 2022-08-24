<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class HistoryOverbooking extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('History Overbooking'))
            ->route('historyOverbooking.index')
            ->icon('fas fa-history')
            ->active("history-overbooking*");
    }
}
