<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class UserTypes extends Plugin
{
    public function sidebar()
    {
        return Item::create(__('User Types'))
            ->route('types.index')
            ->icon('fas fa-users')
            ->active("types*")
            ->permissions('types.manage');
    }
}
