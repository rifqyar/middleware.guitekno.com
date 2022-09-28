<?php

namespace Vanguard\Support\Plugins;

use Vanguard\Plugins\Plugin;
use Vanguard\Support\Sidebar\Item;

class RolesAndPermissions extends Plugin
{
    public function sidebar()
    {
        $roles = Item::create(__('Roles'))
            ->route('roles.index')
            ->active("roles*")
            ->permissions('roles.manage');

        $permissions = Item::create(__('Permissions'))
            ->route('permissions.index')
            ->active("permissions*")
            ->permissions('permissions.manage');

        $types = Item::create(__('User Types'))
            ->route('types.index')
            ->active("types*")
            ->permissions('types.manage');

        return Item::create(__('Roles & Permissions'))
            ->href('#roles-dropdown')
            ->icon('fas fa-users-cog')
            ->permissions(['roles.manage', 'permissions.manage'])
            ->addChildren([
                $roles,
                $permissions,
                $types
            ]);
    }
}
