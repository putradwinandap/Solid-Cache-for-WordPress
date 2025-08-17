<?php

namespace PtrSoc\Interfaces\Providers;

use PtrSoc\Interfaces\WordPress\Hooks\AdminBar;

class HookServiceProvider
{
    private array $hooks = [
        AdminBar::class,
    ];

    public function register()
    {
        foreach ($this->hooks as $hookClass) {
            $hook = new $hookClass();
            $hook->register();
        }
    }
}
