<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class StreamLog extends Plugin
{
    /**
     * A sidebar item for the plugin.
     * @return Item|null
     */
    public function sidebar()
    {

        return Item::create(__('Stream Log Middleware'))
            ->route('stream-log')
            ->active("stream-log*")
            ->icon('fas fa-history')
            ->permissions('stream_log');
    }
}
