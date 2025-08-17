<?php

namespace PtrSoc\Interfaces\Providers;

use PtrSoc\Interfaces\WordPress\Assets\AdminAssets;

class AssetsServiceProvider
{
    private array $hooks = [
        AdminAssets::class,
    ];

    public function register()
    {
        foreach ($this->hooks as $hookClass) {
            $hook = new $hookClass();
            $hook->register();
        }
    }
}
