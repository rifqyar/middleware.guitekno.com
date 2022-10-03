<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class LogCallback extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('Log Callback'))
            ->route('logCallback.index')
            ->icon('fas fa-history')
            ->active("log-callback*")
            ->permissions("log-callback");
    }
}