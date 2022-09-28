<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class ListUser extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('User Service'))
            ->route('user-service.index')
            ->icon('fas fa-users')
            ->active("user-service*");
    }
}
